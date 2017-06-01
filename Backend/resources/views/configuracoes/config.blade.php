@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url('admin/configuracao/cadastrar') }}"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="id"
                           value="@if(isset($dados->id)) {{$dados->id}} @elseif(old('id')) {{old('id')}} @endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">Configurações</h4>
                        <p>Cadastre as alterações para a aplicação.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nome da empresa</label>
                                    <input type="text"
                                           name="empresa"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->empresa)) {{$dados->empresa}} @elseif(old('empresa')) {{old('empresa')}} @endif" />
                                    @if ($errors->has('empresa'))
                                        <label class="error">{{ $errors->first('empresa') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Cor de identificação</label>
                                    <input type="text"
                                           name="cor"
                                           style="background-color: {{ $dados->cor }}; color: #fff;"
                                           class="form-control"
                                           id="colorpicker"
                                           required
                                           value="@if(isset($dados->cor)) {{$dados->cor}} @elseif(old('cor')) {{old('cor')}} @endif"
                                    />
                                    @if ($errors->has('cor'))
                                        <label class="error">{{ $errors->first('cor') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="position: relative;">
                                    <label class="control-label" style="display: block;">Banner de promoção</label>

                                    @if ($dados->banner)
                                        <button type="submit" style="position: absolute;top: 30px;right: 0;" class="btn btn-default">
                                            <i class="fa fa-close"></i> Remover
                                        </button>
                                        <div class="col-sm-6"
                                             style="float: none; margin: 20px auto;">
                                            <img src="{{ url('storage/' . $dados->banner) }}"
                                                 alt="{{ $dados->empresa }}"
                                                 class="img-responsive">
                                        </div>
                                    @endif

                                    <input type="file"
                                           name="banner"
                                           class="form-control"
                                    />
                                    @if ($errors->has('banner'))
                                        <label class="error">{{ $errors->first('banner') }}</label>
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

