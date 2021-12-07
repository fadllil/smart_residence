<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\AdminRT;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index($id){
        $user = User::where('id', $id)->with('adminRt')->first();
        if (!$user){
            return Response::failure('User tidak ditemukan', 404);
        }
        return  Response::success('data user', $user);
    }

    public function update(Request $request){
        $user = User::where('id', $request->id)->first();
        if (!$user){
            return Response::failure('Data kegiatan tidak ditemukan', 404);
        }
        try {
            DB::beginTransaction();
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email
            ]);
            if ($user->role == 'RT'){
                AdminRT::where('id_user', $request->id)->update([
                    'jabatan' => $request->jabatan,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat
                ]);
            }else{
                Warga::where('id_user', $request->id)->update([
                    'nik' => $request->nik,
                    'no_kk' => $request->no_kk,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'jml_anggota_keluarga' => $request->jml_anggota_keluarga,
                ]);
            }

            DB::commit();
            return Response::success('Berhasil merubah data pengguna', null);
        }catch (Exception $e){
            return Response::failure('Data tidak ditemukan', 400);
        }
    }

    public function warga($id){
        $user = User::where('id', $id)->with('warga')->first();
        if (!$user){
            return Response::failure('User tidak ditemukan', 404);
        }
        return  Response::success('data user', $user);
    }
}
