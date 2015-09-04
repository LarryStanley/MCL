@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>更改使用者權限</h1>
	<hr>
	<h2><?php echo $user->name;?></h2>
	<hr>
	<ul>
		<li>email : <?php echo $user->email; ?></li>
	</ul>
	<form action="/dashboard/changeUserGroup" method="POST">
		<div class="form-group">
			<?php 
				$group = DB::table("users_group")->where("user_id", $user->id)->lists("group_name");
			?>
			<input type="checkbox" name='group[]' value="fresh" <?php if(in_array("fresh", $group)) echo "checked";?>> fresh<br>
			<input type="checkbox" name='group[]' value="worker" <?php if(in_array("worker", $group)) echo "checked";?>> worker<br>
			<input type="checkbox" name='group[]' value="admin" <?php if(in_array("admin", $group)) echo "checked";?>> admin<br>
			<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
			<input type="hidden" name="id" value="<?php echo $user->id;?>">
			<input type="submit" value="送出" class="btn btn-default pull-right">
		</div>
	</form>
@stop