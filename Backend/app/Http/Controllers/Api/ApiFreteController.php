<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Frete;
use App\Http\Controllers\RestController as BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiFreteController extends BaseController
{
  public function frete(Request $request)
  {
    try {
      $request = (object)$request->all();

      $retorno = Frete::select('valor', 'prazo')->whereRaw("({$request->cep} between `cep_inicial` and `cep_final` and {$request->peso} between `peso_inicial` and `peso_final`)")->firstOrFail();

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
