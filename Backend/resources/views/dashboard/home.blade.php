@extends('template')

@section('content')
    <div class="row">

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-dark panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="{{ url('adminpanel/images/is-money.png') }}"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos</small>
                                <h1>{{ $qntPedidos }}</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4>{{ 'R$' . number_format($somaTotalPedidos, 2, ',', '.') }}</h4>
                            </div>

                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos enviados ao KPL</small>
                                <h4>{{ 'R$' . number_format($somaTotalPedidosEnviados, 2, ',', '.') }}</h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-success panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="{{ url('adminpanel/images/is-money.png') }}"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos mês atual</small>
                                <h1>{{ $qntPedidosEsteMes }}</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4>{{ 'R$' . number_format($somaPedidosEsteMes, 2, ',', '.') }}</h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-danger panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="{{ url('adminpanel/images/is-money.png') }}"
                                     alt="" />
                            </div>
                            <div class="col-xs-8">
                                <small class="stat-label">Quantidade de pedidos do mês passado</small>
                                <h1>{{ $qntPedidosMesPassado }}</h1>
                            </div>
                        </div><!-- row -->

                        <div class="mb15"></div>

                        <div class="row">
                            <div class="col-xs-6">
                                <small class="stat-label">Total de pedidos</small>
                                <h4>{{ 'R$' . number_format($somaPedidosMesPassado, 2, ',', '.') }}</h4>
                            </div>
                        </div><!-- row -->

                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div><!-- row -->

    <div class="row">

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-primary panel-stat">
                <div class="panel-heading">

                    <div class="stat" style="max-width: 100%">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-xs-12">
                                <small class="stat-label">Atualização de Produtos</small>
                                <h4>@if(!$datas || is_null($datas->produtos))"Não
                                                                           atualizado" @else {{ $datas->produtos }} @endif</h4>
                            </div>
                        </div><!-- row -->
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <small class="stat-label">Atualização de Pedidos</small>
                                <h4>@if(!$datas || is_null($datas->pedidos))"Não
                                                                             atualizado" @else {{ $datas->pedidos }} @endif</h4>
                            </div>
                        </div><!-- row -->
                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>

@endsection