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

Route::get('/', function () {
  return view('index');
});

//region Autorização
$this->get('admin/login', 'Auth\LoginController@showLoginForm');
$this->post('login', 'Auth\LoginController@login')->name('login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
//endregion

Route::get('admin/', function () {
  return redirect('admin/login');
});

//region Sem auth
Route::group(['prefix' => 'admin'], function () {
  Route::group(['prefix' => 'produtos'], function () {
    Route::get('/importarProdutos', 'Admin\AdminProdutosController@importarProdutos');
  });

  Route::group(['prefix' => 'pedidos'], function () {
    Route::get('/naoConcluidos', 'Admin\AdminPedidosController@naoConcluidos')->name('naoConcluidos');
    Route::get('/enviarNovamente', 'Admin\AdminPedidosController@enviarNovamente')->name('enviarNovamente');
  });
});
//endregion

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'gate']], function () {
  //region Dashboard
  Route::get('/dashboard', 'Admin\AdminDashboardController@index')->name('home');
  //endregion

  //region Configurações
  Route::group(['prefix' => 'configuracao'], function () {
    Route::get('/', 'Admin\AdminConfigController@index')->name('config');
    Route::get('/promocao', 'Admin\AdminConfigController@banner')->name('banner');
    Route::get('/parcelas', 'Admin\AdminConfigController@parcelas')->name('parcelas');
    Route::post('/cadastrar', 'Admin\AdminConfigController@cadastrar');
    Route::post('/cadastrar/parcelas', 'Admin\AdminConfigController@cadastrarParcelas')->name('cadastrarParcelas');
    Route::post('/cadastrar/banner', 'Admin\AdminConfigController@cadastrarBanner')->name('cadastrarBanner');
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
    Route::get('/importarProdutosView', 'Admin\AdminProdutosController@importarProdutosView')->name('importarProdutos');
  });
  //endregion

  //region Pedidos
  Route::group(['prefix' => 'pedidos'], function () {
    Route::get('/', 'Admin\AdminPedidosController@index')->name('pedidos');
    Route::get('/detalhes/{id}', 'Admin\AdminPedidosController@detalhes')->name('pedidoDetalhe');
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

  //region Usuários
  Route::group(['prefix' => 'usuarios'], function () {
    Route::get('/', 'Admin\AdminUsuariosController@index')->name('usuarios');
    Route::get('/detalhes/{id}', 'Admin\AdminUsuariosController@detalhes')->name('usuariosDetalhe');
    Route::get('/cadastro', 'Admin\AdminUsuariosController@cadastro')->name('usuariosCadastro');
    Route::get('/editar/{id}', 'Admin\AdminUsuariosController@editar')->name('usuariosEditar');
    Route::get('/deletar/{id}', 'Admin\AdminUsuariosController@excluir')->name('usuariosDeletar');
    Route::post('/cadastrar', 'Admin\AdminUsuariosController@cadastrar')->name('usuariosCadastrar');
  });
  //endregion

  //region Lojas
  Route::group(['prefix' => 'lojas'], function () {
    Route::get('/', 'Admin\AdminUsuariosController@lojas')->name('lojas');
    Route::get('/detalhes/{id}', 'Admin\AdminUsuariosController@detalhesLojas')->name('lojasDetalhe');
    Route::get('/cadastro', 'Admin\AdminUsuariosController@cadastroLojas')->name('lojasCadastro');
    Route::get('/editar/{id}', 'Admin\AdminUsuariosController@editarLojas')->name('lojasEditar');
    Route::get('/deletar/{id}', 'Admin\AdminUsuariosController@excluirLojas')->name('lojasDeletar');
    Route::post('/cadastrar', 'Admin\AdminUsuariosController@cadastrarLojas')->name('lojasCadastrar');
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



