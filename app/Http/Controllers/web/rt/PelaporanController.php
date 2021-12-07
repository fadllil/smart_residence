<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Pelaporan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PelaporanController extends Controller
{
    public function index(){
        $admin_rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Pelaporan::where('id_rt', $admin_rt->id_rt)->latest()->get();
        return view('rt.pelaporan.index', compact('admin_rt'));
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Pelaporan::where([
                'id_rt' => $rt->id_rt,
                'status' => 'Belum Diproses'
                ])->with('user')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/pelaporan/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-details"> Detail</i></a>' .
                        '<a href="/rt/pelaporan/status/diproses/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-refresh"> Diproses</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function datatableDiproses(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Pelaporan::where([
                'id_rt' => $rt->id_rt,
                'status' => 'Diproses'
            ])->with('user')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/pelaporan/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-details"> Detail</i></a>' .
                        '<a href="/rt/pelaporan/status/selesai/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-refresh"> Selesai</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function datatableSelesai(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Pelaporan::where([
                'id_rt' => $rt->id_rt,
                'status' => 'Selesai'
            ])->with('user')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/pelaporan/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-details"> Detail</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
