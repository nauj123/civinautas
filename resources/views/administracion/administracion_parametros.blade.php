@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Administración del sistema</h1>
</div><br>
<div class="container-fluid">

	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#administracion_parametro">Administración de usuarios</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#disciplinas_deportivas">Administración de parametros</a></li>
		</ul>
		<div class="tab-content">

			<div class="tab-pane active col-lg-12" id="administracion_parametro"><br>
				<div class="col-lg-12 col-md-12 col-xs-12">
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

			<div class="tab-pane col-lg-12" id="disciplinas_deportivas"><br>
				<div class="col-lg-10 offset-lg-1 col-md-12 col-xs-12">
					<div class="card">
						<div class="card-header bg-primary text-white">Administrar disciplinas deportivas o categorias</div>
						<div class="car-body"><br>
							<form id="form-nueva-disciplina">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-10 offset-lg-1">
											<label>Seleccione un deporte</label>
											<select class="form-control selectpicker" id="deporte" data-live-search="true" title="Seleccione una opción" required></select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-11 offset-lg-1 col-xs-11 offset-xs-1">
											<label>Nueva disciplina o categoria</label>
										</div>
										<div class="col-lg-9 offset-lg-1 col-9">
											<input class="form-control" id="disciplina-asociada" type="text" required>
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
										<table class="table" id="tabla_disciplinas_deporte">
											<thead>
												<tr>
													<th>Disciplina deportiva / Categoria</th>
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
</div>
@endsection