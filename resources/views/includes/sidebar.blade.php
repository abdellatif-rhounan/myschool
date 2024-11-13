<aside class="main-sidebar sidebar-dark-primary elevation-4">

	<a class="brand-link" href='{{ route("dashboard.{$role}") }}' style="text-align: center; font-weight: bold; font-size: 24px">
		<i class="fas fa-book-open" style="position: relative; top: 1px"></i>

		<span class="brand-text">{{ config('app.name') }}</span>
	</a>

	<div class="sidebar" style="margin-top: 4rem">
		<div class="user-panel d-flex mb-3 mt-3 pb-3">
			<div class="image">
				<i class="fas fa-user" style="position: relative; top: 2px; font-size: 26px; color: #d6d7d9;"></i>
			</div>

			<div class="info">
				<a class="d-block" href="javascript:;" style="overflow: hidden; text-overflow: ellipsis;">
					{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
				</a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" role="menu">
				<li class="nav-item">
					<a class="nav-link @if (request()->segment(2) == 'dashboard') active @endif" href='{{ route("dashboard.{$role}") }}'>
						<i class="nav-icon fas fa-tachometer-alt"></i>

						<p>Dashboard</p>
					</a>
				</li>

				@yield('sidebar_links')
			</ul>
		</nav>
	</div>

</aside>
