@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url('admin/configuracao/cadastrar') }}" method="post" class="validate">
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
                                <div class="form-group">
                                    <label class="control-label">Numero máximo de parcelas</label>
                                    <input type="number"
                                           name="maxParcelas"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->maxParcelas)){{$dados->maxParcelas}}@elseif(old('maxParcelas')){{old('maxParcelas')}}@endif" />
                                    @if ($errors->has('maxParcelas'))
                                        <label class="error">{{ $errors->first('maxParcelas') }}</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Numero máximo de parcelas sem juros</label>
                                    <input type="number"
                                           name="maxParcelasSemJuros"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->maxParcelasSemJuros)){{$dados->maxParcelasSemJuros}}@elseif(old('maxParcelasSemJuros')){{old('maxParcelasSemJuros')}}@endif" />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">% de juros simples sobre o total a ser
                                                                 parcelado</label>
                                    <input type="number"
                                           name="juros"
                                           class="form-control"
                                           required
                                           value="@if(isset($dados->juros)){{$dados->juros}}@elseif(old('juros')){{old('juros')}}@endif" />
                                    @if ($errors->has('juros'))
                                        <label class="error">{{ $errors->first('juros') }}</label>
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
