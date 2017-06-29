<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Cliente;
use App\Http\Controllers\Model\Configuracao;
use App\Http\Controllers\Model\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminPedidosController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Pedidos";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "pedidos";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Pedido::where('user_id', Auth::id())->paginate(15);

    foreach ($data['dados'] as $item) {
      $item->pedido_id = 'SF.' . preg_replace("/^(\d{4})(\d{4})(\d+)(\d{2})/", '$1.$2.$3-$4', str_pad((string)$item->id, 13, 0, STR_PAD_LEFT));
    }

    return view('pedidos.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-money";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Pedidos";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "pedidos";
    $data['submenu'] = "";
    //endregion

    $config = Configuracao::find(1)->toArray();
    $data['dados'] = Pedido::with('produtos', 'cliente')->findOrFail($id);

    $data['dados']->pedidos_id = 'SF.' . preg_replace("/^(\d{4})(\d{4})(\d+)(\d{2})/", '$1.$2.$3-$4', str_pad((string)$data['dados']->id, 13, 0, STR_PAD_LEFT));

    if (!is_null($data['dados']->parcelas)) {
      $juros = $config['parcela' . $data['dados']->parcelas] / 100;
      $data['dados']->totalComJuros = $data['dados']->total + ($data['dados']->total * $juros);
    }

    foreach ($data['dados']->produtos as $item) {
      $item->produto->preco = $item->produto["preco" . $config['listaPreco']];
    }

    return view('pedidos.detalhe', $data);
  }

  public function naoConcluidos()
  {
    Pedido::where(function ($q) {
      $q->Where(function ($query) {
        $query->where('user_id', Auth::id());
        $query->where('total', 0);
        $query->orWhere('total', '=', NULL);
      });
      $q->where('status', 0);
    })->delete();

    return redirect(route('pedidos'));
  }

  public function enviarNovamente()
  {
    $pedidos = Pedido::with('produtos')->where(function ($q) {
      $q->Where(function ($query) {
        $query->where('total', '>', 0);
        $query->orWhere('total', '!=', NULL);
      });
      $q->where('status', 0);
      $q->where('user_id', Auth::id());
    })->get();

    foreach ($pedidos as $pedido) {
      $url = url($pedido->comprovante);
      $cliente = Cliente::find($pedido->cliente_id);

      foreach ($pedido->produtos as $item) {
        $item->produto;
      }

      $this->savePedidosKpl($pedido, $cliente, $url);

      $pedido->status = TRUE;
      $pedido->save();
    }

    return redirect(route('pedidos'));
  }

  protected function savePedidosKpl($pedido, $cliente, $url)
  {

    $itens = [];
    $itens['DadosPedidosItem'] = [];

    foreach ($pedido->produtos as $item) {
      $item = (object)$item;
      $temp = [
          "QuantidadeProduto" => (float)$item->quantidade,
          "CodigoProduto" => $item->produto->codigoproduto,
          "PrecoUnitario" => $this->totalComJuros($pedido->parcelas, (float)$item->produto->preco),
          "ValorReferencia" => $this->totalComJuros($pedido->parcelas, (float)$item->produto->preco),
          "PrecoUnitarioBruto" => $this->totalComJuros($pedido->parcelas, (float)$item->produto->preco),
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
            "NumeroDoPedido" => 'SF' . str_pad((string)$pedido->id, 13, 0, STR_PAD_LEFT),
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
                    "FormaPagamentoCodigo" => $this->condicaoPagamento($pedido->parcelas),
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

  protected function condicaoPagamento($aVista)
  {
    return $aVista > 0 ? "CARTAO DE CREDITO" : "A VISTA";
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
