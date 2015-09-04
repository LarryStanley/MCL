@extends("dashboard/dashboardLayout")

@section("dashboardContent")
	<h1>作業系統</h1>
	<hr>
	<ul>
		<li>
			Windows 7
			<ul>
				<li><a href="/downloads/Win7Ent_32_CHT_wSP1.ISO">32位元</a></li>
				<li><a href="/downloads/Win7Ent_64_CHT_wSP1.ISO">64位元</a></li>
			</ul>
		</li>
		<li>
			Ubuntu 12.04
			<ul>
				<li><a href="/downloads/ubuntu12.32">Desktop 32位元</a></li>
				<li><a href="/downloads/ubuntu12.64">Desktop 64位元</a></li>
				<li><a href="/downloads/ubuntu12.32">Server 32位元</a></li>
				<li><a href="/downloads/ubuntu12.64">Server 64位元</a></li>
			</ul>
		</li>
		<li>
			Ubuntu 14.04
			<ul>
				<li><a href="/downloads/ubuntu-14.04.3-desktop-i386.iso">Desktop 32位元</a></li>
				<li><a href="/downloads/ubuntu14.64">Desktop 64位元</a></li>
				<li><a href="/downloads/ubuntu12.32">Server 32位元</a></li>
				<li><a href="/downloads/ubuntu12.64">Server 64位元</a></li>
			</ul>
		</li>
		<li><a href="/downloads/">再生龍</a></li>
	</ul>
@stop