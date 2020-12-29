<input type="hidden" id="id-institucion-m">
<div class="form-group">
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6 offset-lg-3">
			<span>Tipo de institución </span>
			<select class="form-control selectpicker" id="tipo-institucion-m" title="Seleccione una opción" required>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6">
			Localidad:<span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="localidad-m" title="Seleccione una opción" required>
			</select>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Upz:
			<select class="form-control selectpicker" id="upz-m" title="Seleccione una opción">
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6">
			Nombre Institución<span class="rojo">(*)</span>
			<input class="form-control" type="text" id="nombre-institucion-m" required>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Código DANE 11
			<input class="form-control" type="text" id="codigo-dane-m">
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
	<div class="col-xs-6 col-md-6 col-lg-6">
		Iniciales Institucion<span class="rojo">(*)</span>
		<input class="form-control" type="text" id="iniciales-institucion-m">
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Sedes:
			<select class="form-control sedes" title="Seleccione una opción" id="Numero-sedes-m" required>
				<option value="1">Sede Unica</option>
				<option value="2">2 sedes</option>
				<option value="3">3 sedes</option>
				<option value="4">4 sedes</option>
				<option value="5">5 sedes</option>
				<option value="6">6 sedes</option>
				<option value="7">7 sedes</option>
			</select>
		</div>		
	</div>
</div>
<div class="form-group">
	<div id="registrar_sedes_m">
	</div>	
</div>