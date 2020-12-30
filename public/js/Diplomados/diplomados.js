var options_diplomados;
var options_localidades;
var options_instituciones;
var options_enfoque;

$(document).ready(function(){

	tabla_info_diplomados = $("#tabla-info-diplomados").DataTable({
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

	getDiplomadosMediador();
	getLocalidades();
	getOptionsInstituciones();
	getEnfoque(7);

	$("#entidad").html(options_instituciones).selectpicker("refresh");
	$("#localidad").html(options_localidades).selectpicker("refresh");
	$("#etnia").html(options_enfoque).selectpicker("refresh");

	$('a[href="#agregar_estudiantes"]').on('shown.bs.tab', function(e){ 
		getOptionsDiplomadosMediador();
		$("#diplomado-asistencia").html(options_diplomados).selectpicker("refresh");		
	});

	function getLocalidades() {
		$.ajax({
			url: "../administracion/getLocalidades",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_localidades += data["option"];
			},
			error: function(data){
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
			success: function(data) {
				options_instituciones += data["option"];
			},
			error: function(data){
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
			data:{
				id_parametro: id_parametro
			},
			success: function(data) {
				options_enfoque += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_enfoque;
	}

	

	$("#form-nuevo-diplomado").submit(function (e){
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
			success: function(data) {
				informacion_diplomados = data;
				tabla_info_diplomados.clear().draw();
				informacion_diplomados.forEach((value, index) => {

					rowNode = tabla_info_diplomados.row.add([
						informacion_diplomados[index]["IDDIPLOMADO"],
						informacion_diplomados[index]["NOMBRE"],
						informacion_diplomados[index]["DURACION"],
						informacion_diplomados[index]["TEMATICA"],
						informacion_diplomados[index]["ESTADO"],
						"<center><buton type='button' class='btn btn-primary agregar' data-id-diplomado='"+informacion_diplomados[index]["IDDIPLOMADO"]+"' data-toggle='modal' data-target='#modal-registrar-participante'>Agregar participante</buton></center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de diplomados creados, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	function getOptionsDiplomadosMediador() {
		$.ajax({
			url: "getOptionsDiplomadosMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_diplomados += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de diplomados del mediador, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_diplomados;
	}

	$("#form-participantes").submit(function (e){
		e.preventDefault();
		$.ajax({
			url: "guardarParticipantesDiplomado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
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
				if (data == 200) {
					swal("Éxito", "Se agrego correctamente el participante al diplomado", "success");
					//$(":input").val("");
					//$('.selectpicker').selectpicker('val', '');
					//$("#modal-crear-diplomado").modal('hide');
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});


});