@extends('layouts.geral')

@section('titulo','Nekhen - Adicionar Unidade Consumidora')

@section('css-include')
    <link rel="stylesheet" href="/css/all.css">
@endsection

@section('js-include')
    <script type="text/javascript" src="/js/all.js"></script>   
@endsection

<!-- @section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection -->

@section('cor-fundo','#ffffff')

@section('conteudo')
<div class="container-conteudo">
    <!-- @include('plataforma.cardPerfil') -->
    <div class="container-fluid container-secao margem-conteudo">
        <div style="padding-bottom:50px;background-color: inherit;"></div>
        <div id="ctn-tmpl-form_passo_resumo"></div>

    </div>
    <br/>
</div>

@endsection

@section('scripts')

    @include('testes.templateResumoCadastrarUC')

@endsection