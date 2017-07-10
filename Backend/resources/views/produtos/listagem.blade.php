@extends('template')

@section('content')

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul style="list-style: none; padding: 0;">
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul style="list-style: none; padding: 0;">
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Produtos</h4>
                    <p>Aqui você confere a lista de produtos cadastrados no momento</p>
                    @if(\App\Gate::hasAccess('admin/produtos/importarProdutosView'))
                        <a class="btn btn-default"
                           style="margin-top: 20px;"
                           href="{{ url(route('importarProdutos')) }}">
                            Atualizar base de dados
                        </a>
                    @endif
                    @if(\App\Gate::hasAccess('admin/lojas/frete'))
                        <a class="btn btn-default"
                           style="margin-top: 20px;"
                           href="{{ url(route('frete')) }}">
                            Importar Lista de Fretes
                        </a>
                    @endif
                </div>

                <div class="panel-body">
                    <form method="get">
                        <div class="form-group">
                            <input type="text"
                                   name="pesquisa"
                                   placeholder="Pesquisar por Nome, código ou código de barras do produto"
                                   class="form-control"
                                   value="{{ isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '' }}">
                        </div>
                    </form>
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
                                    <th>Estoque</th>
                                    <th>Habilitado</th>
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
                                            <td>{{ $data->estoque }}</td>
                                            <td>{{ ($data->disabled ? 'Não' : 'Sim') }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes de produto"
                                                   href="{{ url(route('produtosDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                @if(\App\Gate::hasAccess('admin/produtos/habilitar'))
                                                    @if($data->disabled)
                                                        <a class="btn btn-default"
                                                           title="Habilitar produto"
                                                           href="{{ url(route('habilitar', ['id' => $data->id])) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-default"
                                                           title="Desabilitar produto"
                                                           href="{{ url(route('desabilitar', ['id' => $data->id])) }}">
                                                            <i class="fa fa-eye-slash"></i>
                                                        </a>
                                                    @endif
                                                @endif
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
                    {{ $dados->appends(['pesquisa' => (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '')])->render() }}
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

