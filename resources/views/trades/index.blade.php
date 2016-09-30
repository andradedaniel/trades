@extends('layouts.app')

@section('htmlheader_title')
    WINQ16
@endsection
@section('contentheader_title')
    Histórico de Trades
@endsection


@section('main-content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('trades.create')
    @include('trades.close_trade')

    {{--<button id="adicionarTrade" name="adicionarTrade" class="btn btn-primary" data-toggle="modal" data-target="#addTradeFormModal"><i class='fa fa-plus'></i><span>&nbsp;&nbsp;Adicionar Trade</span></button>--}}
    <div class="container spark-screen">
        <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-10">
    @if(!$trades->isEmpty())
                <div class="col-sm-2"><strong>Data</strong></div>
                <div class="col-sm-1">Tipo</div>
                <div class="col-sm-2 text-right">PM Entrada</div>
                {{--<div class="col-sm-1 text-center"></div>--}}
                {{--<div class="col-sm-1">Saida</div>--}}
                <div class="col-sm-1">Volume</div>
                <div class="col-sm-2">Resultado</div>
                <div class="col-sm-2 text-center">Lucro/Prejuizo</div>
                <div class="col-sm-2 text-right"></div>
            </div>

        </div>


        <div class="row">
            {{--<div class="col-md-10 col-md-offset-1">--}}
            <div class="col-md-10">
                <div class="panel-group" id="accordion">
                    <?php  $countCollapse = 1; ?>
                    @foreach($trades as $trade)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h4 class="panel-title">
                                        {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$countCollapse}}"><strong>{{ $trade->data->format('d/m/Y') }}</strong></a>--}}
                                        <a data-toggle="collapse" href="#collapse{{$countCollapse}}"><strong>{{ $trade->data->format('d/m/Y') }}</strong></a>
                                    </h4>
                                </div>
                                <div class="col-sm-1">
                                    {{--Melhorar para if ternario--}}
                                    @if ($trade->tipo == 'buy')
                                        <h4 class="panel-title" style="color: blue;"><i class='fa fa-arrow-up fa-3' aria-hidden="true"></i></h4>
                                    @else
                                        <h4 class="panel-title" style="color: red;"><i class='fa fa-arrow-down fa-3' aria-hidden="true"></i></h4>
                                    @endif
                                </div>
                                <div class="col-sm-2 text-right"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse{{$countCollapse}}">{{ $trade->preco_medio }}</a></h4></div>
                                {{--<div class="col-sm-1 text-center"><h4 class="panel-title"><i class='fa fa-long-arrow-right fa-3' aria-hidden="true"></i></h4></div>--}}
                                {{--<div class="col-sm-1"><h4 class="panel-title">saida</h4></div>--}}
                                <div class="col-sm-1"><h4 class="panel-title">{{ $trade->volume }}</h4></div>
                                <div class="col-sm-2"><h4 class="panel-title">{{ $trade->resultado }}</h4></div>
                                <div class="col-sm-2 text-center"><h4 class="panel-title">R$ {{ $trade->lucro_prejuizo }}</h4></div>
                                <div class="col-sm-2 text-right"><h4 class="panel-title">
                                        <a href="" title= "Encerrar / Realizar Parcial" id="closeTrade" data-id="{{ $trade->id }}" data-toggle="modal" data-target="#closeTradeFormModal"><i class='fa fa-check fa-3' aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        <a href="" id="addEntradaTrade" name="addEntradaTrade" data-toggle="modal" data-target="#addEntradaTradeFormModal"><i class="fa fa-plus fa-3" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        <a href="{{ url('/trade/apagar/'.$trade->id) }}" id="excluir_trade" title= "Excluir Trade"><i class="fa fa-times fa-3" aria-hidden="true"></i></a></h4>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{$countCollapse}}" class="panel-collapse collapse {{ $trade->trade_aberto ? 'in' : '' }}">
                            <div class="panel-body">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover text-center">
                                        <tbody>
                                        {{--<tr>--}}
                                            {{--<th>#</th>--}}
                                            {{--<th>Data</th>--}}
                                            {{--<th>Tipo</th>--}}
                                            {{--<th>Preço Entrada</th>--}}
                                            {{--<th>Preço Saída</th>--}}
                                            {{--<th>Volume</th>--}}
                                            {{--<th>Resultado</th>--}}
                                            {{--<th>Lucro/Prejuizo</th>--}}
                                        {{--</tr>--}}
                                        <?php  $count = 1; ?>
                                        @foreach($trade->tradeOperacao as $operacao)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{ $operacao->tipo.', '.$operacao->in_or_out }}</td>

                                                <td>{{ $operacao->preco }}</td>
{{--                                                @if($key < $trade->getQtdTotalSaidas())--}}
                                                <td>{{ $operacao->volume }}</td>

                                                <td>{{ $operacao->resultado }}</td>
                                                    <td><span class="label {{$operacao->lucro_prejuizo > 0 ? 'label-success' : 'label-danger'}}">{{ number_format($operacao->lucro_prejuizo, 2, ',', '.') }}</span></td>
                                                {{--@else--}}
                                                    {{--<td>0</td>--}}
                                                    {{--<td>{{ $entrada->volume }}</td>--}}
                                                    {{--<td>0</td>--}}
                                                    {{--<td><span class="label label-default">R$ 0,00</span></td>--}}
                                                {{--@endif--}}
                                                {{--<td><a href="{{ url('/trade/apagar/'.$trade->id) }}"><i class='fa fa-times fa-3' aria-hidden="true"></i></a></td>--}}
                                            </tr>
                                            <?php $count++ ?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{--<div class="col-md-12 text-center">--}}
                                        {{--{{ $trades->links() }}--}}
                                    {{--</div>--}}
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <?php $countCollapse++ ?>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    @else
        <h3>Não tem trades cadastrado!</h3>
    @endif
    <script>
        $(document).on("click", "#closeTrade", function () {
            var tradeId = $(this).data('id');
            $(".modal-body #tradeId").val( tradeId );
        });
    </script>
@endsection
