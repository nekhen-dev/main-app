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
                            <label for="filtro-ufs"><strong>Escolha uma UF: </strong></label>
                            <select v-model="selUf" v-on:change="atualizarDados" class="form-control" name="filtro-ufs" id="filtro-ufs" style="width:fit-content;cursor-pointer;margin:0 10px">
                                <option value="all">Todas</option>
                                <option v-for="uf in ufs" :key="uf" :value="uf">{{uf}}</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:10px" v-bind:class="[(selUf == 'all' || carregando)?'esconder':'']">
                        <strong>Municipios</strong>
                        <multi-select v-bind:opcoes="municipios" v-on:change="selMunicipios = $event"></multi-select>
                    </div>
                    <div style="margin-top:10px" v-bind:class="[(selUf == 'all' || carregando)?'esconder':'']">
                        <strong>Concessionárias</strong>
                        <multi-select v-bind:opcoes="concessionarias" v-on:change="selConcessionarias = $event"></multi-select>
                    </div>
                    <div style="display:inline-flex;margin-top:10px">
                        <div>
                            <button style="100px" v-on:click="emitDadosFiltro" type="button" class="btn btn-primary">Executar</button>
                        </div>
                        <div style="margin:0 10px">
                            <button style="100px" v-on:click="limparFiltro" type="button" class="btn btn-primary">Limpar</button>
                        </div>
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
            },
            emitDadosFiltro: function(){
                this.$emit('filtrar',{
                    uf: this.selUf,
                    municipios: this.selMunicipios,
                    concessionarias: this.selConcessionarias
                });
            },
            limparFiltro: function(){
                this.selUf='all';
                this.selMunicipios=[];
                this.selConcessionarias=[];
                this.emitDadosFiltro();
                $('#collapse-filtro').collapse('hide');
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
