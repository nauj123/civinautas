var options_gruposanguineo;
var options_tipodocumento;
var options_roles;
var tabla_info_usuarios;
var info_tabla_info_usuarios;
var options_parametro;
var tabla_parametros_asociados;
var info_tabla_parametros_asociados;
var boton_estado;

$(document).ready(function(){

	$("#parametro").html(getParametros()).selectpicker("refresh");

	$("#parametro").on("change", function(){
		getParametroAsociados();
	})

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

	tabla_parametros_asociados = $("#tabla_parametros_asociados").DataTable({
		autoWidth: false,
		responsive: true,
		pageLength: 50,
		columnDefs: [
		{ "width": "80%", "targets": 0 }
		],
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
	$("#rol-m").html(options_roles).selectpicker("refresh");

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
				swal("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
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
				swal("Error", "No se pudo obtener el listado de roles de usaurio, por favor inténtelo nuevamente", "error");
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

					if (info_tabla_info_usuarios[index]["estado"] == 1) {
						rowNode = tabla_info_usuarios.row.add([
						"<center>"+info_tabla_info_usuarios[index]["identificacion"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["nombre"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["email"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["celular"]+"</center>",
						"<center>"+info_tabla_info_usuarios[index]["rol"]+"</center>",
						"<center><buton type='button' class='btn btn-warning editar' data-id-usuario='"+info_tabla_info_usuarios[index]["id"]+"' data-toggle='modal' data-target='#modal-editar-usuario'>Editar</buton></center>",
						"<center><buton type='button' class='btn btn-danger inactivarusuario' data-id-usuario='"+info_tabla_info_usuarios[index]["id"]+"' data-nombre-usuario='"+info_tabla_info_usuarios[index]["nombre"]+"' data-toggle='modal' data-target='#modal-inactivar-usuario'>Inactivar</buton></center>"
						]).draw().node();
					} else {
						rowNode = tabla_info_usuarios.row.add([
							"<center>"+info_tabla_info_usuarios[index]["identificacion"]+"</center>",
							"<center>"+info_tabla_info_usuarios[index]["nombre"]+"</center>",
							"<center>"+info_tabla_info_usuarios[index]["email"]+"</center>",
							"<center>"+info_tabla_info_usuarios[index]["celular"]+"</center>",
							"<center>"+info_tabla_info_usuarios[index]["rol"]+"</center>",
							"Usuario Inactivo",
							"<center><buton type='button' class='btn btn-success activarusuario' data-id-usuario='"+info_tabla_info_usuarios[index]["id"]+"' data-nombre-usuario='"+info_tabla_info_usuarios[index]["nombre"]+"' data-toggle='modal' data-target='#modal-activar-usuario'>Activar</buton></center>"
							]).draw().node();
					}		
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de tipos de escenario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_tipodocumento;
	}

	$("#tabla-info-usuarios").on("click", ".inactivarusuario",  function(){
		$("#id-usuario").val($(this).attr("data-id-usuario"));
		$("#lb-usuario-inactivar").html("").html($(this).attr("data-nombre-usuario"));
	}); 

	$("#form-inactivar-usuario").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "InactivarUsuario",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_usuario: $("#id-usuario").val(),
				observacion: $("#observacion-usuario").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se inactivo correctamente el usuario, desde este momento no tendrá acceso a la plataforma", "success");
					$("#modal-inactivar-usuario").modal('hide');
					getUsuarios();
					
				}
			},
			error: function (data) {
				swal("Error", "No fue posible inactivar el usuario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	$("#tabla-info-usuarios").on("click", ".activarusuario",  function(){
		$("#id-usuario-activar").val($(this).attr("data-id-usuario"));
		$("#lb-usuario-activar").html("").html($(this).attr("data-nombre-usuario"));
	});

	$("#form-activar-usuario").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "ActivarUsuario",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id_usuario: $("#id-usuario-activar").val()
			},
			success: function (data) {
				if (data == 200) {
					swal("Éxito", "Se activo correctamente el usuario, desde este momento ya tendrá acceso a la plataforma", "success");
					$("#modal-activar-usuario").modal('hide');
					getUsuarios();
					
				}
			},
			error: function (data) {
				swal("Error", "No fue posible activar el usuario, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	});

	function getParametros() {
		$.ajax({
			url: "../administracion/getParametros",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(data) {
				options_parametro += data["option"];
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de parámetros, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
		return options_parametro;
	}

	function getParametroAsociados() {
		$.ajax({
			url: "../administracion/getParametroAsociados",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_parametro: $("#parametro").val()
			},
			success: function(data) {
				info_tabla_parametros_asociados = data;	
				tabla_parametros_asociados.clear().draw();
				info_tabla_parametros_asociados.forEach((value, index) => {
					boton_estado = info_tabla_parametros_asociados[index]["estado"] == 0 ? "<button class='btn btn-block btn-danger edit' data-action='edit' id='estado-parametro-asociado-"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"' type='button' data-hide='"+info_tabla_parametros_asociados[index]["estado"]+"' data-id-parametro-asociado='"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"'><i class='far fa-eye-slash'></i></button>" : "<button class='btn btn-block btn-success edit' data-action='edit' id='estado-parametro-asociado-"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"' type='button' data-hide='"+info_tabla_parametros_asociados[index]["estado"]+"' data-id-parametro-asociado='"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"'><i class='far fa-eye'></i></button>"; 
					rowNode = tabla_parametros_asociados.row.add([
						"<span id='parametro-asociado-"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"'>"+info_tabla_parametros_asociados[index]["descripcion"]+"</span>",
						"<button type='button' class='btn btn-block btn-warning edit' data-id-parametro-asociado='"+info_tabla_parametros_asociados[index]["id_parametro_detalle"]+"' data-action='edit' data-type='contenido'><i class='far fa-edit'></i></button>",
						boton_estado
						]).draw().node();
				});
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado de parámetros, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	function modificarParametroAsociado(id_parametro_asociado, descripcion_parametro_asociado, estado_parametro_asociado){
		$.ajax({
			url: "../administracion/modificarParametroAsociado",
			type: 'POST',
			dataType: 'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				id_parametro_asociado: id_parametro_asociado,
				descripcion_parametro_asociado: descripcion_parametro_asociado,
				estado_parametro_asociado: estado_parametro_asociado
			},
			success: function(data) {
				getParametroAsociados();
			},
			error: function(data){
				swal("Error", "No se pudo actualizar el parámetro asociado seleccionado, por favor inténtelo nuevamente", "error");
			},
			async: false
		});
	}

	$("#tabla_parametros_asociados").on("click", ".edit", function(){
		var input_id = "parametro-asociado-"+$(this).attr("data-id-parametro-asociado");
		var input_value = $("#"+input_id).text();

		if($(this).attr("data-action") == "edit"){
			if(!$(this).is('[data-hide]')){
				$("#"+input_id).replaceWith(function(){
					return '<input type="text" class="form-control" id='+input_id+' value="'+input_value+'">';
				});
				$(this).html("").html("<i class='far fa-save'></i>");
				$(this).removeClass("btn-warning").addClass("btn-success");
				$(this).attr("data-action", "save");
			}
			else{
				$(this).attr("data-hide") == 1 ? $(this).html("").html("<i class='far fa-eye-slash'></i>") : $(this).html("").html("<i class='far fa-eye'></i>");
				$(this).attr("data-hide") == 1 ? $(this).removeClass("btn-success").addClass("btn-danger") : $(this).removeClass("btn-danger").addClass("btn-success");
				$(this).attr("data-hide") == 1 ? $(this).attr("data-hide", 0) : $(this).attr("data-hide", 1);

				modificarParametroAsociado($(this).attr("data-id-parametro-asociado"), $("#"+input_id).text(), $("#estado-"+input_id).attr("data-hide"))
			}
		}else{
			modificarParametroAsociado($(this).attr("data-id-parametro-asociado"), $("#"+input_id).val(), $("#estado-"+input_id).attr("data-hide"))
		}
	});

	$("#form-nuevo-parametro-asociado").submit(function(e){
		e.preventDefault();
		if($("#parametro").val() != "" || $("#parametro-asociado").val() != ""){
			$.ajax({
				url: "../administracion/guardarNuevoParametroAsociado",
				type: 'POST',
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{
					id_parametro: $("#parametro").val(),
					nuevo_parametro_asociado: $("#parametro-asociado").val()
				},
				success: function(data) {
					if(data == 200){
						swal("Éxito", "Parámetro asociado correctamente", "success");
						$("#parametro-asociado").val("");
						getParametroAsociados();
					}
				},
				error: function(data){
					swal("Error", "No se pudo guardar el parámetro asociado, por favor inténtelo nuevamente", "error");
				},
				async: false
			});
		}
	});


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
				$("#rol-m").val(data["fk_rol"]).selectpicker("refresh").trigger("change");
			},
			error: function(data){
				swal("Error", "No se pudo obtener el listado Tipo de documento, por favor inténtelo nuevamente", "error");
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
