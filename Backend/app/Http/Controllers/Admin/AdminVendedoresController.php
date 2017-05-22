<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminVendedoresController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-address-card";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "vendedores";
    $data['submenu'] = "listagem";
    //endregion

    $data['dados'] = Vendedor::paginate(15);

    return view('vendedores.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/vendedores";
    $data['menu'] = "vendedores";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Vendedor::find($id);

    return view('vendedores.detalhe', $data);
  }

  public function cadastro()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/vendedores";
    $data['menu'] = "vendedores";
    $data['submenu'] = "cadastro";
    //endregion


    return view('vendedores.cadastro', $data);
  }

  public function editar($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/vendedores";
    $data['menu'] = "vendedores";
    $data['submenu'] = "cadastro";
    //endregion

    $data['dados'] = Vendedor::find($id);

    return view('vendedores.cadastro', $data);
  }

  public function cadastrar(Request $request)
  {
    $this->validate($request, [
        'nome' => 'required',
        'identificacao' => 'required',
        'senha' => 'required|min:8|confirmed',
        'senha_confirmation' => 'required',
    ]);

    Vendedor::updateOrCreate(
        ['id' => $request->get('id')],
        [
            'nome' => $request->get('nome'),
            'identificacao' => $request->get('identificacao'),
            'senha' => Hash::make($request->get('senha')),
            'idcliente' => Auth::id()
        ]
    );

    return redirect(route('vendedores'));
  }

  public function excluir($id)
  {
    Vendedor::find($id)->delete();

    return redirect(route('vendedores'));
  }
}
