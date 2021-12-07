<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PelaporanController extends Controller
{
    public function belumDiproses($id){
        $data = Pelaporan::where([
            'id_rt' => $id,
            'status' => 'Belum Diproses'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function diproses($id){
        $data = Pelaporan::where([
            'id_rt' => $id,
            'status' => 'Diproses'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function selesai($id){
        $data = Pelaporan::where([
            'id_rt' => $id,
            'status' => 'Selesai'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function belumDiprosesWarga($id){
        $data = Pelaporan::where([
            'id_user' => $id,
            'status' => 'Belum Diproses'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function diprosesWarga($id){
        $data = Pelaporan::where([
            'id_user' => $id,
            'status' => 'Diproses'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function selesaiWarga($id){
        $data = Pelaporan::where([
            'id_user' => $id,
            'status' => 'Selesai'
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data pelaporan tidak ditemukan', 404);
        }
        return  Response::success('data pelaporan', $data);
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'id_user' => 'required',
                'judul' => 'required',
                'isi' => 'required',
                'keterangan' => 'required',
                'gambar' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $data = $request->all();
        $data['status'] = 'Belum Diproses';
        Pelaporan::create($data);
        return Response::success('Berhasil menambah data', null);
    }
}
