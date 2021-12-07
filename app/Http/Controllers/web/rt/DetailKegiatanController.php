<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Kegiatan;
use App\Models\KegiatanAnggota;
use App\Models\KegiatanDetailAnggota;
use App\Models\KegiatanDetailIuran;
use App\Models\KegiatanIuran;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DetailKegiatanController extends Controller
{
    public function detailAnggota($id){
        $rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $warga = Warga::where('id_rt', $rt->id_rt)->with('user')->get();
        $data = KegiatanAnggota::where('id_kegiatan', $id)->with('kegiatan')->with('detailAnggota.user')->first();

//        dd($data->toArray());
        return view('rt.kegiatan.detailanggota', compact('data','warga'));
    }

    public function datatableAnggota($id, Request $request){
        if ($request->ajax()) {
            $data = KegiatanAnggota::where('id_kegiatan', $id)->with('detailAnggota.user')->first();
//            dd($data->toArray());
            return DataTables::of($data['detailAnggota'])
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#edit' . $row->id . '" style="width: 80px">
                                                <i class="icon icon-edit"> Edit</i></a>' .
                            '<a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapus' . $row->id . '" style="width: 80px">
                                                <i class="icon icon-trash text-danger"> Hapus</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function createAnggota(Request $request){
//        dd($request->toArray());
        $validator = Validator::make(
            $request->all(),
            [
                'id_kegiatan_anggota' => 'required',
                'id_user' => 'required',
                'keterangan' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $cek = KegiatanDetailAnggota::where([
            'id_kegiatan_anggota' => $request->id_kegiatan_anggota,
            'id_user' => $request->id_user])->first();

        if ($cek){
            return redirect()->back()->with('warning', 'Gagal, Warga Sudah Terdaftar Sebagai Anggota');
        }

//        unset($request['_token']);
        KegiatanDetailAnggota::create($request->all());

        return redirect()->back()->with('succes', 'Berhasil Menambah Anggota');

    }

    public function updateAnggota($id, Request $request){
        unset($request['_token']);
        KegiatanDetailAnggota::where('id', $id)->update(
            $request->all()
        );
        return redirect()->back()->with('succes', 'Berhasil Mengubah Data Anggota');

    }

    public function deleteAnggota($id){
        KegiatanDetailAnggota::where('id', $id)->delete();
        return redirect()->back()->with('succes', 'Berhasil Mengahapus Data Anggota');
    }

    // Detail Iuran
    public function detailIuran($id){
        $rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $warga = Warga::where('id_rt', $rt->id_rt)->with('user')->get();
        $data = KegiatanIuran::where('id_kegiatan', $id)->with('detailIuran.user')->first();

        return view('rt.kegiatan.detailiuran', compact('data', 'warga'));
    }

    public function datatableIuran($id, Request $request){
        if ($request->ajax()) {
            $data = KegiatanIuran::where('id_kegiatan', $id)->with('detailIuran.user')->first();
//            dd($data->toArray());
            return DataTables::of($data['detailIuran'])
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->status == "Belum Bayar"){
                        $btn = '<a href="#" class="btn btn-outline-primary btn-sm" onclick="status('.$row->id.')" data-toggle="modal" data-target="#bayar">
                                                <i class="icon icon-check"> Sudah Bayar</i></a>';
                    }else{
                        $btn = '';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function statusIuran($id){
        KegiatanDetailIuran::where('id', $id)->update([
            'status' => "Sudah Bayar",
            'tgl_pembayaran' => Carbon::now(),
        ]);
        return redirect()->back()->with('succes', 'Berhasil Mengubah Status Pembayaran');
    }
}
