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
                            <label for="filtro-ufs"><strong>Escolha um UF: </strong></label>
                            <select v-model="selUf" v-on:change="atualizarDados" class="form-control" name="filtro-ufs" id="filtro-ufs" style="width:fit-content;cursor-pointer;margin:0 10px">
                                <option value="all">Todas</option>
                                <option v-for="uf in ufs" :key="uf" :value="uf">{{uf}}</option>
                            </select>
                        </div>
                    </div>
                    <div v-bind:class="[(selUf == 'all' || carregando)?'esconder':'']">
                        <strong>Municipios</strong>
                        <multi-select v-bind:opcoes="municipios" v-on:change="selMunicipios = $event"></multi-select>
                    </div>
                    <div v-bind:class="[(selUf == 'all' || carregando)?'esconder':'']">
                        <strong>Concessionárias</strong>
                        <multi-select v-bind:opcoes="concessionarias" v-on:change="selConcessionarias = $event"></multi-select>
                    </div>
                    <br/>
                    <div>
                        <a name="" id="" class="btn btn-primary" href="#" role="button" style="width:100px">Buscar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import Vue from 'vue'
    import multiSelect from './multi-select.vue'
    export default {
        components:{
            multiSelect
        },
        data(){
            return{
                ufs:null,
                municipios:[],
                concessionarias:[],
                selUf:"all",
                selMunicipios:[],
                selConcessionarias:[],
                carregando:false
            }
        },
        mounted() {
            axios.get('/plataforma/api/get_UFs')
                 .then(response => (this.ufs = response.data.lista));

            console.log('filtro-ucs montado.')
        },
        methods:{
            atualizarDados: function(){
                if(this.selUf=="all"){
                    this.municipios = [],
                    this.concessionarias = []
                }else{
                    this.carregando = true;
                    axios.get('/plataforma/api/get_cidade_concessionaria/'+this.selUf)
                    .then(response => (
                        this.municipios = response.data.municipios,
                        this.concessionarias = response.data.concessionarias,
                        this.carregando = false
                    ));
                }
            }
        },
        watch:{
            selMunicipios: function(){
                console.log(this.selMunicipios);
            }
        }
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
    .esconder{
        display:none;
    }
</style>
