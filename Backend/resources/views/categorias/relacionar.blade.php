@extends('template')

@section('content')

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul style="list-style: none; padding: 0;">
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form action="{{ url(route('categoriasRelacaoCadastrar')) }}"
                      method="post"
                      class="validate"
                >
                    {{ csrf_field() }}
                    <div class="panel-heading">
                        <h4 class="panel-title">Relacionamento de categorias</h4>
                        <p>Aqui você altera as informações das categorias.</p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria cadastrada</label>
                                    <select name="admincategoria_id" class="form-control">
                                        <option value="" selected>Selecione uma categoria</option>
                                        @foreach($Admincategoria as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->descricao }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('Admincategoria'))
                                        <label class="error">Selecione uma categoria cadastrada</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoria importada</label>
                                    <select name="categoria_id" class="form-control">
                                        <option value="" selected>Selecione uma categoria</option>
                                        @foreach($categoriasImportadas as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->id .  ' - ' . $admin->descricao }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('categoriasImportadas'))
                                        <label class="error">Selecione uma categoria importada</label>
                                    @endif
                                </div>
                            </div><!-- col-sm-6 -->
                        </div>

                        <div class="table-responsive">
                            <table class="table mb30">
                                <thead>
                                    <tr>
                                        <th>Categoria cadastrada</th>
                                        <th>Categoria importada</th>
                                    </tr>
                                </thead>
                                @if($dados)
                                    <tbody>
                                        @foreach($Admincategoria as $keyParent => $valParent)
                                            @foreach($valParent->categorias as $key => $val)
                                                <tr @if($keyParent % 2 == 0) class="active" @endif>
                                                    @if($key == 0)
                                                        <td rowspan="{{ count($valParent->categorias) }}">{{ $valParent->descricao }}</td>
                                                    @endif
                                                    <td>
                                                        {{ $val->descricao }}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-default"
                                                           title="Remover relacionamento"
                                                           href="{{ url(route('relacionarDeletar', ['idCatAdmin' => $val->pivot->admincategoria_id, 'idCat' => $val->pivot->categoria_id])) }}">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="4">Nenhum relacionamento cadastrada no momento.</td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div><!-- table-responsive -->

                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- row -->
@endsection

