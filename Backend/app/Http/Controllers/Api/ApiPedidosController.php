<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Pedido;
use App\Http\Controllers\RestController as BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPedidosController extends BaseController
{
  public function save(Request $request)
  {
    try {
      $request = (object)$request->all();

      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->img));

      $now = str_replace(':', '-', str_replace(' ', '-', ((string)Carbon::now())));
      Storage::put("/public/comprovantes/{$request->idcliente}-{$now}.png", $data);

      $pedido = Pedido::find($request->idPedido);
      $pedido->idcliente = $request->idcliente;
      $pedido->total = $request->total;
      $pedido->comprovante = "/public/comprovantes/{$request->idcliente}-{$now}.png";
      $pedido->save();

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }

  }

}
