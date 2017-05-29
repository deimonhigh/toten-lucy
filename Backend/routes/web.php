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
//region Autorização
$this->get('admin/login', 'Auth\LoginController@showLoginForm');
$this->post('login', 'Auth\LoginController@login')->name('login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
//endregion

Route::get('admin/', function () {
  return redirect('admin/login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
  //region Dashboard
  Route::get('/dashboard', 'Admin\AdminDashboardController@index')->name('home');
  //endregion

  //region Configurações
  Route::group(['prefix' => 'configuracao'], function () {
    Route::get('/', 'Admin\AdminTemaController@index')->name('config');
    Route::post('/cadastrar', 'Admin\AdminTemaController@cadastrar');
  });
  //endregion

  //region Perfil
  Route::group(['prefix' => 'perfil'], function () {
    Route::get('/', 'Admin\AdminPerfilController@index')->name('perfil');
    Route::post('/cadastrar', 'Admin\AdminPerfilController@cadastrar');
  });
  //endregion

  //region Clientes
  Route::group(['prefix' => 'clientes'], function () {
    Route::get('/', 'Admin\AdminClientesController@index')->name('clientes');
    Route::get('/detalhes/{id}', 'Admin\AdminClientesController@detalhes')->name('clientesDetalhe');
    Route::post('/cadastrar', 'Admin\AdminClientesController@cadastrar');
    Route::get('/importarClientes', 'Admin\AdminClientesController@importarProdutosView')->name('importarClientes');
    Route::get('/importarClientesView', 'Admin\AdminClientesController@importarProdutosView')->name('importarClientesView');
  });
  //endregion

  //region Produtos
  Route::group(['prefix' => 'produtos'], function () {
    Route::get('/', 'Admin\AdminProdutosController@index')->name('produtos');
    Route::get('/detalhes/{id}', 'Admin\AdminProdutosController@detalhes')->name('produtosDetalhe');
    Route::get('/importarProdutos', 'Admin\AdminProdutosController@importarProdutos');
    Route::get('/importarProdutosView', 'Admin\AdminProdutosController@importarProdutosView')->name('importarProdutos');
    Route::get('/findFiles', 'Admin\AdminProdutosController@findFiles');
  });
  //endregion

  //region Pedidos
  Route::group(['prefix' => 'pedidos'], function () {
    Route::get('/', 'Admin\AdminPedidosController@index')->name('pedidos');
    Route::post('/cadastrar', 'Admin\AdminPedidosController@cadastrar');
  });
  //endregion

  //region Vendedores
  Route::group(['prefix' => 'vendedores'], function () {
    Route::get('/', 'Admin\AdminVendedoresController@index')->name('vendedores');
    Route::get('/detalhes/{id}', 'Admin\AdminVendedoresController@detalhes')->name('vendedoresDetalhe');
    Route::get('/cadastro', 'Admin\AdminVendedoresController@cadastro')->name('vendedoresCadastro');
    Route::get('/editar/{id}', 'Admin\AdminVendedoresController@editar')->name('vendedoresEditar');
    Route::get('/deletar/{id}', 'Admin\AdminVendedoresController@excluir')->name('vendedoresDeletar');
    Route::post('/cadastrar', 'Admin\AdminVendedoresController@cadastrar')->name('vendedoresCadastrar');
  });
  //endregion

  //region Categorias
  Route::group(['prefix' => 'categorias'], function () {
    Route::get('/', 'Admin\AdminCategoriasController@index')->name('listagemCategoria');

    Route::get('/cadastro', 'Admin\AdminCategoriasController@cadastro')->name('categoriasCadastro');
    Route::get('/editar/{id}', 'Admin\AdminCategoriasController@editar')->name('categoriasEditar');
    Route::get('/deletar/{id}', 'Admin\AdminCategoriasController@deletar')->name('deletarCategoria');
    Route::post('/cadastrar', 'Admin\AdminCategoriasController@cadastrar')->name('categoriasCadastrar');

    Route::get('/relacao', 'Admin\AdminCategoriasController@relacionar')->name('categoriasRelacao');
    Route::post('/relacaoCadastrar', 'Admin\AdminCategoriasController@relacionarCadastro')->name('categoriasRelacaoCadastrar');
    Route::get('/deletarRelacao/{idCatAdmin}/{idCat}', 'Admin\AdminCategoriasController@relacionarDeletar')->name('relacionarDeletar');

    Route::get('/importarCategorias', 'Admin\AdminCategoriasController@importarCategorias')->name('importarCategorias');
    Route::get('/importarCategoriasView', 'Admin\AdminCategoriasController@importarCategoriasView')->name('importarCategoriasView');
  });
  //endregion
});


