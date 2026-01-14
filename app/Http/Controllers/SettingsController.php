<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function staionery()
    {

        return view('staionery');
    }

    public function settings()
    {
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

    public function downloadDocuments()
    {
        $userId = auth()->user()->id;

        $faltas = DB::table('faltas')
            ->where('user_id', $userId)
            ->get();

        foreach ($faltas as $falta) {
            $disciplina = DB::table('disciplina')->where('id', $falta->disciplina_id)->first();
            $falta->disciplina_nome = $disciplina->nome ?? 'Disciplina não encontrada';
            $falta->motivo = 'Falta';
        }

        $importantDates = [
            '16-09-2025 - Início 1º Semestre',
            '01-03-2026 - Fim 1º Semestre',
            '05-03-2026 - Início 2º Semestre',
        ];

        $vacations = ['21-12 / 03-01-2026 - Férias de natal', '03/04-03-2026 - Férias de pascoa'];

        $notices = [
            ['title' => 'Alteração de Horário', 'text' => 'Mudança temporária no horário das aulas.'],
            ['title' => 'Entrega de Trabalhos', 'text' => 'Prazo final para entrega de trabalhos práticos.'],
        ];

        $data = ['user' => auth()->user(), 'faltas' => $faltas, 'importantDates' => $importantDates, 'vacations' => $vacations, 'notices' => $notices];

        $html = view('documents.all_documents', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf;
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="documentos_escola.pdf"',
            ]);
        }

        return back()->with('sucesso', 'Para gerar PDFs instale o Dompdf: execute `composer require dompdf/dompdf`.');
    }

    public function products()
    {

        return view('products.products');
    }

    public function drink()
    {

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

    public function downloadGrades()
    {
        $users = User::where('user_type', 10)->get();
        $disciplinas = DB::table('disciplina')->get();
        $grades = DB::table('user_disciplina')->get();

        $filename = 'notas_alunos_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($users, $disciplinas, $grades) {
            $handle = fopen('php://output', 'w');

            $header = array_merge(['Aluno'], $disciplinas->pluck('nome')->toArray());
            fputcsv($handle, $header);

            foreach ($users as $user) {
                $row = [$user->name];
                foreach ($disciplinas as $disc) {
                    $g = $grades->where('user_id', $user->id)->where('disciplina_id', $disc->id)->first();
                    $row[] = $g->nota ?? '';
                }
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
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
                    DB::table('user_disciplina')
                        ->where('user_id', $userId)
                        ->where('disciplina_id', $disciplinaId)
                        ->update(['nota' => $nota]);
                } else {
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
