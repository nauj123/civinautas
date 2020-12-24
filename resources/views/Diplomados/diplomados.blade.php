@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Diplomados/diplomados.js?v=2020.12.23.03') }}" defer></script>
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
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#grupos_mediador">Crear diplomado</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#agregar_estudiantes">Registrar asistencia diplomado</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="grupos_mediador"><br>
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<button class="btn btn-block btn-success" id="btn-crear-grupo" data-toggle='modal' data-target='#modal-crear-diplomado'>Crear diplomado</button>
					</div>
				</div>
				<table class="table display" id="tabla-info-diplomados" style="width: 100%;">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nombre diplomado</th>
							<th>Duración </th>
							<th>Tematica o descripción</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="tab-pane" id="agregar_estudiantes" role="tabpanel"><br>
				<div class="form-group">
					<div class="row mb-3">
						<div class="col-xs-6 col-md-2 col-lg-2">
							<span><strong>Seleccionar Diplomado</strong></span>
						</div>
						<div class="col-xs-6 col-md-4 col-lg-4">
							<select class="form-control selectpicker" id="diplomado-asistencia" title="Seleccione una opción" required></select>
						</div>
						<div class="col-xs-6 col-md-2 col-lg-2">
							<span><strong>Seleccionar fecha</strong></span>
						</div>
						<div class="col-xs-6 col-md-4 col-lg-4">
							<input class="form-control" type="date" id="fecha-asistencia" required>
						</div>
					</div>
				</div>
				<table class="table" style="width:100%" id="tabla_Titulos_Registro">
									<thead>
										<tr>
											<th style="width: 2%; vertical-align: middle;">#</th>
											<th style="width: 12%">Identificación</th>
											<th style="width: 12%">Nombres</th>
											<th style="width: 12%">Apellidos</th>
											<th style="width: 12%">Correo</th>
											<th style="width: 12%">Entidad</th>
											<th style="width: 12%">Rol</th>
											<th style="width: 12%">Localidad</th>
											<th style="width: 12%">Celular</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width: 2%; vertical-align: middle;">1</td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
											<td><input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1"></td>
										</tr>
									</tbody>
								</table>
								<a id="btn_Agregar" class="btn btn-primary " Title="Agregar" data-toggle='tooltip'  data-placement="right">Agregar</a>
								<a id="btn_Quitar"  class="btn btn-danger " Title="Quitar" data-toggle='tooltip'  data-placement="right">Quitar</a>


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


	@endauth
</div>
@endsection