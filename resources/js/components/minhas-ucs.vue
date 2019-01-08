<template>
    <div>
        <div v-if="dados.ucs.length == 0">
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
        <div v-if="dados.ucs.length > 0">
            <h5>Minhas unidades consumidoras</h5>
            <p>Clique nos cartões para exibir detalhes das unidades consumidoras</p>
            <div>
                <a name="" id="" class="btn btn-primary btn-adicionar-top" href="/plataforma/consumidor/CadastrarUC" role="button">Adicionar</a>
                <br/><br/>
                <filtro-ucs></filtro-ucs>
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
                dados: JSON.parse(this.inicializacao),
                uc_destaque : this.uc_add
            }
        },
        mounted() {
            // axios.get('/plataforma/api/get_MinhasUcs/all/all/all/novo')
            //     .then(response => (this.dados = response.data));
            // this.dados = JSON.parse(this.inicializacao);
            console.log('Componente pronto.');
        }
    }
</script>

<style>

</style>