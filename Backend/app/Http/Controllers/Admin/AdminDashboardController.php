<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Atualizacao;
use App\Http\Controllers\Model\Pedido;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-home";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Dashboard";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "dashboard";
    $data['submenu'] = "";
    //endregion

    $data['qntPedidos'] = Pedido::all()->count();
    $data['somaTotalPedidos'] = Pedido::all()->sum('total');
    $data['somaTotalPedidosEnviados'] = Pedido::where('status', true)->sum('total');

    $data['qntPedidosEsteMes'] = Pedido::where(DB::raw('MONTH(created_at)'), '=', date('n'))->count();
    $data['somaPedidosEsteMes'] = Pedido::where(DB::raw('MONTH(created_at)'), '=', date('n'))->sum('total');

    $data['qntPedidosMesPassado'] = Pedido::where(DB::raw('MONTH(created_at)'), '=', date('n', strtotime("last month")))->count();
    $data['somaPedidosMesPassado'] = Pedido::where(DB::raw('MONTH(created_at)'), '=', date('n', strtotime("last month")))->sum('total');

    $data['datas'] = Atualizacao::first();

    return view('dashboard.home', $data);
  }
}
