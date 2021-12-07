<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:8',
                'nama' => 'required|string',
                'email' => 'required|email|unique:users',
            ]
        );

        if ($validator->fails()) {
            $res['results'] = $validator->errors()->first();
            $res['code'] = 422;
            $res['message'] = 'Error form validation';
            return response()->json($res, $res['code']);
        }

        if ($user = User::create([
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email
        ])) {
            $res['code'] = 201;
            $res['message'] = 'User created succesfully';
        }
        return response()->json($res, $res['code']);
    }

    public function login(Request $request){
        $res['code'] = 404;
        $res['results'] = null;
        $res['message'] = 'an error occured';
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            $res['code'] = 422;
            $res['results'] = $validator->errors()->first();
            return response()->json($res, $res['code']);
        }
        $user = User::where('email', $request->email)->with('adminRt', 'warga')->first();
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
