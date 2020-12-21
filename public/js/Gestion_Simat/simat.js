var datos = "";
var options_instituciones;
var options_meses;
var id_estudiante;
$(document).ready(function(){
	getMeses();
	getOptionsInstituciones();

	$("#mes-simat").html(options_meses).selectpicker("refresh");
	$("#institucion").html(options_instituciones).selectpicker("refresh");
	$("#consulta-estudiantes-colegio-simat").html(options_instituciones).selectpicker("refresh");
	$("#mes-consulta-archivos-simat").html(options_meses).selectpicker("refresh");

	tabla_config = {
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


	var tabla_consulta_archivos_simat = $("#tabla-consulta-archivos-simat").DataTable(tabla_config);
	var tabla_estudiantes_colegio_simat = $("#tabla-estudiantes-colegio-simat").DataTable(tabla_config);

	var tabla_resultados_busqueda = $("#tabla-resultados-busqueda").DataTable({
		autoWidth: false,
		responsive: true,
		pageLength: 100,
		paging: false,
		info: true,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	});


	function getOptionsInstituciones(){
		options_instituciones = "";
		$.ajax({
			url: "../Gestion_Colegios/getOptionsInstituciones",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_instituciones += data["option"]
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de colegios, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_instituciones;
	}

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

	$('#form-cargar-simat').on('submit', function (e) {
		e.preventDefault();

		swal({
			title: "Cargando...",
			text: "Espere un poco por favor.",
			imageUrl: "../../public/images/cargando.gif",
			imageWidth: 140,
			imageHeight: 70,
			showConfirmButton: false,
			allowOutsideClick: false,
			allowEscapeKey: false,
			backdrop: `
			rgba(0,0,123,0.4)
			`
		});

		var file = $("#archivo-simat")[0].files[0];

   		// input canceled, return
   		if (!file) return;

   		var FR = new FileReader();
   		FR.onload = function(e) {
   			var data = new Uint8Array(e.target.result);
   			var workbook = XLSX.read(data, {type: 'array'});
   			var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

     	// header: 1 instructs xlsx to create an 'array of arrays'
     	result = XLSX.utils.sheet_to_json(firstSheet, { header: 1, defval: "" });
     	datos = JSON.stringify(result);

     	$.ajax({
     		url: "subirArchivo",
     		type: 'POST',
     		dataType: 'json',
     		headers: {
     			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     		},
     		data:{
     			info: datos,
     			mes: $("#mes-simat").val(),
     			codigo_institucion: $("#institucion").val(),
     		},
     		success: function(data) {
     			swal.close();
     			swal("Éxito", "Se han creado "+data["creado"]+" estudiantes y actualizado "+data["actualizado"], "success");
     			$("#archivo-simat").val("");
     			$("#mes-simat").selectpicker("val", "");
     			$("#institucion").selectpicker("val", "");
     		},
     		error: function(data){
     			if(data["responseJSON"]["message"] == "Call to a member function format() on bool"){
     				swal("Error", "No se pudo guardar la información, el formato de fecha de nacimiento es incorrecto, compruebe que el formato sea DD/MM/AAAA.", "error");
     			}else{
     				swal("Error", "No se pudo guardar la información, por favor inténtelo nuevamente", "error");
     			}
     		},
     		async: true
     	});
     	//data preview
     	//var output = document.getElementById('result');
     	//output.innerHTML = JSON.stringify(result, null, 2);
     };
     FR.readAsArrayBuffer(file); 
 });
	$('#form-archivos-simat').on('submit', function (e) {
		e.preventDefault();

		tabla_consulta_archivos_simat.clear().draw();

		$.ajax({
			url: "getInfoArchivosSubidos",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				mes: $("#mes-consulta-archivos-simat").val(),
			},
			success: function(data) {
				$("#div-consulta-archivos-simat").show();
				data.forEach((value, index) => {
					rowNode = tabla_consulta_archivos_simat.row.add([
						data[index]["Fecha_cargue"],
						data[index]["Colegio"],
						data[index]["Total_estudiantes"]
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
				
			},
			async: false
		});
	});

	$('#form-buscar-estudiante').on('submit', function (e) {
		e.preventDefault();

		tabla_resultados_busqueda.clear().draw();

		$.ajax({
			url: "buscarEstudiante",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				busqueda: $("#busqueda-estudiante").val(),
			},
			success: function(data) {
				$("#div-resultados-busqueda").show();
				data.forEach((value, index) => {
					rowNode = tabla_resultados_busqueda.row.add([
						data[index]["NRO_DOCUMENTO"],
						data[index]["Nombre"],
						"<button class='btn btn-block btn-primary modificar-estudiante' data-toggle='modal' data-target='#modal-modificar-info-estudiante' data-id-estudiante-simat='"+data[index]["Pk_Id_Estudiante_Simat"]+"' type='button'><i class='fas fa-edit'></i></button>"
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
				
			},
			async: false
		});
	});

	$("#tabla-resultados-busqueda").on("click", ".modificar-estudiante",  function(){
		id_estudiante = $(this).attr("data-id-estudiante-simat");
		$.ajax({
			url: "getDatosEstudiante",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_estudiante: id_estudiante
			},
			success: function(data) {
				$("#tipo-documento").selectpicker("val", data["TIPO_DOCUMENTO"]);
				$("#numero-documento").val(data["NRO_DOCUMENTO"]);
				$("#primer-nombre").val(data["NOMBRE1"]);
				$("#segundo-nombre").val(data["NOMBRE2"]);
				$("#primer-apellido").val(data["APELLIDO1"]);
				$("#segundo-apellido").val(data["APELLIDO2"]);
				$("#fecha-nacimiento").val(data["FECHA_NACIMIENTO"]);
				$("#genero").selectpicker("val", data["GENERO"]);
				$("#direccion").val(data["DIRECCION_RESIDENCIA"]);
				$("#telefono").val(data["TEL"]);
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$('#form-modificar-estudiante-simat').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: "modificarEstudiante",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_estudiante: id_estudiante,
				tipo_documento: $("#tipo-documento").val(),
				numero_documento: $("#numero-documento").val(),
				primer_nombre: $("#primer-nombre").val(),
				segundo_nombre: $("#segundo-nombre").val(),
				primer_apellido: $("#primer-apellido").val(),
				segundo_apellido: $("#segundo-apellido").val(),
				fecha_nacimiento: $("#fecha-nacimiento").val(),
				genero: $("#genero").val(),
				direccion: $("#direccion").val(),
				telefono: $("#telefono").val()
			},
			success: function(data) {
				swal("Éxito","Se ha modificado la información del estudiante correctamente","success");
				$("#modal-modificar-info-estudiante").modal("hide");
				$("#btn-busqueda").click();
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: false
		});

	});

	$('#form-estudiantes-colegio-simat').on('submit', function (e) {
		e.preventDefault();

		swal({
			title: "Cargando...",
			text: "Espere un poco por favor.",
			imageUrl: "../../public/images/cargando.gif",
			imageWidth: 140,
			imageHeight: 70,
			showConfirmButton: false,
			allowOutsideClick: false,
			allowEscapeKey: false,
			backdrop: `
			rgba(0,0,123,0.4)
			`
		});

		tabla_estudiantes_colegio_simat.clear().draw();

		$.ajax({
			url: "getEstudiantesColegioSimat",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_colegio: $("#consulta-estudiantes-colegio-simat").val()
			},
			success: function(data) {

				swal.close();
				$("#div-consulta-estudiantes-colegio-simat").show();

				data.forEach((value, index) => {
					rowNode = tabla_estudiantes_colegio_simat.row.add([
						data[index]["ANO_INF"],
						data[index]["MES_INF"],
						data[index]["NRO_DOCUMENTO"],
						data[index]["APELLIDO1"],
						data[index]["APELLIDO2"],
						data[index]["NOMBRE1"],
						data[index]["NOMBRE2"],
						data[index]["FECHA_NACIMIENTO"],
						data[index]["GENERO"],
						data[index]["DIRECCION_RESIDENCIA"],
						data[index]["TEL"],
						data[index]["MUN_CODIGO"],
						data[index]["CODIGO_DANE"],
						data[index]["DANE_ANTERIOR"],
						data[index]["CONS_SEDE"],
						data[index]["TIPO_DOCUMENTO"],
						data[index]["EXP_DEPTO"],
						data[index]["EXP_MUN"],
						data[index]["RES_DEPTO"],
						data[index]["RES_MUN"],
						data[index]["ESTRATO"],
						data[index]["SISBEN"],
						data[index]["NAC_DEPTO"],
						data[index]["NAC_MUN"],
						data[index]["POB_VICT_CONF"],
						data[index]["DPTO_EXP"],
						data[index]["MUN_EXP"],
						data[index]["PROVIENE_SECTOR_PRIV"],
						data[index]["PROVIENE_OTR_MUN"],
						data[index]["TIPO_DISCAPACIDAD"],
						data[index]["CAP_EXC"],
						data[index]["ETNIA"],
						data[index]["RES"],
						data[index]["INS_FAMILIAR"],
						data[index]["TIPO_JORNADA"],
						data[index]["CARACTER"],
						data[index]["ESPECIALIDAD"],
						data[index]["GRADO"],
						data[index]["GRUPO"],
						data[index]["METODOLOGIA"],
						data[index]["MATRICULA_CONTRATADA"],
						data[index]["REPITENTE"],
						data[index]["NUEVO"],
						data[index]["SIT_ACAD_ANO_ANT"],
						data[index]["CON_ALUM_ANO_ANT"],
						data[index]["FUE_RECU"],
						data[index]["ZON_ALU"],
						data[index]["CAB_FAMILIA"],
						data[index]["BEN_MAD_FLIA"],
						data[index]["BEN_VET_FP"],
						data[index]["BEN_HER_NAC"],
						data[index]["CODIGO_INTERNADO"],
						data[index]["CODIGO_VALORACION_1"],
						data[index]["CODIGO_VALORACION_2"],
						data[index]["NUM_CONVENIO"],
						data[index]["PER_ID"],
						data[index]["CODIGO_ESTABLECIMIENTO_EDUCATIVO"],
						data[index]["NOMBRE_ESTABLECIMIENTO_EDUCATIVO"],
						data[index]["NOM_GRADO"],
						data[index]["PAIS_ORIGEN"],
						]).draw().node();
				});
				$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.responsive.recalc();
			},
			error: function(data){
				swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
			},
			async: true
		});

	});
});