@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>驅動程式</h1>
	<hr>
	<ul>
		<?php 
			foreach ($group as $key => $computer) {
				echo "<li>".$computer->computerName."</li>";
				$data = DB::table("drivers")->where("groupId", $computer->id)->get();
				echo "<ul>";
				foreach ($data as $key => $value) {
					echo "<li><a href='/downloads/".$value->location."'>".$value->name."</a></li>";
				}
				echo "</ul>";
			}
		?>
	</ul>
	<a href="/dashboard/uploadDriver" class="btn btn-default">上傳驅動</a>
	<a href="/dashboard/newComputer" class="btn btn-default">新增電腦</a>
	<br><br>
@stop