@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Gestion_Grupos/grupos.js?v=2020.12.10.1') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Gestión de grupos</h1>
</div>
<br>
<div class="container-fluid">
@auth
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#creacion_usuario">Creación de grupos</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#agregar_estudiantes">Agregar estudiantes</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_grupos">Consulta de grupos</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#actualizar_informacion">Actualizar información</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-10 offset-lg-1" id="creacion_usuario"><br>

				<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Crear grupo</div>
					<div class="card-body">
						<form id="form-nuevo-grupo">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6  form-group mb-3">
										<span>Institucion</span> 
										<select class="form-control selectpicker" title="Seleccione una opción" id="institucion" required></select>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Nombre del grupo</span>
										<input type="text" class="form-control" id="nombre-grupo">
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Nombre mediador</span>
										<input type="text" class="form-control" value="{{ Auth::user()->primer_nombre }} {{ Auth::user()->segundo_nombre }} {{ Auth::user()->primer_apellido }}" id="mediador" readonly>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Nombre docente</span>
										<input class="form-control" type="text" id="docente" required>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Tipo de atención</span>
										<select class="form-control selectpicker" title="Seleccione una opción" id="tipo-atencion" required></select>
									</div>
									<div class="col-xs-12 col-md-6 col-lg-6">
										<span>Jornada</span>
										<select class="form-control selectpicker" title="Seleccione una opción" id="jornada" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-4 offset-lg-4"><br>
									<button class="btn btn-block btn-primary" type="submit">Registrar el grupo</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<div class="tab-pane  col-lg-10 offset-lg-1" id="agregar_estudiantes" role="tabpanel"><br>				
			
			<div class="card" id="nuevo-usuario-contenedor">
					<div class="card-header bg-dark text-white">Agregar beneficiarios al grupo</div>
					<div class="card-body">
						<form id="form-nuevo-usuario">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-3 col-lg-3 form-group mb-3">
										Seleccionar grupo								
									</div>
									<div class="col-xs-12 col-md-9 col-lg-9">
									<select class="form-control selectpicker" title="Seleccione una opción" id="entidad" required>
											<option>Option 1</option>
											<option>Option 1</option>
											<option>Option 1</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-3 col-lg-3 form-group mb-3">
										Buscar estudiante										
									</div>
									<div class="col-xs-12 col-md-9 col-lg-9">
									<div class="input-group">
							<input type="text" class="form-control" placeholder="Apellidos Nombres o Documento del usuario" id="TB_buscar_usuario">
							<button class="btn btn-info" id="BT_buscar"><i class="text-20 i-Search-on-Cloud"></i></button>
						</div>
									</div>
								</div>

														
								
							</div>							
						</form>
					</div>
				</div>
			
				<img src="../assets/images/beneficiarios.jpg" style="width: 100%; height: 400px"  alt="">

			</div>
			<div class="tab-pane" id="consulta_grupos" role="tabpanel"><br>
			<table class="table display" id="tabla-info-grupos" style="width: 100%;">
					<thead>
						<tr>
							<th>Localidad</th>
							<th>Entidad</th>
							<th>Grupo</th>
							<th>Mediador</th>
							<th>Docente</th>
							<th>N° de beneficiarios</th>							
						</tr>
					</thead>
					<tbody></tbody>
			</table>

			</div>

			<div class="tab-pane" id="actualizar_informacion" role="tabpanel"><br>

			</div>


		</div>
	</div>
@endauth
</div>
@endsection