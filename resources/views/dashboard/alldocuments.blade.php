@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>MCL文件</h1>
	<hr>
	<ul>
		<?php
			foreach ($documents as $key => $value) {
				echo "<li>".$value->group_name."<ul>";
				foreach ($value->data as $index => $document) {
					echo "<li><a href='/dashboard/documents/".$document->id."'>".$document->name."</a></li>";
				}
				echo "</ul></li>";
			}
		?>
	</ul>
@stop