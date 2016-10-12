@extends('layouts.app')

@section('htmlheader_title')
    Mini-Indice
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
    @include('trades.partials.modal_confirm_exluir_trade')
{{--    @include('trades.partials.selecionar_mes_ano')--}}

    {{--<button id="adicionarTrade" name="adicionarTrade" class="btn btn-primary" data-toggle="modal" data-target="#addTradeFormModal"><i class='fa fa-plus'></i><span>&nbsp;&nbsp;Adicionar Trade</span></button>--}}
    {{--<div class="container spark-screen">--}}


    @if(!$trades->isEmpty())
        <div class="row" style="">
            <div class="col-sm-12">
                <strong>
                    <div class="col-sm-1 text-center">Data</div>
                    <div class="col-sm-1 text-center">Tipo</div>
                    <div class="col-sm-2 text-center">Preço Médio</div>
                    <div class="col-sm-1 text-center">Volume</div>
                    <div class="col-sm-1 text-center">Resultado</div>
                    <div class="col-sm-2 text-center">L/P Bruto</div>
                    <div class="col-sm-2 text-center">L/P Liquido</div>
                    <div class="col-sm-2 text-right"></div>
                </strong>
            </div>

        </div>

        <div class="row">
            {{--<div class="col-md-10 col-md-offset-1">--}}
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    <?php  $countCollapse = 1; ?>
                    @foreach($trades as $trade)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-1 text-center">
                                    <h4 class="panel-title">
                                        {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$countCollapse}}"><strong>{{ $trade->data->format('d/m/Y') }}</strong></a>--}}
                                        <a data-toggle="collapse" href="#collapse{{$countCollapse}}"><strong>{{ $trade->data->format('d/m/Y') }}</strong></a>
                                    </h4>
                                </div>
                                <div class="col-sm-1 text-center">
                                    <h4 class="panel-title" style="color:{{ $trade->tipo == 'buy' ? 'blue' : 'red' }}">{{ $trade->tipo }}</h4>
                                    {{--Melhorar para if ternario--}}
                                    {{--@if ($trade->tipo == 'buy')--}}
                                        {{--<h4 class="panel-title" style="color: blue;"><i class='fa fa-arrow-up fa-3' aria-hidden="true"></i></h4>--}}
                                    {{--@else--}}
                                        {{--<h4 class="panel-title" style="color: red;"><i class='fa fa-arrow-down fa-3' aria-hidden="true"></i></h4>--}}
                                    {{--@endif--}}
                                </div>
                                <div class="col-sm-2 text-center"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse{{$countCollapse}}">{{ $trade->preco_medio }}</a></h4></div>
                                {{--<div class="col-sm-1 text-center"><h4 class="panel-title"><i class='fa fa-long-arrow-right fa-3' aria-hidden="true"></i></h4></div>--}}
                                {{--<div class="col-sm-1"><h4 class="panel-title">saida</h4></div>--}}
                                <div class="col-sm-1 text-center"><h4 class="panel-title">{{ $trade->volume }}</h4></div>
                                <div class="col-sm-1 text-center"><h4 class="panel-title">{{ $trade->resultado or '--' }}</h4></div>
                                <div class="col-sm-2 text-center"><h4 class="panel-title">R$ {{  number_format($trade->lucro_prejuizo_bruto, 2, ',', '.') }}</h4></div>
                                <div class="col-sm-2 text-center"><h4 class="panel-title">R$ {{ number_format($trade->lucro_prejuizo_liquido, 2, ',', '.')  }}</h4></div>
                                <div class="col-sm-2 text-right">
                                    <h4 class="panel-title">
                                        <a href=""
                                           title= "Encerrar / Realizar Parcial"
                                           id="closeTrade"
                                           data-id="{{ $trade->id }}"
                                           data-volumeaberto="{{ $trade->volume_aberto }}"
                                           data-toggle="modal"
                                           data-target="#closeTradeFormModal">
                                            <i class='fa fa-check fa-3' aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        <a href="" id="addEntradaTrade" name="addEntradaTrade" data-toggle="modal"
                                           data-target="#addEntradaTradeFormModal"
                                           style="pointer-events: none">
                                            <i class="fa fa-plus fa-3" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        <a href="#"
                                           data-href="{{ url('/trade/apagar/'.$trade->id) }}" data-toggle="modal" data-target="#confirm-delete"
                                           id="excluir_trade"
                                           title= "Excluir Trade">
                                            <i class="fa fa-times fa-3" aria-hidden="true"></i>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{$countCollapse}}" class="panel-collapse collapse {{ $trade->trade_aberto ? 'in' : '' }}">
                            <div class="panel-body">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover text-center">
                                        <tbody>
                                        <?php  $count = 1; ?>
                                        @foreach($trade->tradeOrdem as $ordem)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td style="color:{{ $ordem->tipo == 'buy' ? 'blue' : 'red' }}">{{ $ordem->tipo.', '.$ordem->in_or_out }}</td>
                                                <td>{{ $ordem->preco }}</td>
                                                <td>{{ $ordem->volume }}</td>
                                                <td>{{ $ordem->resultado or '--' }}</td>
                                                <td>{{ $ordem->taxas }}</td>
{{--                                                @if($ordem->in_or_out == 'out')--}}
                                                    <td><span class="label {{$ordem->lucro_prejuizo_bruto > 0 ? 'label-success' : 'label-danger'}}">{{ number_format($ordem->lucro_prejuizo_bruto, 2, ',', '.') }}</span></td>
                                                    <td><span class="label {{$ordem->lucro_prejuizo_liquido > 0 ? 'label-success' : 'label-danger'}}">{{ number_format($ordem->lucro_prejuizo_liquido, 2, ',', '.') }}</span></td>
                                                {{--@else--}}
                                                    <td></td>
                                                    <td></td>
                                                {{--@endif--}}
                                            </tr>
                                            <?php $count++ ?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $countCollapse++ ?>
                    @endforeach

                </div>
            </div>
        </div>
    {{--</div>--}}
    @else
        <h3>Não existe trades cadastrados!</h3>
    @endif
    <script>
        $(document).on("click", "#closeTrade", function () {
            var tradeId = $(this).data('id');
            $(".modal-body #tradeId").val( tradeId );
            $(".modal-body #volume").val( $(this).data('volumeaberto') );
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

    </script>
@endsection
