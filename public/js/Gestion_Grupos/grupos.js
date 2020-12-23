var tabla_info_grupos; 
var info_grupos;
var options_instituciones;
var options_tipo_atencion;
var options_jornada;
var options_grupos;
var tabla_estudiantes_grupo;
var info_estudiantes_grupo;
var tabla_estudiantes_coincidencias;
var info_estudiante;
var options_tipo_identificacion;
var options_localidades;
var options_enfoque;

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
	getJornadas(9);

	$("#institucion").html(options_instituciones).selectpicker("refresh");
	$("#jornada").html(options_jornada).selectpicker("refresh");

	$('a[href="#agregar_estudiantes"]').on('shown.bs.tab', function(e){ 
		getOptionsGruposMediador();
		getTipoIdentificacion(1);
		getLocalidades();
		getEnfoque(7);

		$("#grupo-mediador").html(options_grupos).selectpicker("refresh");
		$("#tipo-identificacion").html(options_tipo_identificacion).selectpicker("refresh");
		$("#localidad").html(options_localidades).selectpicker("refresh");
		$("#enfoque").html(options_enfoque).selectpicker("refresh");		
	});




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
			success: function(data) {
				info_grupos = data;
				tabla_info_grupos.clear().draw();
				info_grupos.forEach((value, index) => {

					rowNode = tabla_info_grupos.row.add([
						info_grupos[index]["INSTITUCION"],
						info_grupos[index]["NOMBREGRUPO"],
						info_grupos[index]["MEDIADOR"],
						info_grupos[index]["DOCENTE"],
						info_grupos[index]["JORNADA"],
						"<center>"+info_grupos[index]["ESTUDIANTES"]+"</center>",
						"<center><buton type='button' class='btn btn-danger retirar' data-id-estudiante='"+info_grupos[index]["IDGRUPO"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Inactivar Grupo</buton></center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de grupos del mediador, por favor inténtelo nuevamente", "error");
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
				swal("Error", "No fue posible guardar la información del grupo, por favor inténtelo nuevamente", "error");
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
				swal("Error", "No se pudo obtener el listado de los estudiantes del grupo, por favor inténtelo nuevamente", "error");
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
				info_estudiante = data;
				console.log(info_estudiante);
				tabla_estudiantes_coincidencias.clear().draw();
				info_estudiante.forEach((value, index) => {

					rowNode = tabla_estudiantes_coincidencias.row.add([
						info_estudiante[index]["IDENTIFICACION"],
						info_estudiante[index]["ESTUDIANTE"],
						info_estudiante[index]["FECHA"],
						info_estudiante[index]["GENERO"],
						"<buton type='button' class='btn btn-success agregar' data-tipo-identificacion='"+info_estudiante[index]["TIPODOCUMENTO"]+"' data-identificacion='"+info_estudiante[index]["IDENTIFICACION"]+"' data-pnombre='"+info_estudiante[index]["PNOMBRE"]+"' data-snombre='"+info_estudiante[index]["SNOMBRE"]+"' data-papellido='"+info_estudiante[index]["PAPELLIDO"]+"' data-sapellido='"+info_estudiante[index]["SAPELLIDO"]+"' data-fecha='"+info_estudiante[index]["FECHA"]+"' data-genero='"+info_estudiante[index]["IDGENERO"]+"' data-direccion='"+info_estudiante[index]["DIRECCION"]+"' data-celular='"+info_estudiante[index]["CELULAR"]+"' data-estrato='"+info_estudiante[index]["ESTRATO"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Agregar</buton>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener las coincidencias de los datos ingresados en SIMAT, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#tabla-estudiantes-coincidencias").on("click", ".agregar",  function(){
		agregarEstudianteGrupo(
			$(this).attr("data-tipo-identificacion"),
			$(this).attr("data-identificacion"),
			$(this).attr("data-pnombre"),
			$(this).attr("data-snombre"),
			$(this).attr("data-papellido"),
			$(this).attr("data-sapellido"),
			$(this).attr("data-fecha"),
			$(this).attr("data-genero"),
			$(this).attr("data-direccion"),
			$(this).attr("data-celular"),
			$(this).attr("data-estrato")
		);
	});

	function agregarEstudianteGrupo(tipo_identificacion, identificacion, pnombre, snombre, papellido, sapellido, fecha, genero, direccion, celular, estrato) {
		$.ajax({
			url: "guardarNuevoEstudiante",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				tipo_identificacion: tipo_identificacion,
				identificacion: identificacion,
				primer_nombre: pnombre,
				segundo_nombre: snombre,
				primer_apellido: papellido,
				segundo_apellido: sapellido,
				f_nacimiento: fecha,
				genero: genero,
				localidad: '',
				direccion: direccion,
				correo: '',
				celular: celular,
				enfoque: '',
				estrato: estrato,
				id_grupo_agregar: $("#grupo-mediador").val() 				

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

	function getTipoIdentificacion(id_parametro) {
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
				options_tipo_identificacion += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipo de atenciones, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipo_identificacion;
	}

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

	$("#form-nuevo-estudiante").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "guardarNuevoEstudiante",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				tipo_identificacion: $("#tipo-identificacion").val(),
				identificacion: $("#identificacion").val(),
				primer_nombre: $("#primer-nombre").val(),
				segundo_nombre: $("#segundo-nombre").val(),
				primer_apellido: $("#primer-apellido").val(),
				segundo_apellido: $("#segundo-apellido").val(),
				f_nacimiento: $("#f-nacimiento").val(),
				genero: $("#genero").val(),
				localidad: $("#localidad").val(),
				direccion: $("#direccion").val(),
				correo: $("#correo").val(),
				celular: $("#celular").val(),
				enfoque: $("#enfoque").val(),
				estrato: $("#estrato").val(),
				id_grupo_agregar: $("#grupo-mediador").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se registro la información del estudiante correctamente y se agrego al grupo seleccionado, ya puede ser consultado en el listado del grupo", "success");
					$("#modal-registrar-estudiante").modal('hide');
					LimpiarFormulario();
					getEstudiantesGrupo();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información del estudiante, asegurece de seleccionar el grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	function LimpiarFormulario() {
		$("#tipo-identificacion").val("");
		$("#tipo-identificacion").selectpicker("refresh");
		$("#identificacion").val("");
		$("#primer-nombre").val("");
		$("#segundo-nombre").val("");
		$("#primer-apellido").val("");
		$("#segundo-apellido").val("");
		$("#f-nacimiento").val("");
		$("#genero").val("");
		$("#genero").selectpicker("refresh");
		$("#localidad").val("");
		$("#localidad").selectpicker("refresh");
		$("#direccion").val("");
		$("#correo").val("");
		$("#celular").val("");
		$("#enfoque").val("");
		$("#enfoque").selectpicker("refresh");
		$("#estrato").val("");
		$("#estrato").selectpicker("refresh");
	}


});