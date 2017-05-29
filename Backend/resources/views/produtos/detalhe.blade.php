@extends('template')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Clientes</h4>
                    <p>Aqui você visualiza as informações do produto cadastrado.</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Nome do Produto</h5>
                            <p><strong>{{ $dados->nomeproduto }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Código de barras</h5>
                            <p><strong>{{ $dados->codigobarras }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Código produto Ábaco</h5>
                            <p><strong>{{ $dados->codigoprodutoabaco }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Código do Produto</h5>
                            <p><strong>{{ $dados->codigoproduto }}</strong></p>
                        </div>
                        @if(strlen($dados->codigoprodutopai) > 0)
                            <div class="col-sm-6">
                                <h5>Código do Produto Pai</h5>
                                <p><strong>{{ $dados->codigoprodutopai }}</strong></p>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Preço do Produto</h5>
                            <p><strong>{{ "R$ " . number_format($dados->preco, 2,',','.') }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Preço do Produto em promoção</h5>
                            <p><strong>{{ "R$ " . number_format($dados->precopromocao, 2,',','.') }}</strong></p>
                        </div>
                    </div>

                    @if(strlen($dados->descricao) > 0)
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>Descrição</h5>
                                <p><strong>{{ $dados->descricao }}</strong></p>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        @if(strlen($dados->cor) > 0)
                            <div class="col-sm-6">
                                <h5>Cor do Produto</h5>
                                <p><strong>{{ $dados->cor }}</strong></p>
                            </div>
                        @endif
                    </div>

                </div><!-- panel-body -->
                @if($dados->imagens && count($dados->imagens) > 0)
                    <div class="panel-heading">
                        <h4 class="panel-title">Imagens</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row filemanager">
                            @foreach($dados->imagens as $image)
                                <div class="col-xs-6 col-sm-4 col-md-3 document">
                                    <div class="thmb">
                                        <div class="thmb-prev">
                                            <img src="{{ asset($image->path) }}"
                                                 class="img-responsive"
                                                 alt=""
                                                 style="margin: 0 auto; padding: 5px;" />
                                        </div>
                                        <small class="text-muted">
                                            Adicionada em: {{ date('d/m/Y', strtotime($image->updated_at)) }}
                                        </small>
                                    </div><!-- thmb -->
                                </div><!-- col-xs-6 -->
                            @endforeach
                        </div><!-- row -->
                    </div>
                @endif

                <div class="panel-footer">
                    <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

