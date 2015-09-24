@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>使用者設定</h1>
	<hr>
	<h2>更改使用者權限</h2>
	<hr>
	<table class="table table-striped">
		<thead>
			<tr>
				<td>id</td>
				<td>姓名</td>
				<td>帳號</td>
				<td>群組</td>
				<td>更改群組</td>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($users as $key => $value) {
					$group = DB::table("users_group")->where("user_id", $value->id)->get();
					echo "<tr><td>".$value->id."</td>
					<td>".$value->name."</td>
					<td>".$value->email."</td><td>";
					foreach ($group as $key => $item) {
						echo $item->group_name." ";
					}
					echo "</td><td><a href='changeUserGroup/".$value->id."'>更改群組</a></td></tr>";
				}
			?>
		</tbody>
	</table>
	<h2>新增使用者</h2>
	<hr>
	<form action="/dashboard/createNewUserByFile" method="POST" enctype="multipart/form-data" >
		<div class="form-group">
			<label>上傳CSV檔</label>
			<p>
				檔案形式為：
				<code>使用者帳號, 密碼</code>
			</p>
			<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
			<input type="file" class="form-control" name="users">
			<input type="submit" value="新增"  class="btn btn-warning pull-right">
		</div>
	</form>
@stop