<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;

class get_UFs extends Controller
{

    public $lista;
    public function __invoke(){
        $file = new Filesystem;
        $listaUFs = json_decode($file->get(public_path().'/json/UFs.json'));
        $this->lista = $listaUFs->lista;
        return response()->json($listaUFs, 200, array('Content-Type' => 'application/json;charset=UTF-8'),JSON_UNESCAPED_UNICODE);
    }
}
