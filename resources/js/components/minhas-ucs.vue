<template>
    <div>
        <lista-ucs></lista-ucs>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                dados: JSON.parse(window.Laravel.get_ucs)
            }
        },
        mounted() {
            // axios.get('/plataforma/api/get_MinhasUcs/all/all/all/novo')
            //     .then(response => (this.dados = response.data));

            console.log('Component mounted.')
        }
    }
</script>
