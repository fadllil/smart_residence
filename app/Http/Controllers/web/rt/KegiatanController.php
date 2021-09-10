<?php

namespace App\Http\Controllers\web\rt;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\Kegiatan;
use App\Models\KegiatanAnggota;
use App\Models\KegiatanDetailIuran;
use App\Models\KegiatanIuran;
use App\Models\Warga;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    public function index(){
        $rt = AdminRT::where('id_user', Auth::user()->id)->first();
        $data = Kegiatan::where([
            'id_rt' => $rt->id_rt,
            'status' => "Belum Terlaksana"
        ])->latest()->get();
        return view('rt.kegiatan.index', compact('data','rt'));
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'tgl_mulai' => 'required',
                'tgl_selesai' => 'required',
                'lokasi' => 'required',
                'catatan' => 'required',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $rt = AdminRT::where('id_user', Auth::user()->id)->first();
        try {
            DB::beginTransaction();
            $kegiatan = Kegiatan::create([
                'id_rt' => $rt->id_rt,
                'nama' => $request->nama,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'lokasi' => $request->lokasi,
                'status' => 'Belum Terlaksana',
                'catatan' => $request->catatan,
            ]);

            if ($request->nama_anggota){
                foreach ($request->nama_anggota as $key => $nama){
                    $jabatan = $request->jabatan[$key];
                    KegiatanAnggota::create([
                        'id_kegiatan' => $kegiatan->id,
                        'nama' => $nama,
                        'jabatan' => $jabatan
                    ]);
                }
            }

            if ($request->status){
                $iuran = KegiatanIuran::create([
                    'id_kegiatan' => $kegiatan->id,
                    'status' => $request->status,
                    'nominal' => $request->nominal
                ]);
                if ($request->status == "Wajib"){
                    $warga = Warga::where('id_rt', $rt->id)->get();
                    foreach ($warga as $w){
                        KegiatanDetailIuran::create([
                            'id_iuran' => $iuran->id,
                            'id_user' => $w->id_user,
                            'status' => "Belum Bayar"
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('succes', 'Berhasil Menambah Data Kegiatan');
        } catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->with('warning', 'Terjadi Kesalahan Server, silahkan coba lagi');
        }
    }

    public function update($id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        Kegiatan::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Berhasil Mengubah Data Kegiatan');
    }

    public function selesai($id){
        Kegiatan::where('id', $id)->update(['Status' => 'Selesai']);
        return redirect()->back()->with('success', 'Berhasil Mengubah Status Kegiatan');
    }

    public function batal($id){
        Kegiatan::where('id', $id)->update(['Status' => 'Batal']);
        return redirect()->back()->with('success', 'Berhasil Mengubah Status Kegiatan');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $rt = AdminRT::where('id_user', Auth::user()->id)->first();
            $data = Kegiatan::where([
                'id_rt' => $rt->id_rt,
                'status' => "Belum Terlaksana"
            ])->with('anggota')->with('iuran')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (count($row->anggota) > 0 && count($row->iuran) > 0){
                        $btn = '<a class="dropdown-item" href="/rt/kegiatan/pengurus/'.$row->id.'"><i class="icon icon-users"> Pengurus</i></a>
                                <a class="dropdown-item" href="/rt/kegiatan/iuran/'.$row->id.'"><i class="icon icon-money"> Iuran</i></a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="icon icon-edit"> Edit</i></a>';
                    }elseif (count($row->anggota) == 0 && count($row->iuran) > 0){
                        $btn = '<a class="dropdown-item" href="/rt/kegiatan/iuran/'.$row->id.'"><i class="icon icon-money"> Iuran</i></a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="icon icon-edit"> Edit</i></a>';
                    } elseif (count($row->anggota) > 0 && count($row->iuran) == 0){
                        $btn = '<a class="dropdown-item" href="/rt/kegiatan/pengurus/'.$row->id.'"><i class="icon icon-users"> Pengurus</i></a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="icon icon-edit"> Edit</i></a>';
                    } else{
                        $btn = '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="icon icon-edit"> Edit</i></a>';
                    }

                    return '<div class="row" style="padding-left: 10px; padding-right: 10px">
                                <div class="dropdown show">
                                  <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button"
                                  id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon icon-details"> Detail</i></a>
                                  </a>

                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    '.$btn.'
                                  </div>
                                </div>
                                <div class="dropdown show">
                                  <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button"
                                  id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon icon-details"> Status</i></a>
                                  </a>

                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="/rt/kegiatan/selesai/'.$row->id.'"><i class="icon icon-check"> Selesai</i></a>
                                    <a class="dropdown-item" href="/rt/kegiatan/batal/'.$row->id.'"><i class="icon icon-close"> Batal</i></a>
                                  </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
