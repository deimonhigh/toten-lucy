<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Produto;

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

    return view('produtos.detalhe', $data);
  }

  public function importarProdutos()
  {
    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'ProdutosDisponiveis';
    $arguments = array(
        'ProdutosDisponiveis' => [
            'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3'
        ]
    );

    $result = $client->__soapCall($function, $arguments);

    $rows = $result->ProdutosDisponiveisResult->Rows->DadosProdutos;

    foreach ($rows as $row):
      $categoriasIncluir = [];

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
              'cor' => $cor ? $cor->Descricao : null
          ]
      );

      $produto->categorias()->detach();
      if ($categoriasIncluir) {
        $produto->categorias()->attach($categoriasIncluir);
      }

    endforeach;
  }

  public function importarProdutosView()
  {
    $this->importarProdutos();
    return redirect(route('produtos'));
  }
}
