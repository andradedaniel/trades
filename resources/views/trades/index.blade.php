@extends('layouts.app')

@section('htmlheader_title')
    WINQ16
@endsection
@section('contentheader_title')
    Histórico de Trades
@endsection


@section('main-content')

    @include('trades.create')

    <div class="container spark-screen">
        <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-sm-2"><strong>Data</strong></div>
                <div class="col-sm-1">Tipo</div>
                <div class="col-sm-1 text-right">Entrada</div>
                <div class="col-sm-1 text-center"></div>
                <div class="col-sm-1">Saida</div>
                <div class="col-sm-1">Volume</div>
                <div class="col-sm-1">Resultado</div>
                <div class="col-sm-3 text-center">Lucro/Prejuizo</div>
                <div class="col-sm-1 text-right"></div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><strong>10/08/2016</strong></a>
                                    </h4>
                                </div>
                                <div class="col-sm-1">
                                    <h4 class="panel-title" style="color: blue;"><i class='fa fa-arrow-up fa-3' aria-hidden="true"></i></h4>
                                </div>
                                <div class="col-sm-1 text-right"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">50000</a></h4></div>
                                <div class="col-sm-1 text-center"><h4 class="panel-title"><i class='fa fa-long-arrow-right fa-3' aria-hidden="true"></i></h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">53000</h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">10</h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">3000</h4></div>
                                <div class="col-sm-3 text-center"><h4 class="panel-title">R$ 3234,00</h4></div>
                                <div class="col-sm-1 text-right"><h4 class="panel-title">
                                        <i class='fa fa-check fa-3' aria-hidden="true"></i>&nbsp;&nbsp;
                                        <i class='fa fa-plus fa-3' aria-hidden="true"></i></h4>
                                </div>
                            </div>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover text-center">
                                        <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Data</th>
                                            <th>Tipo</th>
                                            <th>Preço Entrada</th>
                                            <th>Preço Saída</th>
                                            <th>Volume</th>
                                            <th>Resultado</th>
                                            <th>Lucro/Prejuizo</th>
                                        </tr>
                                        <?php  $count = 1; ?>
                                        @foreach($trades as $trade)
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $trade->data->format('d/m/Y') }}</td>
                                                <td>{{ $trade->tipo }}</td>
                                                <td>{{ $trade->preco_entrada }}</td>
                                                <td>{{ $trade->preco_saida }}</td>
                                                <td>{{ $trade->volume }}</td>
                                                <td>{{ $trade->resultado }}</td>
                                                <td><span class="label label-success">{{ $trade->lucro_prejuizo }}</span></td>
                                                <td><a href="{{ url('/trade/close') }}"><i class='fa fa-check fa-3' aria-hidden="true"></i></a>&nbsp;&nbsp;
                                                    <a href="{{ url('/trade/edit') }}"><i class='fa fa-pencil fa-3' aria-hidden="true"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-md-12 text-center">
                                        {{ $trades->links() }}
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">10/08/2016</a>
                                    </h4>
                                </div>
                                <div class="col-sm-1">
                                    <h4 class="panel-title" style="color: red;"><i class='fa fa-arrow-down fa-3' aria-hidden="true"></i></h4>
                                </div>
                                <div class="col-sm-1 text-right"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">50470</a></h4></div>
                                <div class="col-sm-1 text-center"><h4 class="panel-title"><i class='fa fa-long-arrow-right fa-3' aria-hidden="true"></i></h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">50340</h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">10</h4></div>
                                <div class="col-sm-1"><h4 class="panel-title">155</h4></div>
                                <div class="col-sm-3 text-center"><h4 class="panel-title">R$ 233,00</h4></div>
                                <div class="col-sm-1 text-right"><h4 class="panel-title">
                                        <i class='fa fa-check fa-3' aria-hidden="true"></i>&nbsp;&nbsp;
                                        <i class='fa fa-plus fa-3' aria-hidden="true"></i></h4>
                                </div>
                            </div>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo consequat.</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                    Collapsible Group 3</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo consequat.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>


        {{--<div class="row">--}}
            {{--<div class="col-md-10 col-md-offset-1">--}}
                {{--<button id="adicionarTrade" name="adicionarTrade" class="btn btn-primary" data-toggle="modal" data-target="#addTradeFormModal"><i class='fa fa-plus'></i><span>&nbsp;&nbsp;Adicionar Trade</span></button>--}}
                {{--<br><br>--}}
                {{--<div class="box box-default">--}}
                    {{--<div class="box-header with-border">--}}
                        {{--<h3 class="box-title">Lista de Trades</h3>--}}
                        {{--<div class="box-tools pull-right">--}}
                            {{--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>--}}
                        {{--</div><!-- /.box-tools -->--}}
                    {{--</div><!-- /.box-header -->--}}
                    {{--<div class="box-body table-responsive no-padding">--}}
                        {{--<table class="table table-hover text-center">--}}
                            {{--<tbody>--}}
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
                                {{--<?php  $count = 1; ?>--}}
                                {{--@foreach($trades as $trade)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{ $count++ }}</td>--}}
                                        {{--<td>{{ $trade->data->format('d/m/Y') }}</td>--}}
                                        {{--<td>{{ $trade->tipo }}</td>--}}
                                        {{--<td>{{ $trade->preco_entrada }}</td>--}}
                                        {{--<td>{{ $trade->preco_saida }}</td>--}}
                                        {{--<td>{{ $trade->volume }}</td>--}}
                                        {{--<td>{{ $trade->resultado }}</td>--}}
                                        {{--<td><span class="label label-success">{{ $trade->lucro_prejuizo }}</span></td>--}}
                                        {{--<td><a href="{{ url('/trade/close') }}"><i class='fa fa-check fa-3' aria-hidden="true"></i></a>&nbsp;&nbsp;--}}
                                        {{--<a href="{{ url('/trade/edit') }}"><i class='fa fa-pencil fa-3' aria-hidden="true"></i></a></td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                        {{--<div class="col-md-12 text-center">--}}
                            {{--{{ $trades->links() }}--}}
                        {{--</div>--}}
                    {{--</div><!-- /.box-body -->--}}
                {{--</div><!-- /.box -->--}}
            {{--</div>--}}
        {{--</div>--}}


    </div>
@endsection
