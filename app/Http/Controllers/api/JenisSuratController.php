<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisSuratController extends Controller
{
    public function index($id){
        if (!$id){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        $data = JenisSurat::where('id_rt', $id)->get();

        return  Response::success('data kegiatan', $data);
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'jenis' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        JenisSurat::create($request->all());

        return Response::success('Berhasil menambah data', null);
    }

    public function update(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'jenis' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        JenisSurat::where('id', $request->id)->update(['jenis' => $request->jenis]);

        return Response::success('Berhasil merubah data', null);
    }

    public function delete($id){

        JenisSurat::where('id', $id)->delete();

        return Response::success('Berhasil merubah data', null);
    }
}
