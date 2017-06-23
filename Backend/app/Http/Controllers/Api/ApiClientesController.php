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
      $json = (object)$request->all();

      if (!isset($json->id)) {
        $json->id = null;
      }

      $clienteKpl = $this->saveClienteKpl($json);

      $idCliente = Cliente::updateOrCreate(
          [
              'id' => $json->id
          ],
          [
              "documento" => $json->documento,
              "nome" => $json->nome,
              "telefone" => $json->telefone,
              "email" => $json->email,
              "sexo" => $json->sexo,
              "celular" => $json->celular,
              "codigo_cliente" => $clienteKpl->CadastrarClienteResult->Rows->DadosClientesResultado->Codigo,
          ]
      );

      Endereco::where('idcliente', $idCliente['id'])->delete();

      foreach ($json->enderecos as $item) {
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
    $endereco = [];
    $enderecoEntrega = [];

    foreach ($cliente->enderecos as $item) {
      if ($item['enderecoOriginal'] && count($cliente->enderecos) > 1) {
        $enderecoEntrega['Cep'] = (string)$item['cep'];
        $enderecoEntrega['Logradouro'] = $item['endereco'];
        $enderecoEntrega['NumeroLogradouro'] = (string)$item['numero'];
        $enderecoEntrega['Bairro'] = $item['bairro'];
        if (isset($item['complemento'])) {
          $enderecoEntrega['ComplementoEndereco'] = $item['complemento'];
        }
        $enderecoEntrega['Municipio'] = $item['cidade'];
        $enderecoEntrega['Estado'] = $item['uf'];
        $enderecoEntrega['TipoLocalEntrega'] = $this->tipoLocalEntrega($cliente->sexo);
      } else {
        $endereco['Cep'] = (string)$item['cep'];
        $endereco['Logradouro'] = $item['endereco'];
        $endereco['NumeroLogradouro'] = (string)$item['numero'];
        $endereco['Bairro'] = $item['bairro'];
        if (isset($item['complemento'])) {
          $endereco['ComplementoEndereco'] = $item['complemento'];
        }
        $endereco['Municipio'] = $item['cidade'];
        $endereco['Estado'] = $item['uf'];
        $endereco['TipoLocalEntrega'] = $this->tipoLocalEntrega($cliente->sexo);
      }
    }

    if (count($cliente->enderecos) == 1) {
      $enderecoEntrega = $endereco;
    }

    $insertKpl = [];
    $insertKpl['CadastrarCliente'] = [];
    $insertKpl['CadastrarCliente']['ChaveIdentificacao'] = '77AD990B-6138-4065-9B86-8D30119C09D3';
    $insertKpl['CadastrarCliente']['ListaDeClientes'] = [
        'DadosClientes' => [
            "Email" => $cliente->email,
            "CPFouCNPJ" => $cliente->documento,
            "TipoPessoa" => $this->tipoPessoa($cliente->sexo),
            "Nome" => $cliente->nome,
            "Sexo" => $this->tipoSexo($cliente->sexo),
            "Endereco" => $endereco,
            "EndEntrega" => $enderecoEntrega,
            "ClienteEstrangeiro" => 'N'
        ]
    ];

    $client = new \SoapClient('http://234F657.ws.kpl.com.br/Abacoswsplataforma.asmx?wsdl', ['trace' => true, "soap_version" => SOAP_1_2]);
    $function = 'CadastrarCliente';

    $result = $client->__soapCall($function, $insertKpl);

    return $result;
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
