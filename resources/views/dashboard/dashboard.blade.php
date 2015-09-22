@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>Hi, <?php echo $user->name;?></h1>
	<hr>
	<div class="panel panel-primary">
	    <div class="panel-heading">
	        <h3 class="panel-title"><h2>公告</h2></h3>
	    </div>
	    <div class="panel-body">
	        <ul>
				<?php
					$announcement = DB::table("announcement")->where("show", true)->get();
					$announcement = array_reverse($announcement);
					foreach ($announcement as $key => $value) {
						echo "<li>".$value->content."<span style='float: right'>".$value->recordUserName."</span></li>";
					}
				?>
			</ul>
	    </div>
	</div>
	<div class="panel panel-material-indigo-500">
	    <div class="panel-heading">
	        <h3 class="panel-title"><h2>代辦事項</h2></h3>
	    </div>
	    <div class="panel-body">
	        <ul>
				<?php
					$list = DB::table("todo_list")->where("done", false)->get();
					$list = array_reverse($list);
					foreach ($list as $key => $value) {
						echo "<li><a href='/dashboard/todo/".$value->id."'>".$value->name."</a></li>";
					}
				?>
			</ul>
	    </div>
	</div>
	<div class="panel panel-material-light-blue-700">
		<div class="panel-heading">
			<h3>目前天氣</h3>
		</div>
		<div class="panel-body" id="weather">
			
		</div>
		<div class="panel-footer">有溫度超爽der</div>
	</div>
	<script>
		$.getJSON("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20woeid%20%3D%202298866)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys", function(data) {
			console.log(data);
			var temp = (data.query.results.channel.item.condition.temp - 32) * 5 /9;
			$("#weather").append("溫度：" + temp);
		});
	</script>
@stop