@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/reportes/reportes.js') }}" defer></script>
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
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#reporte_consolidado">Reporte consolidado</a></li>
			<!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_usuario">Consultar y edición de usuarios</a></li> -->
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="reporte_consolidado"><br>
				<form id="form-reporte-consolidado">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<select class="form-control selectpicker" title="Seleccione un mes" id="mes-reporte-consolidado" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<button class="btn btn-block btn-primary" type="submit">Consultar</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<table id="tabla-reporte-consolidado" class="table display" style="width: 100%;">
								<thead>
									<tr>
										<th>CODIGO_DANE</th>
										<th>NUMERO LOCALIDAD</th>
										<th>NOMBRE LOCALIDAD</th>
										<th>INSTITUCION EDUCATIVA</th>
										<th>SEDE</th>
										<th>JORNADA</th>
										<th>GRADO</th>
										<th>PRIMER_APELLIDO</th>
										<th>SEGUNDO_APELLIDO</th>
										<th>PRIMER_NOMBRE</th>
										<th>SEGUNDO_NOMBRE</th>
										<th>TIPO_IDENTIFICACION</th>
										<th>NUM_DOC</th>
										<th>SIMAT</th>
										<th>GENERO</th>
										<th>FECHA NACIMIENTO</th>
										<th>ETNIA</th>
										<th>POBLACION_VICTIMA</th>
										<th>CONDICION_DISCAPACIDAD</th>
										<th>FECHA_IMPACTO</th>
										<th>HORA_INICIAL</th>
										<th>HORA_FINAL</th>
										<th>ASISTENCIA_(SI/NO)</th>
										<th>LINEA_PEDAGÓGICA</th>
										<th>CENTRO_INTERÉS</th>
										<th>ACTIVIDAD</th>
										<th>ESCENARIO</th>
										<th>DETALLE ESCENARIO</th>
										<th>ENTIDAD_ARCHIVO</th>
										<th>CONVENIO</th>
										<th>TIPO_DOCUMENTO_FORMADOR</th>
										<th>NO_DOCUMENTO_FORMADOR</th>
										<th>GRUPO</th>
										<th>NOVEDAD DE REPORTE</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="tab-pane" id="consulta_usuario" role="tabpanel"><br>
				<div class="card">
					<div class="card-header bg-primary text-white">Información de escenarios creados</div>
				</div>
			</div> -->
		</div>
	</div>
</div>
@endsection