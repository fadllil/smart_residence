<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Keuangan;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeuanganController extends Controller
{
    public function keuangan($id){
        $data = Keuangan::where([
            'id_rt' => $id,
        ])->first();
        if (!$data){
            return Response::failure('Data keuangan tidak ditemukan', 404);
        }
        return  Response::success('data keuangan', $data);
    }

    public function pemasukan($id){
        $data = Pemasukan::where([
            'id_rt' => $id,
        ])->with('kegiatan')->latest()->get();
        if (!$data){
            return Response::failure('Data pemasukan tidak ditemukan', 404);
        }
        return  Response::success('data pemasukan', $data);
    }

    public function pengeluaran($id){
        $data = Pengeluaran::where([
            'id_rt' => $id,
        ])->with('kegiatan')->latest()->get();
        if (!$data){
            return Response::failure('Data pemasukan tidak ditemukan', 404);
        }
        return  Response::success('data pemasukan', $data);
    }

    public function createPengeluaran(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'id_kegiatan' => 'required',
                'nominal' => 'required',
                'keterangan' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $data = $request->all();

        $keuangan = Keuangan::where('id_rt', $request->id_rt)->first();

        if (!$keuangan){
            Keuangan::create([
                'id_rt' => $request->id_rt,
                'nominal' => 0 - $request->nominal
            ]);
        }else{
            $keuangan->update(['nominal' => $keuangan->nominal - $request->nominal]);
        }

        Pengeluaran::create($data);

        return  Response::success('data informasi', $data);
    }
}
