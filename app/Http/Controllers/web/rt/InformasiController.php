<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Http\Utils\Upload;
use App\Models\AdminRT;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InformasiController extends Controller
{
    public function index(){
        $admin_rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Informasi::where('id_rt', $admin_rt->id_rt)->latest()->get();

        return view('rt.informasi.index', compact('data', 'admin_rt'));
    }

    public function datatable($id, Request $request){
        if ($request->ajax()) {
            $data = Informasi::where('id_rt', $id)->latest()->get();
//            dd($data->toArray());
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/rt/informasi/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 80px">
                                                <i class="icon icon-details"> Detail</i></a>' .
                        '<a href="#" class="btn btn-outline-danger btn-sm" onclick="hapus('.$row->id.')" data-toggle="modal" data-target="#hapus" style="width: 80px">
                                                <i class="icon icon-trash text-danger"> Hapus</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request){
//        dd($request->toArray());
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
                'judul' => 'required',
                'tanggal' => 'required',
                'isi' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $data = $request->all();

        if ($request->gambar){
            $gambar = Upload::store('informasi', $request->gambar);
            $data['gambar'] = $gambar;
//            dd($data);
        }

        Informasi::create($data);

        return redirect()->back()->with('succes', 'Berhasil menambah informasi');
    }

    public function detail($id){
        $data = Informasi::where('id', $id)->first();
        return view('rt.informasi.detail', compact('data'));
    }

    public function delete($id){
        $data = Informasi::where('id', $id)->first();
        $avatar_path = storage_path($data) . '/' . $nama;
        if (file_exists($avatar_path)) {

        }
    }
}
