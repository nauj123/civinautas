@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Gestion_Grupos/grupos.js?v=2020.12.21.1') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Gestión de grupos</h1>
</div>
<br>
<div class="container-fluid">
	@auth
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#grupos_mediador">Grupos mediador</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#agregar_estudiantes">Agregar estudiantes</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="grupos_mediador"><br>
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<button class="btn btn-block btn-success" id="btn-crear-grupo" data-toggle='modal' data-target='#modal-crear-grupo'>Crear nuevo grupo</button>
					</div>
				</div>
				<table class="table display" id="tabla-info-grupos" style="width: 100%;">
					<thead>
						<tr>
							<th>Institución</th>
							<th>Nombre grupo</th>
							<th>Nombre mediador</th>
							<th>Nombre docente</th>
							<th>Tipo atención</th>
							<th>N° estudiantes</th>
							<th>Inactivar grupo</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="tab-pane" id="agregar_estudiantes" role="tabpanel"><br>
				<div class="card col-lg-10 offset-lg-1" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Agregar beneficiarios al grupo</div>
					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-3 col-lg-3 form-group mb-3">
									<spa>Seleccionar grupo </spa>
								</div>
								<div class="col-xs-12 col-md-9 col-lg-9">
									<select class="form-control selectpicker" title="Seleccione una opción" id="grupo-mediador" required></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-3 col-lg-3 form-group mb-3">
									Buscar estudiante
								</div>
								<div class="col-xs-12 col-md-9 col-lg-9">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Nombres Apellidos  o Documento del estudiante" id="TB_buscar_usuario">
										<i class="text-20 i-Search-on-Cloud"></i>
									</div>
								</div>
							</div>
							<div id="concidencias_simat" style="display: none;">
								<table class="table display" id="tabla-estudiantes-coincidencias" style="width: 100%;">
									<thead>
										<tr>
											<th>Identificación</th>
											<th>Nombre Estudiante</th>
											<th>Fecha Nacimiento</th>
											<th>Genero</th>
											<th>Agregar</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>

					</div>
				</div><br>

				<div id="beneficiarios_grupo" style="display: none;">
					<div class="p-2 rounded d-flex align-items-center bg-success text-white">
						<h3 class="text-18 mb-1 text-white">Estudiantes que ya estan en el grupo</h3>
					</div><br>
					<table class="table display" id="tabla-estudiantes-grupo" style="width: 100%;">
						<thead>
							<tr>
								<th>Identificación</th>
								<th>Nombre Estudiante</th>
								<th>Fecha Nacimiento</th>
								<th>Genero</th>
								<th>Fecha de registro</th>
								<th>Estado</th>
								<th>Retirar del grupo</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-crear-grupo">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>REGISTRAR NUEVO GRUPO</strong></h3>
					</div>
					<div class="modal-body">
						<form id="form-nuevo-grupo">
							@include('Gestion_Grupos.form_grupo')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-institucion">Cerrar</button>
						<button type="submit" class="btn btn-primary">Crear Grupo</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endauth
</div>
@endsection