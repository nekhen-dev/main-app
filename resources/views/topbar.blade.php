<div class="top-bar-setup">
    <div class="container-topbar">
        <div class="conteiner-topbar-logo">
            <span class="top-logo-nome"><strong>NEKHEN</strong></span>
        </div>
        <div id='topbar_nav-container' style="text-align:right"></div>
    </div>
</div>
<div style="text-align:right">
    <div id='fundo_opaco' class='fundo_opaco esconder'></div>
    <div id='ctn_nav_checked' class='ctn_nav_checked' >
        <div style="border-bottom:1px solid lavender">
            <button id='menu_checked' class='menu_checked'>Menu</button>
        </div>
        <div style="margin-top:20px;">
            <ul id="nav_collapsable" class="nav_list_collapsable"></ul>
        </div>
    </div>
</div>
<div style="padding-bottom:10px;background-color: inherit;"></div>
<!-- ************************ -->
<!-- Script menu dinâmico -->
<script>
$(document).ready(function(){
    $('#menu_unchecked').click(function(){
        
        $('body').addClass('remove_barra_rolagem');
        
        // $('#ctn_nav_unchecked').addClass('esconder');
        
        $('#ctn_nav_checked').addClass('mostrar_collapsable');
        $('#ctn_nav_checked').removeClass('esconder_collapsable');

        $('#fundo_opaco').removeClass('esconder');
    
    });
    $('#menu_checked').click(function(){
        // $('#ctn_nav_unchecked').removeClass('esconder');
        $('#ctn_nav_checked').addClass('esconder_collapsable');
        $('#ctn_nav_checked').removeClass('mostrar_collapsable');

        $('#fundo_opaco').addClass('esconder');
        $('body').removeClass('remove_barra_rolagem');
    });
    $('#fundo_opaco').click(function(){
        // $('#ctn_nav_unchecked').removeClass('esconder');
        $('#ctn_nav_checked').addClass('esconder_collapsable');
        $('#ctn_nav_checked').removeClass('mostrar_collapsable');

        $('#fundo_opaco').addClass('esconder');
        $('body').removeClass('remove_barra_rolagem');
    })
});
</script>

<script id="templ_topbar" type="text/x-jsrender">
    [[if nav && nav.length]]
        <div class="topbar-nav" >
            <ul class="list-inline nav-list">
                [[for nav]]
                    <li class="list-inline-item">
                        <a name="acessar" id="" class="nav-list-link [[if estilo_contorno]]nav-contorno[[/if]]" href="[[:link]]" role="button">
                            [[:texto]]
                        </a>
                    </li>
                [[/for]]
            </ul>
        </div>
    [[/if]]
    <div style="display:flex;flex-direction:row;float:right">
        [[if menu.mostrar]]
            <div id='ctn_nav_unchecked' class='icones_secao ctn_nav_unchecked [[if menu.apenas_responsivo]] esconder_menu [[/if]]'>
                <button id='menu_unchecked' class='menu_unchecked menu_unchecked_branco' ></button>
            </div>
        [[/if]]
        [[if trocar_perfil]]
            <div style="margin-top:10px;">
                <a class="botao_trocar_perfil icones_secao" name="sair" id="sair" href="/plataforma" role="button" alt="Trocar perfil"></a>
            </div>
        [[/if]]
        [[if sair]]
            <div style="margin-top:10px;">
                <a class="botao_sair icones_secao" name="sair" id="sair" href="/plataforma/sair" role="button" alt="Sair"></a>
            </div>
        [[/if]]
    </div>
</script>
<script id="templ_topbar_collapsable" type="text/x-jsrender">
    <li class="">
        [[if dropdown && dropdown.length]]
            <a class="collapsable_links [[if estilo_contorno]]collapsable_links_contorno[[/if]]" data-toggle="collapse" href="#side-bar-dropdown" role="button" aria-expanded="false" aria-controls="side-bar-dropdown">
            [[if imagem_left]]<img src=[[:imagem_left.path]] width=[[:imagem_left.size]] height="auto"/>[[/if]]
            [[:texto]]
            [[if imagem_right]] <img src=[[:imagem_right.path]] width=[[:imagem_right.size]] height="auto"/> [[/if]]
            </a>
            <div class="collapse" id="side-bar-dropdown" style="background-color:#e9ecef ">
                <ul id="nav_collapsable" class="nav_list_collapsable">
                    [[for dropdown]]
                        <li class="">
                            <a name="" id="" class="collapsable_links collapsable-dropdown-links" href="[[:link]]" role="button">
                                [[if imagem_left]]<img src=[[:imagem_left.path]] width=[[:imagem_left.size]] height="auto"/>[[/if]]
                                [[:texto]]
                                [[if imagem_right]] <img src=[[:imagem_right.path]] width=[[:imagem_right.size]] height="auto"/> [[/if]]
                            </a>
                        </li>
                    [[/for]]
                </ul>
            </div>
        [[else]]
            <a name="" id="" class="collapsable_links [[if estilo_contorno]]collapsable_links_contorno[[/if]]" href="[[:link]]" role="button">
                [[if imagem_left]]
                    <img src=[[:imagem_left.path]] width=[[:imagem_left.size]] height="auto"/>
                [[/if]]
                [[:texto]]
            </a>
        [[/if]]
    </li>
</script>
<script>
    var path_img_nav = '/img/';
    var lupa_azul_grande = {path:path_img_nav+"search_azul.png",size:"15px"};

    var seta_dropdown_azul = {path:path_img_nav+"seta-dropdown-azul.png",size:"15px"};
    var links_intro = [
        {
            texto : "Home", link : "/"
        },
        {
            texto : "A Plataforma", link : "#"
        },
        {
            texto : "Simulador Solar", link : "#"
        },
        {
            texto : "Quem Somos", link : "#"
        },
        {
            texto : "Acessar", link : "/entrar", estilo_contorno : true
        }
    ];
    var links_consumidor = [
        {
            texto : "Início", link : "/plataforma/consumidor"
        },
        {
            texto:"Unidades Consumidoras", imagem_left:seta_dropdown_azul,
            dropdown:[
                {texto : "Minhas unidades", link : "#"},
                {texto : "Adicionar nova unidade", link : "{{route('CadastrarUC')}}"}
            ]
        },
        {
            texto : "Contratações", link : "#"
        },
        {
            texto : "Instaladores", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Usinas", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Avaliações", link : "#"
        }
    ];
    var links_instalador = [
        {
            texto : "Início", link : "#"
        },
        {
            texto : "Minhas obras", link : "#"
        },
        {
            texto : "Unidades consumidoras", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Usinas", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Avaliações", link : "#"
        }
    ];
    var links_desenvolvedor = [
        {
            texto : "Início", link : "#"
        },
        {
            texto : "Minhas obras", link : "#"
        },
        {
            texto : "Unidades consumidoras", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Usinas", link : "#", imagem_left:lupa_azul_grande
        },
        {
            texto : "Avaliações", link : "#"
        }
    ];
    var premium = {habilitado:true, texto : "Premium", link : "#", estilo_contorno : true};
    links_consumidor.push(premium);
    links_instalador.push(premium);
    links_desenvolvedor.push(premium);

    /*
    Determina qual os links a mostrar no menu aberto
    */
    var topbar_data = {};
    var sidebar_links = [];
    var login = false;
    var perfil_secao = '';
    @if(!session()->exists('perfil'))
        login = false;
    @else
        login=true;
        perfil_secao = '{{session('perfil')}}';
    @endif
    
    var links_perfil=[];
    if(login){
        switch(perfil_secao){
            case 'consumidor': links_perfil = links_consumidor; break;
            case 'instalador': links_perfil = links_instalador; break;
            case 'desenvolvedor': links_perfil = links_desenvolvedor; break;
        }
        sidebar_links = links_consumidor;
    }else{
        topbar_data.nav = links_intro;
        sidebar_links = links_intro;
    }
    topbar_data.trocar_perfil = (perfil_secao=='plataforma' || perfil_secao=='')?false:true;
    topbar_data.sair = login;
    switch(perfil_secao){
        case '': topbar_data.menu = {mostrar : true,apenas_responsivo : true}; break;
        case 'plataforma': topbar_data.menu = {mostrar : false,apenas_responsivo : true}; break;
        default: topbar_data.menu = {mostrar : true,apenas_responsivo : false};break;
    }


    $.views.settings.delimiters("[[", "]]");
    //Renderiza a navbar junto com a top bar
    var render1 = $.templates("#templ_topbar").render(topbar_data);
    $("#topbar_nav-container").html(render1);
    // Renderiza a barra lateral
    var render2 = $.templates("#templ_topbar_collapsable").render(sidebar_links);
    $("#nav_collapsable").html(render2);
</script>