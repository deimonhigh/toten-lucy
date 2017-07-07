<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Atualizacao;
use App\Http\Controllers\Model\Cliente;
use App\Http\Controllers\Model\Comprovante;
use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\Model\Pedido;
use App\Http\Controllers\Model\Pedidosproduto;
use App\Http\Controllers\Model\Produto;
use App\Http\Controllers\RestController as BaseController;
use App\User;
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
      $img = "/storage/comprovantes/{$request->idcliente}-{$now}.png";

      Storage::put("/public/comprovantes/{$request->idcliente}-{$now}.png", $data);

      $url = url($img);

      $cliente = Cliente::find($request->idcliente);

      $this->savePedidosKpl($request, $cliente, $url);

      foreach ($request->produtos as $produto) {
        $temp = new Pedidosproduto();
        $temp->produto_id = $produto['produto_id'];
        $temp->quantidade = $produto['qnt'];
        $temp->idcliente = $request->idcliente;
        $temp->idpedido = $request->idPedido;
        $temp->save();

        Produto::find($produto['produto_id'])->update(['estoque' => \DB::raw('estoque - 1')]);
      }

      $user = User::where('email', $request->email)->first();

      $pedido = Pedido::find($request->idPedido);
      $pedido->cliente_id = $request->idcliente;
      $pedido->total = $request->totalSemJuros;
      $pedido->parcelas = $request->parcelas;
      $pedido->frete = $request->frete;
      $pedido->comprovante = $img;
      $pedido->status = TRUE;
      $pedido->user_id = $user->id;
      $pedido->save();

      if (isset($request->comprovantes)) {
        foreach ($request->comprovantes as $item) {
          $comprovante = new Comprovante();
          $comprovante->bandeira = $item['bandeira'];
          $comprovante->codigo = $item['codigo'];
          $comprovante->vendedor_id = $item['vendedor_id'];
          $comprovante->cliente_id = $cliente->id;
          $comprovante->user_id = $user->id;

        }
      }

      $update = Atualizacao::findOrNew(1);
      $update->pedidos = Carbon::now();
      $update->save();

      $request->url = $url;
      $request->cliente = $cliente;
      unset($request->img);

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk();
    }
  }

  protected function savePedidosKpl($pedido, $cliente, $url)
  {

    $itens = [];
    $itens['DadosPedidosItem'] = [];

    foreach ($pedido->produtos as $item) {
      $item = (object)$item;
      $temp = [
          "QuantidadeProduto" => (float)$item->qnt,
          "CodigoProduto" => $item->codigoproduto,
          "PrecoUnitario" => $this->totalComJuros($pedido->parcelas, (float)$item->preco),
          "ValorReferencia" => $this->totalComJuros($pedido->parcelas, (float)$item->preco),
          "PrecoUnitarioBruto" => $this->totalComJuros($pedido->parcelas, (float)$item->preco),
          "EmbalagemPresente" => FALSE,
          "Brinde" => FALSE
      ];

      array_push($itens['DadosPedidosItem'], $temp);
    }

    $insertKpl = [];
    $insertKpl['InserirPedido'] = [];
    $insertKpl['InserirPedido']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
    $insertKpl['InserirPedido']['ListaDePedidos'] = [
        'DadosPedidos' => [
            "NumeroDoPedido" => 'SF' . str_pad((string)$pedido->idPedido, 13, 0, STR_PAD_LEFT),
            "Email" => $cliente->email,
            "CPFouCNPJ" => $cliente->documento,
            "CodigoCliente" => $cliente->codigo_cliente,
            "ValorPedido" => $pedido->total,
            "ValorFrete" => 0,
            "ValorEncargos" => 0,
            "ValorDesconto" => 0,
            "ValorEmbalagemPresente" => 0,
            "ValorCupomDesconto" => 0,
            "DestTipoPessoa" => $this->tipoPessoa($cliente->sexo),
            "DestTipoLocalEntrega" => 'tleeDesconhecido',
            "ValorReceberEntrega" => 0,
            "ValorTrocoEntrega" => 0,
            "PedidoJaPago" => TRUE,
            "Anotacao1" => "Comprovante de pagamento: " . $url,
            "DataVenda" => Carbon::now()->format('dmY'),
            "EmitirNotaSimbolica" => FALSE,
            "Lote" => "LOTE DE PEDIDO",
            "Transportadora" => "ENTREGA",
            "OptouNFPaulista" => "tbneNao",
            "ValorTotalCartaoPresente" => 0,
            "CartaoPresenteBrinde" => FALSE,
            "TempoEntregaTransportadora" => 0,
            "ComercializacaoOutrasSaidas" => 0,
            "PrazoEntregaPosPagamento" => 0,
            "ValorAdicionalImpostos" => 0,
            "ValorFretePagar" => 0,
            "FormasDePagamento" => [
                "DadosPedidosFormaPgto" => [
                    "FormaPagamentoCodigo" => $this->condicaoPagamento($pedido->aVista),
                    "Valor" => $pedido->total,
                    "PreAutorizadaNaPlataforma" => FALSE,
                    "CartaoQtdeParcelas" => $pedido->parcelas,
                ]
            ],
            'Itens' => $itens
        ]
    ];

    try {
      $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
      $function = 'InserirPedido';

      $result = $client->__soapCall($function, $insertKpl);

      return $result;
    }
    catch (\Exception $e) {
      return $insertKpl;
    }

  }

  protected function condicaoPagamento(bool $aVista)
  {
    return $aVista ? "CARTAO DE CREDITO" : "A VISTA";
  }

  protected function totalComJuros($parcelas, $total)
  {
    $config = Configuracao::find(1)->toArray();

    try {
      return $total + $total * ($config['parcela' . $parcelas] / 100);
    }
    catch (\Exception $e) {
      return $total;
    }
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
