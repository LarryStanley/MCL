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
@stop