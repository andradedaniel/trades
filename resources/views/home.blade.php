@extends('layouts.app')

@section('htmlheader_title')
	Dashboard
@endsection
@section('contentheader_title')
	Dashboard
@endsection


@section('main-content')
	Periodo de analise: xx/xxxx a xx/xxxx
	<div id="container"></div>
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

	<script>

		$(function () {
			var totalTradesPositivos = <?php echo $totalTradesPositivos; ?>;
			var totalTradesNegativos = <?php echo $totalTradesNegativos; ?>;

			$('#container').highcharts({
				chart: {
					plotBackgroundColor: 'rgba(255,255,255,0.002)'	,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Trades Positivos x Negativos'
				},
				tooltip: {
					pointFormat: '<b>{point.percentage:.1f}%</b><br>Qtd: {point.y} <br>Total: {point.total}'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
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
	</script>

@endsection
