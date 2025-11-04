<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::resource('users', UserController::class);
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');