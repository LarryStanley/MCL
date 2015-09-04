@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL文件</h1>
	<hr>
	<p>
		<?php echo $content;?>
	</p>
	<p>最後由 <?php echo $document->editUserName." 於 ".$document->updateTime." 編輯";?></p>
	<a href="edit/<?php echo $document->id;?>" class="btn btn-default pull-right">編輯</a>
@stop