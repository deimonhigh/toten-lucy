<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\Model\Produto;
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
    $data['comment'] = "Identificação";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "config";
    $data['submenu'] = "tema";
    //endregion

    $config = Configuracao::where('userId', Auth::id())->first();
    $data['dados'] = is_null($config) ? new Configuracao() : $config;

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

//    $configUser = Configuracao::where('userId', Auth::id())->first();
    $config = Configuracao::find(1);
    $data['dados'] = is_null($config) ? new Configuracao() : $config;

    return view('configuracoes.parcelas', $data);
  }

  public function banner()
  {
    //region Breadcrumb
    $data['icon'] = "fa-gear";
    $data['parent'] = "Dashboard";
    $data['current'] = "Configurações";
    $data['comment'] = "Banner Promocional";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "config";
    $data['submenu'] = "banner";
    //endregion

    $config = Configuracao::where('userId', Auth::id())->first();
    $data['dados'] = is_null($config) ? new Configuracao() : $config;
    $data['produtos'] = Produto::all();

    return view('configuracoes.banner', $data);
  }

  public function cadastrarBanner(Request $request)
  {
    $config = Configuracao::where('userId', Auth::id())->first();

    $insert = [];

    if (!is_null($config->banner)) {
      \Storage::delete('public/' . $config->banner);
    }

    if ($request->get('action') == 'remove') {

      $insert['banner'] = null;
      $insert['produto_id'] = null;

      $msg = 'Banner excluído com sucesso.';

    } else {
      $banner = [
          'banner' => 'required|image'
      ];

      if ($request->hasFile('banner')) {
        $banner = [
            'banner' => 'required|image',
            'produto' => 'required'
        ];
      }

      $this->validate($request, $banner);

      $insert = [
          'produto_id' => $request->get('produto'),
          'userId' => Auth::id()
      ];

      $insert['banner'] = $request->file('banner')->store('banners', 'public');

      $msg = 'Banner cadastrado com sucesso.';
    }

    Configuracao::updateOrCreate(
        ['userId' => Auth::id()],
        $insert
    );

    return redirect(route('banner'))->with('success', $msg);
  }

  public function cadastrar(Request $request)
  {
    $this->validate($request, [
        'empresa' => 'required',
        'cor' => 'required'
    ]);

    $insert = [
        'empresa' => $request->get('empresa'),
        'cor' => $request->get('cor'),
        'userId' => Auth::id()
    ];

    Configuracao::updateOrCreate(
        ['userId' => Auth::id()],
        $insert
    );

    return redirect(route('config'))->with('success', 'Identificação da empresa cadastrada com sucesso.');
  }

  public function cadastrarParcelas(Request $request)
  {
    $insert = [
        'max_parcelas' => $request->get('max_parcelas'),
        'parcela0' => ($request->get('parcela0') ? str_replace(',', '.', (string)$request->get('parcela0')) : 0),
        'parcela1' => ($request->get('parcela1') ? str_replace(',', '.', (string)$request->get('parcela1')) : 0),
        'parcela2' => ($request->get('parcela2') ? str_replace(',', '.', (string)$request->get('parcela2')) : 0),
        'parcela3' => ($request->get('parcela3') ? str_replace(',', '.', (string)$request->get('parcela3')) : 0),
        'parcela4' => ($request->get('parcela4') ? str_replace(',', '.', (string)$request->get('parcela4')) : 0),
        'parcela5' => ($request->get('parcela5') ? str_replace(',', '.', (string)$request->get('parcela5')) : 0),
        'parcela6' => ($request->get('parcela6') ? str_replace(',', '.', (string)$request->get('parcela6')) : 0),
        'parcela7' => ($request->get('parcela7') ? str_replace(',', '.', (string)$request->get('parcela7')) : 0),
        'parcela8' => ($request->get('parcela8') ? str_replace(',', '.', (string)$request->get('parcela8')) : 0),
        'parcela9' => ($request->get('parcela9') ? str_replace(',', '.', (string)$request->get('parcela9')) : 0),
        'parcela10' => ($request->get('parcela10') ? str_replace(',', '.', (string)$request->get('parcela10')) : 0),
        'parcela11' => ($request->get('parcela11') ? str_replace(',', '.', (string)$request->get('parcela11')) : 0),
        'parcela12' => ($request->get('parcela12') ? str_replace(',', '.', (string)$request->get('parcela12')) : 0),
        'userId' => Auth::id()
    ];

    Configuracao::updateOrCreate(
        ['id' => 1],
        $insert
    );

    return redirect(route('parcelas'))->with('success', 'Informações de parcelas cadastrada com sucesso.');
  }
}
