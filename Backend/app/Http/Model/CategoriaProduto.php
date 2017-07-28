<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{

  protected $table = "categoria_produto";

//  Whitelist
  protected $fillable = [
      "produto_id",
      "codigocategoria_id",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function categoria()
  {
    return $this->belongsTo('App\Http\Controllers\Model\Categoria', 'codigocategoria_id', 'codigocategoria');
  }
}
