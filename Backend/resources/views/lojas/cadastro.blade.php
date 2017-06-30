@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('lojasCadastrar')) }}" method="post" class="validate">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="id"
                           value="@if(isset($dados->id)) {{$dados->id}} @endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de Lojas</h4>
                        <p>Aqui você altera as informações dos Lojas.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->name)) {{$dados->name}} @elseif(old('name')) {{old('name')}} @endif" />
                                    @if ($errors->has('name'))
                                        <label class="error">Campo Nome é obrigatório.</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">E-mail</label>
                                    <input type="text"
                                           name="email"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->email)) {{$dados->email}} @elseif(old('email')) {{old('email')}} @endif"
                                    />
                                    @if ($errors->has('email'))
                                        <label class="error">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Lista de Preços</label>
                                    <select name="listaPreco" class="form-control">
                                        <option value="1" @if($dados->listaPreco == 1) selected @endif>Lista de Precos 1
                                                                                                       (TABELA_LOJA)
                                        </option>
                                        <option value="2" @if($dados->listaPreco == 2) selected @endif>Lista de Precos 2
                                                                                                       (TABELA DE
                                                                                                       PRECOS)
                                        </option>
                                    </select>
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Senha</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                    />
                                    @if ($errors->has('password'))
                                        <label class="error">Campo senha é obrigatório.</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Confirmar a Senha</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                    />
                                    @if ($errors->has('password_confirmation'))
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

