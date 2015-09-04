@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL文件</h1>
	<hr>
	<form action="/dashboard/documents/edit" method="POST">
		<div class="form-group">
			<label>文件名稱</label>
			<input type="text" class="form-control" name="name" value="<?php if(!empty($document->name)) echo $document->name;?>">
		</div>
		<div class="form-group">
			<label>內容（請用Markdown語法紀錄）</label>
			<textarea type="text" name="content" class="form-control" rows="20"><?php if(!empty($document->content)) echo $document->content;?></textarea>
		</div>
		<input type="hidden" name="id" value="<?php if(!empty($document->id)) echo $document->id;?>">
        {!! csrf_field() !!}
		<input type="submit" class="btn btn-default pull-right" value="送出">
	</form>
@stop