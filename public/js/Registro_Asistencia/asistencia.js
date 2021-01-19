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

	$("#btn-consultar-asistencias").on("click", function(){
		consultarAsistenciasMensual("tabla");
	});

	function consultarAsistenciasMensual(tipo_consulta){
		var info = "";
		$.ajax({
			url: "consultarAsistenciasMensual",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_grupo: $("#consultar_grupo_mensual").val(),
				id_mes: $("#mes_reporte").val(),
				tipo_consulta: tipo_consulta
			},
			success: function (data) {
				$("#pdf-asistencia-mensual").show();
				if(tipo_consulta == "pdf"){
					info = data;
				}else{
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
				}
			},
			error: function (data) {
				swal("Error", "No se encontro información con los datos seleccionados por favor verifique la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return info;
	}

	$("#pdf-asistencia-mensual").click(procesarPdf);

	function procesarPdf(){
		var datosPDF = consultarAsistenciasMensual("pdf");

		datosPDF.datos_tabla_grupo = [];
		datosPDF.datos_tabla_estudiantes = [];
		datosPDF.datos_tabla_atenciones = [];
		array_info_grupo = [];
		array_info_estudiantes = [];
		array_widths_info_estudiantes = [];
		array_info_atenciones = [];

		array_info_grupo.push(
			[{text: "ENTIDAD", style: "titulo_tabla"},{text: datosPDF["grupo"][0]["institucion_educativa"]["VC_Nombre_Institucion"]},{text: "GRUPO", style: "titulo_tabla"},{text: datosPDF["grupo"][0]["VC_Nombre_Grupo"]}],
			[{text: "RESPONSABLE", style: "titulo_tabla"},{text: datosPDF["grupo"][0]["VC_Docente"]},{text: "FECHA", style: "titulo_tabla"},{text: $("#mes_reporte").val()}]);

		array_widths_info_estudiantes.push("auto", "auto", "*", "auto");
		array_info_estudiantes.push([
			{text: "N°", style: "titulo_tabla"},
			{text: "IDENTIFICACIÓN", style: "titulo_tabla"},
			{text: "NOMBRE", style: "titulo_tabla"},
			{text: "GÉNERO", style: "titulo_tabla"}
			]);

		array_info_atenciones.push([
			{text: "N°", style: "titulo_tabla"},
			{text: "FECHA", style: "titulo_tabla"},
			{text: "TIPO ACTIVIDAD", style: "titulo_tabla"},
			{text: "TEMÁTICA (CONCRETA)", style: "titulo_tabla"}
			]);


		$.each(datosPDF.encabezado, function(key, value) {
			array_widths_info_estudiantes.push("auto");

			array_info_estudiantes[0].push(
				{text: value["DT_Fecha_Atencion"], style: "titulo_tabla"}
				);

			array_info_atenciones.push([
				{text: key+1, fillColor: '#cccccc', style: "texto_tabla"},
				{text: value["DT_Fecha_Atencion"], style: "texto_tabla"},
				{text: value["IN_Tipo_Actividad"], style: "texto_tabla"},
				{text: value["VC_Tematica"], style: "texto_tabla"}
				]);
		});

		$.each(datosPDF.datos_asistencia, function(key_f, value) {
			$.each(value, function(key, value){
				if(key == 0){
					array_info_estudiantes.push([
						{text: key_f+1, fillColor: '#cccccc', style: "texto_tabla"},
						{text: value["identificacion"], style: "texto_tabla"},
						{text: value["nombre"], style: "texto_tabla"},
						{text: value["genero"], style: "texto_tabla"}
						]);
				}else{
					asistencia = value[0][0]["IN_Asistencia"] != "SIN REGISTRO" ? value[0][0]["IN_Asistencia"] == 1 ? "SI" : "NO" : value[0][0]["IN_Asistencia"];
					array_info_estudiantes[array_info_estudiantes.length - 1].push(
						{text: asistencia, style: "texto_tabla"}
						);
				}
			})
		});

		$.each(datosPDF.datos_estudiantes, function(key, value) {
			genero = value["IN_Genero"] == 1 ? "MASCULINO" : "FEMENINO";
			array_info_estudiantes.push([
				{text: value["IN_Identificacion"], style: "texto_tabla"},
				{text: value["VC_Primer_Apellido"]+" "+value["VC_Segundo_Apellido"]+" "+value["VC_Primer_Nombre"]+" "+value["VC_Segundo_Nombre"], style: "texto_tabla"}
				]);
		});

		datosPDF.datos_tabla_grupo.push({
			table: {
				widths: [100, "*", 50, "*"],
				body: array_info_grupo,
			},
		});

		datosPDF.datos_tabla_estudiantes.push({
			table: {
				widths: array_widths_info_estudiantes,
				body: array_info_estudiantes,
			},
		});

		datosPDF.datos_tabla_atenciones.push({
			table: {
				widths: ["auto", "auto", "auto", "*"],
				body: array_info_atenciones,
			},
		});

		generarPdf(datosPDF);
	}

	function generarPdf(datosPDF){
		var dd = {
			content: [
			{
				table: {
					widths: ["*"],
					body: [
					[{text: "INSTITUTO DISTRITAL DE PATRIMONIO CULTURAL", style: "titulo_principal"}],
					[{text: "DIVULGACIÓN Y APROPIACIÓN SOCIAL DEL PATRIMONIO", style: "titulo_principal"}],
					[{text: "LISTA DE ASISTENCIA BENEFICIADOS PROGRAMA DE FORMACION EN PATRIMONIO CULTURAL - CIVINAUTAS", style: "titulo_principal"}]
					]
				}
			},
			[{text: "\n"}],
			datosPDF.datos_tabla_grupo,
			[{text: "\n"}],
			datosPDF.datos_tabla_estudiantes,
			[{text: "\n"}],
			[
			{
				table: {
					widths: ["*"],
					body: [
					[{text: "OBSERVACIONES:", style: "titulo"}]
					]
				}
			}
			],
			datosPDF.datos_tabla_atenciones,
			[
			{
				table: {
					widths: [250, "*", "*"],
					body: [
					[{
						text: "Nota: En cumplimiento de la normatividad vigente sobre la implementación de algunas políticas públicas sociales, es deber institucional indagar sobre algunas variables poblacionales diferenciales para saber qué sectores de la población acceden a nuestros servicios.\nEl suministro de esta información por parte de la ciudadanía es de carácter voluntario y la administración de la misma por parte de la Entidad es de carácter reservado.",
						colSpan: 3,
						style: "titulo"
					},
					{},
					{}],
					[{text: "NOMBRE Y FIRMA RESPONSABLE ENTIDAD", style: "titulo"},{text: ""}, {text: "C.C", style: "titulo"}],
					[{text: "NOMBRE Y FIRMA RESPONSABLE IDPC", style: "titulo"}, {text: ""}, {text:"C.C", style: "titulo"}]
					]
				}
			}
			],
			],
			pageOrientation: 'landscape',
			styles: {
				texto_tabla: {
					fontSize: 10,
				},
				titulo_tabla:{
					fontSize: 11,
					bold: true,
					fillColor: '#cccccc'
				},
				titulo_principal:{
					alignment: 'center',
					fontSize: 11,
					bold: true,
					fillColor: '#eeeeee'
				},
				titulo:{
					fontSize: 11,
					bold: true,
				},
			}

		};
		pdfMake.createPdf(dd).download("reporte_asistencia_grupo_"+$("#consultar_grupo_mensual :selected").text()+"_"+$("#mes_reporte").val());
	}
});