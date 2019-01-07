<template>
    <div>
        {{ucs}}
        <ul class="list-group" v-for="uc in ucs" :key="uc.hash">
            <li class="list-group-item" v-bind:id="uc.hash | setId" style="display:block">
                <div class="uc-card" data-toggle="collapse" href="#contentId">
                    <div class="uc-icon uc-card-titulo">
                        UC: {{uc.localizacao.municipio}}, {{uc.localizacao.uf}} | {{uc.consumo.total}} kWh
                    </div>
                    <div class="uc-criado_em uc-card-titulo">
                        Adicionado em: {{uc.criado_em | setData}}
                    </div>
                </div>
                <div class="collapse" id="contentId">
                    {{uc.localizacao.municipio}}
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
        data(){
            return{
                ucs: JSON.parse(window.Laravel.get_ucs).ucs
            }
        },
        mounted() {
            console.log('lista-ucs montado.')
        },
        filters:{
            setId: function(id){
                return "uc-"+id;
            },
            setData:function(data){
                var d = data.split(" ")[0];
                d = d.split("-");
                return d[2]+"/"+d[1]+"/"+d[0];
            }
        }
    }
</script>

<style>
    .uc-card{
        font-size:0.9em;
        font-weight:bold;
    }

    .uc-icon{
        background: url("/img/unidade_consumidora.png") left no-repeat;
        cursor:pointer;
    }
    .uc-criado_em{
        background: url("/img/calendario_adicionado.png") left no-repeat; 
    }
    .uc-card-titulo{
        background-size: 20px;
        padding: 5px 0;
        padding-left: 40px;
    }
</style>
