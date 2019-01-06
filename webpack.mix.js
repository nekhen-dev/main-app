const mix = require('laravel-mix');
mix.browserSync('nekhen');

mix.styles([
   'node_modules/bootstrap/dist/css/bootstrap.min.css',
   'node_modules/chosen-js/chosen.min.css'
], 'public/css/vendor.css');
   
mix.styles([
   'resources/css/estilo_form.css',
   'resources/css/geral.css',
   'resources/css/intro.css',
   'resources/css/plataforma.css',
   'resources/css/rodape.css',
   'resources/css/side-bar-collapsable.css',
   'resources/css/signin.css',
   'resources/css/topbar.css'
], 'public/css/all.css')
   .version();

mix.scripts([
   'node_modules/jquery/dist/jquery.min.js',
   'node_modules/bootstrap/dist/js/bootstrap.min.js',
   'node_modules/jsviews/jsviews.min.js',
   'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
   'node_modules/chart.js/dist/Chart.bundle.min.js',
   'node_modules/chosen-js/chosen.jquery.min.js',
   // 'resources/js/app.js',
   //Minhas classes e funções
   'resources/js/meusScripts/NoOutlaw-Classes.js',
   'resources/js/meusScripts/scripts_form.js',
   'resources/js/meusScripts/UnidadeConsumidora.js',

   //Meus componentes
   'resources/js/componentes/AppUnidadesConsumidoras.js'
], 'public/js/all.js')
.version();
// // require('./jquery');
// // require('./bootstrap');
// // require('./jsviews');
// // require('./jquery-mask-plugin');
// // require('./chart.js');

// mix.js('resources/js/app.js','public/js')
//    .extract(['jquery','bootstrap','jsviews','jquery-mask-plugin','chart.js'])
//    .version();

// mix.js('public/js/all.js','public/js')
//    .extract(['jquery','bootstrap','jsviews','jquery-mask-plugin','chart.js'])
//    .version();

// mix.js('resources/js/app.js', 'public/js').version();

mix.copy('resources/img', 'public/img');
mix.copy('resources/json', 'public/json');