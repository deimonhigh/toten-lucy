@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Categorias do sistema</h4>
                    <p>Aqui você confere a lista de categorias cadastradas no momento</p>
                    <a class="btn btn-default"
                       style="margin-top: 20px;"
                       href="{{ url(route('importarCategoriasView')) }}">
                        Atualizar base de dados
                    </a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descricao</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @if(count($dados) > 0)
                                @foreach($dados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->descricao }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="{{ url(route('categoriasEditar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-default"
                                                   href="{{ url(route('deletarCategoria', ['id' => $data->id])) }}">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum Categoria cadastrada no momento.</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
            </div>
        </div>
    </div><!-- row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Categorias do KPL</h4>
                    <p>Aqui você confere a lista de categorias importadas do KPL no momento</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descricao</th>
                                </tr>
                            </thead>
                            @if(count($dadosImportados) > 0)
                                @foreach($dadosImportados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->descricao }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum Categoria cadastrada no momento.</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
            </div>
        </div>
    </div><!-- row -->
@endsection

