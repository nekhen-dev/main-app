class AppUnidadesConsumidoras{
    constructor(){
        this.componente;
        this.templates;
    }
    loadMinhasUCsApp(){
        this.componente = $.views.viewModels({
            ListarUCsApp: {
                getters: [
                    "ucs",
                    {
                        getter: "resultado",
                        type: "Resultado"
                    },
                    {
                        getter: "filtro",
                        type: "Filtro"
                    }        
                ],
                extend:{
                    init:function(){
                        var filtro = this.filtro();
                        filtro._uf = 'all';
                        filtro._municipio = 'all';
                        filtro._concessionaria = 'all';
                        filtro._ordem = 'novo';
                        var url = '/plataforma/api/get_MinhasUcs/all/all/all/novo';
                        this.buscar(url);
                    },
                    buscar:function(url){
                        var self = this;
                        $.get(url).done(function(data){
                            self.setUCs(data);
                        });
                    },
                    setUCs:function(resultado){
                        $.observable(this.resultado()).setProperty("status",resultado.status);
                        $.observable(this.resultado()).setProperty("total_paginas",resultado.total_paginas);
                        $.observable(this.resultado()).setProperty("pagina_atual",resultado.pagina_atual);
                        $.observable(this.resultado()).setProperty("resultados_por_pagina",resultado.resultados_por_pagina);
                        $.observable(this).setProperty("ucs",resultado.dados);
                    },
                    mudarFiltro: function(){
                        var filtro = this.filtro();
                        var url = '/plataforma/api/get_MinhasUcs/'+
                            filtro.uf()+'/'+
                            filtro.municipio()+'/'+
                            filtro.concessionaria()+'/'+
                            filtro.ordem();
                        this.buscar(url);
                    }
                }
            },
            Resultado:{
                getters: ["status","total_paginas","pagina_atual","resultados_por_pagina"]
            },
            Filtro: {
                getters: ["uf","municipio","concessionaria","ordem"]
            }
        });
        $.templates("templ_lista",
            '<div data-link="id[setId:hash]" style="border:1px solid lightgrey; border-radius:5px; margin:5px 0;">'+
                '<div class="container align-middle" style="padding:5px;display:flex;">'+
                    '<div class="" style="padding-left:10px">'+
                        '[[:#index+1]]'+
                    '</div>'+
                    '<div class="container align-middle" style="display:flex;">'+
                        '<div class="" style="padding:0 10px">'+
                            '[*[:localizacao.municipio]]'+         
                        '</div>'+
                        '<div class="" style="border-left:1px solid lightgrey; padding:0 10px">'+
                            '[*[:configuracao.concessionaria]]'+         
                        '</div>'+
                        '<div class="" style="border-left:1px solid lightgrey; padding:0 10px">'+
                            '[*[:configuracao.consumo.total]] kWh'+         
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        );
        $.templates("templ_filtro",
            '<div>'+
                '<a data-toggle="collapse" href="#collapseFiltrar" name="filtros" id="filtros" class="btn btn-primary" href="#" role="button">Filtros</a>'+
            '</div>'+
            '<div id="collapseFiltrar" class="collapse" style="width:100%;margin-top:10px">'+
                '<div>'+
                    '<div class="form-group">'+
                        '<select class="form-control" name="" id="">'+
                            '<option>Escolher UF</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label for="">Municipios</label>'+
                    '<br/>'+
                    '<select multiple class="form-control form-control-sm chosen-js" name="" id="">'+
                        '<option>Opcão</option>'+
                        '<option>Opcão</option>'+
                        '<option>Opcão</option>'+
                    '</select>'+
                '</div>'+
            '</div>'
        );
        $.views.converters("setId", function(val) {
            return "id-"+val;
        });
    }
}