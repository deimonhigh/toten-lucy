<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Comprovante extends Model
{

//  Whitelist
  protected $fillable = [
      "vendedor_id",
      "user_id",
      "pedido_id",
      "codigo",
      "bandeira",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function vendedor()
  {
    return $this->belongsTo('App\Http\Controllers\Model\Vendedor');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
