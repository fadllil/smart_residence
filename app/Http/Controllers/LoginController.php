<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function getAuth(Request $request){
        $auth = $request->session()->get('auth');
        return $auth;
    }

    public function doLogin(Request $request){
        $data = Administrator::where('email', $request->email)->first();
        if ($data != null){
            if (Hash::check($request->password, $data['password'])){
                $request->session()->put('auth' ,[
                    'id' => $data->id,
                    'nama' => $data->nama,
                    'email' => $data->email,
                    'no_hp' => $data->no_hp
                ]);
                $auth = $this->getAuth($request);
                $nama = $auth['nama'];
                return view('administrator.home', compact('nama'));
            }else{
                return view('login');
            }
        }else{
            return view('login');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
