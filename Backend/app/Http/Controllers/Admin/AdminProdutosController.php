<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Atualizacao;
use App\Http\Controllers\Model\Imagemproduto;
use App\Http\Controllers\Model\Produto;
use Carbon\Carbon;

class AdminProdutosController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-glass";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Produtos";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "produtos";
    $data['submenu'] = "";
    //endregion

    $data['dados'] = Produto::paginate(15);

    return view('produtos.listagem', $data);
  }

  public function detalhes($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-glass";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Produtos";
    $data['comment'] = "Detalhes";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "produtos";
    $data['submenu'] = "listagem";
    //endregion

    $data['dados'] = Produto::findOrFail($id);

    $data['dados']->imagens = array_filter($data['dados']->imagens->toArray(), function ($obj) {
      return strpos($obj['path'], 'noImg') == FALSE;
    });

//    var_dump($data['dados']->imagens);

    return view('produtos.detalhe', $data);
  }

  public function importarProdutos()
  {
    //region Salva Produtos
    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'ProdutosDisponiveis';
    $arguments = [
        'ProdutosDisponiveis' => [
            'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3'
        ]
    ];

    $result = $client->__soapCall($function, $arguments);

    $protocoloProduto = [];
    $estoqueIncluir = [];
    $notInProdutos = [];

    if (isset($result->ProdutosDisponiveisResult->Rows)):
      $rows = $result->ProdutosDisponiveisResult->Rows->DadosProdutos;

      foreach ($rows as $row):
        $categoriasIncluir = [];

        array_push($protocoloProduto, [
            'ProtocoloProduto' => $row->ProtocoloProduto
        ]);

        array_push($estoqueIncluir, $row->CodigoProduto);

        if ($row->CategoriasDoSite->ResultadoOperacao->Tipo != 'tdreSucessoSemDados'):
          if (gettype($row->CategoriasDoSite->Rows->DadosCategoriasDoSite) == 'object') {
            array_push($categoriasIncluir, $row->CategoriasDoSite->Rows->DadosCategoriasDoSite->CodigoCategoria);
          } else {
            foreach ($row->CategoriasDoSite->Rows->DadosCategoriasDoSite as $categoria):
              array_push($categoriasIncluir, $categoria->CodigoCategoria);
            endforeach;
          }
        endif;

        $cor = array_filter($row->DescritorPreDefinido->Rows->DadosDescritorPreDefinido, function ($obj) {
          return trim($obj->GrupoNome) == "COR";
        });

        $cor = reset($cor);
        $produto = Produto::updateOrCreate(
            ['codigobarras' => $row->CodigoBarras],
            [
                'codigobarras' => $row->CodigoBarras,
                'codigoprodutoabaco' => $row->CodigoProdutoAbacos,
                'codigoprodutopai' => $row->CodigoProdutoPai,
                'codigoproduto' => $row->CodigoProduto,
                'nomeproduto' => $row->NomeProduto,
                'descricao' => $row->CaracteristicasComplementares->Rows->DadosCaracteristicasComplementares->Texto,
                'peso' => $row->Peso,
                'preco1' => 0,
                'precopromocao1' => 0,
                'preco2' => 0,
                'precopromocao2' => 0,
                'disabled' => 0,
                'cor' => $cor ? $cor->Descricao : null
            ]
        );

        array_push($notInProdutos, $row->CodigoProduto);

        $produto->categorias()->detach();
        if ($categoriasIncluir) {
          $produto->categorias()->attach($categoriasIncluir);
        }
      endforeach;

      $this->atualizaEstoque($estoqueIncluir);

      Produto::whereNotIn('codigoproduto', $notInProdutos)->update(['disabled' => true]);
      //region Confirma Produtos
      $this->confirmaProdutos($protocoloProduto);
      //endregion
    endif;
    //endregion

    //region Atualiza os Preços
    $this->atualizaPrecos($protocoloProduto);
    //endregion

    $this->findFiles();

    $atualizacao = Atualizacao::firstOrNew(['id' => 1]);
    $atualizacao->produtos = Carbon::now();
    $atualizacao->save();
  }

  public function importarProdutosView()
  {
    $this->importarProdutos();
    return redirect(route('produtos'))->with('success', 'Produtos sincronizados com sucesso.');
  }

  private function atualizaPrecos($countProduto)
  {
    if (count($countProduto) > 0) {
      $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
      $function = 'PrecosDisponiveis';
      $arguments = [
          'PrecosDisponiveis' => [
              'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3'
          ]
      ];
      $result = $client->__soapCall($function, $arguments);

      $listaPreco = $this->array_group_by($result->PrecosDisponiveisResult->Rows->DadosPreco, function ($i) {
        return $i->CodigoProdutoAbacos;
      });

      foreach ($listaPreco as $key => $item) {
        $item1 = array_values(array_filter($item, function ($obj) {
          return strcmp($obj->NomeLista, "LISTA_LOJA");
        }));

        $item2 = array_values(array_filter($item, function ($obj) {
          return !strcmp($obj->NomeLista, "LISTA_LOJA");
        }));

        $produto = Produto::where('codigoprodutoabaco', $key)->first();
        if ($produto):
          $produto->preco1 = count($item1) > 0 ? $item1[0]->PrecoTabela : 0;
          $produto->precopromocao1 = count($item1) > 0 ? $item1[0]->PrecoPromocional : 0;
          $produto->preco2 = count($item2) > 0 ? $item2[0]->PrecoTabela : 0;
          $produto->precopromocao2 = count($item2) > 0 ? $item2[0]->PrecoPromocional : 0;
          $produto->save();
        endif;
      }
    }
  }

  private function atualizaEstoque($produtosEnviar)
  {
    if (count($produtosEnviar) > 0) {
      $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2, "exceptions" => 0]);
      $function = 'EstoqueOnLine';

      $arguments = [
          'EstoqueOnLine' => [
              'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3',
              'ListaDeCodigosProdutos' => [
                  'string' => $produtosEnviar
              ]
          ]
      ];

      try {
        $result = $client->__soapCall($function, $arguments);
        foreach ($result->EstoqueOnLineResult->Rows->DadosEstoqueResultado as $item) {
          $produto = Produto::where('codigoproduto', $item->CodigoProduto)->first();
          $produto->estoque = $item->SaldoDisponivel;
          $produto->save();
        }
      }
      catch (\Exception $e) {
        
      }
    }
  }

  private function findFiles()
  {
    Imagemproduto::truncate();

    $produtos = Produto::all('codigoproduto', 'id');

    $insert = [];
    $basePath = 'app/public/upload/';

    foreach ($produtos as $produto) {
      $path = storage_path($basePath . str_replace('.', '_', $produto->codigoproduto));

      if (is_dir($path)) {
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) {
            $pathToImg = $path . '/' . $file;
            if (($file != '.' && $file != '..') && !is_dir($pathToImg) && getimagesize($pathToImg)) {

              $pathToSave = 'storage/' . str_replace(storage_path('app/public/'), '', $pathToImg);

              $pushToProdutos = [];
              $pushToProdutos['produto_id'] = $produto->id;
              $pushToProdutos['path'] = $pathToSave;
              $pushToProdutos['created_at'] = Carbon::now();
              $pushToProdutos['updated_at'] = Carbon::now();

              array_push($insert, $pushToProdutos);

            }
          }
          closedir($handle);
        }
      } else {
        $pushToProdutos = [];
        $pushToProdutos['produto_id'] = $produto->id;
        $pushToProdutos['path'] = 'storage\default\noImg.png';
        $pushToProdutos['created_at'] = Carbon::now();
        $pushToProdutos['updated_at'] = Carbon::now();

        array_push($insert, $pushToProdutos);
      }
    }

    Imagemproduto::insert($insert);

  }

  private function confirmaProdutos($arr)
  {
    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'ConfirmaRecebimentoProdutoLote';
    $arguments = [
        'ConfirmaRecebimentoProdutoLote' => [
            'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3',
            'ListaDeNumerosDeProtocoloRows' => [
                'ListaDeNumerosDeProtocolo' => $arr
            ]
        ]
    ];
    $client->__soapCall($function, $arguments);
  }

  private function array_group_by(array $arr, callable $key_selector)
  {
    $result = array();
    foreach ($arr as $i) {
      $key = call_user_func($key_selector, $i);
      $result[$key][] = $i;
    }
    return $result;
  }
}
