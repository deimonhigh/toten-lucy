<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

//  Whitelist
  protected $fillable = [
      "cliente_id",
      "vendedor_id",
      "total",
      "parcelas",
      "comprovante",
      "status",
      "user_id"
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

  public function comprovantes()
  {
    return $this->hasMany('App\Http\Controllers\Model\Comprovante');
  }

  public function vendedor()
  {
    return $this->belongsTo('App\Http\Controllers\Model\Vendedor');
  }
}
