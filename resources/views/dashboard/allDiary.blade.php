@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>工讀生日誌</h1>
	<hr>
	<ul>
		<?php
			foreach ($diaries as $key => $value) {
				echo "<li><a href='/dashboard/workerDiary/".$value->id."'>".$value->name."</a><br>".$value->recordUserName." 於 ".$value->recordTime." 編輯</li>";
			}
		?>
	</ul>
	<a href="/dashboard/workerDiary/new" class="btn btn-default pull-right">新增日誌</a>
@stop