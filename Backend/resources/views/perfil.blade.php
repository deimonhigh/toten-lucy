@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url('adminpanel/perfil/cadastrar') }}" method="post" class="validate">
                    {{ csrf_field() }}
                    <div class="panel-heading">
                        <h4 class="panel-title">Meu perfil</h4>
                        <p>Aqui você altera as suas informações.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome da empresa</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->name)) {{$dados->name}} @elseif(old('name')) {{old('name')}} @endif" />
                                    @if ($errors->has('name'))
                                        <label class="error">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Cor de identificação</label>
                                    <input type="text"
                                           name="email"
                                           class="form-control"
                                           id="colorpicker"
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
                                    <label class="control-label">Alterar Senha</label>
                                    <input type="password"
                                           name="senha"
                                           class="form-control"
                                    />
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

