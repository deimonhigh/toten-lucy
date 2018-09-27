@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('vendedoresCadastrar')) }}" method="post" class="validate">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="id"
                           value="@if(isset($dados->id)) {{$dados->id}} @endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de vendedor</h4>
                        <p>Aqui você altera as informações dos vendedores.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome do vendedor</label>
                                    <input type="text"
                                           name="nome"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->nome)) {{$dados->nome}} @elseif(old('nome')) {{old('nome')}} @endif" />
                                    @if ($errors->has('nome'))
                                        <label class="error">{{ $errors->first('nome') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Códido de identificação</label>
                                    <input type="text"
                                           name="identificacao"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->identificacao)) {{$dados->identificacao}} @elseif(old('identificacao')) {{old('identificacao')}} @endif"
                                    />
                                    @if ($errors->has('identificacao'))
                                        <label class="error">{{ $errors->first('identificacao') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Senha</label>
                                    <input type="password"
                                           name="senha"
                                           class="form-control"
                                    />
                                    @if ($errors->has('senha'))
                                        <label class="error">{{ $errors->first('senha') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Confirmar a senha</label>
                                    <input type="password"
                                           name="senha_confirmation"
                                           class="form-control"
                                    />
                                    @if ($errors->has('senha_confirmation'))
                                        <label class="error">Campos de senha não conferem.</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
@endsection

