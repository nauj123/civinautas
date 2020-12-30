var options_meses;

$(document).ready(function(){
	getMeses();

	$("#mes-reporte-consolidado").html(options_meses).selectpicker("refresh");
	$("#mes-reporte-consolidado-mensual-ciclo-vital").html(options_meses).selectpicker("refresh");

	var tabla_config = {
		autoWidth: false,
		responsive: true,
		pageLength: 100,
		paging: false,
		info: false,
		dom: 'Bfrtip',
		buttons: [
		'excel'
		],
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
				// $("#div-consulta-archivos-simat").show();
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
				// $("#div-consulta-archivos-simat").show();
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

	$('a[href="#registrar-sistematizacion"]').click(function() {
		limpiarCajasTexto('#form-guardar-sistematizacion')
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
				// $("#div-consulta-archivos-simat").show();
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
	})
});