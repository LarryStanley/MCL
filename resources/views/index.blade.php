@extends("layout")

@section("head")
	<link rel="stylesheet" href="/css/main.css">
@stop

@section("content")

<div id="titleBox">
	<div class="center">
		<h1>國立中央大學數學系 <br>計算實驗室</h1>
		<hr>
		<h1>Mathematics Computation Laboratory</h1>
	</div>
</div>
<div id="infoBox">
	<div class="container">
		<h2>公告</h2>
		<hr color="black">
		104上學期工讀生招募中！！<br>
		<a href="http://goo.gl/Q4UJyf" target="blank">立即報名</a>
	</div>
</div>
<div id="functionBox">
	<div class="container">
		<div class="col-md-3 col-sm-6 col-xs-6 text-center">
			<a href="/info" class="btn btn-default">
				<i class="fa fa-info fa-4x"></i><br>
				簡介
			</a>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6 text-center">
			<a href="/fresh" class="btn btn-default">
				<i class="fa fa-check-square-o fa-4x"></i><br>
				大一值班
			</a>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6 text-center">
			<a href="/classroom" class="btn btn-default">
				<i class="fa fa-calendar fa-4x"></i><br>
				教室使用表
			</a>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6 text-center">
			<a href="/rule" class="btn btn-default">
				<i class="fa fa-user fa-4x"></i><br>
				使用守則
			</a>
		</div>
	</div>
</div>
@stop