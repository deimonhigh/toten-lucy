<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConfigController extends BaseController
{
  public function index()
  {
    //region Breadcrumb
    $data['icon'] = "fa-gear";
    $data['parent'] = "Dashboard";
    $data['current'] = "Configurações";
    $data['comment'] = "Tema";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "config";
    $data['submenu'] = "tema";
    //endregion

    $data['dados'] = Configuracao::where('userId', Auth::id())->first();

    if (!$data['dados']) {
      $data['dados'] = new \stdClass();
      $data['dados']->cor = '#FF5B10';
    }

    return view('configuracoes.config', $data);
  }

  public function parcelas()
  {
    //region Breadcrumb
    $data['icon'] = "fa-gear";
    $data['parent'] = "Dashboard";
    $data['current'] = "Configurações";
    $data['comment'] = "Parcelas";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "config";
    $data['submenu'] = "parcelas";
    //endregion

    $data['dados'] = Configuracao::where('userId', Auth::id())->first();

    return view('configuracoes.parcelas', $data);
  }


  public function cadastrar(Request $request)
  {

    $this->validate($request, [
        'empresa' => 'required',
        'cor' => 'required',
        'banner' => 'image',
    ]);

    $insert = [
        'empresa' => $request->get('empresa'),
        'cor' => $request->get('cor'),
        'userId' => Auth::id()
    ];

    \Storage::deleteDirectory('public/banners');

    if ($request->hasFile('banner')) {
      $insert['banner'] = $request->file('banner')->store('banners', 'public');
    } else {
      $insert['banner'] = null;
    }

    Configuracao::updateOrCreate(
        ['id' => 1],
        $insert
    );

    return redirect(route('config'));
  }

  public function cadastrarParcelas(Request $request)
  {
    $insert = [
        'parcela1' => ($request->get('parcela1') ? $request->get('parcela1') : 0),
        'parcela2' => ($request->get('parcela2') ? $request->get('parcela2') : 0),
        'parcela3' => ($request->get('parcela3') ? $request->get('parcela3') : 0),
        'parcela4' => ($request->get('parcela4') ? $request->get('parcela4') : 0),
        'parcela5' => ($request->get('parcela5') ? $request->get('parcela5') : 0),
        'parcela6' => ($request->get('parcela6') ? $request->get('parcela6') : 0),
        'parcela7' => ($request->get('parcela7') ? $request->get('parcela7') : 0),
        'parcela8' => ($request->get('parcela8') ? $request->get('parcela8') : 0),
        'parcela9' => ($request->get('parcela9') ? $request->get('parcela9') : 0),
        'parcela10' => ($request->get('parcela10') ? $request->get('parcela10') : 0),
        'parcela11' => ($request->get('parcela11') ? $request->get('parcela11') : 0),
        'parcela12' => ($request->get('parcela12') ? $request->get('parcela12') : 0)
    ];

    Configuracao::updateOrCreate(
        ['id' => 1],
        $insert
    );

    return redirect(route('parcelas'));
  }
}