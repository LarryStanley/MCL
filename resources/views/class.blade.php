@extends("layout")

@section("head")
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/dashboard.css">
	<style>
		.well {
			padding: 10px 10px 10px 10px !important;
			text-align: center;
		}

		.worker {
			color: #3F51B5;
		}

		.notOpen {
			color: #F44336;
		}

		.class {
			color: #33691E;
		}
		
		#note {
			text-align: left;
		}

		td {
			vertical-align: middle !important;
		}
	</style>
@stop

@section("content")
	<div class="container">
		<div class="well">
			<h1>104上學期MCL使用表</h1>
			<hr>
			<table class="table table-bordered">
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
						foreach ($classTime as $key => $value) {
							echo "<tr>";
							for ($i = 0; $i < 6; $i++) { 
								if (!$i)
									echo "<td>".$value."</td>";
								else {
									$currentClassValue = $i.$classValue[$key];
									$classData = DB::table("class")->where("time_id", $currentClassValue)->get();
									echo "<td style='width: 180px; height: 70px;'>";
									if ($classData) {
										foreach ($classData as $index => $class) {
											if ($class->user_id) {
												$user = DB::table('users')->where("id", $class->user_id)->first();
												echo "<span class='".$class->type."' title='".$class->type."'>".$user->name."</span><br>";
											} else {
												echo "<sapn class='".$class->type."' title='".$class->type."'>".$class->name."</span><br>";
											}
										}
									} else {
										echo "<span class='notOpen'>不開放</span>";
									}
									echo "</td>";
								}
							}
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<div id="note">
				<div class="worker">藍色為工讀生</div>
				<div class="class">綠色為教室上課課程</div>
			</div>
		</div>
	</div>
@stop