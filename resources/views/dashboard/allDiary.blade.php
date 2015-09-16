@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>工讀生日誌</h1>
	<hr>
		<div class="diaryList">
			<?php
				foreach ($diaries as $key => $value) {
					echo "<a href='/dashboard/workerDiary/".$value->id."'><div class='panel panel-default'><div class='panel-heading'>".$value->name."</div><div class='panel-body'>".$value->recordUserName." 於 ".$value->recordTime." 編輯</div></div></a>";
				}
			?>
		</div>
	<a href="/dashboard/workerDiary/new" class="btn btn-warning pull-right">新增日誌</a>
@stop