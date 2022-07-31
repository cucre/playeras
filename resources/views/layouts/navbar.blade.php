<div id="header" class="header navbar-default">
	<!-- begin navbar-header -->
	<div class="navbar-header">
		<a href="index.html" class="navbar-brand">
			<div style="width: 35px; margin-top: 7px; margin-right: 10px; display: block;"><img src="/imgs/dc_logo.jpeg"></div>
			Venta de <b>&nbsp;Playeras</b>
		</a>
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- end navbar-header -->
	<!-- begin header-nav -->
	<ul class="navbar-nav navbar-right">
		{{-- <li class="navbar-form">
			<form action="" method="POST" name="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter keyword" />
					<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</li>
		<li class="dropdown">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
				<i class="fa fa-bell"></i>
				<span class="label">0</span>
			</a>
			<div class="dropdown-menu media-list dropdown-menu-right">
				<div class="dropdown-header">NOTIFICATIONS (0)</div>
				<div class="text-center width-300 p-b-10 p-t-10">
					No notification found
				</div>
			</div>
		</li> --}}
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<div class="image image-icon bg-black text-grey-darker">
					<i class="fa fa-user"></i>
				</div>
				<span class="d-none d-md-inline">{{ auth()->user()->full_name }}</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				{{-- <a href="javascript:;" class="dropdown-item">Edit Profile</a>
				<a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">0</span> Inbox</a>
				<a href="javascript:;" class="dropdown-item">Calendar</a>
				<a href="javascript:;" class="dropdown-item">Setting</a>
				<div class="dropdown-divider"></div> --}}
				<a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
			</div>
		</li>
	</ul>
	<!-- end header-nav -->
</div>