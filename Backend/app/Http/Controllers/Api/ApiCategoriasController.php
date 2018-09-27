<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Admincategoria;
use App\Http\Controllers\RestController as BaseController;

class ApiCategoriasController extends BaseController
{
  public function all()
  {
    try {

      $categorias = Admincategoria::all();

      foreach ($categorias as $categoria) {
        $categoria->categorias = $categoria->categorias;
        $categoria->imagem = asset("storage/" . $categoria->imagem);
      }

      return $this->Ok($categorias);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }

  }

}
