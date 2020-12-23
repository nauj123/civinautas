<div class="form-group"> 
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6  form-group mb-3">
			<span>Institución</span>
			<select class="form-control selectpicker" title="Seleccione una opción" id="institucion" required></select>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<span>Nombre del grupo</span>
			<input type="text" class="form-control" id="nombre-grupo" required>
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
			<span>Jornada</span>
			<select class="form-control selectpicker" title="Seleccione una opción" id="jornada" required></select>
		</div>
	</div>
</div>