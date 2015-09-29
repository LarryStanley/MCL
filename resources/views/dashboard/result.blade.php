@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<style>
		.worker {
			color: #3F51B5;
		}

		.notOpen {
			color: #F44336;
		}

		.class {
			color: #33691E;
		}
		
		.fresh {
			color: #0097A7;
		}

		#note {
			text-align: left;
		}

		td {
			vertical-align: middle !important;
			text-align: center;
		}
	</style>
	<h1>勞服分發結果</h1>
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
							echo "<td>";
							if ($classData) {
								foreach ($classData as $index => $class) {
									if ($class->user_id && $class->type == 'fresh') {
										$user = DB::table('users')->where("id", $class->user_id)->first();
										echo "<span class='".$class->type."' title='".$class->type."'>".$user->name."</span><br>";
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
	<p>
		<h3>您的時段</h3>
		<?php
			$class = DB::table("class")->where("user_id", Auth::user()->id)->where("type", "fresh")->first();
			$classTime = ["1" => "1 08:00 ~ 08:50", "2" => "2 09:00 ~ 09:50", "3" => "3 10:00 ~ 10:50", "4" => "4 11:00 ~ 11:50", "Z" => "Z 12:00 ~ 12:50", "5" => "5 13:00 ~ 13:50", "6" => "6 14:00 ~ 14:50", "7" => "7 15:00 ~ 15:50", "8" => "8 16:00 ~ 16:50", "9" => "9 17:00 ~ 17:50", "A" => "A 18:00 ~ 18:50", "B" => "B 19:00 ~ 19:50", "C" => "C 20:00 ~ 20:50"];
			$week = ["1" => "星期ㄧ", "2" => "星期二", "3" => "星期三", "4" => "星期四", "5" => "星期五"];
			if ($class) {
				echo "您的值班時間為<span class='class'>".$week[$class->time_id[0]]."</span> <span class='fresh'>".$classTime[$class->time_id[1]]."</span>";
				$worker = DB::table('class')->where("time_id", $class->time_id)->where("type", "worker")->first();
				if ($worker) {
					$user = DB::table('users')->where("id", $worker->user_id)->first();
					echo "<br>該班工讀生為<span class='worker'>".$user->name."</span><br>請於該時段至MCL進行服務學習";
				}
			}
		?>
		<br>詳細MCL使用表可至<a href="/class" target="_blank">使用表</a>查看
	</p>
@stop