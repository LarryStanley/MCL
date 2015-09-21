@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<div class="panel panel-primary" style="margin-top: 20px;">
	    <div class="panel-heading">
	    	<h3><?php echo $diary->name;?></h3>
	    </div>
	    <div class="panel-body">
	        <?php echo $diary->content;?>
	    </div>
	    <div class="panel-footer">
			<?php 
				echo $diary->recordUserName." 於 ".$diary->recordTime." 編輯";

				if ($diary->recordUserId == Auth::user()->id)
					echo '<a href="/dashboard/workerDiary/edit/'.$diary->id.'" class="btn btn-warning pull-right">編輯日誌</a>';
			?>
		</div>
	</div>
	<div class="row" style="margin-top: 30px">
		<div class="col-md-6 col-sm-6">
			<?php
				$lastData = DB::table("diary")->where("id", "<", $diary->id)->orderBy("id", "desc")->take(1)->first();
				if ($lastData)
					echo '<a href="/dashboard/workerDiary/'.$lastData->id.'">《 '.$lastData->name .'</a>';
			?>
		</div>
		<div class="col-md-6 col-sm-6" style="text-align: right">
			<?php
				$lastData = DB::table("diary")->where("id", ">", $diary->id)->orderBy("id", "asc")->take(1)->first();
				if ($lastData)
					echo '<a href="/dashboard/workerDiary/'.$lastData->id.'">'.$lastData->name .' 》</a>';
			?>
		</div>
	</div>
	<div class="panel panel-primary" style="margin-top: 20px;">
	    <div class="panel-heading">
			<h4>留言</h4>
	    </div>
	    <div class="panel-body">
	        <div id="commentBody">
	        	<?php 
	        		foreach ($comments as $key => $value) {
	        			echo '<div class="row"><div class="col-md-2"><img src="http://graph.facebook.com/'.$value->facebook_id.'/picture?type=square" class="img-circle" style="margin-top: 5px"></div>';
	        			echo '<div class="col-md-10" style="vertical-align: center">'.$value->user_name.'<br>'.$value->comment.'</div></div>';
	        		}
	        	?>
	        </div>
	    </div>
	    <div class="panel-footer">
			 <div class="form-group">
			 	<form action="/dashboard/workerDiary/newComment" id="commentForm" method="POST">
			 		<div class="row">
		                <div class="col-md-10">
		                	<input type="text" id="commentInput" class="form-control" placeholder="新增留言" name="comment">
	                	</div>
	                	<div class="col-md-2">
	                		<input type="hidden" name="id" value="<?php echo $diary->id;?>">
	        				<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
			                <input type="submit" class="btn btn-default" value="新增">                		
	                	</div>
                	</div>
                </form>
	        </div>
		</div>
	</div>
	<script>
		$("#commentForm").submit(function(data) {
			if ($("#commentInput").val()) {
				$.ajax({
					method: "POST",
					data: $("#commentForm").serialize(),
					url: "/dashboard/workerDiary/newComment",
				}).done(function(comment) {
					$("#commentBody").append('<div class="row"><div class="col-md-2"><img src="http://graph.facebook.com/' + comment.fb_id + '/picture?type=square" class="img-circle" style="margin-top: 5px"></div><div class="col-md-10">' + comment.user_name + '<br>' + comment.comment + '</div></div>')
					$("#commentInput").val("");
				});
			}
			return false;
		});
	</script>
@stop