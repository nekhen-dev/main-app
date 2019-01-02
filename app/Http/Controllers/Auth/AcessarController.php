<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


//Controllers auxiliares
use App\Http\Controllers\ValidacaoInput;

//Models
use App\User;

class AcessarController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/plataforma';

    public function novo_login(Request $request)
    {
        $this->middleware('guest')->except('logout');

        $dados_form = array(
            'email' => strtolower($request->input('email')),
            'password' => $request->input('password')
        );

        if(!filter_var($dados_form['email'], FILTER_VALIDATE_EMAIL)){
            return redirect()->route('homeEntrar')
                ->with("msg.status",500)
                ->with("msg.texto",'Email ou senha inválidos.');
        }

        $validacao = new ValidacaoInput;
        $validacao_senha = json_decode($validacao->validarSenhaCadastro($dados_form['password']));
        if($validacao_senha->status != 200){
            return redirect()->route('homeEntrar')
                ->with("msg.status",$validacao_senha->status)
                ->with("msg.texto",$validacao_senha->msg);
        }

        if(Auth::attempt(['email' => $dados_form['email'], 'password' => $dados_form['password']])){
            //Se passou, verificar se usuário é ativo
            $query = User::where('email',$dados_form['email'])->first();
            if(!$query->emailVerificado){
                return redirect()->route('homeEntrar')
                    ->with("msg.status",201)
                    ->with("msg.texto","Você ainda não ativou seu cadastro. Faça isso acessando o link que enviamos para o seu email ou solicite um novo link.");
            }
            return redirect()->route('plataforma');
        }else{
            return redirect()->route('homeEntrar')
            ->with("msg.status",404)
            ->with("msg.texto","Email ou senha inválidos.");
        }
    }
}