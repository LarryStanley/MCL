@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>新增日誌</h1>
	<hr>
	<form action="/dashboard/workerDiary/new" method="POST">
        {!! csrf_field() !!}
		<div class="form-group">
			<label>主旨</label>
			<input type="text" class="form-control" name="name" value="<?php if(!empty($diary->name)) echo $diary->name;?>">
		</div>
		<div class="form-group">
			<label>內容</label>
			<textarea class="form-control" rows="15" name="content"><?php if(!empty($diary->content)) echo $diary->content;?></textarea>			
		</div>
		<input type="hidden" value="<?php if(!empty($diary->id)) echo $diary->id;?>" name="id">
		<input type="submit" class="btn btn-default pull-right" value="送出">
	</form>
	<div>
		日誌支援Markdown語法，Markdown使用方式可參考<a href="http://markdown.tw/" target="_blank">Markdown 語法說明</a><br>
		也支援html，大家可以多多使用，讓日誌更加漂亮
	</div>
@stop