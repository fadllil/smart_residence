<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SuratKeteranganController extends Controller
{
    public function index(){
        $admin_rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Surat::where([
            'id_rt' => $admin_rt->id_rt,
            'jenis' => 'Surat Keterangan'
        ])->latest()->get();
        return view('rt.surat.keterangan.index');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $admin_rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Surat::where([
                'id_rt' => $admin_rt->id_rt,
                'jenis' => 'Surat Keterangan'
            ])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/surat/keterangan/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 80px">
                                                <i class="icon icon-details"> Detail</i></a>' .
                        '<a href="#" class="btn btn-outline-danger btn-sm" onclick="hapus('.$row->id.')" data-toggle="modal" data-target="#hapus" style="width: 80px">
                                                <i class="icon icon-trash text-danger"> Hapus</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
