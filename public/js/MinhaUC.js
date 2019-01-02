class MinhaUC{
    constructor(_dados){
        this.dados = _dados;

        this.procurarNome = function(arr,index){
            for(var i=0;i<arr.length;i++){
                if(arr[i].valor == index){
                    return arr[i].nome;
                }
            }
        }
        this.tranfTipoUC = function(tipoUC){
            switch(tipoUC){
                case 1: return "Residencial";
                case 2: return "Rural";
                case 3: return "Comercial ou Industrial";
                case 4: return "Iluminação pública";

                default: return "Informação pendente";
            }
        }
    }
    
    transfMunicipioConcessionaria(lista){
        this.dados.concessionaria = this.procurarNome(lista.concessionarias,this.dados.concessionaria);
        this.dados.municipio =  this.procurarNome(lista.municipios,this.dados.municipio);
    }
    gerarResumo(){
        var dadosResumo = {};
        dadosResumo.tipo_uc = this.dados.tipo_uc;
        dadosResumo.endereco = this.dados.endereco;
        dadosResumo.endereco_num = this.dados.endereco_num;
        dadosResumo.endereco_comp = this.dados.endereco_comp;
        dadosResumo.cep = this.dados.cep;
        dadosResumo.uf = this.dados.uf;
        dadosResumo.municipio = this.dados.municipio;
        dadosResumo.concessionaria = this.dados.concessionaria;
        
        this.dados = dadosResumo;
    }
}