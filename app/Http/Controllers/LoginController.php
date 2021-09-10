<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function doLogin(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user){
            if (Hash::check($request->password, $user['password'])){
                if ($user['role'] == 'Administrator'){
                    Auth::login($user);
                    return redirect('/');
                }elseif ($user['role'] == 'RT'){
                    Auth::login($user);
                    return redirect('/');
                }
            }else{
                return redirect()->back()->with('warning', 'username atau password salah');
            }
        }else{
            return redirect()->back()->with('warning', 'username tidak terdaftar');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
