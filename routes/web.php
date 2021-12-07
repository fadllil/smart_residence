<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\web\AdminRtController;
use App\Http\Controllers\web\ProvinsiController;
use App\Http\Controllers\web\KabKotaController;
use App\Http\Controllers\web\KecamatanController;
use App\Http\Controllers\web\KelurahanController;
use App\Http\Controllers\web\RwController;
use App\Http\Controllers\web\RtController;
use App\Http\Controllers\web\WargaController;

use App\Http\Controllers\UploadFileController;

use App\Http\Controllers\web\rt\WargaController as RtWarga;
use App\Http\Controllers\web\rt\KegiatanController as RtKegiatan;
use App\Http\Controllers\web\rt\DetailKegiatanController as RtDetailKegiatan;
use App\Http\Controllers\web\rt\InformasiController as RtInformasi;
use App\Http\Controllers\web\rt\PelaporanController as RtPelaporan;
use App\Http\Controllers\web\rt\SuratPengantarController as RtSuratPengantar;
use App\Http\Controllers\web\rt\SuratKeteranganController as RtSuratKeterangan;
use App\Http\Controllers\web\rt\KeuanganController as RtKeuangan;

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

Route::get('/', [HomeController::class, 'index']);
Route::post('/doLogin', [LoginController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/upload-file/{folder}/{nama}', [UploadFileController::class, 'getFile']);

// Route Managemen Pengguna
    //Route Admin
Route::group(['prefix' => 'admin', 'middleware' => 'web.auth'], function () {
    Route::get('/', [AdministratorController::class, 'index']);
    Route::post('/create', [AdministratorController::class, 'create']);
    Route::post('/update/{id}', [AdministratorController::class, 'update']);
    Route::get('/delete/{id}', [AdministratorController::class, 'delete']);
});
    // Route Admin RT
Route::group(['prefix' => 'adminrt', 'middleware' => 'web.auth'], function () {
    Route::get('/', [AdminRtController::class, 'index']);
    Route::get('/getRt', [AdminRtController::class, 'getRt']);
    Route::post('/create', [AdminRtController::class, 'create']);
    Route::get('/datatable', [AdminRtController::class, 'datatable']);
    Route::get('/detail/{id}', [AdminRtController::class, 'detailRT']);
});
    // Route Warga
Route::group(['prefix' => 'warga', 'middleware' => 'web.auth'], function () {
    Route::get('/', [WargaController::class, 'index']);
    Route::get('/datatable', [WargaController::class, 'datatable']);
});

// Route Data Master
    // Route Provinsi
Route::group(['prefix' => 'provinsi', 'middleware' => 'web.auth'], function () {
    Route::get('/', [ProvinsiController::class, 'index']);
    Route::post('/create', [ProvinsiController::class, 'create']);
    Route::get('/datatable', [ProvinsiController::class, 'datatable']);
    Route::post('/update/{id}', [ProvinsiController::class, 'update']);
    Route::get('/delete/{id}', [ProvinsiController::class, 'delete']);
});
    // Route Kab/Kota
Route::group(['prefix' => 'kab_kota', 'middleware' => 'web.auth'], function () {
    Route::get('/', [KabKotaController::class, 'index']);
    Route::post('/create', [KabKotaController::class, 'create']);
    Route::get('/datatable', [KabKotaController::class, 'datatable']);
    Route::post('/update/{id}', [KabKotaController::class, 'update']);
    Route::get('/delete/{id}', [KabKotaController::class, 'delete']);
});
    // Route Kecamatan
Route::group(['prefix' => 'kecamatan', 'middleware' => 'web.auth'], function () {
    Route::get('/', [KecamatanController::class, 'index']);
    Route::get('/getKota', [KecamatanController::class, 'getKota']);
    Route::post('/create', [KecamatanController::class, 'create']);
    Route::get('/datatable', [KecamatanController::class, 'datatable']);
    Route::post('/update/{id}', [KecamatanController::class, 'update']);
    Route::get('/delete/{id}', [KecamatanController::class, 'delete']);
});
    // Route Kelurahan
Route::group(['prefix' => 'kelurahan', 'middleware' => 'web.auth'], function () {
    Route::get('/', [KelurahanController::class, 'index']);
    Route::get('/getKecamatan', [KelurahanController::class, 'getKecamatan']);
    Route::post('/create', [KelurahanController::class, 'create']);
    Route::get('/datatable', [KelurahanController::class, 'datatable']);
    Route::post('/update/{id}', [KelurahanController::class, 'update']);
    Route::get('/delete/{id}', [KelurahanController::class, 'delete']);
});
    // Route RW
Route::group(['prefix' => 'rw', 'middleware' => 'web.auth'], function () {
    Route::get('/', [RwController::class, 'index']);
    Route::get('/getKelurahan', [RwController::class, 'getKelurahan']);
    Route::post('/create', [RwController::class, 'create']);
    Route::get('/datatable', [RwController::class, 'datatable']);
    Route::post('/update/{id}', [RwController::class, 'update']);
    Route::get('/delete/{id}', [RwController::class, 'delete']);
});
    // Route RT
Route::group(['prefix' => 'rt', 'middleware' => 'web.auth'], function () {
    Route::get('/', [RtController::class, 'index']);
    Route::get('/getRw', [RtController::class, 'getRw']);
    Route::post('/create', [RtController::class, 'create']);
    Route::get('/datatable', [RtController::class, 'datatable']);
    Route::post('/update/{id}', [RtController::class, 'update']);
    Route::get('/delete/{id}', [RtController::class, 'delete']);
});


Route::group(['prefix' => 'rt', 'middleware' => 'web.auth'], function () {
    Route::group(['prefix' => 'warga'], function () {
        Route::get('/', [RtWarga::class, 'index']);
        Route::get('/datatable', [RtWarga::class, 'datatable']);
        Route::get('/datatableTidakAktif', [RtWarga::class, 'datatableTidakAktif']);
        Route::post('/create', [RtWarga::class, 'create']);
        Route::get('/detail/{id}', [RtWarga::class, 'detailWarga']);
        Route::get('/status/{id}', [RtWarga::class, 'status']);
    });

    Route::group(['prefix' => 'kegiatan'], function () {
        Route::get('/', [RtKegiatan::class, 'index']);
        Route::post('/create', [RtKegiatan::class, 'create']);
        Route::post('/update/{id}', [RtKegiatan::class, 'update']);
        Route::get('/delete/{id}', [RtKegiatan::class, 'delete']);
        Route::get('/selesai/{id}', [RtKegiatan::class, 'selesai']);
        Route::get('/batal/{id}', [RtKegiatan::class, 'batal']);
        Route::get('/datatable', [RtKegiatan::class, 'datatable']);
        Route::get('/datatableSelesai', [RtKegiatan::class, 'datatableSelesai']);
        Route::get('/datatableBatal', [RtKegiatan::class, 'datatableBatal']);

        Route::group(['prefix' => 'detail-anggota'], function () {
            Route::get('/{id}', [RtDetailKegiatan::class, 'detailAnggota']);
            Route::get('/delete/{id}', [RtDetailKegiatan::class, 'deleteAnggota']);
            Route::get('/datatable/{id}', [RtDetailKegiatan::class, 'datatableAnggota']);
            Route::post('/create', [RtDetailKegiatan::class, 'createAnggota']);
            Route::post('/update/{id}', [RtDetailKegiatan::class, 'updateAnggota']);
        });

        Route::group(['prefix' => 'detail-iuran'], function () {
            Route::get('/{id}', [RtDetailKegiatan::class, 'detailIuran']);
            Route::get('/datatable/{id}', [RtDetailKegiatan::class, 'datatableIuran']);
            Route::get('/status/{id}', [RtDetailKegiatan::class, 'statusIuran']);
        });
    });

    Route::group(['prefix' => 'informasi'], function () {
        Route::get('/', [RtInformasi::class, 'index']);
        Route::post('/create', [RtInformasi::class, 'create']);
        Route::get('/datatable/{id}', [RtInformasi::class, 'datatable']);
        Route::get('/detail/{id}', [RtInformasi::class, 'detail']);
    });

    Route::group(['prefix' => 'pelaporan'], function () {
        Route::get('/', [RtPelaporan::class, 'index']);
        Route::get('/datatable', [RtPelaporan::class, 'datatable']);
        Route::get('/datatable/diproses', [RtPelaporan::class, 'datatableDiproses']);
        Route::get('/datatable/selesai', [RtPelaporan::class, 'datatableSelesai']);
    });

    Route::group(['prefix' => 'surat'], function () {
        Route::group(['prefix' => 'pengantar'], function () {
            Route::get('/', [RtSuratPengantar::class, 'index']);
            Route::get('/datatable', [RtSuratPengantar::class, 'datatable']);
        });

        Route::group(['prefix' => 'keterangan'], function () {
            Route::get('/', [RtSuratKeterangan::class, 'index']);
            Route::get('/datatable', [RtSuratKeterangan::class, 'datatable']);
        });
    });

    Route::group(['prefix' => 'keuangan'], function () {
        Route::group(['prefix' => 'pemasukan'], function () {
            Route::get('/', [RtKeuangan::class, 'pemasukan']);
        });
        Route::group(['prefix' => 'pengeluaran'], function () {
        });
    });
});
