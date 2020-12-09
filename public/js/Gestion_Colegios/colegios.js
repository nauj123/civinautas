var tabla_info_instituciones;
var info_instituciones;

$(document).ready(function () {

	tabla_info_instituciones = $("#tabla-info-instituciones").DataTable({
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

	getInstitucionesEducativas();


	$(document).delegate('#Numero-sedes', 'change', function() {
		var Numero_sedes = $(this).val();
		console.log(Numero_sedes);
		$("#Numero_sedes").append("<table class='table' style='width:100%' id='tabla_Sedes_Colegio'>"+
		"<thead><tr>"+
		"<th style='width: 2%; vertical-align: middle;'>#</th>"+
		"<th style='width: 49%'>Nombre de la sede</th>"+
		"<th style='width: 49%'>Dirección</th>"+
		"</tr></thead><tbody></tbody></table>");
		for(i=1 ; i<=Numero_sedes; i++){
	  $("#tabla_Sedes_Colegio").append("<tr id='" + i + "'>"+
		"<td style='width: 2%; vertical-align: middle;'>"+i+"</td>"+
		"<td style='width: 49%'>"+
		"<div class='form-group'>"+
		"<input type='text' class='form-control' placeholder='Nombre sede' id='TX_Dia_"+i+"' name='TX_Dia_"+i+"'><span class='help-block' id='error'></span>"+
		"</div>"+
		"</td>"+
		"<td style='width: 49%'>"+
		"<div class='form-group'>"+
		"<input type='text' class='form-control fecha' placeholder='Dirección' id='TX_Fecha_"+i+"'' name='TX_Fecha_"+i+"''><span class='help-block' id='error'></span>"+
		"</div>"+
		"</td>"+		
		"</tr>");	
		}		
	});

	$("#form-nueva-institucion").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "guardarNuevaInstitucion",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				tipo_institucion: $("#tipo-institucion").val(),
				localidad: $("#localidad").val(),
				upz: $("#upz").val(),
				nombre_colegio: $("#nombre-institucion").val(),
				codigo_dane: $("#codigo-dane").val(),
				iniciales_institucion: $("#iniciales-institucion").val(),
				sede: $("#Numero-sedes").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Institución educativa registrada correctamente, ya puede ser consultado en el listado, desde este momento podrá ingresar a la plataforma", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#modal-crear-institucion").modal('hide');
					//getUsuarios();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	

	function getInstitucionesEducativas() {
		$.ajax({
			url: "getInstitucionesEducativas",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				info_instituciones = data;	
				tabla_info_instituciones.clear().draw();
				info_instituciones.forEach((value, index) => {

					rowNode =tabla_info_instituciones.row.add([
						"<center>"+info_instituciones[index]["LOCALIDAD"]+"</center>",
						"<center>"+info_instituciones[index]["UPZ"]+"</center>",
						"<center>"+info_instituciones[index]["TIPOINSTITUCION"]+"</center>",
						"<center>"+info_instituciones[index]["NOMBRE"]+"</center>",
						"<center>"+info_instituciones[index]["CODIGODANE"]+"</center>",
						"<center>"+info_instituciones[index]["SEDES"]+"</center>",
						"<center><buton type='button' class='btn btn-warning editar' data-id-usuario='"+info_instituciones[index]["IDINSTITUCIONAL"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Actualizar</buton></center>"
						]).draw().node();
				});
			},
			error: function(data){
				Swal.fire("Error", "No se pudo obtener el listado de tipos de escenario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipodocumento;
	}

});