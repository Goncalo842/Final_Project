<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class CandidaturaController extends Controller
{
    public function create()
    {
        return view('candidaturas_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|string|max:32',
            'data_nascimento' => 'nullable|date',
            'nif' => 'nullable|string|max:20',
            'morada' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
            'localidade' => 'nullable|string|max:100',
            'tipo_curso' => 'nullable|string|max:100',
            'curso_id' => 'nullable|integer',
            'motivacao' => 'nullable|string',
        ]);

        $id = DB::table('candidaturas')->insertGetId(array_merge($data, ['status' => 'pending', 'created_at' => now(), 'updated_at' => now()]));

        return redirect()->route('candidaturas.create')->with('success', 'Candidatura enviada com sucesso!');
    }

    /**
     * Admin: list all candidaturas
     */
    public function index()
    {
        if (!auth()->check() || auth()->user()->user_type != 30) {
            return redirect()->route('welcome')->with('error', 'Sem permissão.');
        }

        $candidaturas = DB::table('candidaturas')->orderBy('created_at','desc')->get();
        return view('admin.candidaturas.index', compact('candidaturas'));
    }

    /**
     * Admin: show a candidatura
     */
    public function show($id)
    {
        if (!auth()->check() || auth()->user()->user_type != 30) {
            return redirect()->route('welcome')->with('error', 'Sem permissão.');
        }

        $cand = DB::table('candidaturas')->where('id', $id)->first();
        if (!$cand) return redirect()->route('admin.candidaturas.index')->with('error', 'Candidatura não encontrada.');

        return view('admin.candidaturas.show', compact('cand'));
    }

    /**
     * Accept a candidatura (admin only) and create a user record.
     */
    public function accept($id)
    {
        // admin-check
        if (!auth()->check() || auth()->user()->user_type != 30) {
            return redirect()->back()->with('error', 'Sem permissão.');
        }

        $cand = DB::table('candidaturas')->where('id', $id)->first();
        if (!$cand) return redirect()->back()->with('error', 'Candidatura não encontrada.');

        if ($cand->status === 'accepted') {
            return redirect()->back()->with('message', 'Candidatura já aceite.');
        }

        // generate email as first name @gmail.com (add numeric suffix if collision)
        $firstName = explode(' ', trim($cand->nome))[0] ?? $cand->nome;
        $base = preg_replace('/[^a-z0-9]/', '', Str::slug(mb_strtolower($firstName), ''));
        $email = $base . '@gmail.com';
        $suffix = 1;
        $orig = $base;
        while (DB::table('users')->where('email', $email)->exists()) {
            $email = $orig . $suffix . '@gmail.com';
            $suffix++;
        }

        $passwordPlain = '1234567';
        $userId = DB::table('users')->insertGetId([
            'name' => $cand->nome,
            'email' => $email,
            'password' => bcrypt($passwordPlain),
            'user_type' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('candidaturas')->where('id', $id)->update(['status' => 'accepted', 'user_id' => $userId, 'updated_at' => now()]);

        // Note: not emailing credentials here — can be added later.
        return redirect()->route('admin.candidaturas.index')->with('message', "Candidatura aceite. Utilizador criado: {$email} | Palavra-passe: {$passwordPlain}");
    }

    public function reject($id)
    {
        if (!auth()->check() || auth()->user()->user_type != 30) {
            return redirect()->back()->with('error', 'Sem permissão.');
        }

        $cand = DB::table('candidaturas')->where('id', $id)->first();
        if (!$cand) return redirect()->back()->with('error', 'Candidatura não encontrada.');

        DB::table('candidaturas')->where('id', $id)->update(['status' => 'rejected', 'updated_at' => now()]);

        return redirect()->route('admin.candidaturas.index')->with('message', 'Candidatura rejeitada.');
    }
}
