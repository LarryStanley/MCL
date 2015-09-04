@extends("dashboard/dashboardLayout")

@section("dashboardContent")	
	<h3>新增電腦</h3>
	<hr>
	<form action="/dashboard/newComputer" method="POST">
		<div class="form-group">
			<label>電腦名稱</label>
			<input type="text" name="computerName" class="form-control">
		</div>
		<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
		<input type="submit" value="新增" class="btn btn-default pull-right">
	</form>
@stop