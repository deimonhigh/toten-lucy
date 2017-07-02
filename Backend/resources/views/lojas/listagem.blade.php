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
                    <h4 class="panel-title">Lojas</h4>
                    <p>Aqui você confere a lista de lojas cadastradas no momento</p>

                    @if(\App\Gate::hasAccess('admin/lojas/frete'))
                        <a class="btn btn-default"
                           style="margin-top: 20px;"
                           href="{{ url(route('frete')) }}">
                            Importar Lista de Fretes
                        </a>
                    @endif

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb30">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome do Usuário</th>
                                    <th>E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @if(count($dados) > 0)
                                @foreach($dados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   title="Detalhes do Loja"
                                                   href="{{ url(route('lojasDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Editar Loja"
                                                   href="{{ url(route('lojasEditar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Excluir Loja"
                                                   href="{{ url(route('lojasDeletar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhuma loja cadastrada no momento.</td>
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

