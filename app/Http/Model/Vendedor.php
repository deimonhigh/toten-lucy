<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vendedor extends Model
{

  protected $table = "vendedores";

//  Whitelist
  protected $fillable = [
      "nome",
      "identificacao",
      "senha",
      "usuario_id"
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];
}
