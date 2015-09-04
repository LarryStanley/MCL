@extends("layout")

@section("head")
	<link rel="stylesheet" href="/css/fresh.css">

	<script src="/js/timer.min.js"></script>
	<script src="/js/fresh.js"></script>
@stop

@section("content")

<div class="container" ng-app="freshApp">
	<div class="center" ng-controller="FreshController as fresh">
		<div class="well" style="overflow:auto">
			<h1>孫紅旗</h1>
			<hr color="#F44336">
			<p>值班時間：10:00 ~ 10:50</p>
			<p>打掃內容：大教室擦鍵盤</p>
			<p><?php echo "{{message}}";?></p>
			<hr color="#0D47A1">
			<p>翹班次數：0 次</p>
			<p>遲到次數：0 次</p>
			<p>詳細狀況可<a href="/fresh/" target="blank">至此</a>查詢</p>
			<p>若上述有誤，請趕快向值班工讀生提出</p>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
			<button class="btn pull-right" style="color: #F44336" id="signUpButton" ng-click="fresh.signUp()">簽到</button>
		</div>
	</div>
</div>

@stop