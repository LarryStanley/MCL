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
			echo '<a href="/dashboard/workerDiary/edit/'.$diary->id.'" class="btn btn-default pull-right">編輯</a>';
	?>
@stop