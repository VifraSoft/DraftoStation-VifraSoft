@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Crear Nuevo Usuario</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" class="col-md-6 mx-auto">
        @csrf

        <div class="mb-3">
            <label for="nickname" class="form-label">Nombre de usuario</label>
            <input type="text" name="nickname" id="nickname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Crear Usuario</button>
            <a href="{{ route('admin') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
