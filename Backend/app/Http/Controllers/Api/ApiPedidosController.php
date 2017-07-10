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
  public function checarComprovantes(Request $request)
  {
    $request = (array)$request->all();
    $exist = [];
    try {
      foreach ($request as $item) {
        $exist = Comprovante::select('bandeira', 'codigo')->where(function ($q) use ($item, &$exist) {
          $q->where('bandeira', $item['bandeira']['id']);
          $q->where('codigo', $item['codigo']);
        })->first();

        if ($exist) {
          throw new \Exception();
        }
      }

      return $this->Ok(false);
    }
    catch (\Exception $e) {
      return $this->nonOk($exist);
    }
  }

  public function save(Request $request)
  {
    try {
      $request = (object)$request->all();

      \DB::transaction(function () use ($request) {

        foreach ($request->produtos as $produto) {
          $prod = Produto::find($produto['produto_id']);
          if ($prod->estoque <= 0) {
            throw new \Exception("Não temos mais o produto {$prod->nomeproduto} em estoque.", 789);
          }
        }

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->img));

        $now = str_replace(':', '-', str_replace(' ', '-', ((string)Carbon::now())));
        $img = "/storage/comprovantes/{$request->idcliente}-{$now}.png";

        Storage::put("/public/comprovantes/{$request->idcliente}-{$now}.png", $data);

        $url = url($img);

        $cliente = Cliente::find($request->idcliente);

//        $retornoKpl = $this->savePedidosKpl($request, $cliente, $url);
//
//        \Log::info(json_decode($retornoKpl));

//        if (
//            (
//                isset($retornoKpl->InserirPedidoResult->ResultadoOperacao->Tipo) &&
//                !strcmp($retornoKpl->InserirPedidoResult->ResultadoOperacao->Tipo, 'tdreSucesso')
//            ) ||
//            (
//                isset($retornoKpl->flag) &&
//                !$retornoKpl->flag
//            )
//        ) {
//          throw new \Exception("Ocorreu um problema ao finalizar seu pedido..", 789);
//        }

        foreach ($request->produtos as $produto) {
          $temp = new Pedidosproduto();
          $temp->produto_id = $produto['produto_id'];
          $temp->quantidade = $produto['qnt'];
          $temp->idcliente = $request->idcliente;
          $temp->idpedido = $request->idPedido;
          $temp->save();

          Produto::find($produto['produto_id'])->decrement('estoque');
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
            $comprovante->pedido_id = $request->idPedido;
            $comprovante->user_id = $user->id;
            $comprovante->save();
          }
        }

        $update = Atualizacao::findOrNew(1);
        $update->pedidos = Carbon::now();
        $update->save();

        $request->url = $url;
        $request->cliente = $cliente;
        unset($request->img);
      });

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      if ($e->getCode() == 789) {
        return $this->nonOk($e->getMessage(), 1);
      } else {
        return $this->nonOk();
      }

    }
  }

  public function saveMP(Request $request)
  {
    try {
      $request = (object)$request->all();
      $pagamento = [];

      \DB::transaction(function () use (&$request, &$pagamento) {
        foreach ($request->produtos as $produto) {
          $prod = Produto::find($produto['produto_id']);
          if ($prod->estoque <= 0) {
            throw new \Exception("Não temos mais o produto {$prod->nome} em estoque.", 789);
          }
        }

        $cliente = Cliente::find($request->idcliente);

        $mp = new \MP(config('app.customVars.apiKeyPriv'));
        $mp->sandbox_mode = TRUE;

        $itens = [];
        $somaProdutos = 0;
        foreach ($request->produtos as $item) {
          $item = (object)$item;
          $temp = [
              "quantity" => (float)$item->qnt,
              "title" => Produto::select('nomeproduto')->where('codigoproduto', $item->codigoproduto)->first()->nomeproduto,
              "unit_price" => $this->totalComJuros($request->parcelas, (float)$item->preco),
              'category_id' => 'home'
          ];

          $somaProdutos += $temp['unit_price'];

          array_push($itens, $temp);
        }

        $payment_data = [
            "transaction_amount" => $somaProdutos,
            "statement_descriptor" => 'Lucy Home',
            "payment_method_id" => $request->method,
            "description" => "Lucy Home",
            'installments' => (int)$request->parcelas > 0 ? $request->parcelas : 1,
            "payer" => [
                "email" => "bruno@agenciadominio.com.br"
                //                "email" => $cliente->email
            ],
            "additional_info" => [
                "items" => $itens
            ]
        ];

        if (!strcmp($request->method, 'bolbradesco')) {
          $payment_data["token"] = $request->token;
        }

        $payment = $mp->post("/v1/payments", $payment_data);

        if (!strcmp($payment['response']['status'], 'approved')) {
          throw new \Exception("Pedido não aprovado pela emissora do cartão.", 789);
        }

        $pagamento = $payment;

        if (!strcmp($request->method, 'bolbradesco')) {
          $request->boleto = $payment['response']['transaction_details']['external_resource_url'];
        }
        $request->mp = true;

        //region KPL
        //        $retornoKpl = $this->savePedidosKpl($request, $cliente, $url);
//
//        \Log::info(json_decode($retornoKpl));

//        if (
//            (
//                isset($retornoKpl->InserirPedidoResult->ResultadoOperacao->Tipo) &&
//                !strcmp($retornoKpl->InserirPedidoResult->ResultadoOperacao->Tipo, 'tdreSucesso')
//            ) ||
//            (
//                isset($retornoKpl->flag) &&
//                !$retornoKpl->flag
//            )
//        ) {
//          throw new \Exception("Ocorreu um problema ao finalizar seu pedido..", 789);
//        }
        //endregion

        //region Salva produtos
        foreach ($request->produtos as $produto) {
          $temp = new Pedidosproduto();
          $temp->produto_id = $produto['produto_id'];
          $temp->quantidade = $produto['qnt'];
          $temp->idcliente = $request->idcliente;
          $temp->idpedido = $request->idPedido;
          $temp->save();

          Produto::find($produto['produto_id'])->decrement('estoque');
        }
        //endregion

        $user = User::where('email', $request->email)->first();

        //region Altera pedido
        $pedido = Pedido::find($request->idPedido);
        $pedido->cliente_id = $request->idcliente;
        $pedido->total = $request->totalSemJuros;
        $pedido->parcelas = $request->parcelas;
        $pedido->frete = $request->frete;
        $pedido->comprovante = null;
        $pedido->status = TRUE;
        $pedido->user_id = $user->id;
        $pedido->save();
        //endregion

        //region Atualiza tabela de Integração
        $update = Atualizacao::findOrNew(1);
        $update->pedidos = Carbon::now();
        $update->save();
        //endregion
      });

      return $this->Ok($request);
    }
    catch (\Exception $e) {
      $except = new \StdClass();
      $except->error = $e->getMessage();
      $except->line = $e->getLine();
      $except->trace = $e->getTraceAsString();
      $except->flag = false;

      \Log::error(json_encode($except));

//      $mp = new \MP(config('app.customVars.apiKeyPriv'));
//      $mp->cancel_payment($pagamento['response']);

      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      if ($e->getCode() == 789) {
        return $this->nonOk(['msg' => $e->getMessage()], 1, 400);
      } else {
        return $this->nonOk();
      }


    }
  }

  protected function savePedidosKpl($pedido, $cliente, $url)
  {
    try {
      $itens = [];
      $itens['DadosPedidosItem'] = [];

      $somaProdutos = 0;
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

        $somaProdutos += $temp['PrecoUnitario'];

        array_push($itens['DadosPedidosItem'], $temp);
      }

      $aVista = (int)$pedido->parcelas > 0;

      $insertKpl = [];
      $insertKpl['InserirPedido'] = [];
      $insertKpl['InserirPedido']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
      $insertKpl['InserirPedido']['ListaDePedidos'] = [
          'DadosPedidos' => [
              "NumeroDoPedido" => 'SF' . str_pad((string)$pedido->idPedido, 13, 0, STR_PAD_LEFT),
              "Email" => $cliente->email,
              "CPFouCNPJ" => $cliente->documento,
              "CodigoCliente" => $cliente->codigo_cliente,
              "ValorPedido" => $somaProdutos,
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
                      "FormaPagamentoCodigo" => $this->condicaoPagamento($aVista),
                      "Valor" => $somaProdutos,
                      "PreAutorizadaNaPlataforma" => FALSE,
                      "CartaoQtdeParcelas" => (int)$pedido->parcelas ? (int)$pedido->parcelas : 1,
                  ]
              ],
              'Itens' => $itens
          ]
      ];

      $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
      $function = 'InserirPedido';

      $result = $client->__soapCall($function, $insertKpl);

      return $result;
    }
    catch (\Exception $e) {
      $except = new \StdClass();
      $except->error = $e->getMessage();
      $except->line = $e->getLine();
      $except->error = $e->getTraceAsString();
      $except->flag = false;

      \Log::error(json_encode($except));

      return $except;
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

  // parse the excepetion "message" to get the code and detail, if exists
  private function parseException($message)
  {
    $error = new \stdClass();
    $error->code = 0;
    $error->detail = '';
    $posA = strpos($message, '-');
    $posB = strpos($message, ':');
    if ($posA && $posB) {
      $posA += 2;
      $length = $posB - $posA;
      // get code
      $error->code = substr($message, $posA, $length);
      // get message
      $error->detail = substr($message, $posB + 2);
    }
    return $error;
  }
}
