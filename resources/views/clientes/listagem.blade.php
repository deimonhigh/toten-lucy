@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Clientes</h4>
                    <p>Aqui você confere a lista de clientes cadastrados no momento</p>
                </div>

                <div class="panel-body">
                    <form method="get">
                        <div class="form-group">
                            <input type="text"
                                   name="pesquisa"
                                   placeholder="Pesquisar por Documento, Nome"
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
                                    <th>Nome</th>
                                    <th>Documento (CPF/CNPJ)</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            @if(count($dados) > 0)
                                @foreach($dados as $data)
                                    <tbody>
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->nome }}</td>
                                            <td>{{ $data->documento }}</td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="{{ url(route('clientesDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum cliente cadastrado no momento.</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                  <?php echo $dados->appends(['pesquisa' => (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '')])->render(); ?>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

