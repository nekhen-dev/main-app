<?php

namespace App\Http\Controllers\Consumidor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\Resources\get_UFs;

class CadastrarUcController extends Controller
{
    public function index(){
        
        $obj = new get_UFs;
        $obj->loadUcs();
        $listaUFs = $obj->lista;
        return view('plataforma.consumidor.CadastrarUC',['listaUFs' => $listaUFs]);
    }
}
