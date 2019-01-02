@extends('layouts.geral')

@section('titulo','Nekhen - Adicionar Unidade Consumidora')

@section('css-include')
    <link rel="stylesheet" href="/css/all.css">
@endsection

@section('js-include')
    <script type="text/javascript" src="/js/all.js"></script>   
@endsection

@section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('cor-fundo','#ffffff')

@section('conteudo')
<div class="container-conteudo">
    @include('plataforma.cardPerfil')
    <div class="container-fluid container-secao margem-conteudo">
        <div style="padding-bottom:50px;background-color: inherit;"></div>
        <div class="container" style="width:fit-content">
            <center>
                <div id="container_msg_validacao">
                    <div id='msg_validacao1'></div>
                    <div id='msg_validacao2'></div>
                </div>
            </center>
        </div>
        <!-- <center> -->
            <h5 style="font-weight:bold;">Adicione sua unidade consumidora</h3><br/>
        <!-- </center> -->
        <div class="progress" style="background-color:white;border:1px solid lightgrey">
            <div class="progress-bar" style="width:0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br/> 
        <form method="POST" action="{{route('CadastrarUC.nova')}}" content-type="application/x-www-form-urlencoded" id="form_add_uc" name="form_add_uc">
            {{ csrf_field() }}
            <div id='form_passo_gerais'>
                <!-- **********************************8 -->
                <!-- Parte 1: Incluir dados gerais -->
                    <h6 style="font-weight:bold">Dados gerais</h5>
                    <div style='text-align:left' class='form_explicacao'>
                        *Campos obrigatórios
                    </div>
                    <div class="form_inner_ctn">
                        <div class="form_campos_width30 tam_box">
                            <select class="form-control texto-plataforma-cinza require_not_zero perfil" tagOutlaw = "perfil" name="tipo_uc" id="tipo_uc">
                                <option value="0">Perfil*</option>
                                <option value="1">Residencial</option>
                                <option value="2">Rural</option>
                                <option value="3">Comercial ou Industrial</option>
                                <option value="4">Iluminação pública</option>
                            </select>
                        </div>
                        <div class="form_campos_width70 tam_box">
                            <input type="text" class="form-control texto-plataforma-cinza require_not_null endereco" tagOutlaw = "endereco" name="endereco_uc" id="endereco_uc" aria-describedby="" placeholder="Endereço*">
                        </div>
                    </div>
                    <div class="form_inner_ctn">
                        <div class="form_campos_width20 tam_box">
                            <input type="text" class="form-control require_not_null endereco_num" tagOutlaw = "endereco_num" name="num_endereco_uc" id="num_endereco_uc" aria-describedby="" placeholder="Número*">
                        </div>
                        <div class="form_campos_width60 tam_box">
                            <input type="text" class="form-control" name="comp_endereco_uc" id="comp_endereco_uc" aria-describedby="" placeholder="Complemento">
                        </div>
                        <div class="form_campos_width20 tam_box">
                            <input type="text" class="form-control require_not_null require_zipcode cep" tagOutlaw = "cep" name="cep_uc" id="cep_uc" aria-describedby="" placeholder="CEP*">
                        </div>
                    </div>
                    <div class="form_inner_ctn">
                        <div class='form_campos_width10 tam_box'>
                            <select class="form-control require_not_zero uf" tagOutlaw = "uf" name="uf_uc" id="uf_uc" placeholder="">
                                <option value="0">UF*</option>
                                @foreach($listaUFs as $uf)
                                    <option value="{{$uf}}">{{$uf}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form_campos_width60 tam_box">
                            <select class="form-control input_bloqueado require_not_zero cidade" tagOutlaw = "cidade" name="sel_cidade_endereco_uc" id="sel_cidade_endereco_uc" disabled >
                                <option value="0">Cidade*</option>
                            </select>
                        </div>
                        <div class="form_campos_width30 tam_box">
                            <select class="form-control input_bloqueado require_not_zero concessionaria" tagOutlaw = "concessionaria" name="concessionaria_uc" id="concessionaria_uc" disabled>
                            <option value="0">Companhia de energia*</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <center>
                        <button id='btn_proximo_gerais' type="button" class="btn btn-primary">Próximo</button>
                    </center>
            </div>  
            <!-- Fim da parte geral -->

            <!-- *********************************** -->
            <!-- O consumo da UC -->
            <div id='form_passo_consumo_tipo' class="esconder">
                <center>
                    <h6 style="font-weight:bold">Tipos de tarifas de energia</h5>
                </center>
                <p>Verique sua conta de luz e marque os tipos de consumo que aparecem:</p>
                <div>
                    <div class="form-check">
                    <label class="form-check-label posto_tarifario" style="padding:10px 0">
                        <input type="checkbox" class="form-check-input require_one_check" name="check_conv" id="check_conv" value="checkedValue" unchecked>
                        <strong>Convencional</strong>: No caso de unidade consumidora na Classe B (baixa tensão). Se só aparece um tipo de consumo, esse é o seu caso.
                    </label>
                    </div>

                    <div class="form-check">
                    <label class="form-check-label posto_tarifario" style="padding:10px 0;">
                        <input type="checkbox" class="form-check-input require_one_check " name="check_fp_p" id="check_fp_p" value="checkedValue" unchecked>
                        <strong>Fora da Ponta e Ponta</strong>: No caso de unidade consumidora na classe A (alta e média tensão) ou na classe B (baixa tensão) optante pela Tarifa Branca. Substitui a modalidade Convencional.
                    </label>
                    </div>

                    <div class="form-check" >
                    <label class="form-check-label posto_tarifario" style="padding:10px 0;">
                        <input type="checkbox" class="form-check-input require_one_check " name="check_int" id="check_int" value="checkedValue" unchecked>
                        <strong>Intermediário</strong>: No caso de unidade consumidora na Classe B (baixa tensão) optante pela Tarifa Branca. Neste caso, você também tem consumo Fora da Ponta e na Ponta. Substitui a modalidade Convencional.
                    </label>
                    </div>

                </div>
                <br/>
                <center>
                    <button id='btn_anterior_consumo_tipo' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_proximo_consumo_tipo' type="button" class="btn btn-primary">Próximo</button>
                </center>
            </div>
            <div id='form_passo_consumo' class="esconder">
                <center>
                    <h6 style="font-weight:bold">Consumo de energia</h5>
                </center>
                <div id='escolhas_consumo'>
                    <p>Escolha abaixo como você quer informar o seu consumo de energia:</p>

                    <div class="form-check" >
                    <label class="form-check-label media_ou_historico" style="padding:10px 0;">
                        <input type="checkbox" class="form-check-input require_one_check" name="check_media_consumo" id="check_media_consumo" value="checkedValue" unchecked>
                        Quero informar apenas o consumo da minha última conta de luz. Seu cadastro será mais rápido, mas menos preciso.
                    </label>
                    </div>

                    <div class="form-check" >
                    <label class="form-check-label media_ou_historico" style="padding:10px 0;">
                        <input type="checkbox" class="form-check-input require_one_check" name="check_historico" id="check_historico" value="checkedValue" unchecked>
                        Estou com tempo. Quero preencher o meu histórico de consumo.
                    </label>
                    </div>
                </div>
                <br/>
                <center>
                    <button id='btn_anterior_consumo' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_proximo_consumo' type="button" class="btn btn-primary">Próximo</button>
                </center>
            </div>
            <div id="form_passo_consumo_valor" class="esconder">
                <center>
                <h6 style="font-weight:bold">Preencha o seu consumo de energia</h6>
                <p style="font-size:0.9em">Lembre-se: o consumo de energia é medido em kWh.</p>
                </center>
                <div id='ctn-tmpl-consumo-media'></div>
                <div id='ctn-tmpl-consumo-historico' style="text-align:center"></div>
                <br/>
                <center>
                    <button id='btn_anterior_consumo_valor' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_proximo_consumo_valor' type="button" class="btn btn-success">Concluir</button>
                </center>
            </div>
            <br/>
        </form>
    </div>
    <br/>
</div>

@endsection

@section('scripts')
    <script>
        /*
        Configurações iniciais ou gerais
        */
        //Configura máscara de CEP
        $('#cep_uc').mask('99999-999');  
    </script>
    <script>
        $('#uf_uc').change(function(){
            if($('#uf_uc').val()!="0"){
                
                $('#sel_cidade_endereco_uc').append("<option value='-1'>Carregando...</option>");
                $('#sel_cidade_endereco_uc').val(-1);
                $('#sel_cidade_endereco_uc').prop('disabled',true);
                $('#sel_cidade_endereco_uc').addClass('input_bloqueado');

                $('#concessionaria_uc').append("<option value='-1'>Carregando...</option>");
                $('#concessionaria_uc').val(-1);
                $('#concessionaria_uc').prop('disabled',true);
                $('#concessionaria_uc').addClass('input_bloqueado');

                $.get('/plataforma/api/get_cidade_concessionaria/'+$(this).val())
                    .done(function(data) {
                        $('#sel_cidade_endereco_uc').prop('disabled',false);
                        $('#sel_cidade_endereco_uc').removeClass('input_bloqueado');
                        $('#concessionaria_uc').prop('disabled',false);
                        $('#concessionaria_uc').removeClass('input_bloqueado');

                        get_list_form_from_json(data.municipios,'#sel_cidade_endereco_uc');
                        get_list_form_from_json(data.concessionarias,'#concessionaria_uc');
                    });
            }else{
                $('#sel_cidade_endereco_uc').prop('disabled',true);
                $('#sel_cidade_endereco_uc').addClass('input_bloqueado');
                $('#sel_cidade_endereco_uc').children('option:not(:first)').remove();
                
                $('#concessionaria_uc').prop('disabled',true);
                $('#concessionaria_uc').addClass('input_bloqueado');
                $('#concessionaria_uc').children('option:not(:first)').remove();
            }
        });
    </script>
    
    <script>
        // Reconfigura os delimitadores do JViews
        $.views.settings.delimiters("[[", "]]", "*");
    </script>
    <!-- Validação de formulario -->
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
        var form_consumo = {
            conv:false,
            fp_p:false,
            int:false,
            mostrar_consumo_media : false,
            mostrar_consumo_historico : false,
            grid_historico:'',
            meses:[
                {id:'jan',nome:'Jan',abrir:false},
                {id:'fev',nome:'Fev',abrir:false},
                {id:'mar',nome:'Mar',abrir:false},
                {id:'abr',nome:'Abr',abrir:false},
                {id:'mai',nome:'Mai',abrir:false},
                {id:'jun',nome:'Jun',abrir:false},
                {id:'jul',nome:'Jul',abrir:false},
                {id:'ago',nome:'Ago',abrir:false},
                {id:'set',nome:'Set',abrir:false},
                {id:'out',nome:'Out',abrir:false},
                {id:'nov',nome:'Nov',abrir:false},
                {id:'dez',nome:'Dez',abrir:false}
            ],
            abrir_todos:false
        };
        var msg_servidor={};
        @if (session('msg.status') && session('msg.texto'))
            msg_servidor.status = {{session('msg.status')}} ;
            msg_servidor.texto = "{{session('msg.texto')}}" ;
           {{session()->forget('msg.status')}}
           {{session()->forget('msg.texto')}}
        @endif
        var validacao = [];
        var retorno_bd_ok = [];
        if(msg_servidor.hasOwnProperty("status")){
            if(msg_servidor.status == 200){
                var validacao_bd = [
                    {
                        retorno_ok:[
                            {law: "retorno_bd", lawMsg: msg_servidor.texto}
                        ]
                    }
                ];
                $.observable(retorno_bd_ok).refresh(validacao_bd);
            }else{
                var validacao_bd = [
                    {
                        outLaws:[
                            {law: "retorno_bd", lawMsg: msg_servidor.texto}
                        ]
                    }
                ];
                $.observable(validacao).refresh(validacao_bd);
            }
        }
        $('#btn_proximo_gerais').click(function(event){
            $.observable(validacao).refresh([]);
            $.observable(retorno_bd_ok).refresh([]);
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra1',
                    ref:[
                        {name:'require_not_null'},
                        {name:'require_not_zero'}
                    ],
                    msg:'Campos obrigatórios.',
                    style_outlaws:'alert-danger'
                }
            );
            r.add_law(
                {
                    name:'regra2',
                    ref:[
                        {name:'require_zipcode'}
                    ],
                    msg:'Forneça um CEP válido.',
                    style_outlaws:'alert-danger'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#form_passo_gerais');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }else{
                $('.progress-bar').css('width','25%');
                $('.progress-bar').attr('aria-valuenow',25);
                $('#form_passo_gerais').addClass('esconder');
                $('#form_passo_consumo_tipo').removeClass('esconder');
                ir_para_msg_validacao('#container_msg_validacao');
            }
        });
    
    
        $('#btn_proximo_consumo_tipo').click(function(event){
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra1',
                    ref:[
                        {name:'require_one_check',tagOutlaw:"posto_tarifario"}
                    ],
                    msg:'Escolha pelo menos uma modalidade de consumo.',
                    style_outlaws:'alert_check_box'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#form_passo_consumo_tipo');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }else{
                $('.progress-bar').css('width','50%');
                $('.progress-bar').attr('aria-valuenow',50);
                $('#form_passo_consumo_tipo').addClass('esconder');
                $('#form_passo_consumo').removeClass('esconder');
                ir_para_msg_validacao('#container_msg_validacao');
                $.observable(form_consumo).setProperty('conv', false);
                $.observable(form_consumo).setProperty('fp_p', false);
                $.observable(form_consumo).setProperty('int', false);
                if($('#check_conv')[0].checked){
                    $.observable(form_consumo).setProperty('conv', true);
                    $.observable(form_consumo).setProperty('grid_historico', 'grid-2');
                }
                
                if($('#check_int')[0].checked){
                    $.observable(form_consumo).setProperty('fp_p', true);
                    $.observable(form_consumo).setProperty('int', true);
                    $.observable(form_consumo).setProperty('grid_historico', 'grid-4');
                }else{
                    if($('#check_fp_p')[0].checked){
                        $.observable(form_consumo).setProperty('fp_p', true);
                        $.observable(form_consumo).setProperty('grid_historico', 'grid-3');
                    }
                }
            }
        });
        $('#btn_proximo_consumo').click(function(event){
            let r = new myLaws();
            r.add_law(
                {
                    name:'regra1',
                    ref:[
                        {name:'require_one_check',tagOutlaw:"media_ou_historico"}
                    ],
                    msg:'Escolha como vai informar o seu consumo de energia.',
                    style_outlaws:'alert_check_box'
                }
            );
            var _regras = r.get_laws();
            var _container = $('#form_passo_consumo');
            let v = new myJudge(_container,_regras);
            v.release_outlaws();
            v.work();
            $.observable(validacao).refresh(v.get_accusations());
            if(v.get_hasOutlaws()){
                event.preventDefault();
                v.arrest_outlaws();
                ir_para_msg_validacao('#container_msg_validacao');
            }else{
                $('.progress-bar').css('width','75%');
                $('.progress-bar').attr('aria-valuenow',75);
                $('#form_passo_consumo').addClass('esconder');
                $('#form_passo_consumo_valor').removeClass('esconder');
                $.observable(form_consumo).setProperty('mostrar_consumo_media', $('#check_media_consumo')[0].checked);
                $.observable(form_consumo).setProperty('mostrar_consumo_historico', $('#check_historico')[0].checked);
            }
        });
        $('#btn_proximo_consumo_valor').click(function(event){
            if(form_consumo.mostrar_consumo_media){
                let r = new myLaws();
                r.add_law(
                    {
                        name:'regra2',
                        ref:[
                            {name:'require_num'}
                        ],
                        msg:'Seu consumo precisa ser um número.',
                        style_outlaws:'alert-danger'
                    }
                );
                r.add_law(
                    {
                        name:'regra3',
                        ref:[
                            {name:'require_sum_ge',tagOutlaw:"tag_media_valor",val:0}
                        ],
                        msg:'Seu consumo não pode ser zero.',
                        style_outlaws:'alert-danger'
                    }
                );
                var _regras = r.get_laws();
                var _container = $('#form_passo_consumo_valor');
                let v = new myJudge(_container,_regras);
                v.release_outlaws();
                v.work();
                $.observable(validacao).refresh(v.get_accusations());
                if(v.get_hasOutlaws()){
                    event.preventDefault();
                    v.arrest_outlaws();
                    ir_para_msg_validacao('#container_msg_validacao');
                }else{
                    $('#form_add_uc').submit();
                }
            }
            if(form_consumo.mostrar_consumo_historico){
                let r = new myLaws();
                r.add_law(
                    {
                        name:'regra1',
                        ref:[
                            {name:'require_one_check',tagOutlaw:"tag_mes_consumo"}
                        ],
                        msg:'Abra pelo menos 1 mês para preencher o consumo.',
                        style_outlaws:'alert_check_box'
                    }
                );
                r.add_law(
                    {
                        name:'regra3',
                        ref:[
                            {name:'require_num'}
                        ],
                        msg:'Seu consumo precisa ser um número.',
                        style_outlaws:'alert-danger'
                    }
                );
                r.add_law(
                    {
                        name:'regra4',
                        ref:[
                            {name:'require_sum_ge',tagOutlaw:"tag_historico_valor",val:0}
                        ],
                        msg:'Seu consumo não pode ser zero.',
                        style_outlaws:'alert-danger'
                    }
                );
                var _regras = r.get_laws();
                var _container = $('#form_passo_consumo_valor');
                let v = new myJudge(_container,_regras);
                v.release_outlaws();
                v.work();
                $.observable(validacao).refresh(v.get_accusations());
                if(v.get_hasOutlaws()){
                    event.preventDefault();
                    v.arrest_outlaws();
                    ir_para_msg_validacao('#container_msg_validacao');
                }else{
                    $('#form_add_uc').submit();
                }
            }
            
        });
    
        var tmpl1 = $.templates("#template_validacao");
        tmpl1.link("#msg_validacao1", validacao);
    
        var tmpl2 = $.templates("#template_retorno_bd_ok");
        tmpl2.link("#msg_validacao2", retorno_bd_ok);
    
    </script>
    <script>
        // Configura os botões de voltar
        $('#btn_anterior_consumo_tipo').click(function(event){
            $('.progress-bar').css('width','0%');
            $('.progress-bar').attr('aria-valuenow',0);
            ir_para_msg_validacao('#container_msg_validacao');
            $('#form_passo_consumo_tipo').addClass('esconder');
            $('#form_passo_gerais').removeClass('esconder');
        });
        $('#btn_anterior_consumo').click(function(event){
            $('.progress-bar').css('width','25%');
            $('.progress-bar').attr('aria-valuenow',25);
            ir_para_msg_validacao('#container_msg_validacao');
            $('#form_passo_consumo').addClass('esconder');
            $('#form_passo_consumo_tipo').removeClass('esconder');
        });
        $('#btn_anterior_consumo_valor').click(function(event){
            $('.progress-bar').css('width','50%');
            $('.progress-bar').attr('aria-valuenow',50);
            ir_para_msg_validacao('#container_msg_validacao');
            $('#form_passo_consumo_valor').addClass('esconder');
            $('#form_passo_consumo').removeClass('esconder');
        });
    </script>
    <script>
        // Configura os checkbox de modalidade de consumo
        $('#check_fp_p').change(function(){
            if(this.checked) {
                $('#check_conv').prop('checked',false);
            }else{
                $('#check_int').prop('checked',false);
            }
        });
        $('#check_int').change(function(){
            if(this.checked) {
                $('#check_fp_p').prop('checked',true);
                $('#check_conv').prop('checked',false);
            }
        });
        $('#check_conv').change(function(){
            if(this.checked) {
                $('#check_fp_p').prop('checked',false);
                $('#check_int').prop('checked',false);
            }
        });
    </script>
    <script>
        //Configura as checkbox de media e histórico de consumo
        $('#check_media_consumo').change(function(){
            if(this.checked){
                $('#check_historico').prop('checked',false);
            }
        });
        $('#check_historico').change(function(){
            if(this.checked){
                $('#check_media_consumo').prop('checked',false);
            }
        });
    </script>
    <script id="templ_consumo_media" type="text/x-jsrender">
        [*[if mostrar_consumo_media]]
            <center>
                <div style="display:grid;max-width:500px;">
                    [*[if conv]]
                        <div class="grid-row-consumo-media">
                            <label for="consumo_media_conv">Consumo</label>
                            <input type="text"
                                class="form-control require_num require_sum_ge tag_media_conv tag_media_valor" tagOutlaw="tag_media_conv" name="consumo_media_conv" id="consumo_media_conv" placeholder="">
                        </div>
                    [[/if]]
                    [*[if fp_p]]
                        <div class="grid-row-consumo-media">
                            <label for="consumo_media_fp">Fora da Ponta</label>
                            <input type="text"
                                class="form-control require_num require_sum_ge tag_media_fp tag_media_valor"  tagOutlaw="tag_media_fp" name="consumo_media_fp" id="consumo_media_fp" placeholder="">
                        </div>
                    [[/if]]
                    [*[if int]]
                        <div class="grid-row-consumo-media">
                            <label for="consumo_media_int">Intermediário</label>
                            <input type="text"
                                class="form-control require_num require_sum_ge tag_media_int tag_media_valor"  tagOutlaw="tag_media_int" name="consumo_media_int" id="consumo_media_int" placeholder="">
                        </div>
                    [[/if]]
                    [*[if fp_p]]
                        <div class="grid-row-consumo-media">
                            <label for="consumo_media_p">Ponta</label>
                            <input type="text"
                                class="form-control require_num require_sum_ge tag_media_p tag_media_valor"  tagOutlaw="tag_media_p" name="consumo_media_p" id="consumo_media_p" placeholder="">
                        </div>
                    [[/if]]  
                </div>
            </center>
        [[/if]]
    </script>
    <script id="templ_consumo_historico" type="text/x-jsrender">
    [*[if mostrar_consumo_historico]]  
        <div>
            <p style="font-size:0.9em">Escolha os meses e preencha os valores para os quais você tem consumo de energia.</p>
            <center>
                <div data-link="class[:grid_historico]">
                    <div class="espacamento-grid-row" style="width:60px;">
                        Mês
                    </div>
                    [*[if conv]]
                    <div class="espacamento-grid-row">
                        Consumo
                    </div>
                    [[/if]]
                    [*[if fp_p]]
                    <div class="espacamento-grid-row" >
                        F. Ponta
                    </div>
                    [[/if]]
                    [*[if int]]
                    <div class="espacamento-grid-row">
                        Inter.
                    </div>
                    [[/if]]
                    [*[if fp_p]]
                    <div class="espacamento-grid-row">
                        Ponta
                    </div>
                    [[/if]]
                    [[for meses]]
                        <div class="espacamento-grid-row" style="width:60px;text-align:left">
                            <input type="checkbox" data-link="abrir" class="mes_[[:id]] check_mes require_one_check" name="check_mes_consumo_[[:id]]" id="check_mes_consumo_[[:id]]" value="checkedValue" unchecked>
                            <label style="padding-left:3px" for="check_mes_consumo_[[:id]]" class="tag_mes_consumo">[[:nome]]</label>
                        </div>
                        [*[if ~root.conv]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_conv_[[:id]]" tagOutlaw="tag_historico_conv_[[:id]]" name="consumo_conv_[[:id]]" id="consumo_conv_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.fp_p]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_fp_[[:id]]" tagOutlaw="tag_historico_fp_[[:id]]" name="consumo_fp_[[:id]]" id="consumo_fp_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.int]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado  tam_box require_num tag_historico_int_[[:id]]" tagOutlaw="tag_historico_int_[[:id]]" name="consumo_int_[[:id]]" id="consumo_int_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                        [*[if ~root.fp_p]]
                            <div class="espacamento-grid-row" style="width:100%">
                                <input type="text" data-link="class[merge:!abrir toggle='input_bloqueado'] class[merge:abrir toggle='require_sum_ge tag_historico_valor'] disabled[:!abrir]" class="form-control mes_[[:id]] input_bloqueado tam_box require_num tag_historico_p_[[:id]]" tagOutlaw="tag_historico_p_[[:id]]" name="consumo_p_[[:id]]" id="consumo_p_[[:id]]" placeholder="" disabled>
                            </div>
                        [[/if]]
                    [[/for]]
                </div>
            </center>
        </div>
    [[/if]]
    </script>
    <script>
        
        var tmpl_consumo_media = $.templates("#templ_consumo_media");
        tmpl_consumo_media.link("#ctn-tmpl-consumo-media", form_consumo);
    
        var tmpl_consumo_historico = $.templates("#templ_consumo_historico");
        tmpl_consumo_historico.link("#ctn-tmpl-consumo-historico", form_consumo);
    </script>
@endsection