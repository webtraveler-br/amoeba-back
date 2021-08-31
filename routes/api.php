<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'API\AuthController@login')->name('login');
Route::post('registro', 'API\AuthController@registro')->name('registro');

Route::get('arquivos/{arquivo}', 'ArquivoController@show');

//As rotas dentro desse ggrupo precisam de autenticação
Route::middleware(['auth:api'])->group(function () {



    Route::get('meu-perfil', 'AuthController@meuPerfil')->name('perfil');

    Route::apiResource('arquivos', 'ArquivoController')->except([
        'show'
    ]);

});

//As rotas dentro desse grupo precisam de acesso admin

    Route::post('CriaServico', 'API\ServicoController@store');
    Route::post('AtualizarServico', 'API\ServicoController@update');
    Route::post('DeletaServico', 'API\ServicoController@destroy');
    Route::get('ListaServico', 'API\ServicoController@index');
    Route::post('MostraServico', 'API\ServicoController@show'); 



Route::get('teste', function(){
    return 'abc';
});

Route::post('novaImagem', 'API\ImagemController@store');
Route::post('Imagem', 'API\ImagemController@show');
Route::get('Checaimagem', 'API\ImagemController@index');
Route::post('Deletaimagem', 'API\ImagemController@destroy');
Route::post('Atualizaimagem', 'API\ImagemController@update');

Route::post('Guardacategoria', 'API\CategoriasController@store');
Route::post('Mostracategoria', 'API\CategoriasController@show');
Route::post('Atualizacategoria', 'API\CategoriasController@update');
Route::get('Checacategoria', 'API\CategoriasController@index');
Route::post('Deletacategoria', 'API\CategoriasController@destroy');


Route::get('logout', 'API\AuthController@logout');

Route::post('Novoportfolio', 'API\PortfolioController@store');
Route::post('Atualizaportfolio', 'API\PortfolioController@update');
Route::post('Listaportfolio', 'API\PortfolioController@show');
Route::get('Portfolios', 'API\PortfolioController@index');
Route::post('Deletaportfolio', 'API\PortfolioController@destroy');

Route::post('Novocontato', 'API\ContatosController@store');
Route::post('Mostracontato', 'API\ContatosController@show');
Route::post('Deletacontato', 'API\ContatosController@destroy');
Route::post('Atualizacontato', 'API\ContatosController@update');
Route::get('Checacontato', 'API\ContatosController@index');

Route::post('Novaequipe', 'API\EquipeController@store');
Route::post('Atualizaequipe', 'API\EquipeController@update');
Route::get('Equipes', 'API\EquipeController@index');
Route::post('Listaequipe', 'API\EquipeController@show');
Route::post('Eliminaequipe', 'API\EquipeController@destroy');

Route::post('Novamensagem', 'API\MensagemController@store');
Route::post('Listamensagem', 'API\MensagemController@show');
Route::get('Mensagems', 'API\MensagemController@index');
Route::post('Deletamensagem', 'API\MensagemController@destroy');
