@extends('layouts.app')

@section('htmlheader_title')
	Dashboard
@endsection
@section('contentheader_title')
	Dashboard
@endsection


@section('main-content')

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
			$('#container').highcharts({
				chart: {
					plotBackgroundColor: 'rgba(255,255,255,0.002)'	,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Browser market shares January, 2015 to May, 2015'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					name: 'Brands',
					colorByPoint: true,
					data: [{
						name: 'Microsoft Internet Explorer',
						y: 56.33
					}, {
						name: 'Chrome',
						y: 24.03,
						sliced: true,
						selected: true
					}, {
						name: 'Firefox',
						y: 10.38
					}, {
						name: 'Safari',
						y: 4.77
					}, {
						name: 'Opera',
						y: 0.91
					}, {
						name: 'Proprietary or Undetectable',
						y: 0.2
					}]
				}]
			});
		});
	</script>

@endsection
