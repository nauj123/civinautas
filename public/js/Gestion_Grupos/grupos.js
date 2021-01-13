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
var tabla_consultar_grupos;
var info_consultar_grupos;

$(document).ready(function(){

	$("body").on("keyup",".mayuscula", function(){
		$(this).val($(this).val().toUpperCase());
	  });

	  function mostrarCargando(){
		swal({
			title: "Cargando...",
			text: "Espere un poco por favor.",
			imageUrl: "../../public/images/cargando.gif",
			imageWidth: 140,
			imageHeight: 70,
			showConfirmButton: false,
			allowOutsideClick: false,
			allowEscapeKey: false
			});
	}

	function cerrarCargando(){
		swal.close();
	}

	tabla_info_grupos = $("#tabla-info-grupos").DataTable({
		autoWidth: false,
		paging: false,
		aaSorting: [],
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

	$(document).delegate('#institucion', 'change', function() {
		getInicialesIdLocalidad();
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


	function getInicialesIdLocalidad() {
		$.ajax({
			url: "../Gestion_Colegios/getInicialesIdLocalidad",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_atencion: $("#institucion").val()
			},
			success: function (data) {
				$("#nombre-grupo").val("").val(data[0]["CODIGO"]);

			},
			error: function (data) {
				swal("Error", "No se pudo obtener la información de la actividad, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
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

					if (info_grupos[index]["ESTADO"] == 1) {
						rowNode = tabla_info_grupos.row.add([
							info_grupos[index]["INSTITUCION"],
							info_grupos[index]["NOMBREGRUPO"],
							info_grupos[index]["DOCENTE"],
							info_grupos[index]["JORNADA"],
							"<center>"+info_grupos[index]["ESTUDIANTES"]+"</center>",
							"<center><buton type='button' class='btn btn-danger inactivargrupo' data-id-grupo='"+info_grupos[index]["IDGRUPO"]+"' data-nombre-grupo='"+info_grupos[index]["NOMBREGRUPO"]+"' data-toggle='modal' data-target='#modal-inactivar-grupo'>Inactivar Grupo</buton></center>"
							]).draw().node();
				
					} else {
						rowNode = tabla_info_grupos.row.add([
							info_grupos[index]["INSTITUCION"],
							info_grupos[index]["NOMBREGRUPO"],
							info_grupos[index]["DOCENTE"],
							info_grupos[index]["JORNADA"],
							"<center>"+info_grupos[index]["ESTUDIANTES"]+"</center>",
							"<center>GRUPO INACTIVO</center>"
							]).draw().node();
					}
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
					LimpiarFormularioGrupo();
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
		options_grupos = "";
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
		autoWidth: false,
		paging: false,
		aaSorting: [],
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

				if (info_estudiantes_grupo[index]["IDESTADO"] == 1) {
				
					rowNode = tabla_estudiantes_grupo.row.add([						
						"<center>"+info_estudiantes_grupo[index]["IDENTIFICACION"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["ESTUDIANTE"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["FECHA"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["GENERO"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["FECHAINGRESO"]+"</center>",
						"<center><strong>"+info_estudiantes_grupo[index]["ESTADO"]+"<strong></center>",
						"<center><buton type='button' class='btn btn-danger estado' data-id-estudiante='"+info_estudiantes_grupo[index]["IDESTUDIANTE"]+"' data-toggle='modal' data-target='#modal-inactivar-estudiante'>Inactivar</buton></center>"
						]).draw().node();				
				} else {
					rowNode = tabla_estudiantes_grupo.row.add([
						"<center>"+info_estudiantes_grupo[index]["IDENTIFICACION"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["ESTUDIANTE"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["FECHA"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["GENERO"]+"</center>",
						"<center>"+info_estudiantes_grupo[index]["FECHAINGRESO"]+"</center>",
						"<center><strong>"+info_estudiantes_grupo[index]["ESTADO"]+"</strong></center>",
						"<center><buton type='button' class='btn btn-success estado' data-id-estudiante='"+info_estudiantes_grupo[index]["IDESTUDIANTE"]+"' data-toggle='modal' data-target='#modal-activar-estudiante'>Activar</buton></center>"
						]).draw().node();					
				}
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
		mostrarCargando();
		$.ajax({			
			url: "getBuscarEstudianteSimat",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				buscar: $("#TB_buscar_usuario").val(),
				id_Grupo: $("#grupo-mediador").val()
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
				cerrarCargando();
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

	function LimpiarFormularioGrupo() {
		$("#institucion").val("");
		$("#institucion").selectpicker("refresh");
		$("#nombre-grupo").val("");
		$("#docente").val("");
		$("#jornada").val("");
		$("#jornada").selectpicker("refresh");
	}

	$("#tabla-estudiantes-grupo").on("click", ".estado",  function(){
		getEstadoEstudiante($(this).attr("data-id-estudiante"));
	}); 

	function getEstadoEstudiante(estudiante) {
		$.ajax({
			url: "getEstadoEstudiante",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_estudiante: estudiante
			},
			success: function(data) {
				$("#id-estudiante").val(data[0]["IDESTUDIANTE"]);
				$("#lb-grupo").html("").html(data[0]["GRUPO"]);
				$("#lb-estudiante").html("").html(data[0]["ESTUDIANTE"]);
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información del estudainte que desea inactivar, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#form-inactivar-estudiante").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "InactivarEstudiante",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_estudiante: $("#id-estudiante").val(),
				observacion: $("#observacion").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se inactivo correctamente el estudiante del grupo, ya no aparecerá en el listado de asistencia", "success");
					$("#modal-inactivar-estudiante").modal('hide');
					getEstudiantesGrupo();
					
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("#form-activar-estudiante").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "ActivarEstudiante",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_estudiante: $("#id-estudiante").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se activo nuevamente el estudiante al grupo, desde este momento aparecerá en el listado de asistencia", "success");
					$("#modal-activar-estudiante").modal('hide');
					getEstudiantesGrupo();
					
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});	

	$("#tabla-info-grupos").on("click", ".inactivargrupo",  function(){
		$("#id-grupo").val($(this).attr("data-id-grupo"));
		$("#lb-grupo-inactivar").html("").html($(this).attr("data-nombre-grupo"));
	}); 

	$("#form-inactivar-grupo").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "InactivarGrupo",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_grupo: $("#id-grupo").val(),
				observacion: $("#observacion-grupo").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se inactivo correctamente el grupo, ya no estará disponible para agregar estudiantes ni registrar asistencia", "success");
					$("#modal-inactivar-grupo").modal('hide');
					getGruposMediador();
					
				}
			},
			error: function (data) {
				swal("Error", "No fue posible inactivar el grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	tabla_consultar_grupos = $("#tabla-consultar-grupos").DataTable({
		autoWidth: false,
		paging: false,
		aaSorting: [],
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

	$('a[href="#consultar_grupos"]').on('shown.bs.tab', function(e){
		getTotalGrupos();
	});


	function getTotalGrupos() {
		$.ajax({
			url: "getTotalGrupos",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_Grupo: $("#grupo-mediador").val()
			},
			success: function(data) {
				info_consultar_grupos = data;
				tabla_consultar_grupos.clear().draw();
				info_consultar_grupos.forEach((value, index) => {				
					rowNode = tabla_consultar_grupos.row.add([		
						
						"<center>"+info_consultar_grupos[index]["IDGRUPO"]+"</center>",
						"<center>"+info_consultar_grupos[index]["LOCALIDAD"]+"</center>",
						"<center>"+info_consultar_grupos[index]["TIPOINSTITUCION"]+"</center>",
						"<center>"+info_consultar_grupos[index]["INSTITUCION"]+"</center>",
						"<center>"+info_consultar_grupos[index]["NOMGRUPO"]+"</center>",
						"<center>"+info_consultar_grupos[index]["ESTUDIANTES"]+"</center>",
						"<center>"+info_consultar_grupos[index]["MEDIADOR"]+"</center>",
						"<center>"+info_consultar_grupos[index]["DOCENTE"]+"</center>",
						"<center>"+info_consultar_grupos[index]["JORNADA"]+"</center>",
						"<center>"+info_consultar_grupos[index]["FCREACION"]+"</center>",
						"<center>"+info_consultar_grupos[index]["ESTADO"]+"</center>",
						"<center>"+info_consultar_grupos[index]["OBSERVACIONES"]+"</center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de los estudiantes del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

});