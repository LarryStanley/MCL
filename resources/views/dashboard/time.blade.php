@extends("dashboard/dashboardLayout")

@section("dashboardContent")
<script src="/js/freshTime.js"></script>
<div ng-app="freshTimeApp">
	<div ng-controller="FreshTimeController as freshTime"  data-ng-init="init()">
		<h1>大一勞服時間填寫</h1>
		<hr>
		<table class="table table-bordered" style="text-align: center">
			<thead>
				<tr>
					<td>時間/星期</td>
					<td>一</td>
					<td>二</td>
					<td>三</td>
					<td>四</td>
					<td>五</td>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="(index, row) in freshTime.classTable">
					<td><?php echo "{{ freshTime.duration[index] }}" ?></td>
					<td ng-repeat="value in row">
						<input type="checkbox" ng-model="value.checked">
					</td>
				</tr>
			</tbody>
		</table>
		<?php echo "{{ freshTime.status() }}";?><br>
		您必須點選儲存才能進行分發喔！
		<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
		<p id="message"></p>
		<button class="btn btn-info pull-right" ng-click="freshTime.submit()">儲存</button>
	</div>
</div>
@stop