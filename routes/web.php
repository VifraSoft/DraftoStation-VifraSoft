<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DraftoMoveController;
use App\Http\Controllers\DraftoResultsController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as FrameworkCsrf;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');;

Route::get('/login', function () {
    return view('authentication.login');
})->name('login');;


Route::get('/register', function () {
    return view('authentication.register');
})->name('register');;
 
Route::get('/game', function () {
    return view('game');
});

Route::get('/jugar', function () {
    return view('draftostation.juego');
})->name('jugar');

Route::post('/draftostation/move', [DraftoMoveController::class, 'store'])
    ->name('drafto.move.store')
    ->withoutMiddleware([FrameworkCsrf::class]);

Route::post('/draftostation/results', [DraftoResultsController::class, 'store'])
    ->name('drafto.results.store')
    ->withoutMiddleware([FrameworkCsrf::class]);

// NUEVO: vista con grilla de histórico
Route::get('/draftostation/history', [DraftoResultsController::class, 'history'])
    ->name('drafto.results.history')
    ->withoutMiddleware([FrameworkCsrf::class]);

Route::get('/createuser', function () {
    return view('admin.createuser');
})->name('createuser');;

// Mostrar lista de usuarios para elegir cuál modificar
Route::get('/modifyuser', [UserController::class, 'modifyUserList'])->name('modifyuser');

// Mostrar formulario de edición de un usuario específico
Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');

Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::resource('users', UserController::class);
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Panel admin
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
