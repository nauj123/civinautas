@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/Gestion_Colegios/colegios.js?v=2021.01.13.4') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Gestión de instituciones educativas</h1>
</div>
<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#gestion_instituciones">Instituciones</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="gestion_instituciones"><br>
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
					<button class="btn btn-block btn-success" id="btn-crear-institucion" data-toggle='modal' data-target='#modal-crear-institucion'>Crear institución educativa</button>
					</div>
				</div>
				<table class="display table table-striped table-bordered" id="tabla-info-instituciones" style="width: 100%;">
					<thead>
						<tr style="text-align: center;">
							<th>Localdiad</th>
							<th>Upz</th>
							<th>Tipo de institución</th>							
							<th>Nombre institución</th>
							<th>Código DANE</th>
							<th>N° de sedes</th>							
							<th>Actualizar</th>
							<th>Inactivar</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-crear-institucion">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>REGISTRAR NUEVA INSTITUCIÓN EDUCATIVA</strong></h3>
					</div>
					<div class="modal-body">
						<form id="form-nueva-institucion">
							@include('Gestion_Colegios.form_colegio')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-institucion">Cerrar</button>
						<button type="submit" class="btn btn-primary">Crear Institucion</button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-actualizar-institucion">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>ACTUALIZAR INFORMACIÓN DE LA INSTITUCIÓN EDUCATIVA</strong></h3>
					</div>
					<div class="modal-body">
						<form id="form-editar-institucion">
							@include('Gestion_Colegios.edit_colegio')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-actualizar-institucion">Cerrar</button>
						<button type="submit" class="btn btn-primary">Actualizar Institucion</button>
					</div>
					</form>
				</div>
			</div>
		</div>	

	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-inactivar-institucion">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>INACTIVAR INSTITUCIÓN EDUCATIVA</strong></h3>
				</div>
				<div class="modal-body">
					<form id="form-inactivar-institucion">
						¿Esta seguro de inactivar la institución educativa <strong><label id="lb-institucion-inactivar"></label></strong>?, por favor ingrese el motivo de la inactivación.<br><br>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 col-lg-12">
									<input class="form-control" type="text" id="observacion-usuario" required>
								</div>
							</div>
						</div>
						<input class="form-control" type="hidden" id="id-institucion" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-inactivar-institucion">Cerrar</button>
					<button type="submit" class="btn btn-primary">Inactivar Instituciones</button>
				</div>
				</form>
			</div>
		</div>
	</div>	

	</div>
</div>
@endsection