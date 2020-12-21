var options_meses;

$(document).ready(function(){
	getMeses();

	$("#mes-reporte-consolidado").html(options_meses).selectpicker("refresh");

	var tabla_reporte_consolidado = $("#tabla-reporte-consolidado").DataTable({
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
	});


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


	})
});