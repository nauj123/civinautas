var datos = "";
$(document).ready(function(){

	$("#mes-simat").html(getMeses()).selectpicker("refresh");
	$("#institucion").html(getOptionsInstituciones()).selectpicker("refresh");
	$("#consulta-simat-colegio").html(getOptionsInstituciones()).selectpicker("refresh");

	function getOptionsInstituciones(){
		var options_instituciones = "";
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
				swal("Error", "No se pudo obtener el listado de meses, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_instituciones;
	}

	function getMeses(){
		var options_meses = "";
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
     			swal("Error", "No se pudo guardar la información, por favor inténtelo nuevamente", "error");
     		},
     		async: true
     	});

     	//data preview
     	//var output = document.getElementById('result');
     	//output.innerHTML = JSON.stringify(result, null, 2);
     };
     FR.readAsArrayBuffer(file); 
 });
});