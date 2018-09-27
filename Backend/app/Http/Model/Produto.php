<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

//  Whitelist
  protected $fillable = [
      "codigobarras",
      "codigoprodutoabaco",
      "codigoprodutopai",
      "codigoproduto",
      "nomeproduto",
      "descricao",
      "cor",
      "categoriaId",
      "preco1",
      "precopromocao1",
      "preco2",
      "precopromocao2",
      "peso",
      "disabled"
  ];

  protected $hidden = [
      "updated_at"
  ];

  public function categorias()
  {
    return $this->hasMany('App\Http\Controllers\Model\CategoriaProduto', 'produto_id', 'id');
  }

  public function imagens()
  {
    return $this->hasMany('App\Http\Controllers\Model\Imagemproduto');
  }


}
