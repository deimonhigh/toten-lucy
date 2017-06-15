@extends('template')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('cadastrarParcelas')) }}"
                      method="post"
                      class="validate"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden"
                           name="id"
                           value="@if(isset($dados->id)) {{$dados->id}} @elseif(old('id')) {{old('id')}} @endif">
                    <div class="panel-heading">
                        <h4 class="panel-title">Parcelas</h4>
                        <p>Cadastre os juros referentes a quantidade de parcelas a serem aplicadas nos preços da
                           aplicação.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">À vista (em %) </label>
                                    <input type="text"
                                           name="parcela0"
                                           class="form-control"
                                           value="@if(isset($dados->parcela0)) {{$dados->parcela0}} @elseif(old('parcela0')) {{old('parcela0')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 1 (em %) </label>
                                    <input type="text"
                                           name="parcela1"
                                           class="form-control"
                                           value="@if(isset($dados->parcela1)) {{$dados->parcela1}} @elseif(old('parcela1')) {{old('parcela1')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 2 (em %) </label>
                                    <input type="text"
                                           name="parcela2"
                                           class="form-control"
                                           value="@if(isset($dados->parcela2)) {{$dados->parcela2}} @elseif(old('parcela2')) {{old('parcela2')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 3 (em %) </label>
                                    <input type="text"
                                           name="parcela3"
                                           class="form-control"
                                           value="@if(isset($dados->parcela3)) {{$dados->parcela3}} @elseif(old('parcela3')) {{old('parcela3')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 4 (em %) </label>
                                    <input type="text"
                                           name="parcela4"
                                           class="form-control"
                                           value="@if(isset($dados->parcela4)) {{$dados->parcela4}} @elseif(old('parcela4')) {{old('parcela4')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 5 (em %) </label>
                                    <input type="text"
                                           name="parcela5"
                                           class="form-control"
                                           value="@if(isset($dados->parcela5)) {{$dados->parcela5}} @elseif(old('parcela5')) {{old('parcela5')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 6 (em %) </label>
                                    <input type="text"
                                           name="parcela6"
                                           class="form-control"
                                           value="@if(isset($dados->parcela6)) {{$dados->parcela6}} @elseif(old('parcela6')) {{old('parcela6')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 7 (em %) </label>
                                    <input type="text"
                                           name="parcela7"
                                           class="form-control"
                                           value="@if(isset($dados->parcela7)) {{$dados->parcela7}} @elseif(old('parcela7')) {{old('parcela7')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 8 (em %) </label>
                                    <input type="text"
                                           name="parcela8"
                                           class="form-control"
                                           value="@if(isset($dados->parcela8)) {{$dados->parcela8}} @elseif(old('parcela8')) {{old('parcela8')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 9 (em %) </label>
                                    <input type="text"
                                           name="parcela9"
                                           class="form-control"
                                           value="@if(isset($dados->parcela9)) {{$dados->parcela9}} @elseif(old('parcela9')) {{old('parcela9')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 10 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela10"
                                           class="form-control"
                                           value="@if(isset($dados->parcela10)) {{$dados->parcela10}} @elseif(old('parcela10')) {{old('parcela10')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 11 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela11"
                                           class="form-control"
                                           value="@if(isset($dados->parcela11)) {{$dados->parcela11}} @elseif(old('parcela11')) {{old('parcela11')}} @endif"
                                    />
                                </div>
                            </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Juros da parcela 12 (em
                                                                                      %) </label>
                                    <input type="text"
                                           name="parcela12"
                                           class="form-control"
                                           value="@if(isset($dados->parcela12)) {{$dados->parcela12}} @elseif(old('parcela12')) {{old('parcela12')}} @endif"
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

