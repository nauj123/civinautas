<div class="main-header">
	<div class="logo">
		<img src="../assets/images/logo.jpg" style="width: 90%;" alt="">
	</div>

	<div class="menu-toggle">
		<div></div>
		<div></div>
		<div></div>
	</div>
	<div style="margin: auto">
	 <label style="font-size:15px;"><strong>SISTEMA DE INFROMACIÓN - CIVINAUTAS</strong></label>
	</div>

	<div class="header-part-right">
		@auth
		{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}
		
		<!-- Full screen toggle -->
		<i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
		<!-- Grid menu Dropdown -->
		<div class="dropdown">
			<i class="i-Safe-Box text-muted header-icon" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"></i>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<div class="menu-icon-grid">
					<a href="#"><i class="i-Shop-4"></i> Home</a>
					<a href="#"><i class="i-Library"></i> UI Kits</a>
					<a href="#"><i class="i-Drop"></i> Apps</a>
					<a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>
					<a href="#"><i class="i-Checked-User"></i> Sessions</a>
					<a href="#"><i class="i-Ambulance"></i> Support</a>
				</div>
			</div>
		</div>
		<!-- Notificaiton -->
		<div class="dropdown">
			<div class="badge-top-container" id="dropdownNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="badge badge-primary">3</span>
				<i class="i-Bell text-muted header-icon"></i>
			</div>
			<!-- Notification dropdown -->
			<div class="dropdown-menu rtl-ps-none dropdown-menu-right notification-dropdown" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
				<div class="dropdown-item d-flex">
					<div class="notification-icon">
						<i class="i-Speach-Bubble-6 text-primary mr-1"></i>
					</div>
					<div class="notification-details flex-grow-1">
						<p class="m-0 d-flex align-items-center">
							<span>New message</span>
							<span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
							<span class="flex-grow-1"></span>
							<span class="text-small text-muted ml-auto">10 sec ago</span>
						</p>
						<p class="text-small text-muted m-0">James: Hey! are you busy?</p>
					</div>
				</div>
				<div class="dropdown-item d-flex">
					<div class="notification-icon">
						<i class="i-Receipt-3 text-success mr-1"></i>
					</div>
					<div class="notification-details flex-grow-1">
						<p class="m-0 d-flex align-items-center">
							<span>New order received</span>
							<span class="badge badge-pill badge-success ml-1 mr-1">new</span>
							<span class="flex-grow-1"></span>
							<span class="text-small text-muted ml-auto">2 hours ago</span>
						</p>
						<p class="text-small text-muted m-0">1 Headphone, 3 iPhone x</p>
					</div>
				</div>
				<div class="dropdown-item d-flex">
					<div class="notification-icon">
						<i class="i-Empty-Box text-danger mr-1"></i>
					</div>
					<div class="notification-details flex-grow-1">
						<p class="m-0 d-flex align-items-center">
							<span>Product out of stock</span>
							<span class="badge badge-pill badge-danger ml-1 mr-1">3</span>
							<span class="flex-grow-1"></span>
							<span class="text-small text-muted ml-auto">10 hours ago</span>
						</p>
						<p class="text-small text-muted m-0">Headphone E67, R98, XL90, Q77</p>
					</div>
				</div>
				<div class="dropdown-item d-flex">
					<div class="notification-icon">
						<i class="i-Data-Power text-success mr-1"></i>
					</div>
					<div class="notification-details flex-grow-1">
						<p class="m-0 d-flex align-items-center">
							<span>Server Up!</span>
							<span class="badge badge-pill badge-success ml-1 mr-1">3</span>
							<span class="flex-grow-1"></span>
							<span class="text-small text-muted ml-auto">14 hours ago</span>
						</p>
						<p class="text-small text-muted m-0">Server rebooted successfully</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Notificaiton End -->

		<!-- User avatar dropdown -->
		<div class="dropdown">
			<div class="user col align-self-end">
				<img src="../assets/images/faces/1.jpg" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<div class="dropdown-header">
						<i class="i-Lock-User mr-1"></i> Timothy Carlson
					</div>
					<a class="dropdown-item">Account settings</a>
					<a class="dropdown-item">Billing history</a>
					<a class="dropdown-item" href="signin.html">Sign out</a>
				</div>
			</div>
		</div>
		@endauth
	</div>
</div>

<!--
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>
	<span class="navbar-text ml-auto">
		Sistema de información - CIVINAUTAS
	</span>
	<ul class="navbar-nav ml-auto">
		@auth
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="{{ route('perfil-usuario') }}">Perfil de usuario</a>
				<a class="dropdown-item" href="#">Cambiar contraseña</a>
				<a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">Cerrar Sesión</a>
			</div>
		</li>
		@endauth
	</ul>
</nav>
<form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
	@csrf
</form> -->