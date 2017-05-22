<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Pedido;

class AdminPedidosController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Pedidos";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "pedidos";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Pedido::paginate(15);

    return view('pedidos.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Pedidos";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "pedidos";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Pedido::find($id);

    return view('pedidos.detalhe', $data);
  }
}
