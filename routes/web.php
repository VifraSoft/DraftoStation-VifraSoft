<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('authentication.login');
})->name('authentication.login');


Route::get('/register', function () {
    return view('authentication.register');
})->name('authentication.register');
 
Route::get('/game', function () {
    return view('game');
});


use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);

Route::resource('users', UserController::class);
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

