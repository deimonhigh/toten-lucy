<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Produto;
use App\Http\Controllers\RestController as BaseController;
use Illuminate\Http\Request;

class ApiProdutosController extends BaseController
{
  public function all()
  {
    $produtos = Produto::with('imagens')->get();

    foreach ($produtos as $prod) {
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

      $produtos = Produto::with('imagens')->where(function ($q) use ($itens) {
        $q->where('disabled', false);
        $q->whereNull('codigoprodutopai');
        $q->whereHas('categorias', function ($query) use ($itens) {
          $query->whereIn('codigocategoria', $itens);
        });
      })->get();

      foreach ($produtos as $prod) {
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

  public function find($id)
  {
    try {
      $produto = Produto::with('imagens')->find($id);

      foreach ($produto->imagens as $item) {
        $item->url = url($item->path);
      }

      return $this->Ok($produto);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }
  }

  public function relacionados(Request $request)
  {
    try {
      $codigoProduto = $request->get('produtocodigo');

      $result = Produto::select('id', 'cor')->where(function ($q) use ($codigoProduto) {
        $q->where('codigoprodutopai', $codigoProduto);
        $q->where('estoque', '>', 0);
        $q->where('disabled', false);
      })->get();

      return $this->Ok($result);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }
  }
}
