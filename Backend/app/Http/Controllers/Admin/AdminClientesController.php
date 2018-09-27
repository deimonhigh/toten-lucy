<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Cliente;
use App\Http\Controllers\Model\Endereco;
use Illuminate\Http\Request;

class AdminClientesController extends BaseController
{
  public function index(Request $request)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-suitcase";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Clientes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "clientes";
    $data['submenu'] = "";
    //endregion

    if ($request->get('pesquisa')) {
      $pesquisa = $request->get('pesquisa');
      $data['dados'] = Cliente::where(function ($q) use ($pesquisa) {
        $q->Where('nome', 'LIKE', "%{$pesquisa}%");
        $q->orWhere('documento', 'LIKE', "%{$pesquisa}%");
      })->paginate(15);
    } else {
      $data['dados'] = Cliente::paginate(15);
    }

    return view('clientes.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-suitcase";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Clientes";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "clientes";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Cliente::findOrFail($id);
    $data['enderecos'] = Endereco::where('idcliente', $id)->get();

    return view('clientes.detalhe', $data);
  }
}
