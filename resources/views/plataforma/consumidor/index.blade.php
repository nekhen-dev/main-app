@extends('layouts.geral')

@section('titulo','Nekhen - Consumidor')

@section('css-include')
    <link rel="stylesheet" href="/css/all.css">
@endsection

{{-- @section('js-include')
    <script src="/js/NoOutlaw-Classes.js"></script>
@endsection --}}

{{-- @section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection --}}

@section('cor-fundo','#ffffff')

@section('conteudo')
    <!-- ********************************************************* -->
    <!-- Começa a parte de conteúdo -->
    <div class="container-conteudo">
        @include('plataforma.cardPerfil')
        <div class="container container-secao">
            <div style="padding-bottom:50px;background-color: inherit;"></div>
            <center>
                <h3>Isto aqui que está meio deserto</h1>
                <span class="lead">Você ainda não tem unidades consumidoras cadastradas</span>
                <div class='deserto'></div>
                <div>
                <a name="add_uc" id="add_uc" class="btn btn-primary" href="{{route('CadastrarUC')}}" role="button">
                        Cadastre uma unidade consumidora
                    </a>
                </div>
            </center>
        </div>
    </div>
@endsection

@section('scripts')
@endsection