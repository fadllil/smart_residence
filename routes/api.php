<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;

use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\api\ProfilController;
use App\Http\Controllers\api\DataWargaController;
use App\Http\Controllers\api\KegiatanController;
use App\Http\Controllers\api\InformasiController;
use App\Http\Controllers\api\PelaporanController;
use App\Http\Controllers\api\SuratController;
use App\Http\Controllers\api\KeuanganController;
use App\Http\Controllers\api\JenisSuratController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/upload-file/{folder}/{nama}', [UploadFileController::class, 'getFile']);

Route::group(['prefix' => 'rt','middleware' => 'jwt.auth.mobile'], function () {
    Route::post('/upload-file/{folder}', [UploadFileController::class, 'store']);
    Route::group(['prefix' => 'profil'], function () {
        Route::get('/{id}', [ProfilController::class, 'index']);
        Route::post('/update', [ProfilController::class, 'update']);
    });

    Route::group(['prefix' => 'warga'], function () {
        Route::get('/aktif/{id}', [DataWargaController::class, 'aktif']);
        Route::get('/tidak_aktif/{id}', [DataWargaController::class, 'tidakAktif']);
        Route::post('/create', [DataWargaController::class, 'create']);
        Route::post('/update', [DataWargaController::class, 'update']);
        Route::get('/update_status/{id}', [DataWargaController::class, 'updateStatus']);
    });

    Route::group(['prefix' => 'kegiatan'], function () {
        Route::get('/{id}', [KegiatanController::class, 'index']);
        Route::get('/proses/{id}', [KegiatanController::class, 'proses']);
        Route::get('/selesai/{id}', [KegiatanController::class, 'selesai']);
        Route::get('/batal/{id}', [KegiatanController::class, 'batal']);
        Route::post('/create', [KegiatanController::class, 'create']);
        Route::get('/postSelesai/{id}', [KegiatanController::class, 'postSelesai']);
        Route::get('/postBatal/{id}', [KegiatanController::class, 'postBatal']);
        Route::get('/detail_anggota/{id}', [KegiatanController::class, 'detailAnggota']);
        Route::get('/detail_iuran/belum_bayar/{id}', [KegiatanController::class, 'detailIuranBelumBayar']);
        Route::get('/detail_iuran/menunggu_validasi/{id}', [KegiatanController::class, 'detailIuranMenungguValidasi']);
        Route::get('/detail_iuran/sudah_bayar/{id}', [KegiatanController::class, 'detailIuranSudahBayar']);
        Route::get('/detail_iuran_warga/{id}/{id_user}', [KegiatanController::class, 'detailIuranWarga']);
        Route::get('/iuran/validasi/{id}', [KegiatanController::class, 'validasi']);
    });

    Route::group(['prefix' => 'informasi'], function () {
        Route::get('/{id}', [InformasiController::class, 'index']);
        Route::post('/create', [InformasiController::class, 'create']);
    });

    Route::group(['prefix' => 'pelaporan'], function () {
        Route::get('/belum_diproses/{id}', [PelaporanController::class, 'belumDiproses']);
        Route::get('/diproses/{id}', [PelaporanController::class, 'diproses']);
        Route::get('/selesai/{id}', [PelaporanController::class, 'selesai']);
    });

    Route::group(['prefix' => 'keuangan'], function () {
        Route::get('/{id}', [KeuanganController::class, 'keuangan']);
        Route::get('/pemasukan/{id}', [KeuanganController::class, 'pemasukan']);
        Route::get('/pengeluaran/{id}', [KeuanganController::class, 'pengeluaran']);
        Route::post('/pengeluaran/create', [KeuanganController::class, 'createPengeluaran']);
    });

    Route::group(['prefix' => 'jenis-surat'], function () {
        Route::get('/{id}', [JenisSuratController::class, 'index']);
        Route::post('/create', [JenisSuratController::class, 'create']);
        Route::post('/update', [JenisSuratController::class, 'update']);
        Route::get('/delete/{id}', [JenisSuratController::class, 'delete']);
    });

    Route::group(['prefix' => 'surat'], function () {
        Route::get('/{id}', [SuratController::class, 'index']);
    });
});

Route::group(['prefix' => 'warga','middleware' => 'jwt.auth.mobile'], function () {
    Route::group(['prefix' => 'profil'], function () {
        Route::get('/{id}', [ProfilController::class, 'warga']);
        Route::post('/update', [ProfilController::class, 'update']);
    });

    Route::group(['prefix' => 'pelaporan'], function () {
        Route::get('/belum_diproses/{id}', [PelaporanController::class, 'belumDiprosesWarga']);
        Route::get('/diproses/{id}', [PelaporanController::class, 'diprosesWarga']);
        Route::get('/selesai/{id}', [PelaporanController::class, 'selesaiWarga']);
        Route::post('/create', [PelaporanController::class, 'create']);
    });

    Route::group(['prefix' => 'surat'], function () {
        Route::post('/create', [SuratController::class, 'create']);
        Route::get('/{id}', [SuratController::class, 'getSuratWarga']);
    });
    Route::group(['prefix' => 'kegiatan'], function () {
        Route::post('/iuran/bayar', [KegiatanController::class, 'bayar']);
    });
    
    Route::group(['prefix' => 'cetak'], function(){
        Route::post('/domisili', [SuratController::class, 'suratDomisili']);
        Route::post('/kematian', [SuratController::class, 'suratKematian']);
        Route::post('/tidak-mampu', [SuratController::class, 'suratTidakMampu']);
        Route::post('/milik-usaha', [SuratController::class, 'suratMilikUsaha']);
        Route::post('/belum-menikah', [SuratController::class, 'suratBelumMenikah']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
