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

Route::get('begin', 'Controller@begin');

Route::group(['middleware' => 'auth:api'], function () {
  Route::resource('tema', 'Api\ApiThemeController', ['only' => ['show']]);

  Route::group(['prefix' => 'vendedores'], function () {
    Route::post('/validate', 'Api\ApiVendedorController@validate');
  });

  Route::group(['prefix' => 'clientes'], function () {
    Route::get('/{documento}', 'Api\ApiClientesController@findByDocumento');
    Route::post('/save', 'Api\ApiClientesController@save');
  });

  Route::group(['prefix' => 'produtos'], function () {
    Route::get('/', 'Api\ApiProdutosController@all');
    Route::post('/filtro', 'Api\ApiProdutosController@filtro');
  });

  Route::group(['prefix' => 'categorias'], function () {
    Route::get('/', 'Api\ApiCategoriasController@all');
  });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});



