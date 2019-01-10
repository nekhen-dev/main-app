<template>
  <div>
    <multiselect
        v-model="selected" 
        :options="opcoes"
        :multiple="true"
        :taggable="false"
        placeholder="Procure ou deixe em branco para escolher todos"
        label="nome"
        track-by="valor"
        select-label="Selecionar"
        :closeOnSelect="true"
        deselect-label="Excluir seleção"
        selected-label="Selecionado"
        no-result="Nada foi encontrado"
        :showNoResults="false"
    >
    <span></span>
    </multiselect>
  </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'
  export default {
    components: { Multiselect },
    props:["opcoes"],
    data () {
      return {
        selected: [],
      }
    },
    mounted(){
        // this.options = this.opcoes;
    },
    watch:{
        opcoes:function(){
            this.selected = [];
        },
        selected: function(){
            this.$emit('change',this.selected);
        }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .multiselect__tag,.multiselect__option--highlight,.multiselect__tag-icon:hover,.multiselect__option--highlight:after{
        background-color:#007bff;
    }
</style>