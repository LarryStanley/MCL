@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL待辦事項</h1>
	<hr>
	<div class="panel panel-material-deep-purple-500">
		<div class="panel-heading">
			<?php
				echo $todo->name;
			?>
		</div>
		<div class="panel-body" id="todolistBody">
			<?php
				echo '<div id="description">'.$todo->description.'</div>';
				if ($todo->owner_id == $user->id) {
					echo '<button class="btn btn-warning pull-right" onclick="editDescription()" id="editDescriptionButton">編輯</button>';
					echo '<button class="btn btn-warning pull-right" onclick="submitDescription()" style="display: none" id="submitDescriptionButton">送出</button>';
				}
			?>
		</div>
		<div class="panel-footer">
		<?php
			echo '
		    	<div class="row">
					<div class="col-md-1">
						<img src="http://graph.facebook.com/'.$owner->facebook_id.'/picture?type=square" class="img-circle" style="margin-top: 5px">
					</div><div class="col-md-11">'.$owner->name.'<br>於 '.$todo->create_time.' 建立</div>
				</div>';
		?>
		</div>
	</div>
	<div class="panel panel-material-indigo-500">
		<div class="panel-heading">指派給</div>
		<div class="panel-body">
			<div class="row">
				<?php
					foreach ($assigners as $key => $value) {
						$user = DB::table("users")->where("id", $value->user_id)->first();
						echo '<div class="col-md-1 text-center">
								<img src="http://graph.facebook.com/'.$value->facebook_id.'/picture?type=square" class="img-circle" style="margin-top: 5px" width="40px"><br>
								<span style="font-size: 12px;">'.$user->name.'</span>
							</div>';
					}
				?>
			</div>
		</div>
	</div>
	<?php
		foreach ($comments as $key => $value) {
			echo '<div class="panel panel-info">
				    <div class="panel-body">
				    <p>'.$value->comment.'</p>
				    </div>
				    <div class="panel-footer">
				    	<div class="row">
							<div class="col-md-1">
								<img src="http://graph.facebook.com/'.$value->facebook_id.'/picture?type=square" class="img-circle" style="margin-top: 5px">
							</div><div class="col-md-11">'.$value->user_name.'<br>於 '.$value->record_time.' 編輯</div>
						</div>
					</div>
				</div>';
		}
	?>
	<div class="panel panel-material-blue-500">
	    <div class="panel-heading">
	    	新增評論
	    </div>
	    <div class="panel-body">
	      <form action="/dashboard/newTodoComment" method="POST">
				<div class="form-group">
					<label>評論</label>
					<textarea name="comment" class="form-control" id="description" cols="30" rows="5"></textarea>
				</div>
				<input type="hidden" name="id" value="<?php echo $todo->id; ?>">
				<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
				<input type="submit" value="送出" class="btn btn-warning pull-right">
			</form>  
	    </div>
	</div>
	<div class="panel panel-material-light-blue-500">
	    <div class="panel-heading">
	    	新增指派
	    </div>
	    <div class="panel-body">
	      <form action="/dashboard/newToDoAssign" method="POST">
	      		<div class="row">
	      			<div class="col-md-8">
	      				<div class="form-group">
							<label>指派人員</label>
							<select name="assigner" id="" class="form-control" style="width: 200px">
								<?php 
									$worker = DB::table('users_group')->where("group_name", "worker")->get();
									foreach ($worker as $key => $value) {
										$user = DB::table('users')->where("id", $value->user_id)->first();
										echo "<option value='".$value->user_id."'>".$user->name."</option>";
									}
								?>
							</select>
						</div>	
	      			</div>
	      			<div class="col-md-4">
	      				<input type="hidden" name="id" value="<?php echo $todo->id; ?>">
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						<input type="submit" value="指派" class="btn btn-warning pull-right">
	      			</div>
	      		</div>
			</form>  
	    </div>
	</div>
	<?php
		if ($todo->owner_id == Auth::user()->id) {
			echo '<form action="/dashboard/closeTodo" method="POST">
					<input type="hidden" name="id" value="'.$todo->id.'">
					<input name="_token" type="hidden" value="'.csrf_token().'" />
					<input class="btn btn-info pull-right" value="終結事項" type="submit">
				</form>';
		}
	?>
	<?php
		foreach ($assigners as $key => $value) {
			if ($value->user_id == Auth::user()->id) {
				echo '<form action="/dashboard/todoComplete" method="POST">
						<input type="hidden" name="id" value="'.$todo->id.'">
						<input name="_token" type="hidden" value="'.csrf_token().'" />
						<input class="btn btn-material-green-500 pull-right" value="完成任務" type="submit">
					</form>';
				break;
			}
		}
	?>
	<script src="/js/marked.js"></script>
	<script src="/js/to-markdown.js"></script>
	<script>
		function editDescription() {
			var description = toMarkdown($("#description").html());
			$("#description").replaceWith('<textarea class="form-control" name="description" id="description" cols="30" rows="10">'+ description +'</textarea>');
			$("#editDescriptionButton").hide();
			$("#submitDescriptionButton").show();
		}

		function submitDescription() {
			var description = marked($("#description").val());
			$("#description").replaceWith('<div id="description">'+ description +'</div>');
			$("#editDescriptionButton").show();
			$("#submitDescriptionButton").hide();
		}
	</script>
@stop