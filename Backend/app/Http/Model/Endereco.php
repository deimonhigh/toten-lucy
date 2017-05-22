<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{

//  Whitelist
  protected $fillable = [
      "cep",
      "endereco",
      "numero",
      "complemento",
      "bairro",
      "cidade",
      "uf",
      "idCliente",
      "enderecoOriginal",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
