<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Theme;
use App\Http\Controllers\RestController as BaseController;

class ApiThemeController extends BaseController
{
  public function show($tema)
  {
    try {
      $retorno = Theme::findOrFail($tema);
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
