<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Atualizacao extends Model
{

  protected $table = 'atualizacoes';

//  Whitelist
  protected $fillable = [
      "pedidos",
      "clientes",
      "produtos",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
