<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{

//  Whitelist
  protected $fillable = [
      "preco",
      "produto",
      "listaPrecoId",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
