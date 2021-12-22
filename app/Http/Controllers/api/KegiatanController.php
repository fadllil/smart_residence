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
use App\Models\Keuangan;
use App\Models\Pemasukan;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function index($id){
        $data = Kegiatan::select('kegiatan.*')->where('id_rt', $id)->latest()->get();
        if (!$data){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        return  Response::success('data kegiatan', $data);
    }

    public function kegiatan($id, Request $request){
        $data = Kegiatan::where([
            'id_rt' => $id,
            'status' => $request->status
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

    public function detailIuranBelumBayar($id){
        $data = KegiatanDetailIuran::select('kegiatan_detail_iuran.*', 'kegiatan_iuran.nominal', 'kegiatan_iuran.tgl_terakhir_pembayaran')
            ->join('kegiatan_iuran', 'kegiatan_iuran.id', '=', 'kegiatan_detail_iuran.id_iuran')
            ->where([
                'kegiatan_iuran.id_kegiatan' => $id,
                'kegiatan_detail_iuran.status' => 'Belum Bayar'
            ])->with('user')->latest()->get();
        if (!$data){
            return Response::failure('Data detail iuran tidak ditemukan', 404);
        }
        return  Response::success('data detail iuran', $data);
    }

    public function detailIuranMenungguValidasi($id){
        $data = KegiatanDetailIuran::select('kegiatan_detail_iuran.*', 'kegiatan_iuran.nominal', 'kegiatan_iuran.tgl_terakhir_pembayaran')
            ->join('kegiatan_iuran', 'kegiatan_iuran.id', '=', 'kegiatan_detail_iuran.id_iuran')
            ->where([
                'kegiatan_iuran.id_kegiatan' => $id,
                'kegiatan_detail_iuran.status' => 'Menunggu Validasi'
            ])->with('user')->latest()->get();
        if (!$data){
            return Response::failure('Data detail iuran tidak ditemukan', 404);
        }
        return  Response::success('data detail iuran', $data);
    }

    public function detailIuranSudahBayar($id){
        $data = KegiatanDetailIuran::select('kegiatan_detail_iuran.*', 'kegiatan_iuran.nominal', 'kegiatan_iuran.tgl_terakhir_pembayaran')
            ->join('kegiatan_iuran', 'kegiatan_iuran.id', '=', 'kegiatan_detail_iuran.id_iuran')
            ->where([
                'kegiatan_iuran.id_kegiatan' => $id,
                'kegiatan_detail_iuran.status' => 'Sudah Bayar'
            ])->with('user')->latest()->get();
        if (!$data){
            return Response::failure('Data detail iuran tidak ditemukan', 404);
        }
        return  Response::success('data detail iuran', $data);
    }

    public function detailIuranWarga($id, $id_user){
        $data = KegiatanIuran::where([
            'id_kegiatan' => $id
        ])->with('kegiatan')->first();
        $get_iuran = KegiatanDetailIuran::where(['id_iuran' => $data->id ,'id_user' => $id_user])->with('user')->first();
        $data['berpartisipasi'] = false;
        if ($get_iuran){
            $data['berpartisipasi'] = true;
        }
        $data['getIuran'] = $get_iuran;
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
        $kegiatan = Kegiatan::where('id', $id)->with('iuran')->first();
        if (!$kegiatan){
            return Response::failure('Data tidak ditemukan', 400);
        }

        if (count($kegiatan->iuran)>0){
            $total_pemasukan = KegiatanDetailIuran::select('kegiatan_detail_iuran.*')
                ->join('kegiatan_iuran', 'kegiatan_iuran.id', 'kegiatan_detail_iuran.id_iuran')
                ->where([
                    'kegiatan_detail_iuran.status' => 'Sudah Bayar',
                    'kegiatan_iuran.id_kegiatan' => $id
                ])
                ->sum('uang');

            Pemasukan::create([
                'id_rt' => $kegiatan->id_rt,
                'id_kegiatan' => $id,
                'nominal' => $total_pemasukan,
                'keterangan' => 'Iuran'
            ]);

            $keuangan = Keuangan::where('id_rt', $kegiatan->id_rt)->first();

            if ($keuangan){
                $keuangan->update([
                    'nominal' => $keuangan->nominal + $total_pemasukan
                ]);
            }else{
                Keuangan::create([
                    'id_rt' => $kegiatan->id_rt,
                    'nominal' => $total_pemasukan,
                ]);
            }
        }
        $kegiatan->update(['status' => 'Selesai']);

        return Response::success('Berhasil merubah status', null);
    }

    public function postBatal($id){
        Kegiatan::where('id', $id)->update(['status' => 'Batal']);
        return Response::success('Berhasil merubah status', null);
    }

    public function bayar(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'keterangan' => 'required',
                'gambar' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $iuran = KegiatanDetailIuran::where('id', $request->id)->first();
        if (!$iuran){
            return Response::failure('Data tidak ditemukan', 400);
        }

        $kegiatanIuran = KegiatanIuran::where('id', $iuran->id_iuran)->first();

        $iuran->update([
            'uang' => $kegiatanIuran->nominal,
            'keterangan' => $request->keterangan,
            'gambar' => $request->gambar,
            'tgl_pembayaran' => Carbon::now(),
            'status' => 'Menunggu Validasi'
        ]);

        return Response::success('Berhasil menambah data', null);
    }

    public function bayarDonasi(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'id_user' => 'required',
                'keterangan' => 'required',
                'gambar' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $kegiatanIuran = KegiatanIuran::where('id', $request->id)->first();

        KegiatanDetailIuran::create([
            'id_iuran' => $request->id,
            'id_user' => $request->id_user,
            'uang' => $request->nominal,
            'keterangan' => $request->keterangan,
            'gambar' => $request->gambar,
            'tgl_pembayaran' => Carbon::now(),
            'status' => 'Menunggu Validasi'
        ]);

        return Response::success('Berhasil menambah data', null);
    }

    public function validasi($id){
        $iuran = KegiatanDetailIuran::where('id', $id)->first();
        if (!$iuran){
            return Response::failure('Data tidak ditemukan', 400);
        }
        $iuran->update(['status' => 'Sudah Bayar']);
        return Response::success('Berhasil merubah status', null);
    }

    public function berpartisipasiPeserta($id, Request $request){
        $data = KegiatanAnggota::where('id_kegiatan', $id)->first();
        if (!$data){
            return Response::failure('Kegiatan tidak ditemukan', 404);
        }
        $data['berpartisipasi'] = false;
        $kegiatan_iuran = KegiatanDetailAnggota::where(['id_user' => $request->user, 'id_kegiatan_anggota' => $data->id])->first();
        if ($kegiatan_iuran){
            $data['berpartisipasi'] = true;
        }
        $data['user'] = $kegiatan_iuran;
        return  Response::success('data kegiatan', $data);
    }

    public function pesertaJoin(Request $request){
        $validator = Validator::make($request->all(), [
            'id_kegiatan_anggota' => 'required',
            'id_user' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        KegiatanDetailAnggota::create($request->all());
        return  Response::success('Berhasil berpartisipasi', null);
    }
}
