<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidacaoInput extends Controller
{
    
    public function validarSenhaCadastro($senha){
        $senha_invalida=false;
        
        ($senha != filter_var($senha,FILTER_SANITIZE_STRING))?$senha_invalida=true:false; //Caracteres inválidos
        (strlen($senha)<6)?$senha_invalida=true:false; //número de caracteres

        if($senha_invalida){
            return '{"status":500,"msg":"Sua senha precisa ter pelo menos 6 caracteres e não pode ter caracteres especiais."}';
        }else{
            return '{"status":200,"msg":"Senha válida"}';
        }
    }
    static function require_not_null($input){
        if(is_array($input)){
            foreach($input as $item){
                if($item == ''){
                    return false;
                }
            }
        }else{
            if($input == ''){
                return false;
            }
        }
        
        return true;
    }
    static function require_num($input){
        if(is_array($input)){
            foreach($input as $item){
                if(!is_numeric($item)){
                    return false;
                }
            }
        }else{
            if(!is_numeric($input)){
                return false;
            }
        }
        
        return true;
    }
    static function require_order($input){
        switch($input){
            case 'maior_consumo':
            case 'menor_consumo':
            case 'novo':
            case 'antigo':  return true;

            default: return false;
        }
    }
    static function require_length_min($input,$lengthMin){
        if(is_array($input)){
            foreach($input as $item){
                if(strlen($item)<$lengthMin){
                    return false;
                }
            }
        }else{
            if(strlen($input)<$lengthMin){
                return false;
            }
        }
        
        return true;
    }
    static function require_length_max($input,$lengthMax){
        if(is_array($input)){
            foreach($input as $item){
                if(strlen($item)>$lengthMax){
                    return false;
                }
            }
        }else{
            if(strlen($input)>$lengthMax){
                return false;
            }
        }
        
        return true;
    }
    static function require_length($input,$length){
        if(is_array($input)){
            foreach($input as $item){
                if(strlen($item)!=$length){
                    return false;
                }
            }
        }else{
            if(strlen($input)!=$length){
                return false;
            }
        }
        return true;
    }
}
