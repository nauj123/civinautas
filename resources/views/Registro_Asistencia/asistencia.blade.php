@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js?V=2020.12.11.1') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="p-2 rounded d-flex align-items-center bg-primary text-white">
	<h1 class="text-28 mb-1 text-white">Registro de atenciones</h1>
</div>

<br>
<div class="container-fluid">
	<div class="panel-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#registro_asistencia">Registro de asistencia</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_asistencias">Consultar asistencias registradas</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active col-lg-12" id="registro_asistencia"><br>

				<table id="informacion-atencion" style="width: 100%;" border="2">
				<tr style="text-align: center;">
					<td style="width: 25%; height: 30px"><strong>Grupo</strong></td>
					<td style="width: 25%;"><strong>Fecha atención </strong></td>
					<td style="width: 25%;" colspan="2"><strong>Horario atención</strong></td>
					<td style=" width: 25%;"><strong>Tipo de actividad</strong></td>
				</tr>
				<tr>
					<td style="height: 30px"><select class="form-control selectpicker" id="institucion" title="Seleccione una opción" required></td>
					<td><input class="form-control" type="date" id="fecha-atencion" required></td>
					<td><input class="form-control" type="time" id="hora-inicio" required></td>
					<td><input class="form-control" type="time" id="hora-fin" required></td>
					<td><select class="form-control selectpicker" id="tipo-actividad" title="Seleccione una opción" required></td>
				</tr>
				<tr style="text-align: center;">
					<td style="width: 25%; height: 30px"><strong>Temática:</strong></td>
					<td style="width: 75%;" colspan="4"><textarea style="width: 100%;"></textarea></td>
				</tr>
				</table>
			</div>
			<div class="tab-pane" id="consulta_asistencias" role="tabpanel"><br>
				
			</div>
		</div>
	</div>

</div>
@endsection