<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="javascript:;" role="button">
				<i class="fas fa-bars"></i>
			</a>
		</li>
	</ul>

	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
				<i class="fas fa-address-card mr-1"></i>
				<span>My Profile</span>
			</a>

			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">

				<a class="dropdown-item my-2 py-2" href="#" style="font-size: 16px">
					<i class="nav-icon fas fa-id-card mr-2"></i>

					<span>My Profile</span>
				</a>

				<div class="dropdown-divider"></div>

				<a class="dropdown-item my-2 py-2" href="{{ route('logout') }}" style="font-size: 16px">
					<i class="fas fa-sign-out-alt"></i>

					<span>Logout</span>
				</a>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" data-widget="fullscreen" href="javascript:;" role="button">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>
	</ul>
</nav>
