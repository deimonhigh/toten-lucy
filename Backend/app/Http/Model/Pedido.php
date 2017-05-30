<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

//  Whitelist
  protected $fillable = [
      "idcliente",
      "total",
      "comprovante",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function cliente()
  {
    return $this->hasOne('App\Http\Controllers\Model\Cliente', 'id', 'idcliente');
  }

}
