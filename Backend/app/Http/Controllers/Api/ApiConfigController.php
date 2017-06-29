<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\RestController as BaseController;

class ApiConfigController extends BaseController
{
  public function show($email)
  {
    try {
      $retorno = Configuracao::where('email', $email)->firstOrFail();

      if ($retorno->banner){
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
