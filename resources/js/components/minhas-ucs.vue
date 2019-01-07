<template>
    <div>
        <lista-ucs v-bind:lista="dados.ucs"></lista-ucs>
    </div>
</template>

<script>
    export default {
        props: ["inicializacao"],
        data(){
            return{
                dados: JSON.parse(this.inicializacao)
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
