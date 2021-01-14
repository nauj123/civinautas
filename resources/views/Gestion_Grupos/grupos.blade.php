@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Gestion_Grupos/grupos.js?v=2021.01.4.4') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Gestión de grupos</h1>
</div>
<br>
<style>
	.red {
		background-color: red !important;
	}
</style>
<div class="container-fluid">
	@auth
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#grupos_mediador">Grupos mediador</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#agregar_estudiantes">Agregar estudiantes</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consultar_grupos">Consultar grupos</a></li>
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
				<table class="display table table-striped table-bordered" id="tabla-info-grupos" style="width: 100%;">
					<thead>
						<tr>
							<th>Institución</th>
							<th>Sede</th>
							<th>Nombre grupo</th>
							<th>Nombre docente</th>
							<th>Jornada</th>
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
								<div class="col-xs-12 col-md-7 col-lg-7">
									<div class="input-group">
										<input type="text" class="form-control mayuscula" placeholder="Nombres Apellidos  o Documento del estudiante" id="TB_buscar_usuario">
									</div>
								</div>
								<div class="col-xs-12 col-md-2 col-lg-2">
									<button class="btn btn-block btn-success" id="btn-buscar">BUSCAR</button>
								</div>
							</div>
							<div id="concidencias_simat" style="display: none;">
								<table class="display table table-striped table-bordered" id="tabla-estudiantes-coincidencias" style="width: 100%;">
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
								</table><br>
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<button class="btn btn-block btn-primary" id="btn-crear-grupo" data-toggle='modal' data-target='#modal-registrar-estudiante'>REGISTRAR ESTUDIANTES</button>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div><br>

				<div id="beneficiarios_grupo" style="display: none;">
					<div class="p-2 rounded d-flex align-items-center bg-success text-white">
						<h3 class="text-18 mb-1 text-white">Estudiantes que ya estan en el grupo</h3>
					</div><br>
					<table class="display table table-striped table-bordered" id="tabla-estudiantes-grupo" style="width: 100%;">
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

			<div class="tab-pane" id="consultar_grupos" role="tabpanel"><br>	
				<div class="p-2 rounded d-flex align-items-center bg-success text-white">
					<h3 class="text-18 mb-1 text-white">Listado del total de grupos en el sistema CIVINAUTAS </h3>
				</div><br>
				<table class="display table table-striped table-bordered" id="tabla-consultar-grupos" style="width: 100%;">
					<thead>
						<tr>
							<th>N°.</th>
							<th>Localidad</th>
							<th>Tipo de Institución</th>
							<th>Nombre de la Institución</th>
							<th>Nombre del grupo</th>
							<th>Número de estudaintes</th>
							<th>mediador</th>
							<th>Docente</th>
							<th>Jornada</th>
							<th>Fecha de creación</th>
							<th>Estado</th>
							<th>Observación</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

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

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-registrar-estudiante">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>REGISTRO DE ESTUDIANTES</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-nuevo-estudiante">
						@include('Gestion_Grupos.form_registrar_estudiante')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-estudiante">Cerrar</button>
					<button type="submit" class="btn btn-primary">Registrar Estudiante</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-inactivar-estudiante">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>INACTIVAR ESTUDIANTE</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-inactivar-estudiante">
						¿Esta seguro de inactivar el estudiante <strong><label id="lb-estudiante"></label></strong> del grupo <strong> <label id="lb-grupo"></label></strong>? <br> Por favor ingrese el motivo de retiro.<br>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 col-lg-12">
									<input class="form-control" type="text" id="observacion" required>
								</div>
							</div>
						</div>
						<input class="form-control" type="hidden" id="id-estudiante" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-inactivar-estudiante">Cerrar</button>
					<button type="submit" class="btn btn-primary">Inactivar Estudiante</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-activar-estudiante">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>ACTIVAR ESTUDIANTE</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-activar-estudiante">
						¿Esta seguro de activar nuevamente el estudiante <strong><label id="lb-estudiante"></label></strong> en el grupo <strong> <label id="lb-grupo"></label></strong>
						<input class="form-control" type="hidden" id="id-estudiante" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-activar-estudiante">Cerrar</button>
					<button type="submit" class="btn btn-primary">Activar Estudiante</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-inactivar-grupo">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>INACTIVAR GRUPO</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-inactivar-grupo">
						¿Esta seguro de inactivar el grupo <strong><label id="lb-grupo-inactivar"></label></strong>?, por favor ingrese el motivo de la inactivación.<br><br>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 col-lg-12">
									<input class="form-control" type="text" id="observacion-grupo" required>
								</div>
							</div>
						</div>
						<input class="form-control" type="hidden" id="id-grupo" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-inactivar-grupo">Cerrar</button>
					<button type="submit" class="btn btn-primary">Inactivar Grupo</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	@endauth
</div>
@endsection