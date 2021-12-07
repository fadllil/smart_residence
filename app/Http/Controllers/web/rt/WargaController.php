<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Builder;
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
        return view('rt.warga.index', compact('data', 'rt'))->with('aktif');
    }

    public function detailWarga($id){
        $data = Warga::where('id', $id)->with('user')->with('detailRt')->first();
        return view('rt.warga.detail', compact('data'));
    }

    public function status($id){
        $warga = Warga::where('id', $id)->with('user')->first();
//        dd($warga->toArray());
        $user = User::where('id', $warga->id_user)->first();
        if ($warga->user->status == "Aktif"){
            $user->update([
                'status' => 'Tidak Aktif'
            ]);
            return redirect()->back()->with('succes', 'Berhasil Merubah Status Warga');
        }else{
            $user->update([
                'status' => 'Aktif'
            ]);
            return redirect()->back()->with('succes', 'Berhasil Merubah Status Warga');
        }
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Warga::where('id_rt', $rt->id_rt)->with('user')->whereHas('user', function (Builder $query){
                $query->where('status', 'like','Aktif');
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row" style="padding-left: 10px; padding-right: 10px">'.
                                '<a href="/rt/warga/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-details"> Detail</i></a>'.
                                '<div class="dropdown show">
                                      <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button"
                                      id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon icon-details"> Status</i></a>
                                      </a>

                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="/rt/warga/status/'.$row->id.'"><i class="icon icon-close"> Tidak Aktif</i></a>
                                      </div>
                                </div> </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function datatableTidakAktif(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Warga::where('id_rt', $rt->id_rt)->with('user')->whereHas('user', function (Builder $query){
                $query->where('status', 'like','Tidak Aktif');
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row" style="padding-left: 10px; padding-right: 10px">'.
                        '<a href="/rt/warga/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 100px">
                                                <i class="icon icon-details"> Detail</i></a>'.
                        '<div class="dropdown show">
                                      <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button"
                                      id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon icon-details"> Status</i></a>
                                      </a>

                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="/rt/warga/status/'.$row->id.'"><i class="icon icon-check">Aktif</i></a>
                                      </div>
                                </div> </div>';
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
        $data['status'] = 'Aktif';
        unset($data['_token']);
        $user = User::create($data);
        Warga::create([
            'id_user' => $user->id,
            'id_rt' => $request->id_rt,
        ]);
        return redirect()->back()->with('succes','Berhasil Menambah Data Admin RT');
    }
}
