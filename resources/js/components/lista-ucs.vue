<template>
    <div>
        <!-- {{ucs}} -->
        <div v-if="ucs.length>0">
            <div v-for="uc in ucs" :key="uc.hash" class="uc-loop align-top">
                <div class="uc-item" v-bind:class="[ifDestaque(uc.hash) ? 'uc-adicionada' : '']" v-bind:id="uc.hash | setId" style="cursor:pointer">
                    <div data-toggle="collapse" v-bind:href="uc.hash | setHrefCollapse" style="text-align:left">
                        <div v-if="ifDestaque(uc.hash)">
                            <span style="color:green;font-weight:bold">Unidade consumidora adicionada!</span>
                            <br/>
                        </div>
                        <div class="uc-card">
                            <div class="uc-icon uc-card-titulo">
                                {{uc.localizacao.municipio}}, {{uc.localizacao.uf}} | {{uc.consumo.total}} kWh
                            </div>
                            <div class="uc-concessionaria uc-card-titulo">
                                {{uc.configuracao.concessionaria}}
                            </div>
                            <div class="uc-criado_em">
                                Adicionado em: {{uc.criado_em | setData}}
                            </div>
                        </div>
                        <div class="collapse uc-detalhe-container" v-bind:id="uc.hash | setIdCollapse">
                            <div style="margin:5px 0">
                                <h5>Detalhes</h5>
                                <strong>Endereço</strong>
                                <div>{{uc.localizacao | enderecoCompleto}}</div>
                            </div>
                            <div style="margin:5px 0">
                                <strong>Configuração</strong>
                                <div class="container">
                                    <ul class="lista-configuracao">
                                        <li>Concessionária: {{uc.configuracao.concessionaria}}</li>
                                        <li>Perfil: {{uc.configuracao.tipo_estabelecimento}}</li>
                                        <li>Grupo: {{uc.configuracao.grupo}}</li>
                                        <li v-if="uc.configuracao.classe">Classe: {{uc.configuracao.classe}}</li>
                                        <li>Modalidade: {{uc.configuracao.modalidade}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div style="margin:5px 0">
                                <div style="margin-bottom:10px">
                                    <strong>Consumo</strong>
                                </div>
                                <div>
                                    <chart-consumo-uc v-bind:item="uc" ></chart-consumo-uc>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>   
            </div>
        </div>
        <div v-if="ucs.length == 0">
            Não foi possível encontrar unidades consumidoras este filtro.
        </div>
    </div>
</template>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
    export default {
        props: ["lista","uc_destaque"],
        data(){
            return{
                ucs: this.lista,
                destaque : this.uc_destaque
            }
        },
        watch:{
            lista: function(){
                this.ucs = this.lista;
            }
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
        },
        methods:{
            ifDestaque: function(id){
                return (id == this.destaque)? true : false;
            }
        }
    }
</script>

<style>
    .uc-loop{
        font-size:0.9em;
        display:inline-block;
    }
    .uc-item{
        cursor:pointer;
        margin:10px 5px;
        padding:20px;
        border: 1px solid lightgrey;
        box-shadow: 0 3px 10px lightgrey;
        border-radius:5px;
        min-width:400px;
    }
    @media screen and (max-width: 500px) {
        .uc-loop{
            width:100%;
        }
        .uc-item{
            min-width:auto;
        }
    }
    .uc-adicionada{
        border-color:green;
        border-width: 5px;
    }
    .uc-item:hover{
        box-shadow: 0 5px 10px lightgrey;
    }
    .uc-card{
        font-weight:bold;
    }
    .uc-icon{
        background: url("/img/unidade_consumidora.png") left no-repeat;
    }
    .uc-criado_em{
        color:rgb(175, 175, 175);
        font-size:0.8em;
        font-weight:normal;
    }
    .uc-concessionaria{
        background: url("/img/distribuição.png") left no-repeat; 
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
    .lista-configuracao{
        margin: 0;
        margin-left:10px;
        padding: 0;
    }
</style>
