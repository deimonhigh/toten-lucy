<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\RestController as BaseController;
use App\User;

class ApiConfigController extends BaseController
{
  public function show($email)
  {
    try {
      $user = User::where('email', $email)->firstOrFail();
      $retorno = Configuracao::where('userId', $user->id)->firstOrFail();

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
