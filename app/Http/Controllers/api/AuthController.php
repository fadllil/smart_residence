<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdminRT;
use App\Models\RT;
use App\Models\RW;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function register(Request $request){
        $res['code'] = 404;
        $res['results'] = null;
        $res['message'] = 'an error occured';
//        $validator = Validator::make(
//            $request->all(),
//            [
//                'password' => 'required|min:8',
//                'nama' => 'required|string',
//                'email' => 'required|email|unique:users',
//            ]
//        );
//
//        if ($validator->fails()) {
//            $res['results'] = $validator->errors()->first();
//            $res['code'] = 422;
//            $res['message'] = 'Error form validation';
//            return response()->json($res, $res['code']);
//        }

        if ($request->status == "Warga"){
            $cek = Warga::where('no_hp', $request->nomor)->first();
            if ($cek){
                $res['message'] = 'Nomor Hp Sudah terdaftar';
                $res['code'] = 422;
                return response()->json($res, $res['code']);
            }
        }else{
            $cek = AdminRT::where('no_hp', $request->nomor)->first();
            if ($cek){
                $res['message'] = 'Nomor Hp Sudah terdaftar';
                $res['code'] = 422;
                return response()->json($res, $res['code']);
            }
        }

        $rw = RW::where(['id_kelurahan' => $request->id_kelurahan, 'nama' => $request->rw])->first();;
        if (!$rw){
            $rw = RW::create([
                'id_kelurahan' => $request->id_kelurahan,
                'nama' => $request->rw,
            ]);
            $rt = RT::create([
                'id_rw' => $rw->id,
                'nama'=> $request->rt
            ]);
        }else{
            $rt = RT::where(['id_rw' => $rw->id, 'nama' => $request->rt])->first();

            if (!$rt){
                $rt = RT::create([
                    'id_rw' => $rw->id,
                    'nama' => $request->nama
                ]);
            }
        }

        if ($user = User::create([
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->status,
            'status' => "Tidak Aktif"
        ])) {
            $res['code'] = 201;
            $res['message'] = 'User created succesfully';

            if ($request->status == "Warga"){
                Warga::create([
                    'id_rt' => $rt->id,
                    'id_user' => $user->id,
                    'no_hp' => $request->nomor,
                ]);
            }else{
                AdminRT::create([
                    'id_rt' => $rt->id,
                    'id_user' => $user->id,
                    'no_hp' => $request->nomor,
                ]);
            }
        }

        return response()->json($res, $res['code']);
    }

    public function login(Request $request){
        $res['code'] = 404;
        $res['results'] = null;
        $res['message'] = 'an error occured';
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            $res['code'] = 422;
            $res['results'] = $validator->errors()->first();
            return response()->json($res, $res['code']);
        }
        $warga = Warga::where('no_hp', $request->username)->first();
        $adminRt = AdminRT::where('no_hp', $request->username)->first();
        if (!$warga && !$adminRt){
            $res['results'] = 'Username not found';
            return response()->json($res, $res['code']);
        }else if($warga){
            $id_user = $warga->id_user;
        }else if($adminRt){
            $id_user = $adminRt->id_user;
        }
        $user = User::where('id', $id_user)->with('adminRt', 'warga')->first();
        if (!$user){
            $res['results'] = 'Username not found';
            return response()->json($res, $res['code']);
        }
        if (Hash::check($request->password, $user->password)){
            $res['message'] = 'Login succesfully';
            $res['code'] = 200;
            $payload = [
                'iss' => env('APP_URL'),
                'sub' => $user,
                'iat' => time()
            ];
            $token = JWT::encode($payload, env('JWT_SECRET'));
            $res['results'] = $token;
        } else {
            $res['message'] = 'Password not macthed with email';
        }
        return response()->json($res, $res['code']);

    }
}
