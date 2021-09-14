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
        $warga = Warga::where('id_rt', $rt->id_rt)->with('user')->get();
        $data = Kegiatan::where([
            'id_rt' => $rt->id_rt,
            'status' => "Belum Terlaksana"
        ])->latest()->get();
        return view('rt.kegiatan.index', compact('data','rt', 'warga'));
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id_rt' => 'required',
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
                'id_rt' => $request->id_rt,
                'nama' => $request->nama,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'lokasi' => $request->lokasi,
                'status' => 'Belum Terlaksana',
                'catatan' => $request->catatan,
            ]);

            if ($request->status_anggota){
                $kegiatan_anggota = KegiatanAnggota::create([
                    'id_kegiatan' => $kegiatan->id,
                    'status' => $request->status_anggota,
                    'maksimal_anggota' => $request->maksimal_anggota
                ]);
                if ($request->id_user){
                    $count = 0;
                    foreach ($request->id_user as $key => $id_user){
                        $keterangan = $request->keterangan[$key];
                        KegiatanDetailAnggota::create([
                            'id_kegiatan_anggota' => $kegiatan_anggota->id,
                            'id_user' => $id_user,
                            'keterangan' => $keterangan
                        ]);
                        $count++;
                    }
                    if ($count > $kegiatan_anggota->maksimal_anggota){
                        DB::rollBack();
                        return redirect()->back()->with('warning', 'Jumlah anggota melebihi kapasitas');
                    }
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
        return redirect()->back()->with('succes', 'Berhasil Mengubah Status Kegiatan');
    }

    public function batal($id){
        Kegiatan::where('id', $id)->update(['Status' => 'Batal']);
        return redirect()->back()->with('succes', 'Berhasil Mengubah Status Kegiatan');
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
                    $btnAnggota = '<a hidden></a>';
                    $btnIuran = '<a hidden></a>';
                    if (count($row->iuran) > 0){
                        $btnIuran = '<a class="dropdown-item" href="/rt/kegiatan/detail-iuran/'.$row->id.'"><i class="icon icon-money"> Iuran</i></a>';
                    }
                    if (count($row->anggota) > 0) {
                        $btnAnggota = '<a class="dropdown-item" href="/rt/kegiatan/detail-anggota/' . $row->id . '"><i class="icon icon-users"> Anggota</i></a>';
                    }
                    $btn = '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="icon icon-edit"> Edit</i></a>';


                    return '<div class="row" style="padding-left: 10px; padding-right: 10px">
                                <div class="dropdown show">
                                  <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button"
                                  id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon icon-details"> Detail</i></a>
                                  </a>

                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    '.$btnAnggota.$btnIuran.$btn.'
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
