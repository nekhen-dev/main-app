<div id="card-container"></div>

<script id="templ_card" type="text/x-jsrender">
    <div class="margem-conteudo setup_card_perfil_secao">
        <div class="box-imagem card_perfil_secao">
            <img src="/img/[[:perfil]]2.png" width="20px" height="auto" alt="[[:titulo]]">
            <span>[[:titulo]]</span>
        </div>
    </div>
</script>
<script>
    var dados = {};
    dados.perfil = '{{session('perfil')}}';
    switch(dados.perfil){
        case 'consumidor': dados.titulo = "Consumidor"; break;
        case 'instalador': dados.titulo = "Instalador"; break;
        case 'desenvolvedor': dados.titulo = "Desenvolvedor"; break;
    }

    $.views.settings.delimiters("[[", "]]");
    //Renderiza a navbar junto com a top bar
    var render1 = $.templates("#templ_card").render(dados);
    $("#card-container").html(render1);
</script>