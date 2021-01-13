@extends("theme.layout")
@section('js-import')
<script src="../../node_modules/xlsx/dist/xlsx.full.min.js"></script>
<script src="{{ asset('js/Gestion_Simat/simat.js?v=2021.01.13.1') }}" defer></script>
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
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cargar-simat">Cargar BD SIMAT</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-simat">Consultar SIMAT</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-colegios">Consultar estudiantes SIMAT</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificar-estudiante">Modificar estudiante</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="cargar-simat"><br>

				<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Cargar beneficiarios SIMAT</div>
					<div class="card-body">
						<form id="form-cargar-simat">
							<div class="p-3 mb-2 bg-warning text-dark">
								<strong>Recuerde que: </strong><br>
								Puede descargar la plantilla de cargue haciendo clic <a href="{{ asset('plantilla_simat.xlsx') }}">aquí.</a><br>
								No elimine ni agregue columnas a la plantilla.<br>
								Verifique que las fechas de nacimiento cumplan el siguiente formato DD/MM/YYYY.
							</div>
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
			<div class="tab-pane" id="consulta-simat" role="tabpanel"><br>
				<form id="form-archivos-simat">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<span>Seleccione un mes</span>
								<select class="form-control selectpicker" title="Seleccione una opción" id="mes-consulta-archivos-simat" required></select>
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
				<div id="div-consulta-archivos-simat" style="display: none;">
					<table class="display table table-striped table-bordered" id="tabla-consulta-archivos-simat" style="width: 100%;">
						<thead>
							<tr>
								<th>Mes de la información</th>
								<th>Fecha de subida</th>
								<th>Colegio</th>
								<th>Total de estudiantes</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="consulta-colegios" role="tabpanel"><br>
				<form id="form-estudiantes-colegio-simat">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-lg-6 offset-lg-3">
								<span>Seleccione colegio</span>
								<select class="form-control selectpicker" title="Seleccione una opción" id="consulta-estudiantes-colegio-simat" required></select>
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
				<div id="div-consulta-estudiantes-colegio-simat" style="display: none;">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-md-12 col-lg-12">
								<table id="tabla-estudiantes-colegio-simat" class="table display" style="width: 100%;">
									<thead>
										<tr>
											<th>ANO_INF</th>
											<th>MES_INF</th>
											<th>NRO_DOCUMENTO</th>
											<th>APELLIDO1</th>
											<th>APELLIDO2</th>
											<th>NOMBRE1</th>
											<th>NOMBRE2</th>
											<th>FECHA_NACIMIENTO</th>
											<th>GENERO</th>
											<th>DIRECCION_RESIDENCIA</th>
											<th>TEL</th>
											<th>MUN_CODIGO</th>
											<th>CODIGO_DANE</th>
											<th>DANE_ANTERIOR</th>
											<th>CONS_SEDE</th>
											<th>TIPO_DOCUMENTO</th>
											<th>EXP_DEPTO</th>
											<th>EXP_MUN</th>
											<th>RES_DEPTO</th>
											<th>RES_MUN</th>
											<th>ESTRATO</th>
											<th>SISBEN</th>
											<th>NAC_DEPTO</th>
											<th>NAC_MUN</th>
											<th>POB_VICT_CONF</th>
											<th>DPTO_EXP</th>
											<th>MUN_EXP</th>
											<th>PROVIENE_SECTOR_PRIV</th>
											<th>PROVIENE_OTR_MUN</th>
											<th>TIPO_DISCAPACIDAD</th>
											<th>CAP_EXC</th>
											<th>ETNIA</th>
											<th>RES</th>
											<th>INS_FAMILIAR</th>
											<th>TIPO_JORNADA</th>
											<th>CARACTER</th>
											<th>ESPECIALIDAD</th>
											<th>GRADO</th>
											<th>GRUPO</th>
											<th>METODOLOGIA</th>
											<th>MATRICULA_CONTRATADA</th>
											<th>REPITENTE</th>
											<th>NUEVO</th>
											<th>SIT_ACAD_ANO_ANT</th>
											<th>CON_ALUM_ANO_ANT</th>
											<th>FUE_RECU</th>
											<th>ZON_ALU</th>
											<th>CAB_FAMILIA</th>
											<th>BEN_MAD_FLIA</th>
											<th>BEN_VET_FP</th>
											<th>BEN_HER_NAC</th>
											<th>CODIGO_INTERNADO</th>
											<th>CODIGO_VALORACION_1</th>
											<th>CODIGO_VALORACION_2</th>
											<th>NUM_CONVENIO</th>
											<th>PER_ID</th>
											<th>CODIGO_ESTABLECIMIENTO_EDUCATIVO</th>
											<th>NOMBRE_ESTABLECIMIENTO_EDUCATIVO</th>
											<th>NOM_GRADO</th>
											<th>PAIS_ORIGEN</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="modificar-estudiante" role="tabpanel"><br>
				<div class="p-3 mb-2 bg-warning text-dark">
					<strong>Recuerde que: </strong>Puede buscar a un estudiante por el número de documento, por los nombres o por los apellidos.
				</div>						
				<form id="form-buscar-estudiante">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="busqueda-estudiante" placeholder="Número de documento, nombres o apellidos">
							<div class="input-group-append">
								<button class="btn btn-primary" type="submit" id="btn-busqueda"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group" id="div-resultados-busqueda" style="display: none;">
					<div class="row">
						<div class="col-lg-12">
							<table class="table display" id="tabla-resultados-busqueda" style="width: 100%;">
								<thead>
									<tr>
										<th>Número de documento</th>
										<th>Nombre</th>
										<th>Mofificar</th>
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
<!-- Modal modificación estudiante simat -->
<div class="modal fade" id="modal-modificar-info-estudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form id="form-modificar-estudiante-simat">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modificar información estudiante simat</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-lg-6">
								<span>Tipo de documento</span>
								<select class="form-control" id="tipo-documento">
									<option value="1">CC:CÉDULA DE CIUDADANÍA</option>
									<option value="2">TI:TARJETA DE IDENTIDAD</option>
									<option value="3">CE:CÉDULA DE EXTRANJERÍA</option>
									<option value="5">RC:REGISTRO CIVIL DE NACIMIENTO</option>
									<option value="6">NIP:NÚMERO DE IDENTIFICACIÓN PERSONAL</option>
									<option value="7">NUIP:NÚMERO UNICO DE IDENTIFICACIÓN PERSONAL</option>
									<option value="8">NES:NÚMERO ESTABLECIDO POR LA SECRETARÍA</option>
									<option value="9">CCB:CERTIFICADO CABILDO</option>
									<option value="10">PEP:PERMISO ESPECIAL DE PERMANENCIA</option>
									<option value="11">VISA</option>
									<option value="12">TMF: TARJETA DE MOVILIDAD FRONTERIZA</option>
								</select>
							</div>
							<div class="col-lg-6">
								<span>Número de documento</span>
								<input class="form-control" type="text" id="numero-documento">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-6">
								<span>Primer nombre</span>
								<input class="form-control" type="text" id="primer-nombre">
							</div>
							<div class="col-lg-6">
								<span>Segundo nombre</span>
								<input class="form-control" type="text" id="segundo-nombre">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-6">
								<span>Primer apellido</span>
								<input class="form-control" type="text" id="primer-apellido">
							</div>
							<div class="col-lg-6">
								<span>Segundo apellido</span>
								<input class="form-control" type="text" id="segundo-apellido">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-6">
								<span>Fecha de nacimiento</span>
								<input class="form-control" type="date" id="fecha-nacimiento">
							</div>
							<div class="col-lg-6">
								<span>Género</span>
								<select class="form-control selectpicker" title="Seleccione una opción" id="genero">
									<option value="M">Masculino</option>
									<option value="F">Femenino</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-lg-6">
								<span>Dirección de residencia</span>
								<input class="form-control" type="text" id="direccion">
							</div>
							<div class="col-lg-6">
								<span>Teléfono</span>
								<input class="form-control" type="number" id="telefono">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Fin modal -->
@endsection