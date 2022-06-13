<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('student',StudentController::class);
Route::get('/student/{student}/nilai', [StudentController::class, 'nilai'])->name('student.nilai');
Route::get('/student/{student}/nilai/pdf', [StudentController::class, 'print'])->name('student.print');
