<template>
    <div>
        <div>
            <div>
                <button class="btn btn-filtro" type="button" data-toggle="collapse" data-target="#collapse-filtro" aria-expanded="false"
                        aria-controls="contentId">
                        Filtrar
                </button>
            </div>
            <div class="collapse collapse-filtro" id="collapse-filtro">
                <div style="padding:10px">
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="filtro-ufs"><strong>UF</strong></label>
                            <select v-model="selUf" v-on:change="atualizarDados" class="form-control" name="filtro-ufs" id="filtro-ufs" style="width:fit-content;cursor-pointer;margin:0 10px">
                                <option value="all">Todas</option>
                                <option v-for="uf in ufs" :key="uf" :value="uf">{{uf}}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        Municipios
                        <v-select multiple v-model="selMunicipios" :options="municipios"></v-select>
                    </div>
                    <div>
                        Concessionárias
                        <v-select multiple v-model="selConcessionarias" :options="concessionarias"></v-select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import Vue from 'vue'
    import vSelect from 'vue-select'
    export default {
        components:{
            vSelect
        },
        data(){
            return{
                ufs:null,
                municipios:[],
                concessionarias:[],
                selUf:"all",
                selMunicipios:null,
                selConcessionarias:null,
            }
        },
        mounted() {
            axios.get('/plataforma/api/get_UFs')
                 .then(response => (this.ufs = response.data.lista));

            console.log('filtro-ucs montado.')
        },
        methods:{
            atualizarDados: function(){
                axios.get('/plataforma/api/get_cidade_concessionaria/'+this.selUf)
                 .then(response => (
                     this.municipios = this.convSelect(response.data.municipios),
                     this.concessionarias = this.convSelect(response.data.concessionarias)
                 ));
            },
            convSelect:function(arr){
                var novo_arr = [{label:"Todos",value:"all"}];
                arr.forEach(function(item){
                    novo_arr.push({label:item.nome,value:item.valor})
                });
                return novo_arr;
            }
        },
        
    }
</script>

<style>
    .btn-filtro{
        background: url('/img/filtro.png') left no-repeat;
        background-size:30px;
        padding: 5px 15px;
        padding-left:30px;
    }
    .collapse-filtro{
        padding:10px;
        margin:5px;
        border:1px solid lightgrey;
        border-radius:5px;
    }
</style>
