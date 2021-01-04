@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/reportes/reportes.js?v=2021.01.4.2') }}" defer></script>
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
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#reporte_consolidado">Reporte mesa intersectorial</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado-mensual-ciclo-vital">Consolidado mensual ciclo vital</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado-global-ciclo-vital">Consolidado global ciclo vital</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-completa-asistencias">Consulta completa asistencias</a></li>
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
			<div class="tab-pane" id="consolidado-mensual-ciclo-vital" role="tabpanel"><br>
				<form id="form-consolidado-mensual-ciclo-vital">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<select class="form-control selectpicker" title="Seleccione un mes" id="mes-reporte-consolidado-mensual-ciclo-vital" required></select>
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
							<table id="tabla-reporte-consolidado-mensual-ciclo-vital" class="table table-hover table-bordered display" style="width: 100%;">
								<thead>
									<tr>
										<th rowspan="2">Colegio</th>
										<th rowspan="2">Localidad</th>
										<th colspan="2">Primera Infancia (0 - 6 años)</th>
										<th colspan="2">Infancia (7 a 13 años)</th>
										<th colspan="2">Adolescencia (14 -17 años)</th>
										<th colspan="2">Juventud (18 -26 años)</th>
										<th colspan="2">Adultez (27 - 59 años)</th>
										<th colspan="2">Adulto Mayor (Más de 60 años)</th>
										<th colspan="2">Subtotal</th>
										<th rowspan="2">Total asistentes</th>
									</tr>
									<tr>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="consolidado-global-ciclo-vital" role="tabpanel"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<table id="tabla-reporte-consolidado-global-ciclo-vital" class="table table-hover table-bordered display" style="width: 100%;">
								<thead>
									<tr>
										<th rowspan="2">Colegio</th>
										<th rowspan="2">Localidad</th>
										<th colspan="2">Primera Infancia (0 - 6 años)</th>
										<th colspan="2">Infancia (7 a 13 años)</th>
										<th colspan="2">Adolescencia (14 -17 años)</th>
										<th colspan="2">Juventud (18 -26 años)</th>
										<th colspan="2">Adultez (27 - 59 años)</th>
										<th colspan="2">Adulto Mayor (Más de 60 años)</th>
										<th colspan="2">Subtotal</th>
										<th rowspan="2">Total asistentes</th>
									</tr>
									<tr>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
										<th>Hombres</th>
										<th>Mujeres</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="tab-pane" id="consulta-completa-asistencias" role="tabpanel"><br>
			<div class="p-2 rounded d-flex align-items-center bg-success text-white">
					<h3 class="text-18 mb-1 text-white">Consulta completa de registros de asistencia CIVINAUTAS </h3>
				</div><br>
				<table class="display table table-striped table-bordered" id="tabla-consultar-grupos">
					<thead>
						<tr>
						<th>Localidad</th>
						<th>Tipo Institución</th>
						<th>Nombre Institución</th>
						<th>DANE</th>
						<th>Nombre Grupo</th>
						<th>Mediador</th>
						<th>Fecha Atención</th>
						<th>Horario</th>
						<th>Modalidad</th>
						<th>Tipo actividad</th>
						<th>Recursos</th>
						<th>Identificación</th>
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>Dirección</th>
						<th>Correo</th>
						<th>Celular</th>
						<th>Enfoque</th>
						<th>Esthato</th>
						<th>Fecha de Nacimiento</th>
						<th>Genero</th>
						<th>Asistencia</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

		</div>
	</div>
</div>
@endsection