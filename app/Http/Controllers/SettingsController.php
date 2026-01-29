<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SettingsController extends Controller
{
    public function admin()
    {
        if (auth()->user()->user_type != 30) {
            return redirect()->route('welcome');
        }

        $totalUsers = DB::table('users')->where('user_type', 10)->count();

        $totalPagamentosPagos = DB::table('pagamentos')->where('pago', true)->count();

        $pagamentosPendentes = DB::table('pagamentos')->where('pago', false)->count();

        $totalStock = DB::table('stock')->count();

        $ultimosUsers = DB::table('users')
            ->where('user_type', 10)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $ultimosPagamentos = DB::table('pagamentos')
            ->join('users', 'pagamentos.user_id', '=', 'users.id')
            ->select('pagamentos.id', 'pagamentos.mes', 'pagamentos.pago', 'pagamentos.created_at', 'users.name')
            ->orderBy('pagamentos.created_at', 'desc')
            ->paginate(3);

        $totalFaltas = DB::table('faltas')->count();

        $totalDisciplinas = DB::table('disciplina')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPagamentosPagos',
            'pagamentosPendentes',
            'totalStock',
            'ultimosUsers',
            'ultimosPagamentos',
            'totalFaltas',
            'totalDisciplinas'
        ));
    }

    public function staionery()
    {

        return view('staionery');
    }

    public function settings()
    {
        $user = auth()->user();

        if ($user->user_type == 30) {
            return redirect()->route('admin');
        }

        $userId = $user->id;
        if ($user->user_type == 10) {

            $faltas = DB::table('faltas')
                ->where('user_id', $userId)
                ->get();

            foreach ($faltas as $falta) {
                $disciplina = DB::table('disciplina')->where('id', $falta->disciplina_id)->first();
                $falta->disciplina_nome = $disciplina->nome ?? 'Disciplina não encontrada';
                $falta->motivo = 'Falta';
            }

            return view('settings.students.student', compact('faltas'));
        }

        return view('settings.teachers.teacher');
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

        return Pdf::loadHTML($html)->setPaper('A4', 'portrait')->download('documentos_escola.pdf');
    }

    public function downloadPlano($course = null)
    {
        if ($course === 'ds') {
            $data = [
                'title' => 'Plano Curricular — Desenvolvimento de Software (CTeSP)',
                'generated_at' => now()->toDateTimeString(),
                'reference' => 'PL-DS-' . rand(1000, 9999),
                'intro' => 'O CTeSP em Desenvolvimento de Software forma técnicos superiores profissionais com competências abrangentes em conceção, planeamento, desenvolvimento, manutenção e otimização de software e sistemas de informação.',
                'objectives' => [
                    'Interpretar requisitos e projetar soluções de software',
                    'Implementar sistemas com metodologias modernas de desenvolvimento',
                    'Gerir bases de dados SQL e NoSQL',
                    'Desenvolver aplicações web, móveis e back‑end',
                    'Assegurar a qualidade: testes e cibersegurança básica',
                    'Elaborar documentação técnica e atuar em ambiente profissional',
                ],
                'curriculum' => [
                    '1.º Ano – 1.º Semestre' => [
                        'Sistemas de Gestão de Conteúdos', 'Matemática', 'Fundamentos de Desenvolvimento de Software', 'Introdução à Programação', 'Bases de Dados SQL', 'Administração de Sistemas', 'Algoritmos e Estruturas de Dados', 'Conceção de Interfaces Gráficas', 'Desenvolvimento Ágil de Software', 'Introdução às Redes de Dados'
                    ],
                    '1.º Ano – 2.º Semestre' => [
                        'Língua Portuguesa', 'Gestão de Projetos', 'Programação', 'Programação Web‑Cliente', 'Programação de Serviços Web', 'Programação Web‑Servidor', 'Programação de Dispositivos Móveis', 'Língua Inglesa', 'Projeto de Aplicações Móveis', 'Bases de Dados NoSQL'
                    ],
                    '2.º Ano – 1.º Semestre' => [
                        'Cibersegurança', 'Computação Móvel', 'Internet das Coisas', 'Modelação de Sistemas de Software', 'Programação Web Avançada (Front‑end)', 'Projeto de Aplicações Web Avançadas', 'Publicação e Administração Web', 'Testes e Qualidade de Software', 'Projeto Final'
                    ],
                    '2.º Ano – 2.º Semestre' => [
                        'Formação em Contexto de Trabalho (FCT)'
                    ],
                ],
            ];
        } else {
            $data = [
                'title' => 'Plano Curricular',
                'generated_at' => now()->toDateTimeString(),
                'reference' => 'PL-' . rand(1000, 9999),
                'intro' => 'Documento genérico de Plano Curricular.',
                'objectives' => [],
                'curriculum' => [],
            ];
        }

        $html = view('documents.plano', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'plano_curricular_' . date('Ymd_His') . '.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'plano_curricular_' . date('Ymd_His') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function downloadRegulamento($course = null)
    {
        if ($course === 'ds') {
            $data = [
                'title' => 'Regulamento Interno — Desenvolvimento de Software (CTeSP)',
                'generated_at' => now()->toDateTimeString(),
                'reference' => 'RG-DS-' . rand(1000, 9999),
                'chapters' => [
                    'Capítulo I — Disposições gerais',
                    'Capítulo II — Direitos e deveres',
                    'Capítulo III — Procedimentos',
                ],
                'notes' => 'Este regulamento é um exemplo gerado automaticamente e deve ser adaptado pela secretaria.',
            ];
        } else {
            $data = [
                'title' => 'Regulamento Interno',
                'generated_at' => now()->toDateTimeString(),
                'reference' => 'RG-' . rand(1000, 9999),
                'chapters' => [],
                'notes' => 'Documento genérico de regulamento.',
            ];
        }

        $html = view('documents.regulamento', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'regulamento_interno_' . date('Ymd_His') . '.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'regulamento_interno_' . date('Ymd_His') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function downloadGuia()
    {
        $data = [
            'title' => 'Guia de Lançamento de Notas',
            'generated_at' => now()->toDateTimeString(),
            'reference' => 'GU-' . rand(1000, 9999),
            'body' => 'Este guia descreve o procedimento para lançamento de notas no sistema. Utilize campos numéricos com valores entre 0 e 20. Consulte os prazos no painel do docente.',
        ];

        $html = view('documents.guia', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'guia_lancamento_' . date('Ymd_His') . '.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'guia_lancamento_' . date('Ymd_His') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function downloadCriterios()
    {
        $data = [
            'title' => 'Critérios de Avaliação',
            'generated_at' => now()->toDateTimeString(),
            'reference' => 'CR-' . rand(1000, 9999),
            'body' => 'Os critérios de avaliação incluem: frequência, trabalhos práticos, avaliações teóricas e participação. Cada disciplina pode ajustar pesos consoante regulamento interno.',
        ];

        $html = view('documents.criterios', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'criterios_avaliacao_' . date('Ymd_His') . '.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'criterios_avaliacao_' . date('Ymd_His') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function downloadAdministracao()
    {
        $data = [
            'title' => 'Contactar Administração',
            'generated_at' => now()->toDateTimeString(),
            'reference' => 'AD-' . rand(1000, 9999),
            'body' => 'Para contactar a administração utilize o email secretaria@istp.example ou telefone +351 21 000 000. Atendemos de segunda a sexta, 09:00-17:00.',
        ];

        $html = view('documents.administracao', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'contato_administracao_' . date('Ymd_His') . '.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'contato_administracao_' . date('Ymd_His') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
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

    public function buyNotebook(Request $request)
    {
        $request->validate([
            'preco' => 'required|numeric|in:12,15',
        ]);

        $user = auth()->user();
        $preco = (float) $request->preco;

        if ($user->saldo < $preco) {
            return redirect()->route('products')->with('error', 'Saldo insuficiente! Necessita de €' . number_format($preco, 2, ',', '.'));
        }

        $user->saldo -= $preco;
        $user->save();

        return redirect()->route('products')->with('success', 'Caderno ISTP Deluxe adquirido com sucesso! Novo saldo: €' . number_format($user->saldo, 2, ',', '.'));
    }
}
