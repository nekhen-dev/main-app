@extends('layouts.geral')

@section('titulo','Nekhen - Adicionar Unidade Consumidora')

@section('css-include')
    <link rel="stylesheet" href={{ mix('/css/all.css') }}>
@endsection

@section('js-include')
    
@endsection

@section('csrf-token')
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
@endsection

@section('cor-fundo','#ffffff')

@section('conteudo')
<div class="container-conteudo">
    @include('plataforma.cardPerfil')
    <div class="container-fluid container-secao margem-conteudo">
        <div style="padding-bottom:50px;background-color: inherit;"></div>
        @include('templates.validacao.mensagem')
        <h5>Minhas unidades consumidoras</h5>
        <div id="app-container" >
            <minhas-ucs></minhas-ucs>
        </div>
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
    <script type="text/javascript" src='/js/app.js'></script>
@endsection