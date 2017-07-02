<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Frete;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminFretesController extends BaseController
{
  public function index()
  {
    $data = [];

    //region Breadcrumb
    $data['icon'] = "fa-shopping-basket";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Lojas";
    $data['comment'] = "Fretes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "lojas";
    $data['submenu'] = "";
    //endregion

    return view('lojas.fretes', $data);
  }

  public function upload(Request $request)
  {
    $this->validate($request, [
        'listaFretes' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('listaFretes');

    ini_set('max_execution_time', 0);
    ini_set('auto_detect_line_endings', TRUE);

    try {
      $total = 0;

      \DB::transaction(function () use ($file, &$total) {
        Frete::truncate();

        $retorno = [];

        if (($handle = fopen($file, 'r')) !== false) {
          fgetcsv($handle);

          $now = Carbon::now()->toDateTimeString();

          while (($data = fgetcsv($handle, 0, ';')) !== false) {
            $total++;

            $obj = [];
            $obj['cep_inicial'] = $data[0];
            $obj['cep_final'] = $data[1];
            $obj['peso_inicial'] = $data[2];
            $obj['peso_final'] = $data[3];
            $obj['valor'] = $data[4];
            $obj['prazo'] = $data[15];
            $obj['created_at'] = $now;
            $obj['updated_at'] = $now;

            array_push($retorno, $obj);

            if ($total % 500 == 0) {
              Frete::insert($retorno);
              $retorno = [];
            }

            unset($data);
          }

          fclose($handle);
        }
      });

      if ($total == 0) {
        throw new \Exception("Erro ao fazer upload do arquivo.");
      }

      return redirect(route('frete'))->with('success', "Lista de fretes cadastrada com sucesso. Adicionados {$total} registros.");
    }
    catch (\Exception $e) {
      return redirect(route('frete'))->withErrors(['listaFretes' => 'Ocorreu um erro ao fazer o upload do arquivo.']);
    }
  }

}
