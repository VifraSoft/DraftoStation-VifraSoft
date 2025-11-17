<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación
Route::get('/login', function () {
    return view('authentication.login');
})->name('login');

Route::get('/register', function () {
    return view('authentication.register');
})->name('register');

// Rutas del juego
Route::get('/game', function () {
    return view('game');
})->name('game');

// Rutas de usuarios
Route::get('/createuser', function () {
    return view('admin.createuser');
})->name('createuser');

// Mostrar lista de usuarios para modificar
Route::get('/modifyuser', [UserController::class, 'modifyUserList'])->name('modifyuser');

// Mostrar formulario de edición de un usuario específico
Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');

// Registrar usuario
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// Iniciar y cerrar sesión
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Recurso completo de usuarios
Route::resource('users', UserController::class);

// Panel de administrador
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Listar usuarios
Route::get('/admin/users', [AdminController::class, 'listUsers'])->name('admin.users');

// Crear usuario
Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');

// Editar usuario
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');

// Eliminar usuario
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
