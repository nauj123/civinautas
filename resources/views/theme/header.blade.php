<div class="main-header">
	<div class="logo d-none d-sm-block">
		<a href="{{ URL::to('home') }}">
			<img src="{{ asset('images/civinautas_logo.png') }}" style="width: auto;">
		</a>
	</div>

	<div class="menu-toggle">
		<div></div>
		<div></div>
		<div></div>
	</div>
	<div style="margin: auto">
		<label style="font-size:15px;"><strong>SISTEMA DE INFORMACIÓN - CIVINAUTAS</strong></label>
	</div>

	<div class="header-part-right">
		@auth
		{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}

		<!-- Full screen toggle -->
		<i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
		<!-- Grid menu Dropdown -->
		<div class="dropdown">
		</div>
		<!-- Notificaiton End -->

		<!-- User avatar dropdown -->
		<div class="dropdown">
			<div class="user col align-self-end">
				<img src="../assets/images/faces/1.jpg" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<a class="dropdown-item" href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
					document.getElementById('logout-form').submit();">Cerrar Sesión</a>
				</div>
			</div>
		</div>
		@endauth
	</div>
	<form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
		@csrf
	</form>
</div>