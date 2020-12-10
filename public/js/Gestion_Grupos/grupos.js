var tabla_info_grupos;
var options_instituciones;
var options_tipo_atencion;
var options_jornada;

$(document).ready(function(){

	getOptionsInstituciones();
	getTipoAtencion(8);
	getJornadas(9);

	$("#institucion").html(options_instituciones).selectpicker("refresh");
	$("#tipo-atencion").html(options_tipo_atencion).selectpicker("refresh");
	$("#jornada").html(options_jornada).selectpicker("refresh");

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

	function getTipoAtencion(id_parametro) {
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
				options_tipo_atencion += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipo_atencion;
	}

	function getJornadas(id_parametro) {
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
				options_jornada += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado jornadas, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_jornada;
	}

	$("#form-nuevo-grupo").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "guardarNuevoGrupo",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				institucion: $("#institucion").val(),
				nombre_grupo: $("#nombre-grupo").val(),
				docente: $("#docente").val(),
				tipo_atencion: $("#tipo-atencion").val(),
				jornada: $("#jornada").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Grupo del mediador registrado correctamente, ya puede ser consultado en el listado", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					//$("#modal-crear-institucion").modal('hide');
					//getInstitucionesEducativas();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

});