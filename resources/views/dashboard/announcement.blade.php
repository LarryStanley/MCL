@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>新增公告</h1>
	<hr>
	<form action="/dashboard/announcement" method="POST">
        {!! csrf_field() !!}
        <div class="form-group">
        	<label>公告內容</label>
        	<input type="text" class="form-control" name="content">
        	<input type="submit" class="btn btn-default pull-right" value="送出">
        </div>
	</form>
	<h2>現有公告</h2>
	<hr>
	<ul>
		<?php
			foreach ($announcements as $key => $value) {
				echo "<li>".$value->content."</li>";
			}
		?>
	</ul>
@stop