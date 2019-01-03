<style>
    .container-resumoCadastroUC{
        width:75%;
    }
    @media screen and (max-width: 1100px) {
        .container-resumoCadastroUC{
            width:100%;
        }
    }
}
</style>
<script src="/js/MinhaUC.js"></script>
<script id="templ_form_passo_resumo" type="text/x-jsrender">
    <center>
        <div>
            <div id="passo_resumo" class="container-resumoCadastroUC">
                <h5 style="font-weight:bold; text-align:center;">Verifique os dados</h5>
                <br/>
                <p style="text-align:left">
                    Com base nas suas informações, nós obtemos os seguintes resultados sobre a configuração da sua unidade consumidora (você pode voltar a qualquer momento e corrigir os dados):
                </p>
                <br/>
                <div style="text-align:left">
                    <strong>Endereço</strong>
                    <br/>
                    <ul class="list-group" >
                        <li class="list-group-item">
                            [*[>localizacao.endereco]],
                            [*[>localizacao.endereco_num]],
                            [*[if localizacao.endereco_comp != ""]] [*[>localizacao.endereco_comp]], [[/if]]
                            [*[>localizacao.municipio.nome]],
                            [*[>localizacao.uf]],
                            CEP: [*[>localizacao.cep]]
                        </li>
                    </ul>
                </div>
                <br/>
                <div style="text-align:left">
                    <strong>Configuração</strong>
                    <br/>
                    <ul class="list-group">
                        <li class="list-group-item">Concessionária: [*[>configuracao.concessionaria.nome]]</li>
                        <li class="list-group-item">Perfil: [*[>configuracao.tipo_uc]]</li>
                        <li class="list-group-item">Grupo: [*[>configuracao.grupo]]</li>
                        <li class="list-group-item">Classe: [*[>configuracao.classe]]</li>
                        [*[if configuracao.modalidade !== "undefined"]]
                            <li class="list-group-item">Classe: [*[>configuracao.modalidade.nome]]</li>
                        [[/if]]
                    </ul>
                </div>
                <br/>
                <div>
                    <strong>Consumo em kWh ([*[>consumo.media_ou_historico.nome]])</strong>
                    
                    <br/>
                    <div style="position: relative;margin: auto;height: 40vh;width: 100%; ">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <center>
                    <button id='btn_anterior_resumo' type="button" class="btn btn-light">Anterior</button>
                    <button id='btn_concluir' type="button" class="btn btn-success">Concluir</button>
                </center>
            </div>
        </div>
    </center>
</script>
<script> 
    var json = '{"tipo_uc":"3","endereco":"dsads","endereco_num":"3213","endereco_comp":"","cep":"33333-333","uf":"MA","municipio":"464","concessionaria":"14","conv":false,"fp_p":true,"int":true,"mostrar_consumo_media":false,"mostrar_consumo_historico":true,"grid_historico":"grid-4","meses":[{"id":"jan","nome":"Jan","abrir":true,"consumo":{"conv":"","fp":"32132","int":"3123","p":"31"}},{"id":"fev","nome":"Fev","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"mar","nome":"Mar","abrir":true,"consumo":{"conv":"","fp":"3123","int":"31","p":""}},{"id":"abr","nome":"Abr","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"mai","nome":"Mai","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"jun","nome":"Jun","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"jul","nome":"Jul","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"ago","nome":"Ago","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"set","nome":"Set","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}},{"id":"out","nome":"Out","abrir":true,"consumo":{"conv":"","fp":"3123","int":"","p":"3123"}},{"id":"nov","nome":"Nov","abrir":true,"consumo":{"conv":"","fp":"313","int":"31","p":"3123"}},{"id":"dez","nome":"Dez","abrir":false,"consumo":{"conv":"","fp":"","int":"","p":""}}],"consumo_media":{"conv":"","fp":"","int":"","p":""},"abrir_todos":false}';
    var lista = '{"municipios":[{"valor":452,"nome":"Afonso Cunha"},{"valor":454,"nome":"Alcântara"},{"valor":455,"nome":"Aldeias Altas"},{"valor":456,"nome":"Altamira do Maranhão"},{"valor":457,"nome":"Alto Alegre do Maranhão"},{"valor":458,"nome":"Alto Alegre do Pindaré"},{"valor":459,"nome":"Alto Parnaíba"},{"valor":460,"nome":"Amapá do Maranhão"},{"valor":461,"nome":"Amarante do Maranhão"},{"valor":462,"nome":"Anajatuba"},{"valor":463,"nome":"Anapurus"},{"valor":464,"nome":"Apicum-Açu"},{"valor":465,"nome":"Araguanã"},{"valor":466,"nome":"Araioses"},{"valor":467,"nome":"Arame"},{"valor":468,"nome":"Arari"},{"valor":469,"nome":"Axixá"},{"valor":451,"nome":"Açailândia"},{"valor":470,"nome":"Bacabal"},{"valor":471,"nome":"Bacabeira"},{"valor":472,"nome":"Bacuri"},{"valor":473,"nome":"Bacurituba"},{"valor":474,"nome":"Balsas"},{"valor":476,"nome":"Barra do Corda"},{"valor":477,"nome":"Barreirinhas"},{"valor":475,"nome":"Barão de Grajaú"},{"valor":479,"nome":"Bela Vista do Maranhão"},{"valor":478,"nome":"Belágua"},{"valor":480,"nome":"Benedito Leite"},{"valor":481,"nome":"Bequimão"},{"valor":482,"nome":"Bernardo do Mearim"},{"valor":483,"nome":"Boa Vista do Gurupi"},{"valor":484,"nome":"Bom Jardim"},{"valor":485,"nome":"Bom Jesus das Selvas"},{"valor":486,"nome":"Bom Lugar"},{"valor":487,"nome":"Brejo"},{"valor":488,"nome":"Brejo de Areia"},{"valor":489,"nome":"Buriti"},{"valor":490,"nome":"Buriti Bravo"},{"valor":491,"nome":"Buriticupu"},{"valor":492,"nome":"Buritirana"},{"valor":493,"nome":"Cachoeira Grande"},{"valor":494,"nome":"Cajapió"},{"valor":495,"nome":"Cajari"},{"valor":496,"nome":"Campestre do Maranhão"},{"valor":498,"nome":"Cantanhede"},{"valor":499,"nome":"Capinzal do Norte"},{"valor":500,"nome":"Carolina"},{"valor":501,"nome":"Carutapera"},{"valor":502,"nome":"Caxias"},{"valor":503,"nome":"Cedral"},{"valor":504,"nome":"Central do Maranhão"},{"valor":506,"nome":"Centro Novo do Maranhão"},{"valor":505,"nome":"Centro do Guilherme"},{"valor":507,"nome":"Chapadinha"},{"valor":508,"nome":"Cidelândia"},{"valor":509,"nome":"Codó"},{"valor":510,"nome":"Coelho Neto"},{"valor":511,"nome":"Colinas"},{"valor":512,"nome":"Conceição do Lago-Açu"},{"valor":513,"nome":"Coroatá"},{"valor":514,"nome":"Cururupu"},{"valor":497,"nome":"Cândido Mendes"},{"valor":515,"nome":"Davinópolis"},{"valor":516,"nome":"Dom Pedro"},{"valor":517,"nome":"Duque Bacelar"},{"valor":518,"nome":"Esperantinópolis"},{"valor":519,"nome":"Estreito"},{"valor":520,"nome":"Feira Nova do Maranhão"},{"valor":521,"nome":"Fernando Falcão"},{"valor":522,"nome":"Formosa da Serra Negra"},{"valor":523,"nome":"Fortaleza dos Nogueiras"},{"valor":524,"nome":"Fortuna"},{"valor":525,"nome":"Godofredo Viana"},{"valor":526,"nome":"Gonçalves Dias"},{"valor":527,"nome":"Governador Archer"},{"valor":528,"nome":"Governador Edison Lobão"},{"valor":529,"nome":"Governador Eugênio Barros"},{"valor":530,"nome":"Governador Luiz Rocha"},{"valor":531,"nome":"Governador Newton Bello"},{"valor":532,"nome":"Governador Nunes Freire"},{"valor":534,"nome":"Grajaú"},{"valor":533,"nome":"Graça Aranha"},{"valor":535,"nome":"Guimarães"},{"valor":536,"nome":"Humberto de Campos"},{"valor":537,"nome":"Icatu"},{"valor":539,"nome":"Igarapé Grande"},{"valor":538,"nome":"Igarapé do Meio"},{"valor":540,"nome":"Imperatriz"},{"valor":541,"nome":"Itaipava do Grajaú"},{"valor":542,"nome":"Itapecuru Mirim"},{"valor":543,"nome":"Itinga do Maranhão"},{"valor":544,"nome":"Jatobá"},{"valor":545,"nome":"Jenipapo dos Vieiras"},{"valor":547,"nome":"Joselândia"},{"valor":546,"nome":"João Lisboa"},{"valor":548,"nome":"Junco do Maranhão"},{"valor":551,"nome":"Lago Verde"},{"valor":549,"nome":"Lago da Pedra"},{"valor":550,"nome":"Lago do Junco"},{"valor":553,"nome":"Lago dos Rodrigues"},{"valor":554,"nome":"Lagoa Grande do Maranhão"},{"valor":552,"nome":"Lagoa do Mato"},{"valor":555,"nome":"Lajeado Novo"},{"valor":556,"nome":"Lima Campos"},{"valor":557,"nome":"Loreto"},{"valor":558,"nome":"Luís Domingues"},{"valor":559,"nome":"Magalhães de Almeida"},{"valor":560,"nome":"Maracaçumé"},{"valor":561,"nome":"Marajá do Sena"},{"valor":562,"nome":"Maranhãozinho"},{"valor":563,"nome":"Mata Roma"},{"valor":564,"nome":"Matinha"},{"valor":565,"nome":"Matões"},{"valor":566,"nome":"Matões do Norte"},{"valor":567,"nome":"Milagres do Maranhão"},{"valor":568,"nome":"Mirador"},{"valor":569,"nome":"Miranda do Norte"},{"valor":570,"nome":"Mirinzal"},{"valor":572,"nome":"Montes Altos"},{"valor":571,"nome":"Monção"},{"valor":573,"nome":"Morros"},{"valor":574,"nome":"Nina Rodrigues"},{"valor":575,"nome":"Nova Colinas"},{"valor":576,"nome":"Nova Iorque"},{"valor":577,"nome":"Nova Olinda do Maranhão"},{"valor":578,"nome":"Olho D`Água das Cunhãs"},{"valor":579,"nome":"Olinda Nova do Maranhão"},{"valor":581,"nome":"Palmeirândia"},{"valor":582,"nome":"Paraibano"},{"valor":583,"nome":"Parnarama"},{"valor":584,"nome":"Passagem Franca"},{"valor":585,"nome":"Pastos Bons"},{"valor":586,"nome":"Paulino Neves"},{"valor":587,"nome":"Paulo Ramos"},{"valor":580,"nome":"Paço do Lumiar"},{"valor":588,"nome":"Pedreiras"},{"valor":589,"nome":"Pedro do Rosário"},{"valor":590,"nome":"Penalva"},{"valor":591,"nome":"Peri Mirim"},{"valor":592,"nome":"Peritoró"},{"valor":593,"nome":"Pindaré-Mirim"},{"valor":594,"nome":"Pinheiro"},{"valor":595,"nome":"Pio XII"},{"valor":596,"nome":"Pirapemas"},{"valor":598,"nome":"Porto Franco"},{"valor":599,"nome":"Porto Rico do Maranhão"},{"valor":597,"nome":"Poção de Pedras"},{"valor":600,"nome":"Presidente Dutra"},{"valor":601,"nome":"Presidente Juscelino"},{"valor":602,"nome":"Presidente Médici"},{"valor":603,"nome":"Presidente Sarney"},{"valor":604,"nome":"Presidente Vargas"},{"valor":605,"nome":"Primeira Cruz"},{"valor":606,"nome":"Raposa"},{"valor":607,"nome":"Riachão"},{"valor":608,"nome":"Ribamar Fiquene"},{"valor":609,"nome":"Rosário"},{"valor":610,"nome":"Sambaíba"},{"valor":611,"nome":"Santa Filomena do Maranhão"},{"valor":612,"nome":"Santa Helena"},{"valor":613,"nome":"Santa Inês"},{"valor":614,"nome":"Santa Luzia"},{"valor":615,"nome":"Santa Luzia do Paruá"},{"valor":616,"nome":"Santa Quitéria do Maranhão"},{"valor":617,"nome":"Santa Rita"},{"valor":618,"nome":"Santana do Maranhão"},{"valor":619,"nome":"Santo Amaro do Maranhão"},{"valor":620,"nome":"Santo Antônio dos Lopes"},{"valor":645,"nome":"Satubinha"},{"valor":646,"nome":"Senador Alexandre Costa"},{"valor":647,"nome":"Senador La Rocque"},{"valor":648,"nome":"Serrano do Maranhão"},{"valor":650,"nome":"Sucupira do Norte"},{"valor":651,"nome":"Sucupira do Riachão"},{"valor":621,"nome":"São Benedito do Rio Preto"},{"valor":622,"nome":"São Bento"},{"valor":623,"nome":"São Bernardo"},{"valor":624,"nome":"São Domingos do Azeitão"},{"valor":625,"nome":"São Domingos do Maranhão"},{"valor":627,"nome":"São Francisco do Brejão"},{"valor":628,"nome":"São Francisco do Maranhão"},{"valor":626,"nome":"São Félix de Balsas"},{"valor":634,"nome":"São José de Ribamar"},{"valor":635,"nome":"São José dos Basílios"},{"valor":629,"nome":"São João Batista"},{"valor":630,"nome":"São João do Carú"},{"valor":631,"nome":"São João do Paraíso"},{"valor":632,"nome":"São João do Soter"},{"valor":633,"nome":"São João dos Patos"},{"valor":636,"nome":"São Luís"},{"valor":637,"nome":"São Luís Gonzaga do Maranhão"},{"valor":638,"nome":"São Mateus do Maranhão"},{"valor":639,"nome":"São Pedro da Água Branca"},{"valor":640,"nome":"São Pedro dos Crentes"},{"valor":641,"nome":"São Raimundo das Mangabeiras"},{"valor":642,"nome":"São Raimundo do Doca Bezerra"},{"valor":643,"nome":"São Roberto"},{"valor":644,"nome":"São Vicente Ferrer"},{"valor":649,"nome":"Sítio Novo"},{"valor":652,"nome":"Tasso Fragoso"},{"valor":653,"nome":"Timbiras"},{"valor":654,"nome":"Timon"},{"valor":655,"nome":"Trizidela do Vale"},{"valor":656,"nome":"Tufilândia"},{"valor":657,"nome":"Tuntum"},{"valor":658,"nome":"Turiaçu"},{"valor":659,"nome":"Turilândia"},{"valor":660,"nome":"Tutóia"},{"valor":661,"nome":"Urbano Santos"},{"valor":662,"nome":"Vargem Grande"},{"valor":663,"nome":"Viana"},{"valor":664,"nome":"Vila Nova dos Martírios"},{"valor":666,"nome":"Vitorino Freire"},{"valor":665,"nome":"Vitória do Mearim"},{"valor":667,"nome":"Zé Doca"},{"valor":453,"nome":"Água Doce do Maranhão"}],"concessionarias":[{"valor":14,"nome":"CEMAR"}]}';
    json = JSON.parse(json);
    lista = JSON.parse(lista);
    let uc = new MinhaUC(json);
    uc.set_listaMunicipiosConcessionarias(lista);
    uc.gerarResumo();    
    var dadosResumo = uc.getDados();
    var dadosGrafico = uc.geraDadosGrafico();
    console.log(dadosGrafico);


    $.views.settings.delimiters("[[", "]]", "*");
    var templ_form_passo_resumo = $.templates("#templ_form_passo_resumo");
    templ_form_passo_resumo.link("#ctn-tmpl-form_passo_resumo", dadosResumo);
    
    // $('#btn_anterior_resumo').click(function(event){
    //     $('.progress-bar').css('width','75%');
    //     $('.progress-bar').attr('aria-valuenow',75);
    //     ir_para_msg_validacao('#container_msg_validacao');
    //     $('#form_passo_resumo').addClass('esconder');
    //     $('#form_passo_consumo_valor').removeClass('esconder');
    // });
</script>

<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Fev", "Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
        datasets: dadosGrafico
    },
    options: {
        scales: {
            xAxes: [{
                stacked: true
            }],
            yAxes: [{
                
                stacked: true
            }]
        },
        responsive:true,
        maintainAspectRatio: false
    }
});
</script>