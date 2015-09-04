@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>新增驅動</h1>
	<form action="/dashboard/uploadDriver" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label>電腦名稱</label>
			<select class="form-control" style='width: 200px;' name="computerName">
				<?php
					foreach ($group as $key => $value) {
						echo "<option>".$value->computerName."</option>";
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<label>驅動名稱</label>
			<input type="text" name="name" class="form-control">
		</div>
		<div class="form-group">
			<label>驅動檔案</label>
			<input type="file" id="driver" name="driver">
		</div>
		<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
		<input type="submit" value="上傳" class="btn btn-default pull-right">
	</form>
@stop