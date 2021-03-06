<?php

namespace App\Http\Controllers\Presentation;

use App\Http\Controllers\Model\Vendedor;

class VendedorAdapter
{
  public static function toView(Vendedor $vendedor)
  {
    return (object)[
        "id" => $vendedor->id,
        "nome" => $vendedor->nome,
        "identificacao" => $vendedor->identificacao
    ];
  }
}
