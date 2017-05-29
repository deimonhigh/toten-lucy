<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Produto;
use App\Http\Controllers\RestController as BaseController;
use Illuminate\Http\Request;

class ApiProdutosController extends BaseController
{
  public function all()
  {
    $produtos = Produto::where(function ($q) {
      $q->has('imagens');
    })->get();

    foreach ($produtos as $prod) {
      $prod->categorias = $prod->categorias;
      foreach ($prod->imagens as $item) {
        $item->url = url($item->path);
      }

    }

    return $this->Ok($produtos);
  }

  public function filtro(Request $request)
  {
    try {

      $itens = $request->get('itens');

      $produtos = Produto::where(function ($q) use ($itens) {
        $q->has('imagens');
        $q->whereHas('categorias', function ($query) use ($itens) {
          $query->whereIn('codigocategoria', $itens);
        });
      })->get();

      foreach ($produtos as $prod) {
        $prod->categorias = $prod->categorias;
        foreach ($prod->imagens as $item) {
          $item->url = url($item->path);
        }

      }

      return $this->Ok($produtos);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }
  }
}
