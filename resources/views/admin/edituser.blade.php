@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Usuario</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="col-md-6 mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nickname" class="form-label">Nombre de usuario</label>
            <input type="text" name="nickname" id="nickname" value="{{ $user->nickname }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Dejar vacío para no cambiar">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
