@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>勞服管理</h1>
	<div class="panel panel-primary">
	    <div class="panel-heading">
	        <h3 class="panel-title">尚未填寫志願的人</h3>
	    </div>
	    <div class="panel-body">
	    	<?php
	    		$counter = 0;
	    		foreach ($notRegister as $key => $value) {
	    			$userData = DB::table("users")->where("id", $value)->first();
	    			if ($userData) {
		    			echo $userData->name." ";
		    			$counter++;
		    		}
	    		}

	    		echo "<br><br>共 ".$counter." 人";
	    	?>
	    </div>
	</div>
	
@stop