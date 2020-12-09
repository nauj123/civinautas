@extends("theme.layout")
@section('js-import')
<script src="{{ asset('js/usuarios/usuarios.js') }}" defer></script>
@endsection
@section('principal')
@endsection
@section('contenido')
<div class="card col-lg-10 offset-lg-1">
	<div class="card-header bg-primary text-white">Perfil de usuario</div>
	<div class="card-body">
		<form id="form-actualizar-usuario">
			@include('usuarios.form_editar_usuario')
			<div class="form-group">
				<div class="col-lg-4 offset-lg-4">
					<button class="btn btn-block btn-primary" type="submit">Actualizar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection