<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('authentication.login');
});


Route::get('/register', function () {
    return view('authentication.register');
});
 
Route::get('/game', function () {
    return view('game');
});
<<<<<<< Updated upstream
=======



Route::resource('users', UserController::class);

Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
>>>>>>> Stashed changes
