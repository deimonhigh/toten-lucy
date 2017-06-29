@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Loja</h4>
                    <p>Aqui você visualiza as informações da loja cadastrada.</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Nome</h5>
                            <p><strong>{{ $dados->name }}</strong></p>
                        </div>
                        <div class="col-sm-6">
                            <h5>E-mail</h5>
                            <p><strong>{{ $dados->email }}</strong></p>
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

