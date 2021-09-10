<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\KegiatanAnggota;
use Illuminate\Http\Request;

class DetailKegiatanController extends Controller
{
    public function detailPengurus($id){
        $data = KegiatanAnggota::where('id_kegiatan', $id)->get();
        return view('rt.kegiatan.detailanggota', compact('data'));
    }
}
