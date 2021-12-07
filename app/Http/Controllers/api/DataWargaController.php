<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Utils\Response;
use App\Models\RT;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataWargaController extends Controller
{
    public function aktif($id){
        $data = Warga::where('id_rt', $id)->with('user')->whereHas('user', function (Builder $query){
            $query->where('status', 'like','Aktif');
        })->latest()->get();
        if (!$data){
            return Response::failure('Data warga tidak ditemukan', 404);
        }
        return  Response::success('data warga', $data);
    }

    public function tidakAktif($id){
        $data = Warga::where('id_rt', $id)->with('user')->whereHas('user', function (Builder $query){
            $query->where('status', 'like','Tidak Aktif');
        })->latest()->get();
        if (!$data){
            return Response::failure('Data warga tidak ditemukan', 404);
        }
        return  Response::success('data warga', $data);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_rt' => 'required',
            'nama' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return Response::failure($validator->errors()->first(), 417);
        }

        $rt = RT::where('id', $request->id_rt)->first();
        if (!$rt){
            return Response::failure('RT tidak ditemukan', 404);
        }

        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['status'] = 'Aktif';
            $data['role'] = 'Warga';
            $user = User::create($data);
            Warga::create([
                'id_user' => $user->id,
                'id_rt' => $request->id_rt
            ]);
            DB::commit();
            return Response::success('Berhasil menambah data', null);
        }catch (Exception $e){
            return Response::failure('Data tidak ditemukan', 400);
        }
    }

    public function update(Request $request){
        $user = User::where('id', $request->id)->first();
        if (!$user){
            return Response::failure('Data user tidak ditemukan', 404);
        }
        $data = $request->all();
        unset($data['id']);
        $user->update($data);
        return Response::success('Data user berhasil diubah', null);
    }

    public function updateStatus($id){
        $user = User::where('id', $id)->first();
        if (!$user){
            return Response::failure('Data user tidak ditemukan', 404);
        }
        if ($user->status == 'Aktif'){
            $user->update(['status' => 'Tidak Aktif']);
        }else{
            $user->update(['status' => 'Aktif']);
        }
        return Response::success('Data user berhasil diubah', null);
    }
}
