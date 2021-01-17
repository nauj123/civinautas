var options_grupos;
var options_modalidad_actividad;

$(document).ready(function () {

	getOptionsGruposMediador();
	getModalidadActividad(8);

	$("#grupo-mediador").html(options_grupos).selectpicker("refresh");

	$("#modalidad-actividad").html(options_modalidad_actividad).change(function () {
		$("#tipo-actividad").html(getTipoActividad($("#modalidad-actividad").val())).selectpicker("refresh");
		$("#recursos-materiales").html(getRecursosMateriales($("#modalidad-actividad").val())).selectpicker("refresh");
	}).selectpicker("refresh");

	//$("#consultar-grupo").html().selectpicker("refresh");

	$("#consultar-grupo").html(options_grupos).change(function () {
		$("#consultar-actividad").html(getListadoActividadesGrupo($("#consultar-grupo").val())).selectpicker("refresh");
	}).selectpicker("refresh");

	$("#consultar_grupo_mensual").html(options_grupos).selectpicker("refresh");


	function getOptionsGruposMediador() {
		$.ajax({
			url: "../Gestion_Grupos/getOptionsGruposMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (data) {
				options_grupos += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de grupos del mediador, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_grupos;
	}

	function getModalidadActividad(id_parametro) {
		$.ajax({
			url: "../administracion/getOptionsParametro",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_parametro: id_parametro
			},
			success: function (data) {
				options_modalidad_actividad += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_modalidad_actividad;
	}

	function getTipoActividad(id_parametro) {
		var options_tipo_actividad = "";
		$.ajax({
			url: "../administracion/getTipoActividad",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_parametro: id_parametro
			},
			success: function (data) {
				options_tipo_actividad += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipo_actividad;
	}

	function getRecursosMateriales(id_parametro) {
		var options_recursos_materiales = "";
		$.ajax({
			url: "../administracion/getOptionsIDParametroDetalle",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_parametro: id_parametro
			},
			success: function (data) {
				options_recursos_materiales += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_recursos_materiales;
	}

	function getListadoActividadesGrupo(id_grupo) {
		var options_actividad_grupo = "";
		$.ajax({
			url: "getListadoActividadesGrupo",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_grupo: id_grupo
			},
			success: function (data) {
				options_actividad_grupo += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de activiades del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_actividad_grupo;
	}

	tabla_estudiantes_grupo = $("#tabla-estudiantes-grupo").DataTable({
		pageLength: 50,
		lengthChange: false,
		responsive: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excel',
			text: 'Descargar datos',
			filename: 'Datos'
		}],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
			"search": "Filtrar",
			"paginate": {
				"first": "Primera",
				"last": "Última",
				"next": "Siguiente",
				"previous": "Anterior"
			},
		}
	});

	$(document).delegate('#grupo-mediador', 'change', function () {
		$("#div_estudiantes_grupo").show();
		getEstudiantesGrupo();
	});

	function getEstudiantesGrupo() {
		$.ajax({
			url: "../Gestion_Grupos/getEstudiantesGrupoAsistencia",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_Grupo: $("#grupo-mediador").val()
			},
			success: function (data) {
				info_estudiantes_grupo = data;
				tabla_estudiantes_grupo.clear().draw();
				var i = 1;
				info_estudiantes_grupo.forEach((value, index) => {

					rowNode = tabla_estudiantes_grupo.row.add([
						i,
						info_estudiantes_grupo[index]["ESTUDIANTE"],
						info_estudiantes_grupo[index]["IDENTIFICACION"],
						info_estudiantes_grupo[index]["FECHA"],
						info_estudiantes_grupo[index]["GENERO"],
						"<input id='checkbox_' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario[]' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id-beneficiario='" + info_estudiantes_grupo[index]["IDESTUDIANTE"] + "' class='asistencia_actividad'>"
					]).draw().node();
					i++
					$('input[type="checkbox"]').bootstrapToggle();
				});
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de estudiantes del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#form-guardar-actividad").submit(function (e) {
		var checkbox_asistencia_estudiante = new Array();
		var idsRecursos = "";
		$('.asistencia_actividad').each(function () {
			var check;
			if ($(this).is(":checked")) {
				check = 1;
			} else {
				check = 0;
			}
			checkbox_asistencia_estudiante.push(new Array($(this).data('id-beneficiario'), check));
		});
		$('#recursos-materiales :selected').each(function (i, selected) {
			if (idsRecursos == "") {
				idsRecursos = $(selected).val() + ",";
			} else {
				idsRecursos += $(selected).val() + ",";
			}
		});
		e.preventDefault();
		$.ajax({
			url: "guardarActividadAsistencia",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				grupo: $("#grupo-mediador").val(),
				fecha: $("#fecha-atencion").val(),
				inicio: $("#hora-inicio").val(),
				fin: $("#hora-fin").val(),
				modalidad_actividad: $("#modalidad-actividad").val(),
				tipo_actividad: $("#tipo-actividad").val(),
				recursos_materiales: idsRecursos,
				tema: $("#tema-actividad").val(),
				estudiantes: checkbox_asistencia_estudiante
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se ha guardado exitosamente el registro de la actividad y asistencia de estudaintes, puede ser consultada en el listado de actividades", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#div_estudiantes_grupo").hide();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	tabla_asistencia_estudiante = $("#tabla-asistencia-estudiante").DataTable({
		pageLength: 50,
		lengthChange: false,
		responsive: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excel',
			text: 'Descargar datos',
			filename: 'Datos'
		}],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
			"search": "Filtrar",
			"paginate": {
				"first": "Primera",
				"last": "Última",
				"next": "Siguiente",
				"previous": "Anterior"
			},
		}
	});

	$("#consultar-actividad").change(cargarInformacionAtencion);

	function cargarInformacionAtencion() {
		$("#div_consulta_atencion").show();
		getEncabezadoAtencion();
		getAsistenciaAtencion();
	}

	function getEncabezadoAtencion() {
		$.ajax({
			url: "getEncabezadoAtencion",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_atencion: $("#consultar-actividad").val()
			},
			success: function (data) {
				$("#lb-idatencion").html("").html(data[0]["IDATENCION"]);
				$("#lb-grupo").html("").html(data[0]["GRUPO"]);
				$("#lb-mediador").html("").html(data[0]["MEDIADOR"]);
				$("#lb-fecha").html("").html(data[0]["FECHA"]);
				$("#lb-horario").html("").html(data[0]["HORARIO"]);
				$("#lb-modalidad").html("").html(data[0]["MODALIDAD"]);
				$("#lb-actividad").html("").html(data[0]["ACTIVIDAD"]);
				$("#lb-recursos").html("").html(data[0]["RECURSOS"]);
				$("#lb-tematica").html("").html(data[0]["TEMATICA"]);
			},
			error: function (data) {
				swal("Error", "No se pudo obtener la información de la actividad, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	function getAsistenciaAtencion() {

		$.ajax({
			url: "getAsistenciaAtencion",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_atencion: $("#consultar-actividad").val()
			},
			success: function (data) {
				info_asistencia_estudiante = data;
				tabla_asistencia_estudiante.clear().draw();
				var i = 1;
				info_asistencia_estudiante.forEach((value, index) => {

					rowNode = tabla_asistencia_estudiante.row.add([
						"<center>" + i + "</center>",
						"<center>" + info_asistencia_estudiante[index]["IDENTIFICACION"] + "</center>",
						"<center>" + info_asistencia_estudiante[index]["ESTUDIANTE"] + "</center>",
						"<center>" + info_asistencia_estudiante[index]["GENERO"] + "</center>",
						"<center>" + info_asistencia_estudiante[index]["FECHA"] + "</center>",
						"<center><strong>" + info_asistencia_estudiante[index]["ASISTENCIA"] + "</strong></center>"
					]).draw().node();
					i++
				});
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de asistencia de estudiantes, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}


	$("#btn-consultar-asistencias").click(consultarAsistenciasMensual);

	/*function cargarConsolidadoMensual() {
		consultarAsistenciasMensual();
	}*/

	function consultarAsistenciasMensual() {
		$.ajax({
			url: "consultarAsistenciasMensual",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_grupo: $("#consultar_grupo_mensual").val(),
				id_mes: $("#mes_reporte").val()
			},
			success: function (data) {
				$("#div_table_asistencia").html(data);

				$("#table_asistencia").DataTable({
					pageLength: 50,
					lengthChange: false,
					responsive: true,
					dom: 'Bfrtip',
					buttons: [{
						extend: 'excel',
						text: 'Descargar datos',
						filename: 'Datos'
					}],
					"language": {
						"lengthMenu": "Ver _MENU_ registros por página",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando página _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtrado de un total de _MAX_ registros)",
						"search": "Filtrar",
						"paginate": {
							"first": "Primera",
							"last": "Última",
							"next": "Siguiente",
							"previous": "Anterior"
						},
					},
				}).draw();
			},
			error: function (data) {
				swal("Error", "No se encontro información con los datos seleccionados por favor verifique la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});

	}
});