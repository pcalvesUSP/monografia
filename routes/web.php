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

Route::get('/', 'PrincipalController@login');

Route::get('/graduacao', function() {
    echo "área da graduação";
});

Route::get('/orientadores', function() {
    echo "área dos orientadores";
});

Route::get('/alunos', function() {
    echo "área dos alunos";
});