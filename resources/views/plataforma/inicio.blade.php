@extends('layouts.geral')

@section('titulo','Nekhen - Plataforma')

@section('css-include')
    <link rel="stylesheet" href={{ mix('/css/all.css') }}>
@endsection

{{-- @section('js-include')
    <script src="/js/NoOutlaw-Classes.js"></script>
@endsection --}}

{{-- @section('csrf-token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection --}}

@section('cor-fundo','#ffffff')

@section('conteudo')
    <div style="padding-bottom:2vw;background-color: inherit;"></div>
    <!-- ********************************************************* -->
    <!-- Começa a parte de conteúdo -->
    <div class="container-secao" style="text-align:center">
        <div class="container" style="text-align:center;">
            <h1 >Bem vindo à NEKHEN</h1>
            <p >Antes de começar, escolha o seu perfil. Cada perfil tem funcionalidades específicas. Fique a vontade para experimentar com todos.</p>
        </div>
        <div>
            <div class="" id="render_templ_perfil"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script id="templ_perfil" type="text/x-jsrender">
        <div class="box-conteudo">
            <div data-toggle="collapse" href=#[[:collapsable]] role="button" aria-expanded="false" aria-controls=[[:collapsable]]>
                <div class="box-conteudo-card box-imagem" >
                    <img src=[[:imagem]] width="40px" height="auto" title=[[:titulo]]/>
                    <br/>
                    <span style="color:white;font-weight:bold;font-size:16px;padding:0;">
                        [[:titulo]]
                    </span>
                </div>
                <div class="collapse box-conteudo-card box-texto" id=[[:collapsable]]>
                    <ul>
                        [[for lista]]
                            <li>[[:texto_item]]</li>
                        [[/for]]
                    </ul>
                    <br/>
                    <a name="" id="" class="btn btn-primary" href=[[:link]] role="button">Escolher</a>
                </div>
            </div>
        </div>
    </script>
    <script>
        var perfil = [
            {
                titulo:"Consumidor",
                link:"{{route('consumidor')}}",
                imagem:"/img/consumidor2.png",
                lista:[
                    {texto_item: "Cadastre sua unidade consumidora"},
                    {texto_item: "Simule um sistema de geração"},
                    {texto_item: "Encontre usinas para alugar um sistema"},
                    {texto_item: "Encontre instaladores e solicitar orçamento"}
                ],
                collapsable:"collapseConsumidor"
            },
            {
                titulo:"Instalador",
                link:"/plataforma/#",
                imagem:"/img/instalador2.png",
                lista:[
                    {texto_item: "Promova sua empresa"},
                    {texto_item: "Oferte seus serviços"},
                    {texto_item: "Encontre oportunidades de negócios"},
                    {texto_item: "Encontre instaladores e solicitar orçamento"}
                ],
                collapsable:"collapseInstalador"
            },
            {
                titulo:"Desenvolvedor",
                link:"/plataforma/#",
                imagem:"/img/desenvolvedor2.png",
                lista:[
                    {texto_item: "Promova sua usina e projeto"},
                    {texto_item: "Encontre unidade consumidoras"},
                    {texto_item: "Certifique seu projeto"}
                ],
                collapsable:"collapseDesenvolvedor"
            }
        ];
        //Renderiza a navbar junto com a top bar
        $.views.settings.delimiters("[[", "]]", "*");
        var render = $.templates("#templ_perfil").render(perfil);
        $("#render_templ_perfil").html(render);
    </script>
@endsection