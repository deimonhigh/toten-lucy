<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Pedido;
use App\Http\Controllers\RestController as BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPedidosController extends BaseController
{
  public function save(Request $request)
  {
    try {
      $request = (object)$request->all();

      $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->img));

      $now = str_replace(':', '-', str_replace(' ', '-', ((string)Carbon::now())));
      Storage::put("/public/comprovantes/{$request->idcliente}-{$now}.png", $data);

      $pedido = Pedido::find($request->idPedido);
      $pedido->cliente_id = $request->idcliente;
      $pedido->total = $request->total;
      $pedido->parcelas = $request->parcelas;
      $pedido->comprovante = "/public/comprovantes/{$request->idcliente}-{$now}.png";
      $pedido->save();

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }

  }

  protected function savePedidosKpl($pedido)
  {
    $insertKpl = [];
    $insertKpl['InserirPedido'] = [];
    $insertKpl['InserirPedido']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
    $insertKpl['InserirPedido']['ListaDePedidos'] = [
        'DadosPedidos' => [
            "NumeroDoPedido" => $pedido->email,
            "Email" => $pedido->email,
            "CPFouCNPJ" => $pedido->documento,
            "TipoPessoa" => $this->tipoPessoa($pedido->sexo),
            "Nome" => $pedido->nome,
            "Sexo" => $this->tipoSexo($pedido->sexo),
            "ClienteEstrangeiro" => 'N'
        ]
    ];

    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'CadastrarCliente';

    $result = $client->__soapCall($function, $insertKpl);

    return $result;
  }

  protected function condicaoPagamento($parcelas)
  {
    return $parcelas > 0 ? "Cartao de Crédito" : " A vista";
  }

  protected function tipoPessoa($sexo)
  {
    return $sexo == 'E' ? 'tpeJuridica' : 'tpeFisica';
  }

  protected function tipoSexo($sexo)
  {
    return $sexo == 'E' ? 'tseEmpresa' : $sexo == 'M' ? 'tseMasculino' : 'tseFeminino';
  }

  protected function tipoLocalEntrega($sexo)
  {
    return $sexo == 'E' ? 'tleeComercial' : 'tleeResidencial';
  }

}
