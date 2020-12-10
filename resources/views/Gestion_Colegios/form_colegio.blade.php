<div class="form-group"> 
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6 offset-lg-3">
			<span>Tipo de institución </span>
			<select class="form-control selectpicker" id="tipo-institucion" title="Seleccione una opción" required>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6">
			Localidad:<span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="localidad" title="Seleccione una opción" required>
			</select>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Upz:<span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="upz" title="Seleccione una opción" required>
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6">
			Nombre Institución<span class="rojo">(*)</span>
			<input class="form-control" type="text" id="nombre-institucion" required>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Código DANE 11
			<input class="form-control" type="text" id="codigo-dane">
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
	<div class="col-xs-6 col-md-6 col-lg-6">
		Iniciales Institucion<span class="rojo">(*)</span>
		<input class="form-control" type="text" id="iniciales-institucion">
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6">
			Sedes<span class="rojo">(*)</span>
			<select class="form-control select" title="Seleccione una opción" id="Numero-sedes" required>
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
	<div id="registrar_sedes">
	</div>	
</div>