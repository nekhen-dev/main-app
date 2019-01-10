@extends('layouts.geral')

@section('titulo','Nekhen - Adicionar Unidade Consumidora')

@section('css-include')
    <link rel="stylesheet" href={{ mix('/css/all.css') }}>
@endsection

@section('js-include')
    {{-- <script type="text/javascript" src={{ mix('/js/all.js') }}></script>    --}}
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

        @include('templates.validacao.mensagem')

        <h5 style="font-weight:bold;">Adicione sua unidade consumidora</h5><br/>
        <div class="progress" style="background-color:white;border:1px solid lightgrey">
            <div class="progress-bar" style="width:0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br/> 
        <form method="POST" action="{{route('CadastrarUC.nova')}}" content-type="application/x-www-form-urlencoded" id="form_add_uc" name="form_add_uc">
            {{ csrf_field() }}
            <div id='ctn-tmpl-form_passo_gerais'></div>
            
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
                <h6 style="font-weight:bold">Preencha o seu consumo de energia sem as casas decimais</h6>
                <p style="font-size:0.9em">Lembre-se: o consumo de energia é medido em kWh.</p>
                </center>
                <div id='ctn-tmpl-consumo-media'></div>
                <div id='ctn-tmpl-consumo-historico' style="text-align:center"></div>
                <br/>
                <center>
                    <button id='btn_anterior_consumo_valor' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_proximo_consumo_valor' type="button" class="btn btn-primary">Próximo</button>
                </center>
            </div>
            <div id="form_passo_resumo" class="esconder">
                <div id='ctn-tmpl-form_passo_resumo'></div>
            </div>
            <br/>
        </form>
    </div>
    <br/>
</div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            $.views.settings.delimiters("[[", "]]", "*");
        });
    </script>
    @include('templates.validacao.template')
    @include('templates.CadastrarUC.templates')

@endsection