<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\RestController as BaseController;
use Illuminate\Http\Request;

class ApiFreteController extends BaseController
{
  public function frete(Request $request)
  {
    $request = (object)$request->all();
    $filename = base_path() . '/database/csv/frete1.xlsx';

    $data = [];
    \Excel::filter('chunk')->load($filename)->chunk(250, function ($results) use ($data) {
      foreach ($results as $row) {
        $frete = new \StdClass();
        $frete->cep_inicial = $row->cep_inicial;
        $frete->cep_final = $row->cep_final;
        $frete->peso_inicial = $row->peso_inicial;
        $frete->peso_final = $row->peso_final;
        $frete->valor1 = $row->valor1;
        $frete->prazo = $row->prazo;

        array_push($data, $frete);
      }
    });
    return $this->Ok($data);
  }

}
