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
	<div class="btn-toolbar" role="toolbar">
		<div class="btn-group" role="group">
			<?php
				if ($page != 1)
					echo '<a class="btn btn-default" type="button">上一頁</a>';
				for ($i = 1; $i <= $allPageCount; $i++) {
					if ($i == $page)
						echo '<a href="'.$i.'" class="btn btn-default active" type="button">'.$i.'</a>';
					else
						echo '<a href="'.$i.'" class="btn btn-default" type="button">'.$i.'</a>';
				}
				if ($page != $allPageCount)
					echo '<a class="btn btn-default" type="button">下一頁</a>';
			?>
		</div>
	</div>
	<a href="/dashboard/workerDiary/new" class="btn btn-warning pull-right">新增日誌</a>
@stop