@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/caracterizacion/caracterizacion.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Caracterización de estudiantes</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion_usuario">Información beneficiarios</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="creacion_usuario"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<div id="mapdiv" style="width: 100%; height: 500px;"></div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
						</script>
						<div id="chartdiv"></div>   
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-colegios-estudiantes">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-colegios-estudiantes"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table id="tabla-colegios-estudiantes" class="table table-hover table-striped table-bordered display" style="width: 100%;">
					<thead>
						<tr>
							<th>Colegio</th>
							<th>Estudiantes atendidos</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-grupos-estudiantes">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-grupos-estudiantes"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table id="tabla-grupos-estudiantes" class="table table-hover table-striped table-bordered display" style="width: 100%;">
					<thead>
						<tr>
							<th>Grupo</th>
							<th>Estudiantes atendidos</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-estudiantes">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-estudiantes"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table id="tabla-estudiantes" class="table table-hover table-striped table-bordered display" style="width: 100%;">
					<thead>
						<tr>
							<th>Estudiante</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-estudiante">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-estudiante"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Número de documento</span>
							<input class="form-control" type="text" id="numero-documento" disabled>
						</div>
						<div class="col-lg-6">
							<span>Tipo de documento</span>
							<input class="form-control" type="text" id="tipo-documento" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Primer nombre</span>
							<input class="form-control" type="text" id="primer-nombre" disabled>
						</div>
						<div class="col-lg-6">
							<span>Segundo nombre</span>
							<input class="form-control" type="text" id="segundo-nombre" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Primer apellido</span>
							<input class="form-control" type="text" id="primer-apellido" disabled>
						</div>
						<div class="col-lg-6">
							<span>Segundo apellido</span>
							<input class="form-control" type="text" id="segundo-apellido" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Fecha de nacimiento</span>
							<input class="form-control" type="text" id="fecha-nacimiento" disabled>
						</div>
						<div class="col-lg-6">
							<span>Género</span>
							<input class="form-control" type="text" id="genero" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Estrato</span>
							<input class="form-control" type="text" id="estrato" disabled>
						</div>
						<div class="col-lg-6">
							<span>Enfoque</span>
							<input class="form-control" type="text" id="enfoque" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<span>Correo</span>
							<input class="form-control" type="text" id="correo" disabled>
						</div>
						<div class="col-lg-6">
							<span>Celular</span>
							<input class="form-control" type="text" id="celular" disabled>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<span>Dirección</span>
							<input class="form-control" type="text" id="direccion" disabled>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
@endsection