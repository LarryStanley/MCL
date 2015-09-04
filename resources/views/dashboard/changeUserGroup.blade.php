@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>更改使用者權限</h1>
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
@stop