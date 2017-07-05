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

Route::group(['prefix' => 'config'], function () {
  Route::post('', 'Api\ApiConfigController@show');
});

Route::group(['prefix' => 'frete'], function () {
  Route::post('', 'Api\ApiFreteController@frete');
  Route::post('upload', 'Api\ApiFreteController@uploadFrete');
});
Route::group(['middleware' => 'auth:api'], function () {
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
    Route::post('/relacionados', 'Api\ApiProdutosController@relacionados');
    Route::get('/{id}', 'Api\ApiProdutosController@find');
  });

  Route::group(['prefix' => 'categorias'], function () {
    Route::get('/', 'Api\ApiCategoriasController@all');
  });

  Route::group(['prefix' => 'pedidos'], function () {
    Route::post('/save', 'Api\ApiPedidosController@save');
  });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});



