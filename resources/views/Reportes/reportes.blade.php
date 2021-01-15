@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/reportes/reportes.js?v=2021.01.14.2') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Reportes y consultas</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#reporte_consolidado">Reporte mesa intersectorial</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado-mensual-ciclo-vital">Consolidado mensual ciclo vital</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado-global-ciclo-vital">Consolidado global ciclo vital</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-completa-asistencias">Consulta completa asistencias</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reporte-cualitativo">Reporte Cualitativo</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="reporte_consolidado"><br>
				<form id="form-reporte-consolidado">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<select class="form-control selectpicker" title="Seleccione un mes" id="mes-reporte-consolidado" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<button class="btn btn-block btn-primary" type="submit">Consultar</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group" id="div-tabla-reporte-consolidado" style="display: none;">
					<div class="row">
						<div class="col-lg-12">
							<table id="tabla-reporte-consolidado" class="table table-hover table-striped table-bordered display" style="width: 100%;">
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
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<select class="form-control selectpicker" title="Seleccione un mes" id="mes-reporte-consolidado-mensual-ciclo-vital" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<button class="btn btn-block btn-primary" type="submit">Consultar</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group" id="div-tabla-reporte-consolidado-mensual-ciclo-vital" style="display: none;">  
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table id="tabla-reporte-consolidado-mensual-ciclo-vital" class="table table-hover table-striped table-bordered display" style="width: 100%;">
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
			</div>
			<div class="tab-pane" id="consolidado-global-ciclo-vital" role="tabpanel"><br>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table id="tabla-reporte-consolidado-global-ciclo-vital" class="table table-hover table-striped table-bordered display" style="width: 100%;">
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
			</div>
			<div class="tab-pane" id="consulta-completa-asistencias" role="tabpanel"><br>
				<form id="form-reporte-asistencias">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<select class="form-control selectpicker" title="Seleccione un año" id="mes-reporte-asistencias" required>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<button class="btn btn-block btn-primary" type="submit">Consultar</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group" id="div-tabla-reporte-asistencias" style="display: none;">
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-striped table-bordered display" id="tabla-reporte-asistencias" style="width: 100%;">
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
										<th>Estrato</th>
										<th>Fecha de Nacimiento</th>
										<th>Género</th>
										<th>Asistencia</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane" id="reporte-cualitativo" role="tabpanel"><br>
				<form id="form-reporte-cualitativo">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<select class="form-control selectpicker" title="Seleccione un mes" id="mes-reporte-cualitativo" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3 offset-md-3">
								<button class="btn btn-block btn-primary" type="submit">Consultar</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group" id="div-tabla-reporte-cualitativo" style="display: none;">
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-striped table-bordered display" id="tabla-reporte-cualitativo" style="width: 100%;">
								<thead>
									<tr style="text-align: center;">
										<th>FECHA</th>
										<th>ACTIVIDAD</th>
										<th>DETALLE</th>
										<th>ENTIDAD</th>
										<th>GRUPO</th>
										<th>MEDIADOR</th>
										<th>ASISTENTES</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
@endsection