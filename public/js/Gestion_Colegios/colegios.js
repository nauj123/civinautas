var tabla_info_instituciones; 
var info_instituciones;
var options_tipo_institucion;
var options_localidades;

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
	getTipoInstitucion(6);
	getLocalidades();

	$("#tipo-institucion").html(options_tipo_institucion).selectpicker("refresh");

	$("#localidad").html(options_localidades).change(function(){
		$("#upz").html(getUpz($("#localidad").val())).selectpicker("refresh");
	}).selectpicker("refresh");

	$("#tipo-institucion-m").html(options_tipo_institucion).selectpicker("refresh");

	$("#localidad-m").html(options_localidades).change(function(){
		$("#upz-m").html(getUpz($("#localidad-m").val())).selectpicker("refresh");
	}).selectpicker("refresh");

	function getTipoInstitucion(id_parametro) {
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
				options_tipo_institucion += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipo_institucion;
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

	function getUpz(id_localidad) {
		console.log(id_localidad);
		var options_upz = "";
		$.ajax({
			url: "../administracion/getUpz",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_localidad: id_localidad
			},
			success: function(data) {
				options_upz += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de upz, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_upz;
	}

	$("#Numero-sedes").on("change", function() {
		$("#registrar_sedes").html("");
		var Numero_sedes = $(this).val();
		$("#registrar_sedes").append("<table class='table' style='width:100%' id='tabla_Sedes_Colegio'>"+
			"<thead><tr>"+
			"<th style='width: 2%; vertical-align: middle;'>#</th>"+
			"<th style='width: 25%'>Localidad</th>"+
			"<th style='width: 25%'>Upz</th>"+
			"<th style='width: 24%'>Nombre de la sede</th>"+
			"<th style='width: 24%'>Dane 12</th>"+
			"</tr></thead><tbody></tbody></table>");
		for(i=1 ; i<=Numero_sedes; i++){
			$("#tabla_Sedes_Colegio").append("<tr id='" + i + "'>"+
				"<td style='width: 2%; vertical-align: middle;'>"+i+"</td>"+
				"<td style='width: 24%'>"+
				"<div class='form-group'>"+
				"<select class='form-control selectpicker localidad_sede' title='Seleccione una opción' id='TX_LocalidadSede_"+i+"' name='TX_LocalidadSede_"+i+"' required></select>"+
				"</div>"+
				"</td>"+
				"<td style='width: 24%'>"+
				"<div class='form-group'>"+
				"<select class='form-control selectpicker upz_sede' title='Seleccione una opción' id='TX_UpzSede_"+i+"' name='TX_UpzSede_"+i+"'></select>"+
				"</div>"+
				"</td>"+
				"<td style='width: 25%'>"+
				"<div class='form-group'>"+
				"<input type='text' class='form-control nombre_sede' placeholder='Nombre de la sede' id='TX_Sede_"+i+"' name='TX_Sede_"+i+"' required>"+
				"</div>"+
				"</td>"+
				"<td style='width: 25%'>"+
				"<div class='form-group'>"+
				"<input type='text' class='form-control dane_sede' placeholder='Dane 12' id='TX_Dane12_"+i+"' name='TX_Dane12_"+i+"'>"+
				"</div>"+
				"</td>"+			
				"</tr>");

			$("#TX_LocalidadSede_"+i).html(options_localidades).selectpicker("refresh");
			$("#TX_UpzSede_"+i).selectpicker("refresh");
		}
	});

	$("#modal-crear-institucion").on("change", ".selectpicker.localidad_sede", function(){
		let id_elemento =  $(this).attr("id").split("_")[2];
		let id_localidad = $(this).val();
		$("#TX_UpzSede_"+id_elemento).html(getUpz(id_localidad)).selectpicker("refresh");
	});

	$("#form-nueva-institucion").submit(function (e) {
		var sedes_instituciones = new Array();
		i=1;
		$('.nombre_sede').each(function() {
			sedes_instituciones.push(new Array($("#TX_LocalidadSede_"+i).val(),$("#TX_UpzSede_"+i).val(),$("#TX_Sede_"+i).val(),$("#TX_Dane12_"+i).val(),));
			console.log(sedes_instituciones); 
			i++
		});
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
				sede: $("#Numero-sedes").val(),
				sedes: sedes_instituciones
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Institución educativa registrada correctamente, ya puede ser consultado en el listado", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#modal-crear-institucion").modal('hide');
					getInstitucionesEducativas();
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
						"<center><buton type='button' class='btn btn-warning editar' data-id-institucion='"+info_instituciones[index]["IDINSTITUCIONAL"]+"' data-toggle='modal' data-target='#modal-actualizar-institucion'>Actualizar</buton></center>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de estudiantes del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#tabla-info-instituciones").on("click", ".editar",  function(){
		getInformacionInstitucion($(this).attr("data-id-institucion"));
	});

	function getInformacionInstitucion(institucion) {
		$.ajax({
			url: "getInformacionInstitucion",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_institucion: institucion
			},
			success: function(data) {
				$("#id-institucion-m").val(data["Pk_Id_Institucion"]);
				$("#tipo-institucion-m").val(data["Fk_Tipo_Institucion"]).selectpicker("refresh").trigger("change");
				$("#nombre-institucion-m").val(data["VC_Nombre_Institucion"]);
				$("#codigo-dane-m").val(data["VC_Codigo_Dane"]);
				$("#iniciales-institucion-m").val(data["VC_Iniciales"]);
				$("#localidad-m").val(data["Fk_Id_Localidad"]).selectpicker("refresh").trigger("change");
				$("#upz-m").val(data["Fk_Id_Upz"]).selectpicker("refresh").trigger("change");
				$("#Numero-sedes-m").val(data["IN_Sedes"]).selectpicker("refresh").trigger("change"); 
			},
			error: function(data){
				Swal.fire("Error", "No se pudo obtener la información de la institución, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}


	$("#Numero-sedes-m").on("change", function() {
		$("#registrar_sedes_m").html("");
		var Numero_sedesm = $(this).val();
		$("#registrar_sedes_m").append("<table class='table' style='width:100%' id='tabla_Sedes_Colegio'>"+
			"<thead><tr>"+
			"<th style='width: 2%; vertical-align: middle;'>#</th>"+
			"<th style='width: 25%'>Localidad</th>"+
			"<th style='width: 25%'>Upz</th>"+
			"<th style='width: 24%'>Nombre de la sede</th>"+
			"<th style='width: 24%'>Dane 12</th>"+
			"</tr></thead><tbody></tbody></table>");
		for(i=1 ; i<=Numero_sedesm; i++){
			$("#tabla_Sedes_Colegio").append("<tr id='" + i + "'>"+
				"<td style='width: 2%; vertical-align: middle;'>"+i+"</td>"+
				"<td style='width: 24%'>"+
				"<div class='form-group'>"+
				"<select class='form-control selectpicker localidad_sedem' title='Seleccione una opción' id='TX_LocalidadSedem_"+i+"' name='TX_LocalidadSedem_"+i+"' required></select>"+
				"</div>"+
				"</td>"+
				"<td style='width: 24%'>"+
				"<div class='form-group'>"+
				"<select class='form-control selectpicker upz_sedem' title='Seleccione una opción' id='TX_UpzSedem_"+i+"' name='TX_UpzSedem_"+i+"'></select>"+
				"</div>"+
				"</td>"+
				"<td style='width: 25%'>"+
				"<div class='form-group'>"+
				"<input type='text' class='form-control nombre_sedem' placeholder='Nombre de la sede' id='TX_Sedem_"+i+"' name='TX_Sedem_"+i+"' required>"+
				"</div>"+
				"</td>"+
				"<td style='width: 25%'>"+
				"<div class='form-group'>"+
				"<input type='text' class='form-control dane_sedem' placeholder='Dane 12' id='TX_Dane12m_"+i+"' name='TX_Dane12m_"+i+"'>"+
				"</div>"+
				"</td>"+			
				"</tr>");

			$("#TX_LocalidadSedem_"+i).html(options_localidades).selectpicker("refresh");
			$("#TX_UpzSedem_"+i).selectpicker("refresh");
		}
	});

	$("#modal-actualizar-institucion").on("change", ".selectpicker.localidad_sedem", function(){
		let id_elemento =  $(this).attr("id").split("_")[2];
		console.log(id_elemento);
		let id_localidad = $(this).val();
		$("#TX_UpzSedem_"+id_elemento).html(getUpz(id_localidad)).selectpicker("refresh");
	});


	$("#form-editar-institucion").submit(function (e) {
		var sedes_instituciones = new Array();
		i=1;
		$('.nombre_sede').each(function() {
			sedes_instituciones.push(new Array($("#TX_LocalidadSedem_"+i).val(),$("#TX_UpzSedem_"+i).val(),$("#TX_Sedem_"+i).val(),$("#TX_Dane12m_"+i).val(),));
			console.log(sedes_instituciones); 
			i++
		});
		e.preventDefault();
		$.ajax({
			url: "actualizarInformacionInstitucion",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_institucion_m: $("#id-institucion-m").val(),
				tipo_institucion_m: $("#tipo-institucion-m").val(),
				localidad_m: $("#localidad-m").val(),
				upz_m: $("#upz-m").val(),
				nombre_colegio_m: $("#nombre-institucion-m").val(),
				codigo_dane_m: $("#codigo-dane-m").val(),
				iniciales_institucion_m: $("#iniciales-institucion-m").val(),
				sede_m: $("#Numero-sedes-m").val(),
				sedes_m: sedes_instituciones
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Institución educativa registrada correctamente, ya puede ser consultado en el listado", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');
					$("#modal-actualizar-institucion").modal('hide');
					getInstitucionesEducativas();
				}
			},
			error: function (data) {
				swal("Error", "No fue posible guardar la información de la institución educativa, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

});