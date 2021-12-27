<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Surat;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class SuratController extends Controller
{
    public function index($id, Request $request){
        $data = Surat::where([
            'id_rt' => $id,
            'status' => $request->status
        ])->with('jenisSurat', 'user')->latest()->get();

        return  Response::success('data surat', $data);
    }

    public function getSuratWarga($id, Request $request){
        $data = Surat::where([
            'id_user' => $id,
            'status' => $request->status
        ])->with('jenisSurat')->latest()->get();
        if (!$data){
            return Response::failure('Data surat tidak ditemukan', 404);
        }
        return  Response::success('data surat', $data);
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'id_user' => 'required',
                'id_jenis_surat' => 'required',
                'keterangan' => 'required',
                'tanggal' => 'required'
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $data = $request->all();

        Surat::create($data);

        return  Response::success('data surat', $data);
    }

    public function suratDomisili(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $request->all(),
            [
                'id_user' => 'required',
                'id_rt' => 'required',
                'keterangan' => 'required',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required|in:islam,katolik,protestan,hindu,budha,konghuchu',
                'pekerjaan' => 'required',
                'ktp' => 'required'
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
        Surat::create([
            'id_rt' => $request->id_rt,
            'id_user' => $request->id_user,
            'id_jenis_surat' => 4,
            'keterangan' => $request->keterangan,
            'status' => 'Pengajuan',
            'tanggal' => date('Y-m-d')
        ]);
        $no = Surat::whereHas('jenisSurat', function(Builder $query){
            $query->where('jenis', 'Domisili');
        })->count() + 1;

        $user = User::where('id', $request->id_user)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $pdf = PDF::loadView('rt.surat.cetak_surat.domisili', ['user' => $user, 'data' => $request->all(), 'no' => $no]);
    	return $pdf->download('Surat Keterangan Domisili.pdf');
    }

    public function suratKematian(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $request->all(),
            [
                'id_user' => 'required',
                'id_rt' => 'required',
                'keterangan' => 'required',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required|in:islam,katolik,protestan,hindu,budha,konghuchu',
                'pekerjaan' => 'required',
                'ktp' => 'required',
                'tanggal_kematian' => 'required',
                'waktu_kematian' => 'required',
                'jenis_tempat_kematian' => 'required',
                'tempat_kematian' => 'required',
                'tempat_dikebumikan' => 'required',
                'kerabat' => 'required',
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
        
        Surat::create([
            'id_rt' => $request->id_rt,
            'id_user' => $request->id_user,
            'id_jenis_surat' => 4,
            'keterangan' => $request->keterangan,
            'status' => 'Pengajuan',
            'tanggal' => date('Y-m-d')
        ]);
        $no = Surat::whereHas('jenisSurat', function(Builder $query){
            $query->where('jenis', 'Kematian');
        })->count() + 1;
        $kerabat = User::where('id', $request->kerabat)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $user = User::where('id', $request->id_user)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $pdf = PDF::loadView('rt.surat.cetak_surat.kematian', ['user' => $user, 'data' => $request->all(), 'kerabat' => $kerabat, 'no' => $no]);
    	return $pdf->download('Surat Keterangan Kematian.pdf');
    }

    public function suratTidakMampu(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $request->all(),
            [
                'id_user' => 'required',
                'id_rt' => 'required',
                'keterangan' => 'required',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required|in:islam,katolik,protestan,hindu,budha,konghuchu',
                'pekerjaan' => 'required',
                'ktp' => 'required'
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
        Surat::create([
            'id_rt' => $request->id_rt,
            'id_user' => $request->id_user,
            'id_jenis_surat' => 4,
            'keterangan' => $request->keterangan,
            'status' => 'Pengajuan',
            'tanggal' => date('Y-m-d')
        ]);
        $no = Surat::whereHas('jenisSurat', function(Builder $query){
            $query->where('jenis', 'Tidak Mampu');
        })->count() + 1;
        $user = User::where('id', $request->id_user)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $pdf = PDF::loadView('rt.surat.cetak_surat.tidakMampu', ['user' => $user, 'data' => $request->all(), 'no' => $no]);
    	return $pdf->download('Surat Keterangan Keluarga Tidak Mampu.pdf');
    }

    public function suratMilikUsaha(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $request->all(),
            [
                'id_user' => 'required',
                'id_rt' => 'required',
                'keterangan' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'pekerjaan' => 'required',
                'nama_usaha' => 'required',
                'alamat_usaha' => 'required'
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
        Surat::create([
            'id_rt' => $request->id_rt,
            'id_user' => $request->id_user,
            'id_jenis_surat' => 4,
            'keterangan' => $request->keterangan,
            'status' => 'Pengajuan',
            'tanggal' => date('Y-m-d')
        ]);
        $no = Surat::whereHas('jenisSurat', function(Builder $query){
            $query->where('jenis', 'Memiliki Usaha');
        })->count() + 1;
        $user = User::where('id', $request->id_user)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $pdf = PDF::loadView('rt.surat.cetak_surat.milikUsaha', ['user' => $user, 'data' => $request->all(), 'no' => $no]);
    	return $pdf->download('Surat Keterangan Memiliki Usaha.pdf');
    }

    public function suratBelumMenikah(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $request->all(),
            [
                'id_user' => 'required',
                'id_rt' => 'required',
                'keterangan' => 'required',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required|in:islam,katolik,protestan,hindu,budha,konghuchu',
                'pekerjaan' => 'required',
                'ktp' => 'required'
            ]
        );
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
        Surat::create([
            'id_rt' => $request->id_rt,
            'id_user' => $request->id_user,
            'id_jenis_surat' => 4,
            'keterangan' => $request->keterangan,
            'status' => 'Pengajuan',
            'tanggal' => date('Y-m-d')
        ]);
        $no = Surat::whereHas('jenisSurat', function(Builder $query){
            $query->where('jenis', 'Belum Menikah');
        })->count() + 1;
        $user = User::where('id', $request->id_user)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        $pdf = PDF::loadView('rt.surat.cetak_surat.belumMenikah', ['user' => $user, 'data' => $request->all(), 'no' => $no]);
    	return $pdf->download('Surat Keterangan Belum Menikah.pdf');
    }


}
