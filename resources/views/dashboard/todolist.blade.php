@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL待辦事項</h1>
	<hr>
	<div class="panel panel-primary">
		<div class="panel-heading">
			目前正在進行中
		</div>
		<div class="panel-body" id="todolistBody">
			<ul>
				<li>
					被指派
					<ul>
						<?php
							$assignMission = DB::table("todo_assigners")->where("done", false)->where("user_id", Auth::user()->id)->get();
							$showTodo = array();
							foreach ($assignMission as $key => $value) {
								$todo = DB::table("todo_list")->where("done", false)->where("id", $value->todo_id)->first();
								echo "<li><a href='/dashboard/todo/".$todo->id."'>".$todo->name."</a></li>";
								array_push($showTodo, $todo->id);
							}
						?>	
					</ul>
				</li>
				<li>
					其他事項
					<ul>
						<?php
							foreach ($list as $key => $value) {
								if (!in_array($value->id, $showTodo))
									echo "<li><a href='/dashboard/todo/".$value->id."'>".$value->name."</a></li>";
							}
						?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-success">
		<div class="panel-heading">
			已完成事項
		</div>
		<div class="panel-body" id="doneBody">
			<ul>
				<?php
					foreach ($doneList as $key => $value) {
						echo "<li><del><a href='/dashboard/todo/".$value->id."'>".$value->name."</a></del></li>";
					}
				?>
			</ul>
		</div>
	</div>
	<div class="panel panel-info">
	    <div class="panel-heading">
	        <h4>新增待辦事項</h4>
	    </div>
	    <div class="panel-body">
	      <form action="/dashboard/newTodo" method="POST">
				<div class="form-group">
					<label>事項名稱</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label>內容描述</label>
					<textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
				</div>
				<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
				<input type="submit" value="送出" class="btn btn-warning pull-right">
			</form>  
	    </div>
	</div>
@stop