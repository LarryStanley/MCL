@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL待辦事項</h1>
	<hr>
	<div class="panel panel-primary">
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
	<div class="panel panel-info">
	    <div class="panel-heading">
	        <h4>新增評論</h4>
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
	<form action="/dashboard/closeTodo" method="POST">
		<input type="hidden" name="id" value="<?php echo $todo->id; ?>">
		<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
		<input class="btn btn-info pull-right" value="終結事項" type="submit">
	</form>
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