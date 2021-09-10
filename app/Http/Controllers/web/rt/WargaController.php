<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WargaController extends Controller
{
    public function index(){
        $rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Warga::where('id_rt', $rt->id_rt)->get();
        return view('rt.warga.index', compact('data', 'rt'));
    }

    public function detailWarga($id){
        $data = Warga::where('id', $id)->with('user')->with('detailRt')->first();
        return view('rt.warga.detail', compact('data'));
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Warga::where('id_rt', $rt->id_rt)->with('user')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/warga/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 80px">
                                                <i class="icon icon-details"> Detail</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        Warga::create([
            'id_user' => $user->id,
            'id_rt' => $request->id_rt,
        ]);
        return redirect()->back()->with('succes','Berhasil Menambah Data Admin RT');
    }
}
