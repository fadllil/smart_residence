<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Surat;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
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

    public function suratDomisili($id)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'id_user' => 'required',
        //     ]
        // );
        // if ($validator->fails()) {
        //     return Response::failure($validator->errors()->first(), 417);
        // }

        $user = User::where('id', $id)->with('warga.detailRT.detailRW.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->first();
        // dd(strtoupper($user->warga->detailRT->detailRW->detailKelurahan->nama));
        $pdf = PDF::loadView('rt.surat.cetak_surat.domisili', ['user' => $user]);
    	return $pdf->download('Surat Keterangan Domisili.pdf');
        // return $pdf->stream();
    }
}
