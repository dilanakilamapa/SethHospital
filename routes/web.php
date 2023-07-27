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

Route::get('/', function () {
    return view('index');
});

Route::get('/api/docs', function () {
    return file_get_contents(public_path('docs/index.html'));
});

Route::post('/submit-form', 'App\Http\Controllers\frontend@store')->name('submit.form');
Route::post('/validateOTP', 'App\Http\Controllers\frontend@validateOTP')->name('validateOTP');