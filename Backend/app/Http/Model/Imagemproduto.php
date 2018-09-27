<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Imagemproduto extends Model
{

  //  Whitelist
  protected $fillable = [
      "produto_id",
      "path",
      "created_at",
      "updated_at"
  ];

  protected $hidden = [
      "created_at",
  ];

}
