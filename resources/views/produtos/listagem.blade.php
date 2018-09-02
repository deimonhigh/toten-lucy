@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Produtos</h4>
                    <p>Aqui você confere a lista de produtos cadastrados no momento</p>
                    <a class="btn btn-default" style="margin-top: 20px;" href="{{ url(route('importarProdutos')) }}">
                        Atualizar base de dados
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do Produto</th>
                                    <th>Código do Produto</th>
                                    <th>Código de barras</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @if(count($dados) > 0)
                                @foreach($dados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->nomeproduto }}</td>
                                            <td>{{ $data->codigoproduto }}</td>
                                            <td>{{ $data->codigobarras }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes de produtos"
                                                   href="{{ url(route('produtosDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum produto cadastrado no momento.</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        {{ $dados->render() }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

