<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidaturaController extends Controller
{
    public function create()
    {
        return view('candidaturas_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'curriculo' => 'required|string',
        ]);

        return redirect()->route('candidaturas.create')->with('success', 'Candidatura enviada com sucesso!');
    }
}
