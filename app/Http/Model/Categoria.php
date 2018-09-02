<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

//  Whitelist
  protected $fillable = [
      "descricao",
      "codigocategoria",
      "codigocategoriapai",
      "imagem",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];
  
}
