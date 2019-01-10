
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
window.Vue = require('vue');
window.axios = require('axios');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var minhasUcs = Vue.component('minhas-ucs', function (resolve) {
    require(['./components/minhas-ucs.vue'], resolve).default
});
var filtroUcs = Vue.component('filtro-ucs', function (resolve) {
    require(['./components/filtro-ucs.vue'], resolve).default
});
var listaUcs = Vue.component('lista-ucs', function (resolve) {
    require(['./components/lista-ucs.vue'], resolve).default
});
var chartConsumoUcs = Vue.component('chart-consumo-uc', function (resolve) {
    require(['./components/chart-consumo-uc.vue'], resolve).default
});

const minhasUCs = new Vue({
    el: '#app-container',
    components:{
        minhasUcs:minhasUcs,
        filtroUcs:filtroUcs,
        listaUcs:listaUcs,
        chartConsumoUcs:chartConsumoUcs
    }
});



