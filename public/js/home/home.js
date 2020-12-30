$(document).ready(function(){
	var url = window.location.href;
	if(url.indexOf("home") >= 0){

		getTotalAtenciones();
		getTotalBeneficiariosAtendidosPorGenero();
		getTotalBeneficiariosPorGenero();
		getTotalCiclosVitales();
		getTotalColegios();
		getTotalGrupos();
		getTotalBeneficiarios();
	}

	$("#filtro-anio").on("change", function(){
		getTotalAtenciones($(this).val());
		getTotalBeneficiariosAtendidosPorGenero($(this).val());
		getTotalBeneficiariosPorGenero($(this).val());
		getTotalCiclosVitales($(this).val());
		getTotalColegios($(this).val());
		getTotalGrupos($(this).val());
		getTotalBeneficiarios($(this).val());
	});

	function getTotalAtenciones(anio=2020){
		$.ajax({
			url: "getTotalAtenciones",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				if(data["json"] == null){
					$("#echart-total-atenciones").html("").html("No hay información disponible para el año seleccionado");
				}else{
					var myChart = "";
					myChart = echarts.dispose(document.getElementById('echart-total-atenciones'));
					myChart = echarts.init(document.getElementById('echart-total-atenciones'));
					myChart.setOption(JSON.parse(data["json"]));
				}
			},
			error: function(data){

			},
			async: false
		});
	}

	function getTotalColegios(anio=2020){
		$.ajax({
			url: "getTotalColegios",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				$("#cantidad-colegios").html("").html(data)
			},
			error: function(data){

			},
			async: false
		});
	}

	function getTotalGrupos(anio=2020){
		$.ajax({
			url: "getTotalGrupos",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				$("#cantidad-grupos").html("").html(data)			
			},
			error: function(data){

			},
			async: false
		});
	}

	function getTotalBeneficiarios(anio=2020){
		$.ajax({
			url: "getTotalBeneficiarios",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				$("#cantidad-beneficiarios").html("").html(data)			
			},
			error: function(data){
				
			},
			async: false
		});
	}

	function getTotalBeneficiariosPorGenero(anio=2020){
		$.ajax({
			url: "getTotalBeneficiariosPorGenero",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				if(data["json"] == null){
					$("#echart-beneficiarios-por-genero").html("").html("No hay información disponible para el año seleccionado");
				}else{
					var myChart = "";
					myChart = echarts.dispose(document.getElementById('echart-beneficiarios-por-genero'));
					myChart = echarts.init(document.getElementById('echart-beneficiarios-por-genero'));
					myChart.setOption(JSON.parse(data["json"]));
				}
			},
			error: function(data){

			},
			async: false
		});
	}

	function getTotalBeneficiariosAtendidosPorGenero(anio=2020){
		$.ajax({
			url: "getTotalBeneficiariosAtendidosPorGenero",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				if(data["json"] == null){
					$("#echart-beneficiarios-atendidos-por-genero").html("").html("No hay información disponible para el año seleccionado");
				}else{
					var myChart = "";
					myChart = echarts.dispose(document.getElementById('echart-beneficiarios-atendidos-por-genero'));
					myChart = echarts.init(document.getElementById('echart-beneficiarios-atendidos-por-genero'));
					myChart.setOption(JSON.parse(data["json"]));
				}
			},
			error: function(data){

			},
			async: false
		});
	}
	function getTotalCiclosVitales(anio=2020){
		$.ajax({
			url: "getTotalCiclosVitales",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				anio: anio
			},
			success: function(data) {
				if(data["json"] == null){
					$("#echart-total-beneficiarios-ciclo-vital").html("").html("No hay información disponible para el año seleccionado");
				}else{
					var myChart = "";
					myChart = echarts.dispose(document.getElementById('echart-total-beneficiarios-ciclo-vital'));
					myChart = echarts.init(document.getElementById('echart-total-beneficiarios-ciclo-vital'));
					myChart.setOption(JSON.parse(data["json"]));
				}
			},
			error: function(data){

			},
			async: false
		});
	}
});