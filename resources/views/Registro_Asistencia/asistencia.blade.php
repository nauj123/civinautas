@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Registro_Asistencia/asistencia.js?V=2021.01.11.14') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Registro de actividades</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#registro_asistencia">Registro de asistencia</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consolidado_mensual_asistencias">Consolidado mensual asistencias</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_asistencias">Consultar asistencias registradas</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="registro_asistencia">
				<form id="form-guardar-actividad">
					<table id="informacion-atencion" style="width: 100%; border-color: #663399;" border="2">
						<tr style="text-align: center; background: #EBEDEF">
							<td style="width: 25%; height: 30px"><strong>Grupo</strong></td>
							<td style="width: 25%;"><strong>Fecha atención </strong></td>
							<td style="width: 25%;" colspan="2"><strong>Horario atención</strong></td>
						</tr>
						<tr>
							<td><select class="form-control selectpicker" id="grupo-mediador" title="Seleccione una opción" required></td>
							<td><input class="form-control" type="date" id="fecha-atencion" required></td>
							<td><input class="form-control" type="time" id="hora-inicio" required></td>
							<td><input class="form-control" type="time" id="hora-fin" required></td>

						</tr>
						<tr style="text-align: center; background: #EBEDEF">
							<td style="height: 30px"><strong>Modalidad de la actividad</strong></td>
							<td><strong>Tipo de actividad realizada</strong></td>
							<td colspan="2"><strong>Recursos de apoyo o materiales dispuestos</strong></td>
						</tr>
						<tr>
							<td><select class="form-control selectpicker" id="modalidad-actividad" title="Seleccione una opción" required></td>
							<td><select class="form-control selectpicker" id="tipo-actividad" title="Seleccione una opción" required></td>
							<td colspan="2"><select class="form-control selectpicker" multiple data-actions-box="true" id="recursos-materiales" title="Seleccion multiple" required></td>

						</tr>
						<tr style="text-align: center;">
							<td style="width: 25%; height: 30px"><strong>Tema desarrollado durante la actividad:</strong></td>
							<td style="width: 75%;" colspan="4"><textarea style="width: 100%;" id="tema-actividad"></textarea></td>
						</tr>
					</table><br>

					<div id="div_estudiantes_grupo" style="display: none;">
						<div class="p-2 rounded d-flex align-items-center bg-default text-white">
							<h3 class="text-16 mb-1 text-white">Estudiantes que ya estan en el grupo</h3>
						</div><br>
						<table class="table display" id="tabla-estudiantes-grupo" style="width: 100%;">
							<thead>
								<tr>
									<th>N°</th>
									<th>Nombre Estudiante</th>
									<th>Identificación</th>
									<th>Ciclo Vital</th>
									<th>Genero</th>
									<th>Asistencia</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<button type="submit" class="btn btn-success">Registrar actividad</button>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="tab-pane" id="consulta_asistencias" role="tabpanel"><br>
				<div class="form-group">
					<div class="row mb-3">
						<div class="col-xs-6 col-md-4 col-lg-4 offset-md-2 offset-lg-2">
							<span><strong>Seleccionar Grupo</strong></span>
							<select class="form-control selectpicker" id="consultar-grupo" title="Seleccione una opción" required></select>
						</div>
						<div class="col-xs-6 col-md-4 col-lg-4">
							<span><strong>Seleccionar actividad</strong></span>
							<select class="form-control selectpicker" id="consultar-actividad" title="Seleccione una opción" required></select>
						</div>
					</div>
				</div>
				<div id="div_consulta_atencion" style="display: none;">
					<table id="informacion-atencion" style="width: 100%; border-color: #663399;" border="2">
						<tr style="text-align: center; background: #EBEDEF">
							<td style="width: 25%; height: 30px"><strong>Grupo</strong></td>
							<td style="width: 25%;"><strong>Fecha atención </strong></td>
							<td style="width: 25%;"><strong>Horario atención</strong></td>
						</tr>
						<tr style="text-align: center">
							<td><label id="lb-grupo"></label></td>
							<td><label id="lb-fecha"></label></td>
							<td><label id="lb-horario"></label></td>
						</tr>
						<tr style="text-align: center; background: #EBEDEF">
							<td style="height: 30px"><strong>Modalidad de la actividad</strong></td>
							<td><strong>Tipo de actividad realizada</strong></td>
							<td><strong>Recursos de apoyo o materiales dispuestos</strong></td>
						</tr>
						<tr style="text-align: center">
							<td><label id="lb-modalidad"></label></td>
							<td><label id="lb-actividad"></label></td>
							<td><label id="lb-recursos"></label></td>
						</tr>
						<tr style="text-align: center;">
							<td style="width: 25%; height: 30px"><strong>Tema desarrollado durante la actividad:</strong></td>
							<td style="width: 75%;" colspan="3"><label id="lb-tematica"></label></td>
						</tr>
					</table><br>

					<table class="table display" id="tabla-asistencia-estudiante" style="width: 100%;">
						<thead>
							<tr style="text-align: center;">
								<th>N°</th>
								<th>Identificación</th>
								<th>Nombre Estudiante</th>
								<th>Genero</th>
								<th>Ciclo Vital</th>
								<th>Asistencia</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="consolidado_mensual_asistencias" role="tabpanel"><br>
				<div class="form-group">
					<div class="row mb-3">
						<div class="col-xs-6 col-md-4 col-lg-4 offset-md-2 offset-lg-2">
							<span><strong>Seleccionar Grupo</strong></span>
							<select class="form-control selectpicker" id="consultar_grupo_mensual"></select>
							<span class="help-block" id="error"></span>
						</div>
						<div class="col-xs-6 col-md-4 col-lg-4">
							<span><strong>Seleccione Mes</strong></span>
							<select class="form-control selectpicker" id="mes_reporte">
								<option value="2021-01">Enero</option>
								<option value="2021-02">Febrero</option>
								<option value="2021-03">Marzo</option>
								<option value="2021-04">Abril</option>
								<option value="2021-05">Mayo</option>
								<option value="2021-06">Junio</option>
								<option value="2021-07">Julio</option>
								<option value="2020-08">Agosto</option>
								<option value="2020-09">Septiembre</option>
								<option value="2020-10">Octubre</option>
								<option value="2020-11">Noviembre</option>
								<option value="2020-12">Diciembre</option>
							</select>
							<span class="help-block" id="error"></span>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-xs-6 col-md-4 col-lg-4 offset-md-4 offset-lg-4">
							<button class="btn btn-block btn-success" id="btn-consultar-asistencias">Consultar asistencias</button>
						</div>
					</div>
				</div>
				<div id="div_table_asistencia"></div>
			</div>
		</div>
	</div>

</div>
@endsection