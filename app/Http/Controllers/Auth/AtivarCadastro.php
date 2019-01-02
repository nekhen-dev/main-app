<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\ModelVerificacaoEmail;
use App\User;

class AtivarCadastro extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function index($token){

        $token = htmlspecialchars($token,ENT_QUOTES);

        $query = ModelVerificacaoEmail::where('token',$token)->first();
        if(!$query){
            //Não achou. Link é inválido        
            return redirect()->route('homeEntrar')
                ->with("msg.status",404)
                ->with("msg.texto","Este link não é válido.");
        }else{
            //Achou mas o token não vale mais.
            if(!$query->token_ativo){
                return redirect()->route('homeEntrar')
                    ->with("msg.status",500)
                    ->with("msg.texto","Este link é inválido. O seu cadastro já foi ativado.");
            }
        }


        DB::beginTransaction();
        try{
            $usuario = User::where('email',$query->email)->first();
            $usuario->emailVerificado = true;
            $usuario->save();

            $query->token_ativo = false;
            $query->save();

            DB::commit();
            return redirect()->route('homeEntrar')
                ->with("msg.status",200)
                ->with("msg.texto","Cadastro ativado. Faça seu login.");
                
        }catch(\Exception $ex){

            DB::rollBack();
            return redirect()->route('homeEntrar')
                ->with("msg.status",$ex->getCode())
                ->with("msg.texto","Não foi possível ativar seu cadastro. Tente mais tarde.");
        }
    }
}
