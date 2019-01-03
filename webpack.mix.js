const mix = require('laravel-mix');
mix.browserSync('nekhen-laravel');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
mix.styles([
   'node_modules/bootstrap/dist/css/bootstrap.min.css'
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
   'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
   'node_modules/bootstrap/dist/js/bootstrap.min.js',
   // 'resources/assets/js/jsrender.js',
   'resources/js/jsviews.min.js',
   'node_modules/chart.js/dist/Chart.bundle.min.js'
], 'public/js/vendor.js');

mix.scripts([
   'resources/js/NoOutlaw-Classes.js',
   'resources/js/outras_funcoes.js',
   'resources/js/scripts_form.js',
], 'public/js/all.js')
   .version();

mix.copy('resources/img', 'public/img');
mix.copy('resources/json', 'public/json');