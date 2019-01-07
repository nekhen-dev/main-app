<template>
    <div>
        <!-- {{ucs}} -->
        <ul class="list-group" v-for="uc in ucs" :key="uc.hash" style="font-size:0.9em">
            <li class="list-group-item uc-item" v-bind:id="uc.hash | setId" style="cursor:pointer">
                <div data-toggle="collapse" v-bind:href="uc.hash | setHrefCollapse">
                    <div class="uc-card">
                        <div class="uc-icon uc-card-titulo">
                            UC: {{uc.localizacao.municipio}}, {{uc.localizacao.uf}} | {{uc.consumo.total}} kWh
                        </div>
                        <div class="uc-criado_em uc-card-titulo">
                            Adicionado em: {{uc.criado_em | setData}}
                        </div>
                    </div>
                    <div class="collapse uc-detalhe-container" v-bind:id="uc.hash | setIdCollapse">
                        <div style="margin:5px 0">
                            <h6>Detalhes</h6>
                            <strong>Endereço:</strong> {{uc.localizacao | enderecoCompleto}}
                        </div>
                        <div>
                            <strong>Configuração:</strong>
                            <div class="container">
                                <ul>
                                    <li>Concessionária: {{uc.configuracao.concessionaria}}</li>
                                    <li>Perfil: {{uc.configuracao.tipo_estabelecimento}}</li>
                                    <li>Grupo: {{uc.configuracao.grupo}}</li>
                                    <li v-if="uc.configuracao.classe">Classe: {{uc.configuracao.classe}}</li>
                                    <li>Modalidade: {{uc.configuracao.modalidade}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
            </li>   
        </ul>
    </div>
</template>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
    export default {
        props: ["lista"],
        data(){
            return{
                ucs: this.lista
            }
        },
        mounted() {
            console.log('lista-ucs montado.')
        },
        filters:{
            setHrefCollapse: function(id){
                return "#collapse-"+id;
            },
            setIdCollapse: function(id){
                return "collapse-"+id;
            },
            setId: function(id){
                return "uc-"+id;
            },
            setData:function(data){
                var d = data.split(" ")[0];
                d = d.split("-");
                return d[2]+"/"+d[1]+"/"+d[0];
            },
            enderecoCompleto: function(l){
                var comp_endereco = "";
                if(l.comp_endereco !== undefined){
                    comp_endereco = ", "+l.comp_endereco;
                }
                return l.endereco  + ', '+ 
                        l.num_endereco +
                        comp_endereco + ', '+
                        l.uf + ', '+
                        l.cep;
            }
        }
    }
</script>

<style>
    .uc-item{
        cursor:pointer;
        margin:10px 0;
    }
    .uc-item:hover{
        box-shadow: 0 3px 10px lightgrey;
    }
    .uc-card{
        font-weight:bold;
    }
    .uc-icon{
        background: url("/img/unidade_consumidora.png") left no-repeat;
    }
    .uc-criado_em{
        background: url("/img/calendario_adicionado.png") left no-repeat; 
    }
    .uc-card-titulo{
        background-size: 20px;
        padding: 5px 0;
        padding-left: 40px;
    }
    .uc-detalhe-container{
        border-top:1px solid lightgrey;
        margin:10px 0;
    }
</style>
