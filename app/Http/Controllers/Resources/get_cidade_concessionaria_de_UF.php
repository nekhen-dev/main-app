<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Response;

class get_cidade_concessionaria_de_UF extends Controller
{
    private $uf;

    public function show($_uf){
        $this->uf = strtoupper(htmlspecialchars($_uf,ENT_QUOTES));
        $municipios = $this->getItem('municipios');
        $concessionarias = $this->getItem('concessionarias');
        $dupla = array(
            "municipios" => $municipios,
            "concessionarias" => $concessionarias
        );
        return response()->json($dupla, 200, array('Content-Type' => 'application/json;charset=UTF-8'),JSON_UNESCAPED_UNICODE);
    }
    public function getItem($buscar){
        $file = new Filesystem;
        $lista = json_decode($file->get(public_path().'/json/'.$buscar.'.json'))->resposta;
        foreach($lista as $item){
            if($item->uf == $this->uf){
                switch($buscar){
                    case 'municipios': return $item->municipios;
                    case 'concessionarias': return $item->concessionarias;
                    default: return json_decode('{"status":500,"msg":"Erro na solicitação"}');
                }
            }
        }
        return json_decode('{"status":404,"msg":"Esolha uma UF válida."}');
    }

    public function transformar($uf, $municipio_id, $concessionaria_id){
        $municipios_concessionarias = $this->show($uf)->original;
        $municipios = $municipios_concessionarias["municipios"];
        $concessionarias = $municipios_concessionarias["concessionarias"];
        
        return array(
            "municipio" => $this->buscar_em_arr($municipios,$municipio_id),
            "concessionaria" => $this->buscar_em_arr($concessionarias,$concessionaria_id)
        );
    }

    private function buscar_em_arr($lista,$id){
        foreach($lista as $i){
            if($i->valor == $id){
                return $i->nome;
            }
        }
        return null;
    }
    
    
}
