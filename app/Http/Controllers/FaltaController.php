<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FaltaController extends Controller
{
    protected function getFaltasDoAluno($userId)
    {
        return DB::table('faltas')
            ->join('disciplina', 'faltas.disciplina_id', '=', 'disciplina.id')
            ->select(
                'faltas.data',
                'disciplina.nome as disciplina_nome',
                'faltas.motivo'
            )
            ->where('faltas.user_id', $userId)
            ->orderBy('faltas.data', 'desc')
            ->get();
    }

    public function alunos(Request $request){

        $alunos = User::where('user_type', 10)->get(['id', 'name']);

        return response()->json($alunos);
    }

    public function index(){

        $users = User::where('user_type', 10)->get();
        $disciplinas = DB::table('disciplina')->get();

        return view('settings.teachers.teacher', compact('users', 'disciplinas'));
    }

    public function faltasPorDisciplina($disciplinaId){

        $faltas = DB::table('faltas')
            ->where('disciplina_id', $disciplinaId)
            ->where('data', date('Y-m-d'))
            ->pluck('user_id')
            ->toArray();

        return response()->json($faltas);
    }

    public function store(Request $request){

        $faltas = $request->input('faltas', []);
        $disciplinaId = $request->input('disciplina_id');
        $dataHoje = date('Y-m-d');

        if (! $disciplinaId) {
            return response()->json(['error' => 'Disciplina não selecionada'], 400);
        }

        $alunosMarcados = array_keys($faltas);

        DB::table('faltas')
            ->where('disciplina_id', $disciplinaId)
            ->where('data', $dataHoje)
            ->whereNotIn('user_id', $alunosMarcados)
            ->delete();

        foreach ($faltas as $userId => $info) {
            $existe = DB::table('faltas')
                ->where('user_id', $userId)
                ->where('disciplina_id', $disciplinaId)
                ->where('data', $dataHoje)
                ->exists();

            if (! $existe) {
                DB::table('faltas')->insert([
                    'user_id' => $userId,
                    'disciplina_id' => $disciplinaId,
                    'data' => $dataHoje,
                    'motivo' => 'Falta marcada manualmente',
                ]);
            }
        }

        return response()->json(['success' => true]);
    }


}
