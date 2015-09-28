@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<style>
		td {
			vertical-align: middle !important;
		}
	</style>
	<h1>勞服分發管理</h1>
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
	<div class="panel panel-info">
	    <div class="panel-heading">
	        <h3 class="panel-title">預排班表</h3>
	    </div>
	    <div class="panel-body" id="allocateBody">
			<table class="table table-bordered" style="text-align: center; valign: middle;">
				<thead>
					<tr>
						<td></td>
						<td>星期一</td>
						<td>星期二</td>
						<td>星期三</td>
						<td>星期四</td>
						<td>星期五</td>
					</tr>
				</thead>
				<tbody>
			    	<?php
			    		$classTime = ["1 08:00 ~ 08:50", "2 09:00 ~ 09:50", "3 10:00 ~ 10:50", "4 11:00 ~ 11:50", "Z 12:00 ~ 12:50", "5 13:00 ~ 13:50", "6 14:00 ~ 14:50", "7 15:00 ~ 15:50", "8 16:00 ~ 16:50", "9 17:00 ~ 17:50", "A 18:00 ~ 18:50", "B 19:00 ~ 19:50", "C 20:00 ~ 20:50"];
						$classValue = ["1", "2", "3", "4", "Z", "5", "6", "7", "8", "9", "A", "B", "C"];
						$noteOpen = ["13", "14", "44", "23", "24", "55", "56", "57", "58", "59", "5A", "5B", "5C"];
						$inClassPeople = array();
						$result = array();
						foreach ($classTime as $key => $value) {
							echo "<tr>";
							for ($i = 0; $i < 6; $i++) { 
								if (!$i)
									echo "<td style='width: 180px;'>".$value."</td>";
								else {
									$currentClassValue = $i.$classValue[$key];
									$willData = DB::table("fresh_will")->where("select_class", $currentClassValue)->get();
									if (!in_array($currentClassValue, $noteOpen)) {
										echo "<td>";
										if ($willData) {
											while (1 == 1) {
												if (count($willData)) {
													$index = array_rand($willData);
													$fresh = $willData[$index];
													if (!in_array($fresh->user_id, $inClassPeople)) {
														$user = DB::table("users")->where("id", $fresh->user_id)->first();
														echo "<div style='color: #009688'>".$user->name."</div>";
														array_push($inClassPeople, $fresh->user_id);
														array_push($result, ["class_value" => $currentClassValue, "user_id" => $fresh->user_id]);
														break;
													} else {
														unset($willData[$index]);
													}
												} else {
													break;
												}
											}	
										}

										// show worker
										$worker = DB::table("class")->where("time_id", $currentClassValue)->where("type", "worker")->first();
										if ($worker) {
											$user = DB::table("users")->where("id", $worker->user_id)->first();
											echo "<div style='color: #3F51B5'>".$user->name."</div>";
										}
										echo "</td>";
									} else {
										echo "<td style='color: #F44336'>不開放</td>";
									}
								}
							}
							echo "</tr>";
						}
			    	?>
				</tbody>
			</table>
			<hr>
			<h4>沒排到的人</h4>
			<?php
				$fresh = DB::table("users_group")->where("group_name", "fresh")->get();
				$counter = 0;
				foreach ($fresh as $key => $value) {
					if (!in_array($value->user_id, $inClassPeople)) {
						$user = DB::table("users")->where("id", $value->user_id)->first();
						$will = DB::table("fresh_will")->where('user_id', $value->user_id)->get();
						if ($user) {
							if ($will)
								echo $user->name." ";
							else
								echo "<span style='color: #F44336'>".$user->name." </span>";
							$counter++;
						}
					}
				}
				echo "<br>共 ".$counter." 人";
			?>
			<form action="/dashboard/saveAllocate" method="POST" id="saveRegisterForm">
				<input type="hidden" value='<?php echo json_encode($result) ;?>' name="result" id="result">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="submit" class="btn btn-info pull-right" value="儲存目前結果">
			</form>
			<script>
				$("#saveRegisterForm").submit(function(data) {
					$("#saveMessage").remove();
					$.post("/dashboard/saveAllocate", $("#saveRegisterForm").serialize(), function(response) {
						$("#allocateBody").append("<div class='animated fadeIn' style='color: #F44336' id='saveMessage'>已儲存</div>");
					});
					event.preventDefault();
					return false;
				});
			</script>
	    </div>
	</div>
@stop