<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventos = [
            [
                'titulo' => 'Workshop de Programação',
                'data' => '2023-12-01',
                'descricao' => 'Aprenda os fundamentos de programação com especialistas.',
                'local' => 'Auditório Principal',
            ],
            [
                'titulo' => 'Feira de Empregos',
                'data' => '2023-12-15',
                'descricao' => 'Conecte-se com empresas e explore oportunidades de carreira.',
                'local' => 'Campus ISTP',
            ],
        ];

        return view('eventos', compact('eventos'));
    }
}