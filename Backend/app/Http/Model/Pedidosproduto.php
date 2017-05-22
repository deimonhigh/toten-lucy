<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedidosproduto extends Model
{

//  Whitelist
  protected $fillable = [
      "idcliente",
      "idpedido",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
