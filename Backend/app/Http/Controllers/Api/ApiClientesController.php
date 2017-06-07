<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Model\Cliente;
use App\Http\Controllers\Model\Endereco;
use App\Http\Controllers\Model\Pedido;
use App\Http\Controllers\RestController as BaseController;
use Illuminate\Http\Request;

class ApiClientesController extends BaseController
{

  public function findByDocumento($documento)
  {
    try {
      $documento = preg_replace('[^0-9]', '', $documento);

      $cliente = Cliente::where('documento', $documento)->firstOrFail();

      $cliente->enderecos = $cliente->enderecos;

      return $this->Ok($cliente);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }
  }

  public function save(Request $request)
  {
    try {

      $rtt = $this->saveClienteKpl((object)$request->all());


      return $this->Ok($rtt);
      $idCliente = Cliente::updateOrCreate(
          [
              'id' => $request->get('id')
          ],
          [
              "documento" => $request->get('documento'),
              "nome" => $request->get('nome'),
              "telefone" => $request->get('telefone'),
              "email" => $request->get('email'),
              "sexo" => $request->get('sexo'),
              "celular" => $request->get('celular'),
          ]
      );

      Endereco::where('idcliente', $idCliente['id'])->delete();

      foreach ($request->get('enderecos') as $item) {
        $newEndereco = new Endereco();
        $newEndereco->cep = $item['cep'];
        $newEndereco->endereco = $item['endereco'];
        $newEndereco->numero = $item['numero'];
        $newEndereco->bairro = $item['bairro'];
        $newEndereco->complemento = isset($item['complemento']) ? $item['complemento'] : null;
        $newEndereco->cidade = $item['cidade'];
        $newEndereco->uf = $item['uf'];
        $newEndereco->enderecooriginal = $item['enderecoOriginal'];
        $newEndereco->idcliente = $idCliente->id;
        $newEndereco->save();
      }

      $newPedido = new Pedido();
      $newPedido->cliente_id = $idCliente->id;
      $newPedido->total = 0;
      $newPedido->comprovante = '';
      $newPedido->save();

      $json = $request->all();

      $json['idPedido'] = $newPedido->id;

      return $this->Ok($json);
    }
    catch (\Exception $e) {
      if ($this->isModelNotFoundException($e)) {
        return $this->modelNotFound();
      }
      return $this->nonOk($e->getMessage());
    }
  }

  protected function saveClienteKpl($cliente)
  {
    try {
      return Cliente::where('documento', $cliente->documento)->first();
    }
    catch (\Exception $e) {
      $insertKpl = [];
      $insertKpl['CadastrarCliente'] = [];
      $insertKpl['CadastrarCliente']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
      $insertKpl['CadastrarCliente']['ListaDeClientes'] = [
          'DadosClientes' => [
              "Email" => $cliente->email,
              "CPFouCNPJ" => $cliente->documento,
          ]
      ];

      return $cliente;
    }
  }
}
