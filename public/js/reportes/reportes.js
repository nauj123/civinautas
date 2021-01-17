var options_meses;

$(document).ready(function(){
	getMeses();

	$("#mes-reporte-consolidado").html(options_meses).selectpicker("refresh");
	$("#mes-reporte-consolidado-mensual-ciclo-vital").html(options_meses).selectpicker("refresh");
	$("#mes-reporte-cualitativo").html(options_meses).selectpicker("refresh");
	
	var tabla_config = {
		autoWidth: false,
		responsive: true,
		pageLength: 100,
		paging: false,
		info: false,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excel',
			text: 'Descargar datos',
			filename: 'Datos'
		}],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	};

	var tabla_reporte_consolidado = $("#tabla-reporte-consolidado").DataTable(tabla_config);
	var tabla_reporte_consolidado_mensual_ciclo_vital = $("#tabla-reporte-consolidado-mensual-ciclo-vital").DataTable(tabla_config);
	var tabla_reporte_consolidado_global_ciclo_vital = $("#tabla-reporte-consolidado-global-ciclo-vital").DataTable(tabla_config);
	var tabla_reporte_asistencias = $("#tabla-reporte-asistencias").DataTable(tabla_config);
	var tabla_reporte_cualitativo = $("#tabla-reporte-cualitativo").DataTable(tabla_config);
	var tabla_consultar_grupos = $("#tabla-consultar-grupos").DataTable(tabla_config);
	var tabla_consultar_diplomados = $("#tabla-consultar-diplomados").DataTable(tabla_config);

	function getMeses(){
		options_meses = "";
		$.ajax({
			url: "../administracion/getMeses",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_meses += data["option"]
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de meses, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_meses;
	}

	$('#form-reporte-consolidado').on('submit', function (e) {
		e.preventDefault();
		tabla_reporte_consolidado.clear().draw();
		$.ajax({
			url: "getReporteConsolidado",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				mes: $("#mes-reporte-consolidado").val(),
			},
			success: function(data) {
				$("#div-tabla-reporte-consolidado").show();
				data.forEach((value, index) => {
					rowNode = tabla_reporte_consolidado.row.add([
						data[index]["CODIGO_DANE"],
						data[index]["NUMERO LOCALIDAD"],
						data[index]["NOMBRE LOCALIDAD"],
						data[index]["INSTITUCION EDUCATIVA"],
						data[index]["SEDE"],
						data[index]["JORNADA"],
						data[index]["GRADO"],
						data[index]["PRIMER_APELLIDO"],
						data[index]["SEGUNDO_APELLIDO"],
						data[index]["PRIMER_NOMBRE"],
						data[index]["SEGUNDO_NOMBRE"],
						data[index]["TIPO_IDENTIFICACION"],
						data[index]["NUM_DOC"],
						data[index]["SIMAT"],
						data[index]["GENERO"],
						data[index]["FECHA NACIMIENTO"],
						data[index]["ETNIA"],
						data[index]["POBLACION_VICTIMA"],
						data[index]["CONDICION_DISCAPACIDAD"],
						data[index]["FECHA_IMPACTO"],
						data[index]["HORA_INICIAL"],
						data[index]["HORA_FINAL"],
						data[index]["ASISTENCIA_(SI/NO)"],
						data[index]["LINEA_PEDAGÓGICA"],
						data[index]["CENTRO_INTERÉS"],
						data[index]["ACTIVIDAD"],
						data[index]["ESCENARIO"],
						data[index]["DETALLE ESCENARIO"],
						data[index]["ENTIDAD_ARCHIVO"],
						data[index]["CONVENIO"],
						data[index]["TIPO_DOCUMENTO_FORMADOR"],
						data[index]["NO_ DOCUMENTO_FORMADOR"],
						data[index]["GRUPO"],
						data[index]["NOVEDAD DE REPORTE"],
						]).draw().node();
				});
				$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.responsive.recalc();
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$('#form-consolidado-mensual-ciclo-vital').on('submit', function (e) {
		e.preventDefault();
		tabla_reporte_consolidado_mensual_ciclo_vital.clear().draw();
		$.ajax({
			url: "getConsolidadoCicloVital",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				mes: $("#mes-reporte-consolidado-mensual-ciclo-vital").val(),
			},
			success: function(data) {
				$("#div-tabla-reporte-consolidado-mensual-ciclo-vital").show();
				data.forEach((value, index) => {
					rowNode = tabla_reporte_consolidado_mensual_ciclo_vital.row.add([
						data[index]["NOMBRE_INSTITUCION"],
						data[index]["LOCALIDAD"],
						data[index]["HOMBRES_0_6"],
						data[index]["MUJERES_0_6"],
						data[index]["HOMBRES_7_13"],
						data[index]["MUJERES_7_13"],
						data[index]["HOMBRES_14_17"],
						data[index]["MUJERES_14_17"],
						data[index]["HOMBRES_18_26"],
						data[index]["MUJERES_18_26"],
						data[index]["HOMBRES_27_59"],
						data[index]["MUJERES_27_59"],
						data[index]["HOMBRES_60"],
						data[index]["MUJERES_60"],
						data[index]["SUBTOTAL_HOMBRES"],
						data[index]["SUBTOTAL_MUJERES"],
						data[index]["TOTAL"]
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("a[href='#consolidado-global-ciclo-vital']").click(function(){
		tabla_reporte_consolidado_global_ciclo_vital.clear().draw();

		$.ajax({
			url: "getConsolidadoCicloVital",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				data.forEach((value, index) => {
					rowNode = tabla_reporte_consolidado_global_ciclo_vital.row.add([
						data[index]["NOMBRE_INSTITUCION"],
						data[index]["LOCALIDAD"],
						data[index]["HOMBRES_0_6"],
						data[index]["MUJERES_0_6"],
						data[index]["HOMBRES_7_13"],
						data[index]["MUJERES_7_13"],
						data[index]["HOMBRES_14_17"],
						data[index]["MUJERES_14_17"],
						data[index]["HOMBRES_18_26"],
						data[index]["MUJERES_18_26"],
						data[index]["HOMBRES_27_59"],
						data[index]["MUJERES_27_59"],
						data[index]["HOMBRES_60"],
						data[index]["MUJERES_60"],
						data[index]["SUBTOTAL_HOMBRES"],
						data[index]["SUBTOTAL_MUJERES"],
						data[index]["TOTAL"]
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$('#form-reporte-asistencias').on('submit', function (e) {
		e.preventDefault();
		tabla_reporte_asistencias.clear().draw();
		$.ajax({
			url: "getConsultaCompleta",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_Grupo: $("#grupo-mediador").val(),
				anio: $("#mes-reporte-asistencias").val()
			},
			success: function(data) {
				$("#div-tabla-reporte-asistencias").show("");
				data.forEach((value, index) => {				
					rowNode = tabla_reporte_asistencias.row.add([		
						data[index]["LOCALIDAD"],
						data[index]["TIPO_INSTITUCION"],
						data[index]["INSTITUCION"],
						data[index]["DANE"],
						data[index]["NOMBRE_GRUPO"],
						data[index]["MEDIADOR"],
						data[index]["FECHA_ATENCION"],
						data[index]["HORARIO"],
						data[index]["MODALIDAD"],
						data[index]["TIPO_ACTIVIDAD"],
						data[index]["RECURSOS"],
						data[index]["IDENTIFICACION"],
						data[index]["NOMBRES"],
						data[index]["APELLIDOS"],
						data[index]["DIRECCION"],
						data[index]["CORREO"],
						data[index]["CELULAR"],
						data[index]["ENFOQUE"],
						data[index]["ESTRATO"],
						data[index]["FECHANACIMIENTO"],
						data[index]["GENERO"],
						data[index]["ASISTENCIA"]
						]).draw().node();				
				});
				$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.responsive.recalc();
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	})

	$('#form-reporte-cualitativo').on('submit', function (e) {
		e.preventDefault();
		tabla_reporte_cualitativo.clear().draw();
		$.ajax({
			url: "getReporteCualitativo",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				mes: $("#mes-reporte-cualitativo").val()
			},
			success: function(data) {
				$("#div-tabla-reporte-cualitativo").show("");
				data.forEach((value, index) => {				
					rowNode = tabla_reporte_cualitativo.row.add([	
						data[index]["FECHA"],
						data[index]["ACTIVIDAD"],
						data[index]["DETALLE"],
						data[index]["INSTITUCION"],
						data[index]["GRUPO"],
						data[index]["MEDIADOR"],
						"<center>"+data[index]["ESTUDIANTES"]+"</center>"
						]).draw().node();				
				});
				$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.responsive.recalc();
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	})

	$('a[href="#consultar_grupos"]').on('shown.bs.tab', function(e){
		getTotalGrupos();
	});

	function getTotalGrupos() {
		$.ajax({
			url: "../Gestion_Grupos/getTotalGrupos",
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

	$('a[href="#total_diplomados"]').on('shown.bs.tab', function(e){
		getTotalDiplomados();
	});

	function getTotalDiplomados() {
		$.ajax({
			url: "../Diplomados/getTotalDiplomados",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				info_consultar_diplomados = data;
				tabla_consultar_diplomados.clear().draw();
				info_consultar_diplomados.forEach((value, index) => {				
					rowNode = tabla_consultar_diplomados.row.add([						
						"<center>"+info_consultar_diplomados[index]["IDDIPLOMADO"]+"</center>",
						"<center>"+info_consultar_diplomados[index]["NOMBRE"]+"</center>",
						"<center>"+info_consultar_diplomados[index]["MEDIADOR"]+"</center>",
						"<center>"+info_consultar_diplomados[index]["DURACION"]+"</center>",
						"<center>"+info_consultar_diplomados[index]["TEMATICA"]+"</center>",						
						"<center>"+info_consultar_diplomados[index]["PARTICIPANTES"]+"</center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de los diplomados registrados en el sistema, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}
});