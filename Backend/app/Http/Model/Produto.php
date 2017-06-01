<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

//  Whitelist
  protected $fillable = [
      "codigobarras",
      "codigoprodutoabaco",
      "codigoproduto",
      "nomeproduto",
      "descricao",
      "cor",
      "categoriaId",
      "preco",
      "precopromocao",
  ];

  protected $hidden = [
      "updated_at"
  ];

  public function categorias()
  {
    return $this->belongsToMany('App\Http\Controllers\Model\Categoria', 'categoria_produto', 'produto_id', 'codigocategoria_id');
  }

  public function imagens()
  {
    return $this->hasMany('App\Http\Controllers\Model\Imagemproduto');
  }


}
