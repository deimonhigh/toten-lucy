<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminPerfilController extends BaseController
{
  public function index()
  {
    //region Breadcrumb
    $data['icon'] = "fa-user";
    $data['parent'] = "Dashboard";
    $data['current'] = "Meu Perfil";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "perfil";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Auth::user();

    return view('perfil', $data);
  }

  public function cadastrar(Request $request)
  {

    $this->validate($request, [
        'name' => 'required',
        'email' => 'required'
    ]);

    $update = [
        'name' => $request->get('name'),
        'email' => $request->get('email'),
    ];

    $senha = $request->get('senha');

    if ($senha && trim($senha)) {
      $update['password'] = Hash::make($senha);
    }

    User::updateOrCreate(
        ['id' => Auth::id()],
        $update
    );

    return redirect(route('perfil'));
  }
}
