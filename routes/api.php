<?php

use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    
    Route::get('/registrations', 'App\Http\Controllers\registrations@index');
    Route::post('/registrations', 'App\Http\Controllers\registrations@store');
    Route::get('/registrations/{id}', 'App\Http\Controllers\registrations@show');
    Route::put('/registrations/{id}', 'App\Http\Controllers\registrations@update');
    Route::delete('/registrations/{id}', 'App\Http\Controllers\registrations@destroy');
    
    });
    
Route::post("login",[userController::class,'index']);