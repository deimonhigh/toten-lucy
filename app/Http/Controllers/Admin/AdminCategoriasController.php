<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Controllers\Model\Admincategoria;
use App\Http\Controllers\Model\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoriasController extends BaseController
{
  public function index()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-tags";
    $data['parent'] = "Lucy Toten";
    $data['current'] = "Categorias";
    $data['url'] = "/admin/dashboard";
    $data['menu'] = "categorias";
    $data['submenu'] = "listagem";
    //endregion

    $data['dados'] = Admincategoria::all();
    $data['dadosImportados'] = Categoria::all();

    return view('categorias.listagem', $data);
  }

  public function cadastro()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-tags";
    $data['parent'] = "Listagem";
    $data['current'] = "Categorias";
    $data['comment'] = "Cadastro";
    $data['url'] = "/admin/categorias";
    $data['menu'] = "categorias";
    $data['submenu'] = "cadastrar";
    //endregion

    return view('categorias.cadastro', $data);
  }

  public function editar($id)
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-tags";
    $data['parent'] = "Listagem";
    $data['current'] = "Categorias";
    $data['comment'] = "Editar";
    $data['url'] = "/admin/categorias";
    $data['menu'] = "categorias";
    $data['submenu'] = "cadastrar";
    //endregion

    $data['dados'] = Admincategoria::findOrFail($id);
    $data['dados']->imagem = asset('/storage/' . $data['dados']->imagem);

    return view('categorias.cadastro', $data);
  }

  public function cadastrar(Request $request)
  {
    $this->validate($request, [
        'descricao' => 'required',
        'imagem' => 'required|image',
    ]);

    $categoria = Admincategoria::firstOrNew(['id' => $request->get('id')]);

    if ($categoria->imagem) {
      Storage::delete('/public/' . $categoria->imagem);
    }

    $categoria->descricao = $request->get('descricao');

    $categoria->imagem = $request->file('imagem')->store('categorias', 'public');

    $categoria->save();

    return redirect(route('listagemCategoria'));
  }

  public function deletar($id)
  {
    Admincategoria::find($id)->delete();;
    return redirect(route('listagemCategoria'));
  }

  public function importarCategorias()
  {
    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'CategoriasProdutoDisponiveis';
    $arguments = array(
        'CategoriasProdutoDisponiveis' => [
            'ChaveIdentificacao' => '77AD990B-6138-4065-9B86-8D30119C09D3'
        ]
    );

    $result = $client->__soapCall($function, $arguments);
    $rows = $result->CategoriasProdutoDisponiveisResult->Rows->DadosCategoriasProduto;

    foreach ($rows as $row):
      Categoria::updateOrCreate(
          ['codigocategoria' => $row->CodigoCategoriaProduto],
          [
              'descricao' => $row->Nome,
              'codigocategoria' => $row->CodigoCategoriaProduto,
              'codigocategoriapai' => $row->CodigoCategoriaProdutoPai
          ]
      );
    endforeach;
  }

  public function importarCategoriasView()
  {
    $this->importarCategorias();

    return redirect(route('listagemCategoria'));
  }

  public function relacionar()
  {
    $data = [];
    //region Breadcrumb
    $data['icon'] = "fa-tags";
    $data['parent'] = "Listagem";
    $data['current'] = "Relacionar";
    $data['url'] = "/admin/categorias";
    $data['menu'] = "categorias";
    $data['submenu'] = "relacionar";
    //endregion

    $data['Admincategoria'] = Admincategoria::all();

    $count = 0;
    foreach ($data['Admincategoria'] as $item) {
      if (count($item->categorias) > 0) {
        $count++;
      }
    }

    $data['categoriasImportadas'] = Categoria::whereNotIn('id', function ($q) {
      $q->select('categoria_id')->from('admincategoria_categoria');
    })->get();


    $data['dados'] = $count > 0;

    return view('categorias.relacionar', $data);
  }

  public function relacionarCadastro(Request $request)
  {
    $this->validate($request, [
        'admincategoria_id' => 'required',
        'categoria_id' => 'required',
    ]);

    $categoria = Admincategoria::find($request->get('admincategoria_id'));

    $categoria->categorias()->attach($request->get('categoria_id'));

    return redirect(route('categoriasRelacao'));
  }

  public function relacionarDeletar($idCatAdmin, $idCat)
  {
    Admincategoria::find($idCatAdmin)->categorias()->detach($idCat);
    return redirect(route('categoriasRelacao'));
  }
}
