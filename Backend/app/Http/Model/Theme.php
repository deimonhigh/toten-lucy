<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{

//  Whitelist
  protected $fillable = [
      "empresa",
      "maxParcelas",
      "maxParcelasSemJuros",
      "juros",
      "cor",
      "userId",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
