@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Pedidos</h4>
                    <p>Aqui você confere a lista de pedidos cadastrados no momento</p>

                    <a class="btn btn-default" style="margin-top: 20px;" href="{{ url(route('naoConcluidos')) }}">
                        Remover não concluídos
                    </a>

                    <a class="btn btn-default" style="margin-top: 20px;" href="{{ url(route('enviarNovamente')) }}">
                        Enviar novamente
                    </a>
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
                                            <td>{{ $data->cliente->nome }}</td>
                                            <td>{{ $data->cliente->documento }}</td>
                                            <td>
                                                @if($data->status)
                                                    Enviado para KPL
                                                @elseif(is_null($data->total) || $data->total == 0)
                                                    Pedido não concluído
                                                @else
                                                    Não enviado
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-default"
                                                   href="{{ url(route('pedidoDetalhe', ['id' => $data->id])) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum pedido cadastrado no momento.</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- panel-body -->
                <div class="panel-footer">
                  <?php echo $dados->render(); ?>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

