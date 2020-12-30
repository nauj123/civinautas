<div class="form-group"> 
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Identificación</span><span class="rojo">(*)</span>
			<input class="form-control" type="number" id="identificacion" required>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Dirección de correo electrónico</span><span class="rojo">(*)</span>
			<input class="form-control" type="email" id="correo" required>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Nombres completos</span><span class="rojo">(*)</span>
			<input class="form-control" type="text" id="nombres" required>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Apellidos completos</span><span class="rojo">(*)</span>
			<input class="form-control" type="text" id="apellidos" required>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Entidad a la que pertenece</span><span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="entidad" title="Seleccione una opción" required></select>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Rol</span><span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="rol" title="Seleccione una opción" required>
				<option value="1">Contratista</option>
				<option value="2">Padre/ madre de familia - Cuidador</option>
				<option value="3">Docente</option>
				<option value="4">Orientador/a</option>
				<option value="5">Directivo/a</option>
				<option value="6">Otro</option>	
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Localidad en la que habita</span><span class="rojo">(*)</span>
			<select class="form-control selectpicker" id="localidad" title="Seleccione una opción" required></select>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Número telefónico de contacto</span><span class="rojo">(*)</span>
			<input class="form-control" type="text" id="telefono" required>
		</div>
	</div>		
</div>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Pertenencia étnica</span>
			<select class="form-control selectpicker" id="etnia" title="Seleccione una opción"></select>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Sectores sociales</span>
			<select class="form-control selectpicker" id="sector-social" title="Seleccione una opción">
				<option value="1">Víctima del conflicto armado</option>
				<option value="2">Campesino</option>
				<option value="3">Persona con discapacidad</option>
				<option value="4">Otro</option>
				<option value="5">No aplica</option>
			</select>
		</div>
	</div>
</div>