$(document).ready(function(){
	var url = window.location.href;
	if(url.indexOf("home") >= 0){
		$.ajax({
			url: "getTotalColegios",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				$("#cantidad-colegios").html("").html(data)
			},
			error: function(data){

			},
			async: false
		});

		$.ajax({
			url: "getTotalGrupos",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				$("#cantidad-grupos").html("").html(data)			
			},
			error: function(data){

			},
			async: false
		});

		$.ajax({
			url: "getTotalBeneficiarios",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				$("#cantidad-beneficiarios").html("").html(data)			
			},
			error: function(data){
				console.log(data);
			},
			fail: function(data) {
				console.log(data);
			},
			async: false
		});

		$.ajax({
			url: "getTotalBeneficiariosPorGenero",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				var myChart = echarts.init(document.getElementById('echart-beneficiarios-por-genero'));
				myChart.setOption(JSON.parse(data["json"]));
			},
			error: function(data){

			},
			async: false
		});

		$.ajax({
			url: "getTotalAtenciones",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				var myChart = echarts.init(document.getElementById('echart-total-atenciones'));
				myChart.setOption(JSON.parse(data["json"]));
			},
			error: function(data){

			},
			async: false
		});
	}
});