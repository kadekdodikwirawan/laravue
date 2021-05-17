<?php

use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

// public route
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);


// protected route
Route::group(['prefix' => 'property', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/add', [PropertyController::class, 'add']);
    Route::get('/edit/{id}', [PropertyController::class, 'edit']);
    Route::post('/update/{id}', [PropertyController::class, 'update']);
    Route::delete('/delete/{id}', [PropertyController::class, 'delete']);
    Route::get('/', [PropertyController::class, 'index']);

});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);
});