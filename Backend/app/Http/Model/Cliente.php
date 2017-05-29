<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

//  Whitelist
  protected $fillable = [
      "documento",
      "nome",
      "telefone",
      "celular",
      "enderecooriginal",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

  public function enderecos()
  {
    return $this->hasMany('App\Http\Controllers\Model\Endereco', 'idCliente', 'id');
  }
}
