<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
  
//  Whitelist
  protected $fillable = [
      "empresa",
      "maxParcelas",
      "maxParcelasSemJuros",
      "juros",
      "cor",
      "userId",
      "listaPrecoId"
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
