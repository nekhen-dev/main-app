<?php

namespace App\Http\Controllers\BD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\ModelCadastroUsuario;
use App\Models\ModelVerificacaoEmail;

class BD_Usuario extends Controller
{

    public $dados;
    public $tokenVerificacaoEmail;

    public function __construct($_dados){
        $this->dados = $_dados;
    }

    public function insert_user(){
        if(User::where('email', $this->dados['email'])->first()){
            return false;
        }else{
            return User::create([
                'hash' => hash('md2','oros'.$this->dados['email'].time()),
                'email' => $this->dados['email'],
                'password' => bcrypt($this->dados['password']),
                'nome' => $this->dados['nome'],
                'sobrenome' => $this->dados['sobrenome']
                ]);
        }
    }
    public function insert_tokenVerificacaoEmail(){
        $this->tokenVerificacaoEmail = hash('md2','oros'.$this->dados['email'].rand(0,1000));
        $query = ModelVerificacaoEmail::where('email',$this->dados['email'])->first();
        if(!$query){
            //Novo cadastro
            return ModelVerificacaoEmail::Create([
                'email' => $this->dados['email'],
                'token' => $this->tokenVerificacaoEmail
                ]);
        }
        //Atualizando cadastro antigo
        $query->token = $this->tokenVerificacaoEmail;
        $query->save();
        
    }

    
}
