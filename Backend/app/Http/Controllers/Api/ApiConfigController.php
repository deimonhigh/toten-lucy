<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\RestController as BaseController;
use App\User;
use Illuminate\Http\Request;

class ApiConfigController extends BaseController
{
  public function show(Request $request)
  {
    try {
      if ($request->has('email')) {
        $user = User::where('email', $request->get('email'))->firstOrFail();
        $retorno = Configuracao::where('userId', $user->id)->firstOrFail();
      } else {
        $retorno = Configuracao::find($request->get('id'));
      }

      if ($retorno->banner) {
        $retorno->banner = url('storage/' . $retorno->banner);
      }

      return $this->Ok($retorno);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }
  }
}
