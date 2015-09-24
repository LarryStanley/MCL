@extends("layout")

@section("head")
	<link rel="stylesheet" href="/css/dashboard.css">
@stop

@section("content")
	<div class="container">
		<div class="well">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-3">
				<ul class="nav nav-pills nav-stacked">
					<li><a href="/dashboard">總覽</a></li>
					<?php
						$group = DB::table("users_group")->where("group_name", "worker")->where("user_id", Auth::user()->id)->first();
						if ($group) {
							echo '
							<li><label for="">工讀生專區</label></li>
							<li><a href="/dashboard/workerDiary/new">新增日誌</a></li>
							<li><a href="/dashboard/workerDiary">工讀生日誌</a></li>
							<li><a href="/dashboard/todo">待辦事項</a></li>';
							echo "<li><label>MCL相關文件</label></li>
								  <li><a href='/dashboard/documents'>查看文件</a></li>";
							echo '
							<li><a href="/dashboard/announcement/new">新增文件</a></li>
							<li><label>軟體下載</label></li>
							<li><a href="/dashboard/driver">驅動程式</a></li>
							<li><a href="/dashboard/software">應用軟體</a></li>
							<li><a href="/dashboard/os">作業系統</a></li>';
						}
					?>
					<li><label for="">大一勞服</label></li>
					<li><a href="/dashboard/time">時間填寫</a></li>
					<li><a href="/dashboard/result">分發結果</a></li>
					<?php 
						$group = DB::table("users_group")->where("group_name", "admin")->where("user_id", Auth::user()->id)->first();
						if ($group) {
							echo '
							<li><label for="">管理、設定</label></li>
							<li><a href="/dashboard/announcement">新增公告</a></li>
							<li><a href="/dashboard/changeUserGroup">使用者管理</a></li>';		
						}
					?>
					<li><a href="/auth/logout">登出</a></li>
				</ul>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
					@yield("dashboardContent")
				</div>
			</div>
		</div>
	</div>
	<script>
		emmet.require('textarea').setup({
		    pretty_break: true, 
		    use_tab: true
		});
	</script>
@stop