@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js?v=2021.01.13.9') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Administración del Sistema </h1>
</div><br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion_usuario">Administración de usuarios</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#administracion_parametros">Administración parametros</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="creacion_usuario"><br>
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<button class="btn btn-block btn-success" id="btn-crear-usuario"  data-toggle='modal' data-target='#modal-registro-usuario'>Crear Usuario</button>
					</div>
				</div>
				<table id="tabla-info-usuarios" class="display table table-striped table-bordered" style="width:100%">
					<thead>
						<tr style="text-align: center;">
							<th style="width: 10%;">Identificación</th>
							<th style="width: 35%;">Nombre usuario</th>
							<th style="width: 15%;">Email</th>
							<th style="width: 15%;">Celular</th>
							<th style="width: 15%;">Rol</th>
							<th style="width: 10%;">Editar</th>
							<th style="width: 10%;">Estado</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="tab-pane col-lg-12" id="administracion_parametros"><br>
				<div class="col-lg-10 offset-lg-1 col-md-12 col-xs-12">
					<div class="card">
						<div class="card-header bg-primary text-white">Administración de parámetros</div>
						<div class="car-body"><br>
							<form id="form-nuevo-parametro-asociado">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-10 offset-lg-1">
											<label>Seleccione un párametro</label>
											<select class="form-control selectpicker" id="parametro" data-live-search="true" title="Seleccione una opción" required></select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-11 offset-lg-1 col-xs-11 offset-xs-1">
											<label>Nuevo párametro asociado</label>
										</div>
										<div class="col-lg-9 offset-lg-1 col-9">
											<input class="form-control" id="parametro-asociado" type="text" required>
										</div>
										<div class="col-lg-1 col-3">
											<button type="submit" class="btn btn-block btn-primary"><i class="fas fa-plus-circle"></i></button>
										</div>
									</div>
								</div>
							</form>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-10 offset-lg-1">
										<table class="table" id="tabla_parametros_asociados">
											<thead>
												<tr>
													<th>Descripción</th>
													<th>Modificar</th>
													<th>Estado</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-registro-usuario">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel"><label>REGISTRAR NUEVO USUARIO</label></h4>
				</div>
				<div class="modal-body">
					<form id="form-nuevo-usuario">
						@include('usuarios.form_usuario')
					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-registrar-usuario">Cerrar</button>
						<button type="submit" class="btn btn-primary">Crear usuario</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-editar-usuario">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel"><label>EDITAR INFORMACIÓN DEL USUARIO</label></h4>
				</div>
				<div class="modal-body">
					<form id="form-actualizar-usuario">
						@include('usuarios.editar_usuario')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-editar-usuario">Cerrar</button>
						<button type="submit" class="btn btn-primary">Modificar Información</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-inactivar-usuario">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>INACTIVAR USUARIO DEL SISTEMA</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-inactivar-usuario">
						¿Esta seguro de inactivar el usuario <strong><label id="lb-usuario-inactivar"></label></strong>?, por favor ingrese el motivo de la inactivación.<br><br>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 col-lg-12">
									<input class="form-control" type="text" id="observacion-usuario" required>
								</div>
							</div>
						</div>
						<input class="form-control" type="hidden" id="id-usuario" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-inactivar-usuario">Cerrar</button>
					<button type="submit" class="btn btn-primary">Inactivar Usuario</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-activar-usuario">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>ACTIVAR USUARIO DEL SISTEMA</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-activar-usuario">
						¿Esta seguro de activar nuevamente el usuario <strong><label id="lb-usuario-activar"></label></strong> para que pueda acceder a la plataforma?.
						<input class="form-control" type="hidden" id="id-usuario-activar" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-activar-usuario">Cerrar</button>
					<button type="submit" class="btn btn-primary">Activar Usuario</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection