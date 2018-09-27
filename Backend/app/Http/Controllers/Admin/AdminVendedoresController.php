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

    if (Auth::user()->type) {
      $data['dados'] = Vendedor::paginate(15);
    } else {
      $data['dados'] = Vendedor::where('usuario_id', Auth::id())->paginate(15);
    }

    return view('vendedores.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-address-card";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/vendedores";
    $data['menu'] = "vendedores";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Vendedor::findOrFail($id);

    return view('vendedores.detalhe', $data);
  }

  public function cadastro()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-address-card";
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
    $data['icon'] = "fa-address-card";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Vendedores";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/vendedores";
    $data['menu'] = "vendedores";
    $data['submenu'] = "cadastro";
    //endregion

    $data['dados'] = Vendedor::findOrFail($id);

    return view('vendedores.cadastro', $data);
  }

  public function cadastrar(Request $request)
  {
    $msg = 'Vendedor cadastrado com sucesso.';

    $validation = [
        'nome' => 'required',
        'identificacao' => 'required',
        'senha' => 'required|min:8|confirmed',
        'senha_confirmation' => 'required',
    ];

    if (!$request->has('senha')) {
      $validation = [
          'nome' => 'required',
          'identificacao' => 'required'
      ];
    }

    $this->validate($request, $validation);

    if (!is_null($request->get('id'))) {
      $msg = 'Dados do Vendedor editados com sucesso.';
    }

    $insert = [
        'nome' => $request->get('nome'),
        'identificacao' => $request->get('identificacao'),
        'senha' => Hash::make($request->get('senha')),
        'usuario_id' => Auth::id()
    ];

    if (!$request->has('senha')) {
      $insert = [
          'nome' => $request->get('nome'),
          'identificacao' => $request->get('identificacao'),
          'usuario_id' => Auth::id()
      ];
    }

    Vendedor::updateOrCreate(
        ['id' => $request->get('id')],
        $insert
    );

    return redirect(route('vendedores'))->with('success', $msg);
  }

  public function excluir($id)
  {
    Vendedor::find($id)->delete();

    return redirect(route('vendedores'))->with('success', 'Vendedor excluído com sucesso.');
  }
}
