@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>Hi, <?php echo $user->name;?></h1>
	<hr>
	<h2>公告</h2>
	<hr>
	<ul>
		<?php
			$announcement = DB::table("announcement")->where("show", true)->get();
			$announcement = array_reverse($announcement);
			foreach ($announcement as $key => $value) {
				echo "<li>".$value->recordUserName."說：".$value->content."</li>";
			}
		?>
	</ul>
@stop