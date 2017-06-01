<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\RestController as BaseController;

class ApiConfigController extends BaseController
{
  public function show($tema)
  {
    try {
      $retorno = Configuracao::findOrFail($tema);
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