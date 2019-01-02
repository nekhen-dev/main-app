<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelVerificacaoEmail extends Model
{
    protected $table = 'verificacaoEmail';
    protected $fillable = [
        'email',
        'token',
        'created_at',
        'updated_at'
    ];
}
