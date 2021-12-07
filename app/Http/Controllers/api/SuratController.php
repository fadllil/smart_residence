<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    public function getSuratWargaKeterangan($id){
        $data = Surat::where([
            'id_user' => $id,
            'jenis' => 'Surat Keterangan'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data surat tidak ditemukan', 404);
        }
        return  Response::success('data surat', $data);
    }

    public function getSuratWargaPengantar($id){
        $data = Surat::where([
            'id_user' => $id,
            'jenis' => 'Surat Pengantar'
        ])->latest()->get();
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
                'jenis' => 'required',
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
}
