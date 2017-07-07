<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Configuracao;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsuariosController extends BaseController
{
  //region Usuários
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

    $data['dados'] = User::where(function ($q) {
      $q->where('type', 1);
      $q->where('email', '!=', 'bruno@agenciadominio.com.br');
    })->paginate(15);

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
    $msg = 'Usuário cadastrado com sucesso.';

    $validation = [
        'name' => 'required',
        'email' => 'email|required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    if (!$request->has('password')) {
      $validation = [
          'name' => 'required',
          'email' => 'email|required',
      ];
    }

    $this->validate($request, $validation);

    if ($request->has('id')) {
      $msg = 'Usuário cadastrado com sucesso.';
    }

    $insert = [
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        'mercado_pago' => $request->get('mercadoPago'),
        'type' => true
    ];

    if (!$request->has('password')) {
      $insert = [
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
          'mercado_pago' => $request->get('mercadoPago'),
          'type' => true
      ];
    }

    User::updateOrCreate(
        ['id' => $request->get('id')],
        $insert
    );

    return redirect(route('usuarios'))->with('success', $msg);
  }

  public function excluir($id)
  {
    User::find($id)->delete();

    return redirect(route('usuarios'))->with('success', 'Usuário excluído com sucesso.');
  }
  //endregion

  //region Lojas
  public function lojas()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Lojas";
    $data['comment'] = "Listagem";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "lojas";
    $data['submenu'] = "listagem";
    //endregion

    $data['dados'] = User::where(function ($q) {
      $q->where('type', 0);
    })->paginate(15);

    return view('lojas.listagem', $data);
  }

  public function detalhesLojas($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Lojas";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "lojas";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = User::findOrFail($id);
    $configLoja = Configuracao::where('userId', $data['dados']->id)->first();

    $data['dados']->listaPreco = $configLoja->listaPreco;

    return view('lojas.detalhe', $data);
  }

  public function cadastroLojas()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-shopping-basket";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Lojas";
    $data['comment'] = "Cadastro";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "lojas";
    $data['submenu'] = "cadastro";
    //endregion

    $data['dados'] = new User();

    return view('lojas.cadastro', $data);
  }

  public function editarLojas($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-shopping-basket";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Lojas";
    $data['comment'] = "Editar";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "lojas";
    $data['submenu'] = "cadastro";
    //endregion

    $data['dados'] = User::findOrFail($id);

    $configLoja = Configuracao::where('userId', $data['dados']->id)->first();

    $data['dados']->listaPreco = $configLoja->listaPreco;

    return view('lojas.cadastro', $data);
  }

  public function cadastrarLojas(Request $request)
  {
    $msg = 'Loja cadastrada com sucesso.';

    $validation = [
        'name' => 'required',
        'email' => 'email|required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    if (!$request->has('password')) {
      $validation = [
          'name' => 'required',
          'email' => 'email|required',
      ];
    }

    $this->validate($request, $validation);

    if ($request->has('id')) {
      $msg = 'Dados da Loja editados com sucesso.';
    }

    $insert = [
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        'mercado_pago' => $request->get('mercadoPago'),
        'type' => false
    ];

    if (!$request->has('password')) {
      $insert = [
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
          'mercado_pago' => $request->get('mercadoPago'),
          'type' => false
      ];
    }

    $user = User::updateOrCreate(
        ['id' => $request->get('id')],
        $insert
    );

    Configuracao::updateOrCreate(
        ['userId' => $user->id],
        [
            'listaPreco' => $request->get('listaPreco')
        ]
    );

    return redirect(route('lojas'))->with('success', $msg);
  }

  public function excluirLojas($id)
  {
    User::find($id)->delete();

    return redirect(route('lojas'))->with('success', 'Loja excluído com sucesso.');
  }
  //endregion
}
