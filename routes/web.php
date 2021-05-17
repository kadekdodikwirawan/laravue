<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('{any}', function () {
//     return view('app');
// })->where('any', '.*');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [UserController::class, 'login_page']);