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
			<div ng-repeat="(index,people) in freshData">
				<h1><?php echo "{{ people.name }}";?></h1>
				<p><?php echo "{{ people.work }}";?></p>
				<p><?php echo "{{ people.message}}";?></p>
				<button class="btn signUpButton-<?php echo '{{index}}';?>" style="color: #F44336" ng-click="fresh.signUp(people.id, index)">簽到</button>
			</div>
			<hr color="#F44336">
			<h2><?php echo "{{ toAllMessage }}";?></h2>
			<hr color="#0D47A1">
			<!--<p>翹班次數：0 次</p>
			<p>遲到次數：0 次</p>
			<p>詳細狀況可<a href="/fresh/" target="blank">至此</a>查詢</p> 
			<p>若上述有誤，請趕快向值班工讀生提出</p> !-->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
		</div>
	</div>
</div>

@stop