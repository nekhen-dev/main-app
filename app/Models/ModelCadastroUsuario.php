<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCadastroUsuario extends Model
{
    protected $table = 'cadastroUsuario';
    protected $fillable = [
        'hash',
        'email',
        'cpf_cnpj',
        'endereco',
        'endereco_num',
        'endereco_comp',
        'uf',
        'cidade',
        'cep'
    ];
    
}
