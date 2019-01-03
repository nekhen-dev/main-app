class MinhaUC{
    constructor(_input){
        this.input = _input;
        this.dados = {};
        this.municipios = {};
        this.concessionarias = {};

        this.getDados = function(){
            return this.dados;
        }

        this.procurarNome = function(arr,index){
            for(var i=0;i<arr.length;i++){
                if(arr[i].valor == index){
                    return arr[i].nome;
                }
            }
        }
        this.tranfTipoUC = function(tipoUC){
            switch(tipoUC){
                case "1": return "Residencial";
                case "2": return "Rural";
                case "3": return "Comercial ou Industrial";
                case "4": return "Iluminação pública";

                default: return "Informação pendente";
            }
        }
        this.setConfiguracao = function(tipo_uc,tipos_consumo){
            /*
            tipo_uc = 1/2/3/4
            tipos_consumo = {
                conv: true/false,
                fp_p: true/false,
                int: true/false,
            }
            */

            if(tipos_consumo.conv){
                return {
                    grupo: "B"
                    ,classe: "B"+tipo_uc
                    ,modalidade: {
                        valor: "conv",
                        nome: "Convencional"
                    }
                };
            }
            if(tipos_consumo.int){
                return {
                    grupo: "B"
                    ,classe: "B"+tipo_uc
                    ,modalidade: {
                        valor: "branca",
                        nome: "Branca"
                    }
                };
            }
            if(tipos_consumo.fp_p){
                return {
                    grupo: "A"
                    ,classe: "N/A"
                    ,modalidade: {
                        // valor: "azul | verde",
                        // nome: "Azul | Verde"
                    }
                };
            }
        }
        this.consumoToFloat = function(consumo,media_ou_historico){
            if(media_ou_historico == "media"){
                for(var i in consumo){
                    consumo[i] = (consumo[i] == "")? 0:parseFloat(consumo[i]);
                }
            }
            if(media_ou_historico == "historico"){
                consumo.forEach(function(mes){
                    for(var i in mes.consumo){
                        mes.consumo[i] = (mes.consumo[i] == "")? 0:parseFloat(mes.consumo[i]);
                    }
                });
            }
            return consumo;
        }
        this.setConsumoAnual = function(media_ou_historico,consumo,configuracao){
            function setConsumoMedia(consumo,configuracao){
                var arrConsumoMedia = {};
                var arrConsumo = [];
                if(configuracao.grupo == "B"){
                    if(configuracao.modalidade.valor == "conv"){
                        arrConsumoMedia.conv = consumo.conv;
                    }
                    if(configuracao.modalidade.valor == "branca"){
                        arrConsumoMedia.fp = consumo.fp;
                        arrConsumoMedia.int = consumo.int;
                        arrConsumoMedia.p = consumo.p;
                    }
                }else{
                    arrConsumoMedia.fp = consumo.fp;
                    arrConsumoMedia.p = consumo.p;
                }
                for(var i=0;i<12;i++){
                    arrConsumo.push(arrConsumoMedia);
                }
                return arrConsumo;
            }
            function setConsumoHistorico(consumo,configuracao){
                function mediaHistorico(consumo,configuracao){
                    function addConsumoTipo(obj,consumo, tipo){
                        if(!obj.hasOwnProperty(tipo)){
                            return parseFloat(consumo);    
                        }else{
                            return parseFloat(obj[tipo]) + parseFloat(consumo);
                        }
                    }

                    var media = {};
                    var cont_abrir = 0; //Media para os meses não informados
                    consumo.forEach(function(mes){
                        if(mes.abrir){
                            cont_abrir++;
                            if(configuracao.grupo == "B"){
                                if(configuracao.modalidade.valor == "conv"){
                                    media.conv = addConsumoTipo(media,mes.consumo.conv,"conv");
                                }
                                if(configuracao.modalidade.valor == "branca"){
                                    media.fp = addConsumoTipo(media,mes.consumo.fp,"fp");
                                    media.int = addConsumoTipo(media,mes.consumo.int,"int");
                                    media.p = addConsumoTipo(media,mes.consumo.p,"p");
                                }
                            }else{
                                media.fp = addConsumoTipo(media,mes.consumo.fp,"fp");
                                media.p = addConsumoTipo(media,mes.consumo.p,"p");
                            }
                        }
                    });
                    if(configuracao.grupo == "B"){
                        if(configuracao.modalidade.valor == "conv"){
                            media.conv = media.conv/cont_abrir;
                        }
                        if(configuracao.modalidade.valor == "branca"){
                            media.fp =media.fp /cont_abrir;
                            media.int =media.int /cont_abrir;
                            media.p =media.p /cont_abrir;
                        }
                    }else{
                        media.fp =media.fp /cont_abrir;
                        media.p =media.p /cont_abrir;
                    }
                    return media;
                }
                function consumoAberto(consumo,configuracao){
                    if(configuracao.grupo == "B"){
                        if(configuracao.modalidade.valor == "conv"){
                            return {conv:consumo.conv};
                        }
                        if(configuracao.modalidade.valor == "branca"){
                            return {
                                fp : consumo.fp,
                                int : consumo.int,
                                p : consumo.p
                            };
                        }
                    }else{
                        return {
                            fp : consumo.fp,
                            p : consumo.p
                        };
                    }
                }

                var media = mediaHistorico(consumo,configuracao);
                var arrConsumoAnual = [];
                consumo.forEach(function(mes){
                    if(mes.abrir){
                        arrConsumoAnual.push(consumoAberto(mes.consumo,configuracao));
                    }else{
                        arrConsumoAnual.push(media);
                    }
                });
                return arrConsumoAnual;
            }

            if(media_ou_historico == "media"){
                return setConsumoMedia(consumo,configuracao);
            }
            if(media_ou_historico == "historico"){
                return setConsumoHistorico(consumo,configuracao);
            }
        }
    }
    set_listaMunicipiosConcessionarias(lista){
        this.municipios = lista.municipios;
        this.concessionarias = lista.concessionarias;
    }
    
    gerarResumo(){
        this.dados.localizacao = {
            endereco : this.input.endereco,
            endereco_num : this.input.endereco_num,
            endereco_comp : this.input.endereco_comp,
            cep : this.input.cep,
            uf : this.input.uf,
            municipio : {
                id : this.input.municipio,
                nome : this.procurarNome(this.municipios,this.input.municipio)
            }
        }

        this.dados.configuracao = {
            tipo_uc : this.tranfTipoUC(this.input.tipo_uc),
            concessionaria : {
                id : this.input.concessionaria,
                nome : this.procurarNome(this.concessionarias,this.input.concessionaria)
            }
        }
        let _configuracao = this.setConfiguracao(this.input.tipo_uc,{conv:this.input.conv,fp_p:this.input.fp_p,int:this.input.int});
        this.dados.configuracao.grupo = _configuracao.grupo;
        this.dados.configuracao.classe = _configuracao.classe;
        this.dados.configuracao.modalidade = _configuracao.modalidade;

        let media_ou_historico = this.input.mostrar_consumo_media?"media":"historico";
        let nome_media_ou_historico = media_ou_historico == "media"?"Média":"Histórico";
        let consumo = (media_ou_historico == "media")?this.consumoToFloat(this.input.consumo_media,"media") : this.consumoToFloat(this.input.meses,"historico");
        this.dados.consumo = {
            media_ou_historico : {valor : media_ou_historico, nome : nome_media_ou_historico},
            meses : this.setConsumoAnual(media_ou_historico,consumo,this.dados.configuracao)
        };
    }

    geraDadosGrafico(){
        function cor(nome){
            switch(nome){
                case "vermelho": return "rgba(255,0,0, 1)";
                case "azul": return "rgba(56,176,222, 1)";
                case "verde": return "rgba(50,205,153,1)";
                case "preto": return "rgba(0, 0, 0, 1)";
                case "cinza": return "rgba(168,168,168, 1)";
                
                default: return "rgba(168,168,168, 1)";
            }
        }


        var arrDados = [];
        if(this.dados.configuracao.grupo == "B"){
            if(this.dados.configuracao.modalidade.valor == "conv"){
                arrDados = [{
                    label: "Convencional",
                    backgroundColor : cor("preto"),
                    data : []
                }];
                this.dados.consumo.meses.forEach(function(mes){
                    arrDados[0].data.push(mes.conv);
                });
            }
            if(this.dados.configuracao.modalidade.valor == "branca"){
                arrDados = [
                    {
                        label: "Fora da Ponta",
                        backgroundColor : cor("azul"),
                        data : []
                    },
                    {
                        label: "Intermediário",
                        backgroundColor : cor("cinza"),
                        data : []
                    },
                    {
                        label: "Na Ponta",
                        backgroundColor : cor("verde"),
                        data : []
                    }
                ];
                this.dados.consumo.meses.forEach(function(mes){
                    arrDados[0].data.push(mes.fp);
                    arrDados[1].data.push(mes.int);
                    arrDados[2].data.push(mes.p);
                });
            }
        }else{
            arrDados = [
                {
                    label: "Fora da Ponta",
                    backgroundColor : cor("azul"),
                    data : []
                },
                {
                    label: "Na Ponta",
                    backgroundColor : cor("verde"),
                    data : []
                }
            ];
            this.dados.consumo.meses.forEach(function(mes){
                arrDados[0].data.push(mes.fp);
                arrDados[1].data.push(mes.p);
            });
        }
        return arrDados;
    }
}