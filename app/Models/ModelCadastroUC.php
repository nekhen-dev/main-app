<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCadastroUC extends Model
{
    protected $table = 'cadastroUc';
    protected $fillable = [
        "hash",
        "tipo_estabelecimento",
        "endereco",
        "num_endereco",
        "cep",
        "uf",
        "municipio",
        "concessionaria",
        "grupo",
        "classe",
        "modalidade",
        "consumo_conv",
        "consumo_conv_total",
        "consumo_fp",
        "consumo_fp_total",
        "consumo_int",
        "consumo_int_total",
        "consumo_p",
        "consumo_p_total",
        "consumo_total"
    ];
}
