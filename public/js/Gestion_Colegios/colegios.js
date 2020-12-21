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
		$('.nombre_sede').each(function() {
			console.log($(this).val('.localidad_sede')); 
			//sedes_instituciones.push(new Array($(this).val('.localidad_sede'), $(this).val('.upz_sede'), $(this).val('.nombre_sede'), $(this).val('.dane_sede')));
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
				//sedes: sedes_instituciones
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

	
	
	$("#form-registrar-asistencia").submit(function(e){
		var checkbox_asistencia_beneficiario = new Array();
		$('.asistencia_actividad').each(function() {
			var check;
			if($(this).is(":checked")){
				check=1;
			}else{
				check=0;
			}
			checkbox_asistencia_beneficiario.push(new Array($(this).data('id-beneficiario'), check));
		});
		//checkbox_asistencia_beneficiario = JSON.stringify(checkbox_asistencia_beneficiario);
		e.preventDefault();		
		$.ajax({
			url: "registrarAsistencia",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_municipio: $("#id_municipio").val(),
				id_escenario: $("#id_escenario").val(),
				id_grupo: $("#grupos_asistencia").val(),
				fecha: $("#fecha_actividad").val(),
				hora_inicio: $("#hora_inicio").val(),
				hora_fin: $("#hora_fin").val(),
				nombre_actividad: $("#nombre_actividad").val(),
				beneficiarios: checkbox_asistencia_beneficiario
			},
			success: function(data) {
				if(data == 200){
					Swal.fire("Éxito", "Se registró correctamente la asistencia", "success");
					$(":input").val('');
					$("#grupos_asistencia").selectpicker("refresh");
					$("#div_registro_asistencia").hide();
				}
			},
			error: function(data){
				Swal.fire("Error", "No se pudo registrar la asistencia, por favor inténtelo nuevamente", "error");
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
				swal("Error", "No se pudo obtener el listado de estudiantes del grupo, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

});