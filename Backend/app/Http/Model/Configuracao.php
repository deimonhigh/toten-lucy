<?php

namespace App\Http\Controllers\Model;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{

  protected $table = "configuracoes";

  protected $empresa = null;
  protected $banner = null;
  protected $parcela0 = null;
  protected $parcela1 = null;
  protected $parcela2 = null;
  protected $parcela3 = null;
  protected $parcela4 = null;
  protected $parcela5 = null;
  protected $parcela6 = null;
  protected $parcela7 = null;
  protected $parcela8 = null;
  protected $parcela9 = null;
  protected $parcela10 = null;
  protected $parcela11 = null;
  protected $parcela12 = null;
  protected $max_parcelas = null;
  protected $cor = null;
  protected $produto_id = null;
  protected $listaPreco = null;
  protected $userId = null;

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
      "max_parcelas",
      "cor",
      "produto_id",
      'listaPreco',
      "userId",
  ];

  protected $hidden = [
      "created_at",
      "updated_at"
  ];

}
