<template>
    <div>
        <div v-if="!testeDados">
            <center>
                <h4>Isto aqui que está meio deserto</h4>
                <span class="lead">Você ainda não tem unidades consumidoras cadastradas</span>
                <div class='deserto'></div>
                <div>
                    <a name="add_uc" id="add_uc" class="btn btn-primary" href="/plataforma/consumidor/CadastrarUC" role="button">
                        Cadastre uma unidade consumidora
                    </a>
                </div>
            </center>
        </div>
        <div v-if="testeDados">
            <h5>Minhas unidades consumidoras</h5>
            <p>Clique nos cartões para exibir detalhes das unidades consumidoras</p>
            <div>
                <a name="" id="" class="btn btn-primary btn-adicionar-top" href="/plataforma/consumidor/CadastrarUC" role="button">Adicionar</a>
                <br/><br/>
                <filtro-ucs v-on:filtrar="filtro = $event"></filtro-ucs>
            </div>
            <lista-ucs v-bind:lista="dados.ucs" v-bind:uc_destaque="uc_destaque"></lista-ucs>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["inicializacao","uc_add"],
        data(){
            return{
                dados: {},
                uc_destaque : this.uc_add,
                filtro:{}
            }
        },
        mounted() {
            this.dados = JSON.parse(this.inicializacao);
        },
        watch: {
            filtro: function(){
                this.buscar();
            }
        },
        methods:{
            buscar: function(){
                var url = '/plataforma/api/get_MinhasUcs/'+
                    this.filtro.uf+'/'+
                    this.arrayToString(this.filtro.municipios)+'/'+
                    this.arrayToString(this.filtro.concessionarias)+'/'+
                    'novo';
                axios.get(url)
                     .then(response => (this.dados = response.data));
            },
            arrayToString: function(arr){
                if(arr.length==0){
                    return 'all';
                }
                var str = '';
                for(var i=0;i<arr.length;i++){
                    str += arr[i].valor;
                    if(i<arr.length-1){
                        str += ',';
                    }
                }
                return str;
            },
            testeDados: function(){
                if(this.dados != undefined){
                    return this.dados.ucs.length > 0;
                }
                return false;
            }
        }
    }
</script>

<style>

</style>