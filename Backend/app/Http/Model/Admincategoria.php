<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Admincategoria extends Model
{
//  Whitelist
  protected $fillable = [
      "descricao",
      "imagem",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function categorias()
  {
    return $this->belongsToMany('App\Http\Controllers\Model\Categoria');
  }
  
}
