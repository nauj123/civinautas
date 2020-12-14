@extends("theme.layout")
@section('js-import')
<script src="../../node_modules/xlsx/dist/xlsx.full.min.js"></script>
<script src="{{ asset('js/Gestion_Simat/simat.js') }}" defer></script>
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
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_colegios">Consultar estudiantes SIMAT</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="cargar_simat"><br>

				<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Cargar beneficiarios SIMAT</div>
					<div class="card-body">
						<form id="form-cargar-simat">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Mes simat</span>
										<select class="form-control selectpicker" title="Seleccione una opción" id="mes-simat" required></select>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Institución educativa</span>
										<select class="form-control selectpicker" title="Seleccione una opción" id="institucion" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-12 col-lg-12">
										<span>Cargar archivo</span>
										<input class="form-control" type="file" id="archivo-simat" required>
									</div>
								</div>
							</div>
							<pre id="result"></pre>
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
				<div class="form-group">
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
							<span>Seleccione colegio</span>
							<select class="form-control selectpicker" title="Seleccione una opción" id="consulta-simat-colegio" required></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
							<table class="table">
								<thead>
									<tr>
										<th>1</th>
										<th>2</th>
										<th>3</th>
										<th>4</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>2</td>
										<td>3</td>
										<td>4</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection