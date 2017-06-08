<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Pedidosproduto extends Model
{

//  Whitelist
  protected $fillable = [
      "idcliente",
      "idpedido",
      "produto_id",
      "quantidade",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function produto()
  {
    return $this->belongsTo('App\Http\Controllers\Model\Produto', 'produto_id');
  }


}
