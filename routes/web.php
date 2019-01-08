<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/teste',function(){
//     return view('testes.index');
// });


Route::group(['middleware'=>['home']],function($request){
    Route::get('/', function () {
        return view('home.inicio');
    })->name('homeInicio');
    
    Route::get('/cadastro', function () {
        return view('home.cadastro');
    })->name('homeCadastro');
    
    Route::post('/cadastro/novo','Auth\Usuario@create',function ($request) {})
        ->name('novoCadastro');
    
    Route::get('/ReenviarEmailAtivacao',function(){
        return view('home.reenviarEmailAtivacao');
    })->name('homeReenviarEmailAtivacao');
    
    Route::post('/ReenviarEmailAtivacao/enviar','Auth\ReenviarEmailAtivacao@index',function ($request) {})
        ->name('reenviarEmailAtivacaoNovo');
    
    Route::get('/cadastro/ativar/{token}', 'Auth\AtivarCadastro@index')
        ->name('ativarCadastro');
    
    Route::get('/entrar', function () {
        if(\Auth::check()){
            return redirect('/plataforma');
        }
        return view('home.entrar');
    })->name('homeEntrar');
    
    Route::post('/entrar/novo_login', 'Auth\AcessarController@novo_login', function ($request) {})
        ->name('login');

    Route::get('/EsqueciSenha', function () {
        return view('home.esqueci_senha');
    })->name('homeEsqueciSenha');
});


Route::group(['middleware' => ['login_nekhen']], function ($request) {

    Route::group(['middleware' => ['plataforma']],function(){
        Route::get('/plataforma',function(){
            return view('plataforma.inicio');
        })->name('plataforma');
    });
    
    Route::group(['middleware' => ['consumidor']],function(){
        Route::get('/plataforma/consumidor',function(){
            return view('plataforma.consumidor.index');
        })->name('consumidor');

        Route::get('/plataforma/consumidor/CadastrarUC','Consumidor\CadastrarUcController@index')
            ->name('CadastrarUC');

        Route::post('/plataforma/consumidor/CadastrarUC/nova','Consumidor\AddUcController@index')
            ->name('CadastrarUC.nova');

        Route::get('/plataforma/api/get_MinhasUcs/{uf}/{municipio}/{concessionaria}/{ordem}','UnidadesConsumidoras\ListarUcsController@MinhasUCs')
            ->name('get_MinhasUcs');
        //http://nekhen/plataforma/api/get_MinhasUcs/all/all/all/novo

        Route::get('/plataforma/consumidor/MinhasUCs','Consumidor\MinhasUCs@iniciar')->name('MinhasUCs');

    });

    

    Route::get('/plataforma/api/get_cidade_concessionaria/{uf}','Resources\get_cidade_concessionaria_de_UF@show');

    Route::get('/plataforma/api/get_UFs','Resources\get_UFs');

    Route::get('/plataforma/sair','Auth\LogoutController@index', function($request){})
        ->name('sair');
    
});