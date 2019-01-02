<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BD\BD_Usuario;

//Model
// use App\Models\ModelCadastroUsuario;
use App\User;

//Email
use App\Mail\EmailReenviarEmailAtivacao;

class ReenviarEmailAtivacao extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function index(Request $request){
        
        $email_form = $request->input('email');
        if(!filter_var($email_form, FILTER_VALIDATE_EMAIL)){
            return redirect()->route('homeReenviarEmailAtivacao')
                ->with("msg.status",500)
                ->with("msg.texto",'O email fornecido não é válido.');
        }

        DB::beginTransaction();
        try{
            
            $query = User::where('email', $email_form)->first();
            if(!$query){
                return redirect()->route('homeReenviarEmailAtivacao')
                    ->with("msg.status",404)
                    ->with("msg.texto",'Usuário não cadastrado');
            }
            if($query->emailVerificado){
                return redirect()->route('homeEntrar')
                    ->with("msg.status",200)
                    ->with("msg.texto",'Seu cadastro já foi ativado. Faça seu login.');
            }
            $nome = $query->nome;
            $dados = array("email"=>$email_form,"nome"=>$nome);
    
            $usuario = new BD_Usuario($dados);
            $usuario->insert_tokenVerificacaoEmail();
            
            $email = new \stdClass();
            $email->destinatario_email = $dados['email'];
            $email->destinatario = $dados['nome'];
            $email->remetente_email = "nao-responder@nekhen.com";
            $email->remetente = "Nekhen";
            $email->link = "http://".$_SERVER['HTTP_HOST']."/cadastro/ativar/".$usuario->tokenVerificacaoEmail;
            $email_verificao = new EmailReenviarEmailAtivacao($email);
            $email_verificao->enviar();

            DB::commit();

            return redirect()->route('homeEntrar')
                ->with("msg.status",200)
                ->with("msg.texto","Um novo link foi enviado para o seu email.");
        }catch(\Exception $ex){
            DB::rollBack();

            return redirect()->back()
                ->with("msg.status",$ex->getCode())
                ->with("msg.texto","Não foi possível realizar esta operação. Tente mais tarde.");
        }
        

    }
}
