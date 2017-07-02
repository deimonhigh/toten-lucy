@extends('template')

@section('content')

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul style="list-style: none; padding: 0;">
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Vendedores</h4>
                    <p>Aqui você confere a lista de vendedores cadastrados no momento</p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do vendedor</th>
                                    <th>Códido de identificação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @if(count($dados) > 0)
                                @foreach($dados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->nome }}</td>
                                            <td>{{ $data->identificacao }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes do Vendedor"
                                                   href="{{ url(route('vendedoresDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Editar Vendedor"
                                                   href="{{ url(route('vendedoresEditar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Excluir Vendedor"
                                                   href="{{ url(route('vendedoresDeletar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum vendedor cadastrado no momento.</td>
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

