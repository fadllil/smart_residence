<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
}
