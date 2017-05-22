<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTemaController extends BaseController
{
  public function index()
  {
    //region Breadcrumb
    $data['icon'] = "fa-gear";
    $data['parent'] = "Dashboard";
    $data['current'] = "Configurações";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "config";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Theme::where('userId', Auth::id())->first();

    if (!$data['dados']) {
      $data['dados'] = new \stdClass();
      $data['dados']->cor = '#FF5B10';
    }

    return view('config', $data);
  }

  public function cadastrar(Request $request)
  {

    $this->validate($request, [
        'empresa' => 'required',
        'maxParcelas' => 'required',
        'maxParcelasSemJuros' => 'required',
        'juros' => 'required',
        'cor' => 'required',
    ]);

    Theme::updateOrCreate(
        ['id' => $request->get('id')],
        [
            'empresa' => $request->get('empresa'),
            'maxParcelas' => $request->get('maxParcelas'),
            'maxParcelasSemJuros' => $request->get('maxParcelasSemJuros'),
            'juros' => $request->get('juros'),
            'cor' => $request->get('cor'),
            'userId' => Auth::id()
        ]
    );

    return redirect(route('config'));
  }
}
