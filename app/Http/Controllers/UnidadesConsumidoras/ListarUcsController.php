<?php

namespace App\Http\Controllers\UnidadesConsumidoras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Controllers auxiliares
use App\Http\Controllers\ValidacaoInput;
use App\Http\Controllers\Resources\get_cidade_concessionaria_de_UF;

//Models
use App\Models\ModelCadastroUC;
use App\User;

class ListarUcsController extends Controller
{
    public $dados;
    public $validacao;
    public $orderBy;
    public $where;
    public $result;

    public function MinhasUCs($uf,$municipio,$concessionaria,$ordem){
        $this->dados = array(
            "uf" => filter_var_array(explode(",",$uf),FILTER_SANITIZE_ENCODED),
            "municipio" => filter_var_array(explode(",",$municipio),FILTER_SANITIZE_ENCODED),
            "concessionaria" => filter_var_array(explode(",",$concessionaria),FILTER_SANITIZE_ENCODED),
            // "user_id" => filter_var_array(explode(",",$usuario),FILTER_SANITIZE_ENCODED),
            "ordem" => filter_var($ordem,FILTER_SANITIZE_ENCODED),
            "max_itens" => 15
        );

        $this->validacao();
        if($this->validacao->status != 200){
            return response()->json((array)$this->validacao, $this->validacao->status, array('Content-Type' => 'application/json;charset=UTF-8'),JSON_UNESCAPED_UNICODE);
        }

        $this->orderBy();
        $this->where();
        $query = \Auth::user()->ucs()->where(function($q){
            foreach($this->where as $key => $where_list){
                $q->whereIn($key,$where_list);
            }
        })
        ->orderBy($this->orderBy["coluna"],$this->orderBy["regra"])
        ->paginate($this->dados["max_itens"]);
        
        $this->result = array(
            "status" => 200,
            "total_paginas" => $query->lastPage(),
            "pagina_atual" => $query->currentPage(),
            "resultados_por_pagina" => $query->perPage(),
            "dados" => $this->getDadosCadastroUC($query->items())
        );
        return response()->json($this->result, 200, array('Content-Type' => 'application/json;charset=UTF-8'),JSON_UNESCAPED_UNICODE);
    }

    private function getDadosCadastroUC($dados){
        $lista = array();
        $index = 0;
        foreach($dados as $uc){
            $atributos = $uc["attributes"];
            $municipio_concessionaria = new get_cidade_concessionaria_de_UF;
            $municipio_concessionaria = $municipio_concessionaria->transformar($atributos["uf"],$atributos["municipio"],$atributos["concessionaria"]);

            array_push($lista,array(
                "hash" => $atributos["hash"],
                "criado_em" => $atributos["created_at"],
                "ultima_atualizacao" => $atributos["updated_at"],
                "localizacao" => array(
                    "endereco" => $atributos["endereco"],
                    "num_endereco" => $atributos["num_endereco"],
                    "cep" => $atributos["cep"],
                    "uf" => $atributos["uf"],
                    "municipio" => $municipio_concessionaria["municipio"]
                ),
                "configuracao" => array()
            ));

            if($atributos["grupo"] == "B"){
                $lista[$index]["configuracao"] = array(
                    "concessionaria" => $municipio_concessionaria["concessionaria"],
                    "tipo_estabelecimento" => $this->tranfTipoEstabelecimento($atributos["tipo_estabelecimento"]),
                    "classe" => $atributos["classe"],
                    "modalidade" => $this->tranfModalidade($atributos["modalidade"]),
                    "consumo" => $this->gerarArrConsumo($atributos)
                );
            }else{
                $lista[$index]["configuracao"] = array(
                    "concessionaria" => $municipio_concessionaria["concessionaria"],
                    "tipo_estabelecimento" => $this->tranfTipoEstabelecimento($atributos["tipo_estabelecimento"]),
                    "grupo" => $atributos["grupo"],
                    "modalidade" => $this->tranfModalidade($atributos["modalidade"]),
                    "consumo" => $this->gerarArrConsumo($atributos)
                );
            }
            $index++;   
        }
        return $lista;
    }
    private function gerarArrConsumo($dados){
        if($dados["grupo"] == "B"){
            if($dados["modalidade"] == "conv"){
                return array(
                    "consumo_conv" => explode(",",$dados["consumo_conv"]),
                    "consumo_total" => $dados["consumo_total"]
                );
            }
            if($dados["modalidade"] == "branca"){
                return array(
                    "consumo_fp" => explode(",",$dados["consumo_fp"]),
                    "consumo_int" => explode(",",$dados["consumo_int"]),
                    "consumo_p" => explode(",",$dados["consumo_p"]),
                    "consumo_fp_total" => $dados["consumo_fp_total"],
                    "consumo_int_total" => $dados["consumo_int_total"],
                    "consumo_p_total" => $dados["consumo_p_total"],
                    "consumo_total" => $dados["consumo_total"]
                );
            }
        }else{
            return array(
                "consumo_fp" => explode(",",$dados["consumo_fp"]),
                "consumo_p" => explode(",",$dados["consumo_p"]),
                "consumo_fp_total" => $dados["consumo_fp_total"],
                "consumo_p_total" => $dados["consumo_p_total"],
                "consumo_total" => $dados["consumo_total"]
            );
        }
        
    }

    private function tranfModalidade($modalidade){
        switch($modalidade){
            case "conv": return "Convencional";
            case "branca": return "Branca";
            case "verde": return "Verde";
            case "azul": return "Azul";

            default: return "Informação pendente";
        }
    }

    private function tranfTipoEstabelecimento($tipoEstabelecimento){
        switch($tipoEstabelecimento){
            case 1: return "Residencial";
            case 2: return "Rural";
            case 3: return "Comercial ou Industrial";
            case 4: return "Iluminação pública";

            default: return "Informação pendente";
        }
    }

    private function validacao(){
        foreach($this->dados as &$d){
            if(is_array($d) && count($d) == 1){
                $d = $d[0];
            }
        }
        if($this->dados["uf"] != "all"){
            if(is_array($this->dados["uf"])){
                foreach($this->dados["uf"] as &$uf){
                    $uf = strtoupper($uf);
                }
            }else{
                $this->dados["uf"] = strtoupper($this->dados["uf"]);
            }
        }
        if(
            !ValidacaoInput::require_not_null($this->dados)
            || ($this->dados["uf"] != "all" && !ValidacaoInput::require_length($this->dados["uf"],2))
            || !ValidacaoInput::require_order($this->dados["ordem"])
        ){
           return $this->validacao = (object)array('status' => 400, "msg" => "Input inválido");        
        }
        return $this->validacao = (object)array('status' => 200, "msg" => "Input válido"); 
    }

    private function where(){
        $where = array();

        $where_uf = $this->where_item("uf");
        if($where_uf !== false){
            array_push($where,["uf" => $where_uf]);
        }

        $where_municipio = $this->where_item("municipio");
        if($where_municipio !== false){
            array_push($where,["municipio" => $where_municipio]);
        }

        $where_concessionaria = $this->where_item("concessionaria");
        if($where_concessionaria !== false){
            array_push($where,["concessionaria" => $where_concessionaria]);
        }

        $where_usuario = $this->where_item("usuario");
        if($where_usuario !== false){
            array_push($where,["user_id" => $where_usuario]);
        }

        $this->where = array();
        foreach($where as $lista_where){
            foreach($lista_where as $key => $lista){
                $this->where += [$key => $lista];
                // foreach($lista as $item){
                //     // $this->where += [$key => $item];
                //     array_push($this->where,[$key => $item]);
                // }
            }
        }

    }

    private function where_item($i){
        if(array_key_exists($i,$this->dados) && $this->dados[$i] != "all"){
            $where = array();
            if(is_array($this->dados[$i])){
                foreach($this->dados[$i] as $item){
                    array_push($where,$item);
                }
            }else{
                array_push($where ,$this->dados[$i]);
            }
            return $where;
        }
        return false;
    }

    private function orderBy(){
        switch($this->dados["ordem"]){
            case "maior_consumo": $this->orderBy = array("coluna" => "consumo_total", "regra" => "desc");
            case "menor_consumo": $this->orderBy = array("coluna" => "consumo_total", "regra" => "asc");
            case "novo": $this->orderBy = array("coluna" => "created_at", "regra" => "desc");
            case "antigo": $this->orderBy = array("coluna" => "created_at", "regra" => "asc");

            default: $this->orderBy = array("coluna" => "created_at", "regra" => "desc");
        }
    }
    
}
