@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('categoriasCadastrar')) }}"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="id"
                           value="@if(isset($dados->id)) {{$dados->id}} @endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">Cadastro de categorias</h4>
                        <p>Aqui você altera as informações das categorias.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria</label>
                                    <input type="text"
                                           name="descricao"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->descricao)) {{$dados->descricao}} @elseif(old('descricao')) {{old('descricao')}} @endif" />
                                    @if ($errors->has('descricao'))
                                        <label class="error">{{ $errors->first('descricao') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Imagem da categoria</label>
                                    @if(isset($dados) && $dados->imagem)
                                        <img src="{{ $dados->imagem }}"
                                             alt="{{ $dados->descricao }}"
                                             style="max-width: 200px; margin: 10px;">
                                    @endif
                                    <input type="file"
                                           name="imagem"
                                           class="form-control"
                                           required
                                    />
                                    @if ($errors->has('imagem'))
                                        <label class="error">{{ $errors->first('imagem') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
@endsection

