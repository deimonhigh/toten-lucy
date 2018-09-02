@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Usuários</h4>
                    <p>Aqui você confere a lista de usuários cadastrados no momento</p>
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
                                                   title="Detalhes do Usuários"
                                                   href="{{ url(route('usuariosDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Editar Usuários"
                                                   href="{{ url(route('usuariosEditar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-default"
                                                   title="Excluir Usuários"
                                                   href="{{ url(route('usuariosDeletar', ['id' => $data->id])) }}">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum usuário cadastrado no momento.</td>
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

