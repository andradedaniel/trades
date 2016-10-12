@extends('layouts.app')

@section('htmlheader_title')
	Dashboard
@endsection
@section('contentheader_title')
	Dashboard
@endsection


@section('main-content')
	Periodo de analise: xx/xxxx a xx/xxxx
	{{--<div id="container"></div>--}}



	<div class="row">
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title text-danger">Trades Positivos x Negativos</h3>
					{{--<div class="box-tools pull-right">--}}
						{{--<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>--}}
					{{--</div>--}}
				</div>
				<!-- /.box-header -->
				<div class="box-body text-center">
					<div id="tradesPos_x_Neg" class="sparkline" data-type="pie" data-offset="90" data-width="100px" data-height="100px"></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->

		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title text-blue">Grafico 2</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body text-center">
					<div class="sparkline" data-type="line" data-spot-radius="3" data-highlight-spot-color="#f39c12" data-highlight-line-color="#222" data-min-spot-color="#f56954" data-max-spot-color="#00a65a" data-spot-color="#39CCCC" data-offset="90" data-width="100%" data-height="100px" data-line-width="2" data-line-color="#39CCCC" data-fill-color="rgba(57, 204, 204, 0.08)"><canvas width="326" height="100" style="display: inline-block; width: 326px; height: 100px; vertical-align: top;"></canvas></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->

		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title text-warning">Grafico 3</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body text-center">
					<div class="sparkline" data-type="bar" data-width="97%" data-height="100px" data-bar-width="14" data-bar-spacing="7" data-bar-color="#f39c12"><canvas width="224" height="100" style="display: inline-block; width: 224px; height: 100px; vertical-align: top;"></canvas></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>

	<div class="row">
		<div class="col-md-12">
{{--			{{dd($lucro_ano)}}--}}
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title text-danger">Lucro e Prejuizos Liquido em 2016</h3>
					{{--<div class="box-tools pull-right">--}}
					{{--<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>--}}
					{{--</div>--}}
				</div>
				<!-- /.box-header -->
				<div class="box-body text-center">
					<div id="lucro_ano" class="sparkline" data-type="pie" data-offset="90" data-width="100px" data-height="100px"></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>

{{--

	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-5 col-md-offset-1">
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Trades Positivos no Mês</span>
						<span class="info-box-number">32</span>

						<div class="progress">
							<div class="progress-bar" style="width: 20%"></div>
						</div>
                  <span class="progress-description">
                    20% Increase in 30 Days
                  </span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</div>
			<div class="col-md-5">
				<div class="info-box bg-red">
					<span class="info-box-icon"><i class="fa fa-thumbs-o-down"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Trades Negativos no Mês</span>
						<span class="info-box-number">21</span>

						<div class="progress">
							<div class="progress-bar" style="width: 20%"></div>
						</div>
                  <span class="progress-description">
                    20% Increase in 30 Days
                  </span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</div>


			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>
					<div class="panel-body">
						{{ trans('message.logged') }}
					</div>
				</div>
			</div>
		</div>
	</div>
--}}
	<script>

		$(function () {
			var totalTradesPositivos = <?php echo $totalTradesPositivos; ?>;
			var totalTradesNegativos = <?php echo $totalTradesNegativos; ?>;

			$('#tradesPos_x_Neg').highcharts({
				chart: {
					plotBackgroundColor: 'rgba(255,255,255,0.002)'	,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: null
				},
				tooltip: {
					pointFormat: '<b>{point.percentage:.1f}%</b><br>Qtd: {point.y} <br>Total: {point.total}'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false,
							format: '<b>{point.name}</b>: {point.percentage:.1f}%',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					colorByPoint: true,
//					colors: ['blue', 'red'],
					colors: ['#91e8e1','#f45b5b'],
					data: [{
						name: 'Positivos',
						y: totalTradesPositivos,
//						selected: true

					}, {
						name: 'Negativos',
						y: totalTradesNegativos,
//						sliced: true,
						selected: true

					}]
				}]
			});
		});




		$(function () {
			var lucro_ano = <?php echo $lucro_ano; ?>;
//			alert(JSON.stringify(lucro_ano));
			$('#lucro_ano').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: null
				},
				xAxis: {
					categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Lucro: R$',
					data: lucro_ano
				}
					]
			});

		});




	</script>

@endsection
