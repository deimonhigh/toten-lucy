<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

//  Whitelist
  protected $fillable = [
      "documento",
      "nome",
      "enderecoId",
      "mesmoEndereco",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
