@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Diplomados/diplomados.js?v=2021.01.17.8') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Registro de diplomados</h1>
</div>
<br>
<div class="container-fluid">
	@auth
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#crear_diplomado">Crear diplomado</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#registrar_asistencia">Registrar asistencia</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consultar_asistencia">Consultar asistencia</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="crear_diplomado"><br>
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<button class="btn btn-block btn-success" id="btn-crear-grupo" data-toggle='modal' data-target='#modal-crear-diplomado'>Crear diplomado</button>
					</div>
				</div>
				<table class="display table table-striped table-bordered" id="tabla-info-diplomados" style="width: 100%;">
					<thead>
						<tr style="text-align: center;">
							<th>No.</th>
							<th>Nombre diplomado</th>
							<th>Duración </th>
							<th>Tematica o descripción</th>
							<th>No. de participantes</th>
							<th>Agregar participantes</th>
							<th>Editar</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="tab-pane" id="registrar_asistencia" role="tabpanel"><br>
				<form id="form-asistencia-diplomado">
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4 offset-lg-4">
								<span>Seleccionar Diplomado:</span>
								<select class="form-control selectpicker" id="diplomado-asistencia" title="Seleccione una opción" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-4 offset-lg-4">
								<span>Seleccionar fecha:</span>
								<input class="form-control" type="date" id="fecha-asistencia" required>
							</div>
						</div>
					</div>
					<div id="div-participantes-asistencia-diplomado" style="display: none;">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12">
									<table class="display table table-striped table-bordered" style="width: 100%;" id="tabla-participantes-asistencia-diplomado">
										<thead>
											<tr style="text-align: center;">
												<th>Identificación</th>
												<th>Nombres</th>
												<th>Asistencia</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>		
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-4 offset-lg-4">
									<button type="submit" class="btn btn-block btn-primary">Registrar asistencia</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="tab-pane" id="consultar_asistencia" role="tabpanel"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4 offset-lg-4">
							<span>Seleccionar Diplomado:</span>
							<select class="form-control selectpicker" id="diplomado-consulta" title="Seleccione una opción" required></select>
						</div>
					</div>
				</div>
				<div id="div_table_asistencia"></div>				
			</div>			

		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-crear-diplomado">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>CREAR NUEVO DIPLOMADO</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-nuevo-diplomado">
						@include('Diplomados.form_diplomado')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-diplomado">Cerrar</button>
						<button type="submit" class="btn btn-primary">Crear Diplomado</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-editar-diplomado">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>EDITAR INFORMACIÓN DIPLOMADO</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-editar-diplomado">
						@include('Diplomados.edit_diplomado')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-edit-diplomado">Cerrar</button>
						<button type="submit" class="btn btn-primary">Editar Diplomado</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-registrar-participante">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>REGISTRAR PARTICIPANTE AL DIPLOMADO</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-participantes">
						@include('Diplomados.form_participante_diplomado')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-participante-diplomado">Cerrar</button>
						<button type="submit" class="btn btn-primary">Agregar participante</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-participantes-diplomado">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"><strong>Participantes registrados</strong></h3>
				</div>
				<div class="modal-body">
					<table class="display table table-striped table-bordered" style="width: 100%;" id="tabla-participantes-diplomado">
						<thead>
							<tr style="text-align: center;">
								<th>Identificación</th>
								<th>Nombre</th>
								<th>Correo</th>
								<th>Teléfono</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	@endauth
</div>
@endsection