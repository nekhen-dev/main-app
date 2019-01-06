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
        <h5>Minhas unidades consumidoras</h5>
        <div id="container-MinhasUCs">
            <div data-link='[include tmpl="templ_filtro"/]'></div>
            <div data-link="[for ucs() tmpl='templ_lista']"></div>
        </div>
    </div>
    <br/>
</div>

@endsection

@section('scripts')

    <script>
        // $(document).ready(function(){
        //     $.views.settings.delimiters("[[", "]]", "*");
        // });
    </script>
    @include('templates.validacao.template')
    
    {{-- <script src="{{ mix('/js/components/all.js') }}"></script> --}}
    <script>
        let model = new AppUnidadesConsumidoras();
        model.loadMinhasUCsApp();
        var ListarUCsApp = model.componente;
        
        var ListaUC = $.views.viewModels.ListarUCsApp.map({
            filtro: {},
            ucs : [],
            resultado:{}
        });
        ListaUC.init();
        console.log(ListaUC);
        $.link(true, "#container-MinhasUCs", ListaUC);
        $('.chosen-js').chosen();
    </script>
@endsection