<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware('auth.usp:SENHAUNICA')
     ->get('/', 'PrincipalController@index')->name('home');
Route::get('/acesso', 'PrincipalController@acesso')->name('acesso');
Route::get('/logout', 'PrincipalController@logout')->name('logout');

Route::post('salvarMonografia',"MonografiaController@salvar")->name('salvarMonografia');

Route::prefix('/graduacao')->group(function() {
    Route::get('/', 'GraduacaoController@index')->name('graduacao.index');
    Route::get('/edicao/{idMono}/{numUsp}', 'GraduacaoController@edicaoMonografia')->name('graduacao.edicao');
});

Route::prefix('orientador')->group(function() {
    Route::get('/', 'OrientadorController@index')->name('orientador.index');
    Route::get('/edicao/{idMono}/{numUsp}', 'OrientadorController@edicaoMonografia')->name('orientador.edicao');
});

Route::prefix('alunos')->group(function() {
    Route::get('/cadastroMonografia', 'AlunosController@index')->name('alunos.index');
});
