<?php

namespace App\Http\Controllers\Consumidor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;
//Meus controllers
use App\Http\Controllers\UnidadesConsumidoras\ListarUcsController;

class MinhasUCs extends Controller
{
    public function iniciar(){

        $obj = new ListarUcsController();
        $buscar = $obj->MinhasUCs("all","all","all","novo");
        // JavaScript::put([
        //     'get_ucs' => $buscar->content()
        // ]);
        return view('plataforma.consumidor.MinhasUCs',['get_ucs' => $buscar->content()]);


    }
}
