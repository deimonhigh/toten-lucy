<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Listapreco extends Model
{

//  Whitelist
  protected $fillable = [
      "listaPreco",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
