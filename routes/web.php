<?php

use Illuminate\Support\Facades\Route;

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
