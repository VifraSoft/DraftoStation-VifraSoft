@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Panel de Administración</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-grid gap-3 col-6 mx-auto">
        <a href="{{ route('admin.users') }}" class="btn btn-primary">Ver / Modificar Usuarios</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Crear Nuevo Usuario</a>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-outline-dark mt-4">Cerrar sesión</button>
    </form>
</div>
@endsection
