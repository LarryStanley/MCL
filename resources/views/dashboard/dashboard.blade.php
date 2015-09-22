@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>Hi, <?php echo $user->name;?></h1>
	<hr>
	<div class="panel panel-primary">
	    <div class="panel-heading">
	        <h2 class="panel-title">公告</h2>
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
	<div class="panel panel-primary">
		<div class="panel-heading">
			值班狀況
		</div>
		<div class="panel-body">
			<div class="row text-center">
				<div class="col-md-4">
					上一班為
				</div>
				<div class="col-md-4">
					這一班為
				</div>
				<div class="col-md-4">
					下一班為
				</div>
			</div>
			<p>這學期班表可於<a href="/dashboard/documents/8">班表</a>查看</p>
		</div>
	</div>
	<div class="panel panel-material-blue-500">
	    <div class="panel-heading">
	        <h2 class="panel-title">上一班日誌</h2>
	    </div>
	    <div class="panel-body">
	        <ul>
				<?php
					echo "<a href='/dashboard/workerDiary/".$diary->id."'><h4>".$diary->name."</h4></a>";
					echo "<p>".$diary->content."</p>";
				?>
			</ul>
	    </div>
	    <div class="panel-footer">
	    	<div class="row">
				<?php 
					echo '<div class="col-md-1"><img src="http://graph.facebook.com/'.$recordUser->facebook_id.'/picture?type=square" class="img-circle" style="margin-top: 5px"></div><div class="col-md-11">'.$diary->recordUserName."<br>於 ".$diary->recordTime." 編輯</div>";
				?>
			</div>
	    </div>
	</div>
	<div class="panel panel-material-indigo-500">
	    <div class="panel-heading">
	        <h2 class="panel-title">被指派待辦事項</h2>
	    </div>
	    <div class="panel-body">
	        <ul>
				<?php
					$assignMission = DB::table("todo_assigners")->where("done", false)->where("user_id", Auth::user()->id)->get();
					$showTodo = array();
					foreach ($assignMission as $key => $value) {
						$todo = DB::table("todo_list")->where("done", false)->where("id", $value->todo_id)->first();
						echo "<li><a href='/dashboard/todo/".$todo->id."'>".$todo->name."</a></li>";
						array_push($showTodo, $todo->id);
					}
				?>	
			</ul>
	    </div>
	</div>
	<div class="panel panel-material-deep-purple-500">
		<div class="panel-heading">
			<h2 class="panel-title">目前天氣</h2>
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