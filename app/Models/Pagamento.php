<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mes', 'pago'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
