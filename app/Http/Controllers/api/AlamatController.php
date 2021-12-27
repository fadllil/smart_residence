<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function provinsi(){
        $data = Provinsi::get();
        return  Response::success('data provinsi', $data);
    }

    public function kabkota($id){
        $data = KabKota::where('id_provinsi', $id)->get();
        return  Response::success('data kabkota', $data);
    }

    public function kecamatan(){
        $data = Kecamatan::where('id_kabkota', 1)->get();
        return  Response::success('data kecamatan', $data);
    }

    public function kelurahan($id){
        $data = Kelurahan::where('id_kecamatan', $id)->get();
        return  Response::success('data kelurahan', $data);
    }
}
