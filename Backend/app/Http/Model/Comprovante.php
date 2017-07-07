<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Comprovante extends Model
{

//  Whitelist
  protected $fillable = [
      "vendedor_id",
      "user_id",
      "codigo",
      "bandeira",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function vendedor()
  {
    return $this->hasOne('App\Http\Controllers\Model\Vendedor');
  }

  public function user()
  {
    return $this->hasOne('App\User');
  }

}
