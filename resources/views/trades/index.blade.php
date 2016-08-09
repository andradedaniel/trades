@extends('layouts.app')

@section('htmlheader_title')
    WINQ16
@endsection
@section('contentheader_title')
    Histórico de Trades
@endsection


@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class='fa fa-plus'></i><span> Adicionar Trade</span></button>
                <br><br>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Trades</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
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
                                        <td>{{ $trade->data }}</td>
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
                </div><!-- /.box -->
            </div>
        </div>
    </div>
@endsection
