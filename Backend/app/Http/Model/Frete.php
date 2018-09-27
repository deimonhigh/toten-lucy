<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Frete extends Model
{

//  Whitelist
  protected $fillable = [
      "cep_inicial",
      "cep_final",
      "peso_inicial",
      "peso_final",
      "valor",
      "prazo",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
