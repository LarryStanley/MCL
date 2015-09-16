@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1><?php echo $diary->name;?></h1>
	<hr>
	<p>
		<?php echo $diary->content;?>
	</p>
	<hr>
	<?php 
		echo $diary->recordUserName." 於 ".$diary->recordTime." 編輯";

		if ($diary->recordUserId == Auth::user()->id)
			echo '<a href="/dashboard/workerDiary/edit/'.$diary->id.'" class="btn btn-warning pull-right">編輯日誌</a>';
	?>
	<div class="row" style="margin-top: 30px">
		<div class="col-md-6 col-sm-6">
			<?php
				$lastData = DB::table("diary")->where("id", "<", $diary->id)->orderBy("id", "desc")->take(1)->first();
				if ($lastData)
					echo '<a href="/dashboard/workerDiary/'.$lastData->id.'">《 '.$lastData->name .'</a>';
			?>
		</div>
		<div class="col-md-6 col-sm-6" style="text-align: right">
			<?php
				$lastData = DB::table("diary")->where("id", ">", $diary->id)->orderBy("id", "asc")->take(1)->first();
				if ($lastData)
					echo '<a href="/dashboard/workerDiary/'.$lastData->id.'">'.$lastData->name .' 》</a>';
			?>
		</div>
	</div>
@stop