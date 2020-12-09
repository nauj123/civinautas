@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Registro de atenciones</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion_usuario">Registro de asistencia</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_usuario">Consultar asistencias registradas</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="creacion_usuario"><br>
			<img src="../assets/images/asistencia.jpg" style="width: 100%; height: 400"  alt="">
			</div>
			<div class="tab-pane" id="consulta_usuario" role="tabpanel"><br>
				
			</div>
		</div>
	</div>

</div>
@endsection