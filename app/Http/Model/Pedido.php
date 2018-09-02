<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

//  Whitelist
  protected $fillable = [
      "cliente_id",
      "total",
      "parcelas",
      "comprovante",
      "status",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function cliente()
  {
    return $this->belongsTo('App\Http\Controllers\Model\Cliente');
  }

  public function produtos()
  {
    return $this->hasMany('App\Http\Controllers\Model\Pedidosproduto', 'idpedido');
  }

}
