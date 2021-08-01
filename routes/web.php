<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdminRtController;
use App\Http\Controllers\WargaController;

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
    return view('login');
});

Route::post('/doLogin', [LoginController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Route administrator
Route::get('/admin/user', [AdministratorController::class, 'user'])->name('admin.user');
Route::get('/admin/formTambah', [AdministratorController::class, 'formTambah'])->name('admin.formTambah');
Route::post('/admin/tambah', [AdministratorController::class, 'tambah'])->name('admin.tambah');
Route::get('/admin/formEdit/{id}', [AdministratorController::class, 'formEdit']);
Route::post('/admin/edit/{id}', [AdministratorController::class, 'edit']);
Route::get('/admin/hapus/{id}', [AdministratorController::class, 'hapus']);

// Route RT
Route::get('/admin/rt', [AdminRtController::class, 'index'])->name('admin.rt');

// Route Warga
Route::get('/admin/warga', [WargaController::class, 'index'])->name('admin.warga');
