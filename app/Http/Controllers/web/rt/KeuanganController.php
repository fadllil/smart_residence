<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function pemasukan(){
        $admin_rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Kegiatan::where([
            'id_rt' => $admin_rt->id_rt,
            'status' => 'Selesai'
        ])->get();
        return view('rt.keuangan.pemasukan.index');
    }
}
