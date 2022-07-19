<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);

Route::get('/kelas', [\App\Http\Controllers\Api\KelasController::class, 'index']);
Route::group(['prefix' => 'keluhan', 'middleware' => 'auth:api'], function () {
    Route::match(['post', 'get'],'/', [\App\Http\Controllers\Api\KeluhanController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\KeluhanController::class, 'detail']);
});



