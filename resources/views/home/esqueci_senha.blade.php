@extends('layouts.geral')

@section('titulo','Nekhen - Redefinir senha')

@section('css-include')
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section('js-include')
    <script src="{{ mix('/js/all.js') }}"></script>
@endsection

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('cor-fundo','#8FAADC')

@section('conteudo')
	<!-- ********************************************************* -->
	<!-- Começa a parte de conteúdo -->
	<div style="padding-bottom:5vw;background-color: inherit;"></div>
        <div class="setup_form">
            <div id="container_msg_validacao">
                <div id='msg_validacao1'></div>
                <div id='msg_validacao2'></div>
            </div>
            <div class="container-form-centro">
                <div class="container" style="text-align:center;">
                    <h1 class="form_titulo">Esqueci minha senha</h1>
                </div>
                <div class="container" style="text-align:center">
                    <small class="form-text text-muted">Para redefinir sua senha, informe seu e-mail. Você receberá uma mensagem com instruções</small>
                </div>
                <br/>
                <form method="post" action="ope_reset_senha.php" content-type="application/x-www-form-urlencoded"  id="formresetsenha" name="formresetsenha" >
                    {{ csrf_field() }}
                    <div id="container_itens_form">
                        <div class="input-group mb-2 style_div" style="display:flex;flex-direction:row;">
                            <div class="input-group-prepend">
                                <div class="input-group-text tag_email">@</div>
                            </div>
                            <input type="text" class="form-control style_input require_not_null require_email tag_email" tagOutlaw = "tag_email" id="email" name="email" placeholder="E-mail">
                        </div>
                        <div class="container" style="text-align:center">
                            <button type="submit" id="submit" class="btn btn-primary botao_azul" style="width:100%;">Enviar</button>
                        </div>
                    </div>
                </form>
                <br/>
                <div style="border-top:1px solid #8FAADC;width:100%;margin:0 10px;"></div>
                <br/>
                <div class="container" style="text-align:center;">
                    <a name="" id="" class="btn btn-success" style="width:100%;" href="{{route('homeEntrar')}}" role="button">Acessar</a>            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script id="template_validacao" type="text/x-jsrender">
        [*[if outLaws.length]]
            <div class="alert alert-danger" style="font-size:0.9em;text-align:center;" role="alert">
                <ul class="lista_validacao">
                    [*[for outLaws]]
                        <li>[*[>lawMsg]]</li>
                    [[/for]]
                </ul>
            </div>
        [[/if]]
    </script>
    <script id="template_retorno_bd_ok" type="text/x-jsrender">
        [*[if retorno_ok.length]]
            <div class="alert alert-success" style="font-size:0.9em;text-align:center;" role="alert">
                <ul class="lista_validacao">
                    [*[for retorno_ok]]
                        <li>[*[>lawMsg]]</li>
                    [[/for]]
                </ul>
            </div>
        [[/if]]
    </script>
    <script>
        var validacao = [];
        var retorno_bd_ok = [];
        $('#submit').click(function(event){
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra1',
                    ref:[
                        {name:'require_not_null'}
                    ],
                    msg:'O campo é obrigatório',
                    style_outlaws:'alert-danger'
                }
            );
            r.add_law(
                {
                    name:'regra3',
                    ref:[
                        {name:'require_email'}
                    ],
                    msg:'Forneça um email válido.',
                    style_outlaws:'alert-danger'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#container_itens_form');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }
        });

        $.views.settings.delimiters("[[", "]]", "*");

        var tmpl1 = $.templates("#template_validacao");
        tmpl1.link("#msg_validacao1", validacao);

        var tmpl2 = $.templates("#template_retorno_bd_ok");
        tmpl2.link("#msg_validacao2", retorno_bd_ok);
    </script>
@endsection