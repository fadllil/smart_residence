<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Http\Utils\Upload;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformasiController extends Controller
{
    public function index($id){
        $data = Informasi::where([
            'id_rt' => $id,
        ])->latest()->get();
        if (!$data){
            return Response::failure('Data informasi tidak ditemukan', 404);
        }
        return  Response::success('data informasi', $data);
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'judul' => 'required',
                'tanggal' => 'required',
                'isi' => 'required',
                'gambar' => 'required'
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $data = $request->all();

        Informasi::create($data);

        return  Response::success('data informasi', $data);
    }

    public function update(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'judul' => 'required',
                'tanggal' => 'required',
                'isi' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $data = $request->all();
        unset($data['id']);
        Informasi::where('id', $request->id)->update($data);

        return Response::success('berhasil merubah data informasi', null);
    }

    public function delete($id){
        Informasi::where('id', $id)->delete();
        return Response::success('berhasil menghapus data informasi', null);
    }
}
