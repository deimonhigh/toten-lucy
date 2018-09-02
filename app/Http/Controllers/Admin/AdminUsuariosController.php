<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsuariosController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Usuários";
    $data['comment'] = "Listagem";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "usuarios";
    $data['submenu'] = "listagem";
    //endregion

    $data['dados'] = User::where('id', '!=', Auth::id())->paginate(15);

    return view('usuarios.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Usuários";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "usuarios";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = User::findOrFail($id);

    return view('usuarios.detalhe', $data);
  }

  public function cadastro()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Usuários";
    $data['comment'] = "Cadastro";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "usuarios";
    $data['submenu'] = "cadastro";
    //endregion


    return view('usuarios.cadastro', $data);
  }

  public function editar($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Usuários";
    $data['comment'] = "Editar";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "usuarios";
    $data['submenu'] = "cadastro";
    //endregion

    $data['dados'] = User::findOrFail($id);

    return view('usuarios.cadastro', $data);
  }

  public function cadastrar(Request $request)
  {
    $this->validate($request, [
        'name' => 'required',
        'email' => 'email|required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ]);

    User::updateOrCreate(
        ['id' => $request->get('id')],
        [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]
    );

    return redirect(route('usuarios'));
  }

  public function excluir($id)
  {
    User::find($id)->delete();

    return redirect(route('usuarios'));
  }
}
