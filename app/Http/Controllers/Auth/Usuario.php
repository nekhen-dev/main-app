<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BD\BD_Usuario;

//Models
use App\Models\ModelCadastroUsuario;

//Emails
use App\Mail\EmailValidacaoCadastro;

//Controllers auxiliares
use App\Http\Controllers\ValidacaoInput;

class Usuario extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }
    public function create(Request $request){

        /*************************************
        1. Recebe e filtra os dados de cadastro
        2. Adiciona na tabela users
        3. Adiciona na tabela cadastroUsuario
        4. Adiciona token de verificacao na tabela verificacaoEmail
        5. Manda email de verificação
        **************************************/
        
        //1.Recebe e filtra os dados
        $dados_form = array(
            "nome" => $request->input('nome'),
            "sobrenome" => $request->input('sobrenome'),
            "email" => strtolower($request->input('email')),
            "password" => $request->input('password')
        );

        if(!filter_var($dados_form['email'], FILTER_VALIDATE_EMAIL)){
            return redirect()->route('homeCadastro')
                ->with("msg.status",500)
                ->with("msg.texto",'O email fornecido não é válido.');
        }

        $validacao = new ValidacaoInput;
        $validacao_senha = json_decode($validacao->validarSenhaCadastro($dados_form['password']));
        if($validacao_senha->status != 200){
            return redirect()->route('homeCadastro')
                ->with("msg.status",$validacao_senha->status)
                ->with("msg.texto",$validacao_senha->msg);
        }

        $dados_form['nome'] = htmlspecialchars($dados_form['nome'],ENT_QUOTES);
        $dados_form['sobrenome'] = htmlspecialchars($dados_form['sobrenome'],ENT_QUOTES);
        
        DB::beginTransaction();
        try{
            
            $usuario = new BD_Usuario($dados_form);
            if(!$usuario->insert_user()){
                return redirect()->route('homeCadastro')
                    ->with("msg.status",500)
                    ->with("msg.texto","Usuário já cadastrado.");
            }
            $usuario->insert_tokenVerificacaoEmail();
            
            // $email = new \stdClass();
            // $email->destinatario_email = $dados_form["email"];
            // $email->destinatario = $dados_form["nome"];
            // $email->remetente_email = "nao-responder@nekhen.com";
            // $email->remetente = "Nekhen";
            // $email->link = "http://".$_SERVER['HTTP_HOST']."/cadastro/ativar/".$usuario->tokenVerificacaoEmail;
            // $email_verificao = new EmailValidacaoCadastro($email);
            // $email_verificao->enviar();

            DB::commit();

            // return redirect()->route('homeCadastro')
            //     ->with("msg.status",200)
            //     ->with("msg.texto","Cadastro realizado com sucesso. Acesse seu email para ativar sua conta.");

            return redirect()->route('homeEntrar')
                ->with("msg.status",200)
                ->with("msg.texto","Cadastro realizado com sucesso. Faça seu login.");

        }catch(\Exception $ex){
            DB::rollBack();

            return redirect()->route('homeCadastro')
                ->with("msg.status",$ex->getCode())
                ->with("msg.texto","Não foi possível realizar o cadastro. Tente mais tarde.");
        }
            
    }
}
