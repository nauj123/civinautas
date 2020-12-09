@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Gestión SIMAT</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cargar_simat">Cargar BD SIMAT</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_simat">Consultar SIMAT</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_colegios">Consultar estudiantes SIMAT </a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="cargar_simat"><br>

				<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Cargar beneficiarios SIMAT</div>
					<div class="card-body">
						<form id="form-nuevo-usuario">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										Mes simat
										<select class="form-control selectpicker" title="Seleccione una opción" id="tipo-documento" required></select>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										Colegio
										<select class="form-control selectpicker" title="Seleccione una opción" id="colegio" required></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										Cargar archivo
										<input class="form-control" type="file" id="documento" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4 offset-lg-4"><br>
									<button class="btn btn-block btn-primary" type="submit">Subir Simat</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<div class="tab-pane" id="consulta_simat" role="tabpanel"><br>
				<table class="table display" id="tabla-info-usuarios" style="width: 100%;">
					<thead>
						<tr>
							<th>Mes de cargar</th>
							<th>Fecha de subida</th>
							<th>Número de colegios</th>
							<th>Número de beneficiarios</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="tab-pane" id="consulta_colegios" role="tabpanel"><br>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
						<label>Seleccione colegio</label>
						<select class="form-control selectpicker" title="Seleccione una opción" id="tipo-documento" required></select>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection