@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('cadastrarBanner')) }}"
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
                                <div class="form-group" style="position: relative;">
                                    <label class="control-label" style="display: block;">Banner de promoção</label>
                                    @if (isset($dados->banner))
                                        <div class="col-sm-6"
                                             style="float: none; margin: 20px auto;">
                                            <img src="{{ asset('storage/' . $dados->banner) }}"
                                                 alt="Banner promocional"
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Produto do banner</label>
                                    <select name="produto" class="select2" data-placeholder="Escolha um produto">
                                        <option value="" @if(is_null($dados->produto_id)) selected @endif>Selecione
                                        </option>
                                        @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}"
                                                    @if($dados->produto_id == $produto->id) selected @endif >{{ $produto->nomeproduto }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('produto'))
                                        <label class="error">{{ $errors->first('produto') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div><!-- row -->

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" name="action" value="save" class="btn btn-primary">Salvar</button>
                        @if (isset($dados->banner))
                            <button type="submit" class="btn btn-default" name="action" value="remove">
                                Remover
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
@endsection

