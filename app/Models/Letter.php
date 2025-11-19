<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $table = 'letter'; // opcional, se o nome não seguir plural padrão

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem'
    ];
}
