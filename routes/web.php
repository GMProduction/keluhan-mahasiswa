<?php

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

Route::match(['post', 'get'], '/', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
Route::get('/dashboard/data', [\App\Http\Controllers\Admin\DashboardController::class, 'get_data_keluhan']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\Admin\AdminController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\Admin\AdminController::class, 'patch']);
    Route::post('/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy']);
});

Route::group(['prefix' => 'mahasiswa'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\MahasiswaController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\MahasiswaController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\Admin\MahasiswaController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\MahasiswaController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\Admin\MahasiswaController::class, 'patch']);
    Route::post('/delete', [\App\Http\Controllers\Admin\MahasiswaController::class, 'destroy']);
});

Route::group(['prefix' => 'progdi'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\ProgdiController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\ProgdiController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\Admin\ProgdiController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\ProgdiController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\Admin\ProgdiController::class, 'patch']);
    Route::post('/delete', [\App\Http\Controllers\Admin\ProgdiController::class, 'destroy']);
});

Route::group(['prefix' => 'kelas'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\KelasController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\Admin\KelasController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\Admin\KelasController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\KelasController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\Admin\KelasController::class, 'patch']);
    Route::post('/delete', [\App\Http\Controllers\Admin\KelasController::class, 'destroy']);
});

Route::group(['prefix' => 'keluhan-baru'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\KeluhanController::class, 'index']);
    Route::match(['post', 'get'], '/{id}', [\App\Http\Controllers\Admin\KeluhanController::class, 'detail']);
});

Route::group(['prefix' => 'keluhan-proses'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\KeluhanController::class, 'proses']);
    Route::match(['post', 'get'], '/{id}', [\App\Http\Controllers\Admin\KeluhanController::class, 'detail_proses']);
});

Route::group(['prefix' => 'keluhan-selesai'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\KeluhanController::class, 'selesai']);
    Route::match(['post', 'get'], '/{id}', [\App\Http\Controllers\Admin\KeluhanController::class, 'detail_selesai']);
});


