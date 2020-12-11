var tabla_info_grupos;
var info_grupos;
var options_instituciones;
var options_tipo_atencion;
var options_jornada;
var options_grupos;
var tabla_estudiantes_grupo;
var info_estudiantes_grupo;
var tabla_estudiantes_coincidencias;
var info_estudiantes_coincidencias;

$(document).ready(function(){

	tabla_info_grupos = $("#tabla-info-grupos").DataTable({
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
	getGruposMediador();
	getOptionsInstituciones();
	getTipoAtencion(8);
	getJornadas(9);
	getOptionsGruposMediador();

	$("#institucion").html(options_instituciones).selectpicker("refresh");
	$("#tipo-atencion").html(options_tipo_atencion).selectpicker("refresh");
	$("#jornada").html(options_jornada).selectpicker("refresh");
	$("#grupo-mediador").html(options_grupos).selectpicker("refresh");

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

	function getGruposMediador() {
		$.ajax({
			url: "getGruposMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_Grupo: $("#grupo-mediador").val()
			},
			success: function(data) {
				info_grupos = data;
				tabla_info_grupos.clear().draw();
				info_grupos.forEach((value, index) => {

					rowNode = tabla_info_grupos.row.add([
						info_grupos[index]["INSTITUCION"],
						info_grupos[index]["NOMBREGRUPO"],
						info_grupos[index]["MEDIADOR"],
						info_grupos[index]["DOCENTE"],
						info_grupos[index]["TIPOATENCION"],
						"<center>"+info_grupos[index]["ESTUDIANTES"]+"</center>",
						"<center><buton type='button' class='btn btn-danger retirar' data-id-estudiante='"+info_grupos[index]["IDGRUPO"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Inactivar Grupo</buton></center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipos de escenario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
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
					$("#modal-crear-grupo").modal('hide');
					getGruposMediador();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	function getOptionsGruposMediador() {
		$.ajax({
			url: "getOptionsGruposMediador",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_grupos += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de grupos del mediador, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_grupos;
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
	$(document).delegate('#grupo-mediador', 'change', function() {
		$("#beneficiarios_grupo").show();
		getEstudiantesGrupo();
	});	

	function getEstudiantesGrupo() {
		$.ajax({
			url: "getEstudiantesGrupo",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_Grupo: $("#grupo-mediador").val()
			},
			success: function(data) {
				info_estudiantes_grupo = data;
				tabla_estudiantes_grupo.clear().draw();
				info_estudiantes_grupo.forEach((value, index) => {

					rowNode = tabla_estudiantes_grupo.row.add([
						info_estudiantes_grupo[index]["IDENTIFICACION"],
						info_estudiantes_grupo[index]["ESTUDIANTE"],
						info_estudiantes_grupo[index]["FECHA"],
						info_estudiantes_grupo[index]["GENERO"],
						info_estudiantes_grupo[index]["FECHAINGRESO"],
						info_estudiantes_grupo[index]["ESTADO"],
						"<buton type='button' class='btn btn-danger retirar' data-id-estudiante='"+info_estudiantes_grupo[index]["IDESTUDIANTE"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Retirar</buton>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipos de escenario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	tabla_estudiantes_coincidencias = $("#tabla-estudiantes-coincidencias").DataTable({
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
	$("#TB_buscar_usuario").keyup(function(e){
	    if(e.keyCode == 13){
			getBuscarEstudianteSimat();
		}
	});

	$(document).delegate('#TB_buscar_usuario', 'change', function() {
		$("#concidencias_simat").show();
		getBuscarEstudianteSimat();
	});	

	function getBuscarEstudianteSimat() {
		$.ajax({
			url: "getBuscarEstudianteSimat",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				buscar: $("#TB_buscar_usuario").val()
			},
			success: function(data) {
				info_estudiantes_coincidencias = data;
				console.log(info_estudiantes_coincidencias);
				tabla_estudiantes_coincidencias.clear().draw();
				info_estudiantes_coincidencias.forEach((value, index) => {

					rowNode = tabla_estudiantes_coincidencias.row.add([
						info_estudiantes_coincidencias[index]["IDENTIFICACION"],
						info_estudiantes_coincidencias[index]["ESTUDIANTE"],
						info_estudiantes_coincidencias[index]["FECHA"],
						info_estudiantes_coincidencias[index]["GENERO"],
						"<buton type='button' class='btn btn-success agregar' data-id-estudiante='"+info_estudiantes_coincidencias[index]["IDSIMAT"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Agregar</buton>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipos de escenario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#tabla-estudiantes-coincidencias").on("click", ".agregar",  function(){
		agregarEstudianteGrupo($(this).attr("data-id-estudiante"));
	});

	function agregarEstudianteGrupo(id_estudiante) {
		console.log(id_estudiante); 
		$.ajax({
			url: "agregarEstudianteGrupo",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				grupo_mediador: $("#grupo-mediador").val(),
				id_estudiante: id_estudiante
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se agrego correctamente el estudiante al grupo seleccionado, por favor consultarlo en el listado del grupo", "success");
					getEstudiantesGrupo();
				}
			},
			error: function(data){
				swal("Error", "No se pudo registrar el estudiante en el grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

});