<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Provinsi;
use App\Models\RT;
use App\Models\RW;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminRtController extends Controller
{
    public function index(){
        $provinsi = Provinsi::pluck("nama","id");
        $data = User::where('role', "RT")->get();
        return view('administrator.user.rt.adminrt', compact('data', 'provinsi'));
    }

    public function detailRT($id){
        $data = AdminRT::where('id', $id)->with('user')->with('detailRt')->first();
        return view('administrator.user.rt.detail', compact('data'));
    }

    public function getRt(Request $request){
        $rt = RT::where("id_rw",$request->id_rw)
            ->pluck("nama","id");
        return response()->json($rt);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_rt' => 'required',
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        unset($data['_token']);
        $user = User::create($data);
        AdminRT::create([
            'id_user' => $user->id,
            'id_rt' => $request->id_rt,
        ]);
        return redirect()->back()->with('succes','Berhasil Menambah Data Admin RT');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = AdminRT::with('detailRt.detailRw.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->with('user')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('lokasi', function ($row) {
                    $lokasi = $row->detailRt->detailRw->detailKelurahan->detailKecamatan->detailKabKota->detailProvinsi->nama.
                        ', '.$row->detailRt->detailRw->detailKelurahan->detailKecamatan->detailKabKota->nama.
                        ', '.$row->detailRt->detailRw->detailKelurahan->detailKecamatan->nama.
                        ', '.$row->detailRt->detailRw->detailKelurahan->nama.
                        ', RW '.$row->detailRt->detailRw->nama;
                    return $lokasi;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="adminrt/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 80px">
                                                <i class="icon icon-details"> Detail</i></a>';
                    return $btn;
                })
                ->rawColumns(['rt', 'action'])
                ->make(true);
        }
    }
}
