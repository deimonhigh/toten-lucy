<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Atualizacao;
use App\Http\Controllers\Model\Cliente;
use App\Http\Controllers\Model\Pedido;
use App\Http\Controllers\Model\Pedidosproduto;
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

      $url = url("/storage/comprovantes/{$request->idcliente}-{$now}.png");

      $cliente = Cliente::find($request->idcliente);

      $this->savePedidosKpl($request, $cliente, $url);

      foreach ($request->produtos as $produto) {
        $temp = new Pedidosproduto();
        $temp->produto_id = $produto['produto_id'];
        $temp->quantidade = $produto['qnt'];
        $temp->idcliente = $request->idcliente;
        $temp->idpedido = $request->idPedido;
        $temp->save();
      }


      $pedido = Pedido::find($request->idPedido);
      $pedido->cliente_id = $request->idcliente;
      $pedido->total = $request->total;
      $pedido->parcelas = $request->parcelas;
      $pedido->comprovante = "/public/comprovantes/{$request->idcliente}-{$now}.png";
      $pedido->status = TRUE;
      $pedido->save();


      $update = Atualizacao::findOrNew(1);
      $update->pedidos = Carbon::now();
      $update->save();

      $request->url = $url;
      $request->cliente = $cliente;

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }

  }

  protected function savePedidosKpl($pedido, $cliente, $url)
  {
    $insertKpl = [];
    $insertKpl['InserirPedido'] = [];
    $insertKpl['InserirPedido']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
    $insertKpl['InserirPedido']['ListaDePedidos'] = [
        'DadosPedidos' => [
            "NumeroDoPedido" => $pedido->idPedido,
            "Email" => $cliente->email,
            "CPFouCNPJ" => $cliente->documento,
            "CodigoCliente" => $cliente->codigo_cliente,
            "CondicaoPagamento" => $this->condicaoPagamento($pedido->parcelas),
            "ValorPedido" => $pedido->total,
            "CampoUsoLivre" => $url,
            "DataVenda" => Carbon::now()->toDateTimeString(),
            "EmitirNotaSimbolica" => FALSE,
            "Lote" => "LOTE DE PEDIDO",
            "FormasDePagamento" => [
                "DadosPedidosFormaPgto" => [
                    "PreAutorizadaNaPlataforma" => TRUE
                ]
            ],
            "Itens" => []
        ]
    ];

    foreach ($pedido->produtos as $item) {
      $item = (object)$item;
      $temp = [];
      $temp['DadosPedidosItem'] = [
          "CodigoProduto" => $item->codigoproduto,
          "QuantidadeProduto" => $item->qnt,
          "PrecoUnitario" => $item->preco,
          "Brinde" => FALSE,
          "OptouNFPaulista" => "tbneNao",
          "CartaoPresenteBrinde" => FALSE,
      ];

      array_push($insertKpl['InserirPedido']['ListaDePedidos']['DadosPedidos']['Itens'], $temp);
    }

    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'InserirPedido';

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
