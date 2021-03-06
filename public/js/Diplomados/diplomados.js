var options_diplomados;
var options_localidades;
var options_instituciones;
var options_enfoque;
var id_diplomado;
var id_diplomado_registro;
$(document).ready(function () {

	tabla_config = {
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
	};

	tabla_info_diplomados = $("#tabla-info-diplomados").DataTable(tabla_config);
	tabla_participantes_diplomado = $("#tabla-participantes-diplomado").DataTable(tabla_config);
	tabla_participantes_asistencia_diplomado = $("#tabla-participantes-asistencia-diplomado").DataTable({
		pageLength: 50,
		lengthChange: false,
		responsive: true,
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

	getDiplomadosMediador();
	getLocalidades();
	getOptionsInstituciones();
	getEnfoque(7);

	$("#entidad").html(options_instituciones).selectpicker("refresh");
	$("#localidad").html(options_localidades).selectpicker("refresh");
	$("#etnia").html(options_enfoque).selectpicker("refresh");

	$('a[href="#registrar_asistencia"]').on('shown.bs.tab', function (e) {
		getOptionsDiplomadosMediador();
		$("#diplomado-asistencia").html(options_diplomados).selectpicker("refresh");
	});

	$('a[href="#consultar_asistencia"]').on('shown.bs.tab', function (e) {
		getOptionsDiplomadosMediador();
		$("#diplomado-consulta").html(options_diplomados).selectpicker("refresh");
	});

	function getLocalidades() {
		$.ajax({
			url: "../administracion/getLocalidades",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (data) {
				options_localidades += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_localidades;
	}

	function getOptionsInstituciones() {
		$.ajax({
			url: "../Gestion_Colegios/getOptionsInstituciones",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (data) {
				options_instituciones += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de instituciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_instituciones;
	}

	function getEnfoque(id_parametro) {
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
				options_enfoque += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_enfoque;
	}

	$("#form-nuevo-diplomado").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "guardarNuevoDiplomado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				nombre_diplomado: $("#nombre-diplomado").val(),
				fecha_inicio: $("#fecha-inicio").val(),
				fecha_fin: $("#fecha-fin").val(),
				tematica: $("#tematica").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se creo correctamente el diplomado  ya se puede registrar la asistencia de los participantes", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#modal-crear-diplomado").modal('hide');
					getDiplomadosMediador();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	function getDiplomadosMediador() {
		$.ajax({
			url: "getDiplomadosMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (data) {
				informacion_diplomados = data;
				tabla_info_diplomados.clear().draw();
				informacion_diplomados.forEach((value, index) => {

					rowNode = tabla_info_diplomados.row.add([
						"<center>" + informacion_diplomados[index]["IDDIPLOMADO"] + "</center>",
						informacion_diplomados[index]["NOMBRE"],
						informacion_diplomados[index]["DURACION"],
						informacion_diplomados[index]["TEMATICA"],
						"<center><a href='#' class='btn btn-secondary participantes' data-id-diplomado='" + informacion_diplomados[index]["IDDIPLOMADO"] + "' data-toggle='modal' data-target='#modal-participantes-diplomado'>" + informacion_diplomados[index]["PARTICIPANTES"] + "</a></center>",
						"<buton type='button' class='btn btn-block btn-primary agregar' data-id-diplomado='" + informacion_diplomados[index]["IDDIPLOMADO"] + "' data-toggle='modal' data-target='#modal-registrar-participante'>Agregar participante</buton>",
						"<center><buton type='button' class='btn btn-warning editar' data-id-diplomado='" + informacion_diplomados[index]["IDDIPLOMADO"] + "' data-toggle='modal' data-target='#modal-editar-diplomado'>Editar</buton></center>"
					]).draw().node();
				});
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de diplomados creados, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	function getOptionsDiplomadosMediador() {
		options_diplomados = "";
		$.ajax({
			url: "getOptionsDiplomadosMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (data) {
				options_diplomados += data["option"];
			},
			error: function (data) {
				swal("Error", "No se pudo obtener el listado de diplomados del mediador, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_diplomados;
	}

	$("#tabla-info-diplomados").on("click", ".agregar", function () {
		id_diplomado_registro = $(this).attr("data-id-diplomado");
		console.log(id_diplomado_registro);
		$("#id_diplomado").val(id_diplomado_registro);
	});

	$("#tabla-info-diplomados").on("click", ".participantes", function () {
		id_diplomado = $(this).attr("data-id-diplomado");
		$.ajax({
			url: "getInfoParticipantesDiplomado",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado: id_diplomado
			},
			success: function (data) {
				tabla_participantes_diplomado.clear().draw();
				data.forEach((value, index) => {
					rowNode = tabla_participantes_diplomado.row.add([
						data[index]["IDENTIFICACION"],
						data[index]["NOMBRE"],
						data[index]["CORREO"],
						data[index]["TELEFONO"]
					]).draw().node();
				});
			},
			error: function (data) {
				swal("Error", "No se pudo obtener la información de los participantes del diplomado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("#diplomado-asistencia").on("change", function () {
		$("#div-participantes-asistencia-diplomado").show();
		id_diplomado = $(this).val();
		$.ajax({
			url: "getInfoParticipantesDiplomado",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado: id_diplomado
			},
			success: function (data) {
				tabla_participantes_asistencia_diplomado.clear().draw();
				data.forEach((value, index) => {
					rowNode = tabla_participantes_asistencia_diplomado.row.add([
						"<center>" + data[index]["IDENTIFICACION"] + "</center>",
						"<center>" + data[index]["NOMBRE"] + "</center>",
						"<center><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id-participante='" + data[index]["IDPARTICIPANTE"] + "' class='asistencia_diplomado'><center>"
					]).draw().node();
				});
				$('input[type="checkbox"]').bootstrapToggle();
			},
			error: function (data) {
				swal("Error", "No se pudo obtener la información de los participantes del diplomado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("#tabla-info-diplomados").on("click", ".editar", function () {
		getInformacionDiplomado($(this).attr("data-id-diplomado"));
	});

	function getInformacionDiplomado(diplomado) {
		$.ajax({
			url: "getInformacionDiplomado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado: diplomado
			},
			success: function (data) {
				$("#id-diplomado-m").val(data["Pk_Id_Diplomado"]);
				$("#nombre-diplomado-m").val(data["VC_Nombre_Diplomado"]);
				$("#fecha-inicio-m").val(data["DT_Fecha_Inicio"]);
				$("#fecha-fin-m").val(data["DT_Fecha_fin"]);
				$("#tematica-m").val(data["VC_Tematica"]);
			},
			error: function (data) {
				Swal.fire("Error", "No se pudo obtener la información del diplomado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#form-editar-diplomado").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "actualizarInformacionDiplomado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado_m: $("#id-diplomado-m").val(),
				nombre_m: $("#nombre-diplomado-m").val(),
				fecha_inicio_m: $("#fecha-inicio-m").val(),
				fecha_fin_m: $("#fecha-fin-m").val(),
				tematica_m: $("#tematica-m").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Diplomado actualizado correctamente, ya puede ser consultado en el listado", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#modal-editar-diplomado").modal('hide');
					getDiplomadosMediador();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible actualizar la información del diplomado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("#form-asistencia-diplomado").submit(function (e) {
		e.preventDefault();

		var array_datos_asistencia = new Array();

		$('.asistencia_diplomado').each(function () {
			var check;
			check = $(this).is(":checked") ? 1 : 0;
			array_datos_asistencia.push(new Array($(this).attr("data-id-participante"), check));
		});

		$.ajax({
			url: "guardarAsistenciaDiplomado",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				diplomado: $("#diplomado-asistencia").val(),
				fecha: $("#fecha-asistencia").val(),
				array_datos_asistencia: array_datos_asistencia
			},
			success: function (data) {
				swal("Éxito", "Se ha guardado la asistencia correctamente", "success");
				$("#div-participantes-asistencia-diplomado").hide();
				$("#diplomado-asistencia").selectpicker("val", "");
				$("#fecha-asistencia").val("")
			},
			error: function (data) {
				swal("Error", "No se pudo guardar la asistencia, por favor inténtelo nuevamente", "error");
			},
			async: false
		});

	});

	$("#form-participantes").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "guardarParticipantesDiplomado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado: id_diplomado_registro,
				identificacion: $("#identificacion").val(),
				correo: $("#correo").val(),
				nombres: $("#nombres").val(),
				apellidos: $("#apellidos").val(),
				entidad: $("#entidad").val(),
				rol: $("#rol").val(),
				localidad: $("#localidad").val(),
				telefono: $("#telefono").val(),
				etnia: $("#etnia").val(),
				sector_social: $("#sector-social").val()
			},
			success: function (data) {
				swal("Éxito", "Se agrego correctamente el participante al diplomado", "success");
				LimpiarFormulario();
				$("#modal-registrar-participante").modal("hide");
				getDiplomadosMediador();
			},
			error: function (data) {
				swal("Error", "No se pudo agregar el participante al diplomado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	function LimpiarFormulario() {
		$("#identificacion").val("");
		$("#correo").val("");
		$("#nombres").val("");
		$("#apellidos").val("");
		$("#entidad").val("");
		$("#entidad").selectpicker("refresh");
		$("#rol").val("");
		$("#rol").selectpicker("refresh");
		$("#localidad").val("");
		$("#localidad").selectpicker("refresh");
		$("#telefono").val("");
		$("#etnia").val("");
		$("#etnia").selectpicker("refresh");
		$("#sector-social").val("");
		$("#sector-social").selectpicker("refresh");
	}

	$("#diplomado-consulta").change(consultarAsistenciasMensual);

	function consultarAsistenciasMensual() {
		$.ajax({
			url: "consultarAsistenciaDiplomado",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_diplomado: $("#diplomado-consulta").val()
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