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
                            <p><strong>{{ $dados->cliente->nome }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Documento CPF/CNPJ</h5>
                            <p><strong>{{ $dados->cliente->documento }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Data de solicitação do pedido</h5>
                            <p><strong>{{ date('d/m/Y', strtotime($dados->created_at)) }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h5>Comprovante</h5>
                            <p>
                                <a href="{{ asset(str_replace('public', 'storage', $dados->comprovante)) }}" download>
                                    <img src="{{ asset(str_replace('public', 'storage', $dados->comprovante)) }}"
                                         class="img-responsive"
                                         alt="{{ $dados->cliente->nome }}"
                                         style="width: 100%; margin-top: 20px;">
                                </a>
                            </p>
                        </div>
                    </div>

                    @if($dados->cliente->enderecos && count($dados->cliente->enderecos) > 0)
                        <h3 class="bbottom">Endereço(s)</h3>
                        @foreach($dados->cliente->enderecos as $key => $endereco)
                            <h4>Endereço {{ $key + 1 }}</h4>
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
                                    <h5>Endereço de entrega</h5>
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
                            @if($key != 1)
                                <hr>
                            @endif
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

