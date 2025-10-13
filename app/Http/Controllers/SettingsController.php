<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function staionery() {

        if (auth()->user()->user_type == 10) {
            return view('settings.students.staionery');

        } else {
            return view('settings.teachers.staionery');
        }
    }

    public function settings(){
        $userId = auth()->user()->id;
        if (auth()->user()->user_type == 10) {

        $faltas = DB::table('faltas')
        ->where('user_id', $userId)
        ->get();

            foreach ($faltas as $falta) {
              $disciplina = DB::table('disciplina')->where('id', $falta->disciplina_id)->first();
                $falta->disciplina_nome = $disciplina->nome ?? 'Disciplina não encontrada';
                $falta->motivo = 'Falta';
            }
            return view('settings.students.student', compact('faltas'));
        } else {
            return view('settings.teachers.teacher');
        }
    }

    public function products(){

        return view('products.products');
    }

    public function drink() {

        if (auth()->user()->user_type == 10) {
            return view('settings.students.drink');

        } else {
            return view('settings.teachers.drinks');
        }
    }

    public function grade()
    {
        if (auth()->user()->user_type == 10) {
            $user_id = auth()->user()->id;

            $grade = DB::table('user_disciplina')
                ->join('disciplina', 'user_disciplina.disciplina_id', '=', 'disciplina.id')
                ->where('user_disciplina.user_id', $user_id)
                ->select('disciplina.nome as disciplina_nome', 'user_disciplina.nota')
                ->get();

            return view('settings.students.grade', compact('grade'));
        } else {
            $users = User::where('user_type', 10)->get();
            $disciplinas = DB::table('disciplina')->get();
            $grades = DB::table('user_disciplina')->get();

            return view('settings.teachers.grades', compact('users', 'disciplinas', 'grades'));
        }
    }

    public function store(Request $request)
{
    $gradesInput = $request->input('grades', []);

    foreach ($gradesInput as $userId => $disciplinas) {
        foreach ($disciplinas as $disciplinaId => $nota) {
            $existing = DB::table('user_disciplina')
                ->where('user_id', $userId)
                ->where('disciplina_id', $disciplinaId)
                ->first();

            if ($existing) {
                // Atualiza nota
                DB::table('user_disciplina')
                    ->where('user_id', $userId)
                    ->where('disciplina_id', $disciplinaId)
                    ->update(['nota' => $nota]);
            } else {
                // Insere nova nota
                DB::table('user_disciplina')->insert([
                    'user_id' => $userId,
                    'disciplina_id' => $disciplinaId,
                    'nota' => $nota,
                ]);
            }
        }
    }

    return redirect()->route('settings')->with('message', 'Notas inseridas com sucesso!');
}

}
