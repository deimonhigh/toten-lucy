<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{

  protected $table = "configuracoes";

//  Whitelist
  protected $fillable = [
      "empresa",
      "banner",
      "parcela0",
      "parcela1",
      "parcela2",
      "parcela3",
      "parcela4",
      "parcela5",
      "parcela6",
      "parcela7",
      "parcela8",
      "parcela9",
      "parcela10",
      "parcela11",
      "parcela12",
      "cor",
      "produto_id",
      "userId",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
