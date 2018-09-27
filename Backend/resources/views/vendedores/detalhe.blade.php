@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Vendedor</h4>
                    <p>Aqui você visualiza as informações do vendedor cadastrado.</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Nome</h5>
                            <p><strong>{{ $dados->nome }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>Códido de identificação</h5>
                            <p><strong>{{ $dados->identificacao }}</strong></p>
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-default" onclick="window.history.back(-1);">Voltar</button>
                </div>
            </div>
        </div>

    </div><!-- row -->
@endsection

