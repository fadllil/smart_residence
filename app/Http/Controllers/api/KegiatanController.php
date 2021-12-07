<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\AdminRT;
use App\Models\Kegiatan;
use App\Models\KegiatanAnggota;
use App\Models\KegiatanDetailAnggota;
use App\Models\KegiatanDetailIuran;
use App\Models\KegiatanIuran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function proses($id){
        $data = Kegiatan::where([
            'id_rt' => $id,
            'status' => "Belum Terlaksana"
        ])->with('anggota')->with('iuran')->latest()->get();
        if (!$data){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        return  Response::success('data kegiatan', $data);
    }

    public function selesai($id){
        $data = Kegiatan::where([
            'id_rt' => $id,
            'status' => "Selesai"
        ])->with('anggota')->with('iuran')->latest()->get();
        if (!$data){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        return  Response::success('data kegiatan', $data);
    }

    public function batal($id){
        $data = Kegiatan::where([
            'id_rt' => $id,
            'status' => "Batal"
        ])->with('anggota')->with('iuran')->latest()->get();
        if (!$data){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        return  Response::success('data kegiatan', $data);
    }

    public function detailAnggota($id){
        $data = KegiatanAnggota::where([
            'id_kegiatan' => $id
        ])->with('detailAnggota.user')->latest()->first();
        if (!$data){
            return Response::failure('Data detail anggota tidak ditemukan', 404);
        }
        return  Response::success('data detail anggota', $data);
    }

    public function detailIuran($id){
        $data = KegiatanIuran::where([
            'id_kegiatan' => $id
        ])->with('detailIuran.user')->latest()->first();
        if (!$data){
            return Response::failure('Data detail iuran tidak ditemukan', 404);
        }
        return  Response::success('data detail iuran', $data);
    }

    public function detailIuranWarga($id, $id_user){
        $data = KegiatanIuran::where([
            'id_kegiatan' => $id
        ])->with('getIuran.user', 'kegiatan')->whereHas('detailIuran', function ($query) use ($id_user){
            $query->where('id_user', '=', $id_user);
        })->first();
        if (!$data){
            return Response::failure('Data detail iuran tidak ditemukan', 404);
        }
        return  Response::success('data detail iuran', $data);
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
            return Response::failure($validator->errors()->first(), 417);
        }

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
                if ($request->status_anggota == "Panitia"){
                    $kegiatan_anggota = KegiatanAnggota::create([
                        'id_kegiatan' => $kegiatan->id,
                        'status' => $request->status_anggota
                    ]);
                    if ($request->id_user){
                        foreach ($request->id_user as $key => $id_user){
                            $keterangan = $request->keterangan[$key];
                            KegiatanDetailAnggota::create([
                                'id_kegiatan_anggota' => $kegiatan_anggota->id,
                                'id_user' => $id_user,
                                'keterangan' => $keterangan
                            ]);
                        }
                    }
                }else{
                    KegiatanAnggota::create([
                        'id_kegiatan' => $kegiatan->id,
                        'status' => $request->status_anggota,
                        'maksimal_anggota' => $request->maksimal_anggota
                    ]);
                }
            }

            if ($request->status){
                if ($request->status == "Wajib"){
                    $iuran = KegiatanIuran::create([
                        'id_kegiatan' => $kegiatan->id,
                        'status' => $request->status,
                        'nominal' => $request->nominal,
                        'tgl_terakhir_pembayaran' => $request->tgl_terakhir_pembayaran
                    ]);

                    $warga = Warga::where('id_rt', $request->id_rt)->whereHas('user', function ($query){
                        $query->where('status', '=', 'Aktif');
                    })->get();
                    foreach ($warga as $w){
                        KegiatanDetailIuran::create([
                            'id_iuran' => $iuran->id,
                            'id_user' => $w->id_user,
                            'status' => "Belum Bayar"
                        ]);
                    }
                }else{
                    KegiatanIuran::create([
                        'id_kegiatan' => $kegiatan->id,
                        'status' => $request->status,
                    ]);
                }
            }
            DB::commit();
            return Response::success('Berhasil menambah data', null);
        } catch (Exception $e){
            DB::rollBack();
            return Response::failure('Data tidak ditemukan', 400);
        }
    }

    public function postSelesai($id){
        Kegiatan::where('id', $id)->update(['Status' => 'Selesai']);
        return Response::success('Berhasil merubah status', null);
    }

    public function postBatal($id){
        Kegiatan::where('id', $id)->update(['Status' => 'Batal']);
        return Response::success('Berhasil merubah status', null);
    }

    public function bayar(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'gambar' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }
    }
}
