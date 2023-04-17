<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('instructor',instructorController::class);
Route::resource('trainee',TraineeController::class);
Route::resource('admin',AdminController::class);
