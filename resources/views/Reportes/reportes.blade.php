@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
		<h1 class="text-28 mb-1 text-white">Gestión de Usuarios</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion_usuario">Creación de usuario</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_usuario">Consultar y edición de usuarios</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="creacion_usuario"><br>
				<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-primary text-white">Creación de usuario</div>
					<div class="card-body">
						<form id="form-nuevo-usuario">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-3 col-md-6 offset-md-3 col-lg-6 offset-lg-3">
										<label>Tipo de usuario</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="rol" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										<label>Tipo de documento</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="tipo-documento" required></select>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										<label>Número de documento</label>
										<input class="form-control" type="text" id="documento" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Pimer nombre</label>
										<input class="form-control" type="text" id="primer_nombre" required>
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Segundo nombre</label>
										<input class="form-control" type="text" id="segundo_nombre">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Primer apellido</label>
										<input class="form-control" type="text" id="primer_apellido" required>
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Segundo apellido</label>
										<input class="form-control" type="text" id="segundo_apellido">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Departamento</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="departamento" required></select>
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Municipio</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="municipio" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Dirección</label>
										<input class="form-control" type="text" id="direccion" required>
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Barrio</label>
										<input class="form-control" type="text" id="barrio" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Email</label>
										<input class="form-control" type="email" id="email" required>
									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<label>Celular</label>
										<input class="form-control" type="text" id="celular" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4 offset-lg-4">
									<button class="btn btn-block btn-primary" type="submit">Crear usuario</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="consulta_usuario" role="tabpanel"><br>
				<div class="card">
					<div class="card-header bg-primary text-white">Información de escenarios creados</div>
				</div>
				<br>
				<table class="table display" id="tabla-info-usuarios" style="width: 100%;">
					<thead>
						<tr>
							<th>Identificación</th>
							<th>Tipo de identificación</th>
							<th>Nombre usuario</th>
							<th>Departamento</th>
							<th>Municipio</th>
							<th>Dirección</th>
							<th>Barrio</th>
							<th>Email</th>
							<th>Celular</th>
							<th>Rol</th>
							<th>Editar</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-editar-usuario">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
				</div>
				<div class="modal-body">
					<form id="form-actualizar-usuario">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-3 col-md-6 offset-md-3  col-lg-6 offset-lg-3">
									<label>Tipo de usuario</label>
									<select class="form-control selectpicker" title="Seleccione una opción" id="rol-m" required></select>
								</div>
							</div>
						</div>
						@include('usuarios.form_editar_usuario')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Actualizar</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection