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

    $data['dados'] = Produto::find($id);

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

    if (isset($result->ProdutosDisponiveisResult->Rows)):
      $rows = $result->ProdutosDisponiveisResult->Rows->DadosProdutos;

      foreach ($rows as $row):
        $categoriasIncluir = [];

        array_push($protocoloProduto, [
            'ProtocoloProduto' => $row->ProtocoloProduto
        ]);

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
                'descricao' => $row->Descricao,
                'preco' => $row->PrecoTabela2,
                'precopromocao' => $row->PrecoPromocao2,
                'cor' => $cor ? $cor->Descricao : null
            ]
        );

        $produto->categorias()->detach();
        if ($categoriasIncluir) {
          $produto->categorias()->attach($categoriasIncluir);
        }


      endforeach;

      //region Confirma Produtos
      $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
      $function = 'ConfirmaRecebimentoProdutoLote';
      $arguments = [
          'ConfirmaRecebimentoProdutoLote' => [
              'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3',
              'ListaDeNumerosDeProtocoloRows' => [
                  'ListaDeNumerosDeProtocolo' => $protocoloProduto
              ]
          ]
      ];
      $client->__soapCall($function, $arguments);
      //endregion
    endif;
    //endregion

    //region Atualiza os Preços
    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'PrecosDisponiveis';
    $arguments = [
        'PrecosDisponiveis' => [
            'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3'
        ]
    ];
    $result = $client->__soapCall($function, $arguments);

    $listaPreco = $result->PrecosDisponiveisResult->Rows->DadosPreco;

    foreach ($listaPreco as $item) {
      $produto = Produto::where('codigoprodutoabaco', $item->CodigoProdutoAbacos)->first();
      if ($produto):
        $produto->preco = $item->PrecoTabela;
        $produto->precopromocao = $item->PrecoPromocional;
        $produto->save();
      endif;
    }
    //endregion

    $this->findFiles();

    $atualizacao = Atualizacao::firstOrNew(['id' => 1]);
    $atualizacao->produtos = Carbon::now();
    $atualizacao->save();
  }

  public function importarProdutosView()
  {
    $this->importarProdutos();
    return redirect(route('produtos'));
  }

  public function findFiles()
  {
    Imagemproduto::truncate();

    $produtos = Produto::all('codigoproduto', 'id');

    $insert = [];
    $basePath = 'app\public\upload\\';

    foreach ($produtos as $produto) {
      $path = storage_path($basePath . str_replace('.', '_', $produto->codigoproduto));
      if (is_dir($path)) {
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) {
            $pathToImg = $path . '\\' . $file;
            if (($file != '.' && $file != '..') && getimagesize($pathToImg)) {

              $pathToSave = 'storage\\' . str_replace(storage_path('app\public\\'), '', $pathToImg);

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
}
