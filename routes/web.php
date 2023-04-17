<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/', [App\Http\Controllers\LoginController::class, 'showLoginForm']);
Route::get('/instructor', function () {
    return view('instructor.index');
})->middleware('auth', 'role:instructor');

Route::get('/trainee', function () {
    return view('trainee.index');
})->middleware('auth', 'role:trainee');

Route::get('/admin', function () {
    return view('admin.index');
})->middleware('auth', 'role:admin');
//for instructor
Route::resource('instructor' , 'App\Http\Controllers\instructorController');
Route::resource('instructor.store' , 'App\Http\Controllers\instructorController');
Route::resource('instructor', App\Http\Controllers\InstructorController::class)->names([
    'update' => 'instructor.custom.update'
]);
Route::resource('instructor', App\Http\Controllers\InstructorController::class)->names([
    'update' => 'instructor.update'
]);
Route::get('/instructor/{instructor}/edit', 'App\Http\Controllers\instructorController@edit')->name('instructor.edit');
Route::delete('/instructor/{instructor}', 'App\Http\Controllers\instructorController@destroy')->name('instructor.destroy');


//  for trainee
Route::resource('trainee' , 'App\Http\Controllers\TraineeController');
Route::resource('trainee.store' , 'App\Http\Controllers\TraineeController');
Route::resource('trainee', App\Http\Controllers\TraineeController::class)->names([
    'update' => 'trainee.custom.update'
]);
Route::resource('trainee', App\Http\Controllers\TraineeController::class)->names([
    'update' => 'trainee.update'
]);
Route::get('/trainee/{trainee}/edit', 'App\Http\Controllers\TraineeController@edit')->name('trainee.edit');
Route::delete('/trainee/{trainee}', 'App\Http\Controllers\TraineeController@destroy')->name('trainee.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//for admin
Route::resource('admin' , 'App\Http\Controllers\AdminController');
Route::resource('admin.store' , 'App\Http\Controllers\AdminController');
Route::resource('admin', App\Http\Controllers\AdminController::class)->names([
    'update' => 'admin.custom.update'
]);
Route::resource('admin', App\Http\Controllers\AdminController::class)->names([
    'update' => 'admin.update'
]);
Route::get('/admin/{admin}/edit', 'App\Http\Controllers\AdminController@edit')->name('admin.edit');
Route::delete('/admin/{admin}', 'App\Http\Controllers\AdminController@destroy')->name('admin.destroy');

