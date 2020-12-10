var options_gruposanguineo;
var options_tipodocumento;
var options_roles;
var tabla_info_usuarios;
var info_tabla_info_usuarios;

$(document).ready(function(){

	tabla_info_usuarios = $("#tabla-info-usuarios").DataTable({
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
	getUsuarios();
	getTiposDocumento(1);
	getroles(5);

	$("#tipo_documento").html(options_tipodocumento).selectpicker("refresh");
	$("#rol-usuario").html(options_roles).selectpicker("refresh");	
	$("#tipo-documento-m").html(options_tipodocumento).selectpicker("refresh");
	$("#rol-usuario-m").html(options_roles).selectpicker("refresh");

	function getTiposDocumento(id_parametro) {
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
				options_tipodocumento += data["option"];
			},
			error: function(data){
				Swal.fire("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipodocumento;
	}

	function getroles(id_parametro) {
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
				options_roles += data["option"];
			},
			error: function(data){
				Swal.fire("Error", "No se pudo obtener el listado de roles de usaurio, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_roles;
	}

	$("#form-nuevo-usuario").submit(function(e){
		e.preventDefault();		
		$.ajax({
			url: "guardarNuevoUsuario",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				tipo_documento: $("#tipo_documento").val(),
				identificacion: $("#documento").val(),
				primer_nombre: $("#primer_nombre").val(),
				segundo_nombre: $("#segundo_nombre").val(),
				primer_apellido: $("#primer_apellido").val(),
				segundo_apellido: $("#segundo_apellido").val(),				
				fecha_nacimiento: $("#f_nacimiento").val(),
				genero: $("#genero").val(),				
				email: $("#email").val(),
				email_verificacion: $("#email").val(),
				celular: $("#celular").val(),
				rol: $("#rol-usuario").val()
			},
			success: function(data) {
				if(data == 200){
					swal("Éxito", "Usuario registrado correctamente, desde este momento podrá ingresar a la plataforma", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');	
					$("#modal-registro-usuario").modal('hide');
					getUsuarios();				
				}
			},
			error: function(data){
				swal("Error", "No se pudo guardar el usuario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});		
	});

	function getUsuarios() {
		$.ajax({
			url: "getUsuarios",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				info_tabla_info_usuarios = data;	
				tabla_info_usuarios.clear().draw();
				info_tabla_info_usuarios.forEach((value, index) => {

					rowNode = tabla_info_usuarios.row.add([
						"<center>"+info_tabla_info_usuarios[index]["identificacion"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["nombre"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["email"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["celular"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["rol"]+"</center>",
						"<center><buton type='button' class='btn btn-warning editar' data-id-usuario='"+info_tabla_info_usuarios[index]["id"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Editar</buton></center>"
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

	var url = window.location.href;

	if(url.indexOf('perfil-usuario') != -1){
		getInfoUsuario();		
	}

	function getInfoUsuario(id_usuario="") {
		$.ajax({
			url: "getInfoUsuario",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_usuario: id_usuario
			},
			success: function(data) {
				$("#id-m").val(data["id"]);
				$("#primer-nombre-m").val(data["primer_nombre"]);
				$("#segundo-nombre-m").val(data["segundo_nombre"]);
				$("#primer-apellido-m").val(data["primer_apellido"]);
				$("#segundo-apellido-m").val(data["segundo_apellido"]);
				$("#tipo-documento-m").val(data["tipo_documento"]).selectpicker("refresh").trigger("change");
				$("#documento-m").val(data["identificacion"]);				
				$("#fecha-nacimiento-m").val(data["fecha_nacimiento"]);
				$("#genero-m").val(data["genero"]);
				$("#email-m").val(data["email"]);
				$("#celular-m").val(data["celular"]);
				$("#rol-m").val(data["rol_m"]).selectpicker("refresh").trigger("change");
			},
			error: function(data){
				Swal.fire("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#form-actualizar-usuario").submit(function(e){
		e.preventDefault();		
		$.ajax({
			url: "actualizarInfoUsuario",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_usuario: $("#id-m").val(),
				rol: $("#rol-m").val(),
				primer_nombre: $("#primer-nombre-m").val(),
				segundo_nombre: $("#segundo-nombre-m").val(),
				primer_apellido: $("#primer-apellido-m").val(),
				segundo_apellido: $("#segundo-apellido-m").val(),
				tipo_documento: $("#tipo-documento-m").val(),
				identificacion: $("#documento-m").val(),
				fecha_nacimiento: $("#fecha-nacimiento-m").val(),
				genero: $("#genero").val(),				
				email: $("#email-m").val(),
				celular: $("#celular-m").val(),
			},
			success: function(data) {
				if(data == 200){
					swal("Éxito", "Perfil de usuario actualizado correctamente", "success");
					$(":input").val("");
					$('.selectpicker').selectpicker('val', '');	
					$("#modal-editar-usuario").modal('hide');
					getUsuarios();
				}
			},
			error: function(data){
				swal("Error", "No se pudo actualizar el perfil de usuario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});		
	});

	$("#tabla-info-usuarios").on("click", ".editar",  function(){
		getInfoUsuario($(this).attr("data-id-usuario"));
	});

	$("#cerrar-modal").click(function(){
		getUsuarios()
	})
});