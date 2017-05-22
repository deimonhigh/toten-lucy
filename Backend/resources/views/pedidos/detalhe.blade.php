@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Pedidos</h4>
                    <p>Aqui você visualiza as informações dos clientes cadastrados.</p>
                </div>
                <div class="panel-body">
                    <h3 class="bbottom">Dados do cliente</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Nome</h5>
                            <p><strong>{{ $dados->nome }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Documento CPF/CNPJ</h5>
                            <p><strong>{{ $dados->documento }}</strong></p>
                        </div>
                    </div>

                    @if($enderecos && count($enderecos) > 0)
                        <h3 class="bbottom">Endereço(s)</h3>
                        @foreach($enderecos as $endereco)
                            <h4>Endereço 1</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>CEP</h5>
                                    <p><strong>{{ $endereco->cep}}</strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Endereço</h5>
                                    <p><strong>{{ $endereco->endereco }}, {{ $endereco->numero }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Complemento</h5>
                                    <p><strong>{{ $endereco->complemento }}</strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Bairro</h5>
                                    <p><strong>{{ $endereco->bairro }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Cidade</h5>
                                    <p><strong>{{ $endereco->cidade }}</strong></p>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Estado</h5>
                                    <p><strong>{{ $endereco->uf }}, {{ $endereco->numero }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Endereço principal</h5>
                                    <p>
                                        <strong>
                                            @if($endereco->enderecooriginal)
                                                Sim
                                            @else
                                                Não
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

