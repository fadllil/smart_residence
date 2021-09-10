<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if (Auth::check()){
            if (Auth::user()->role == 'Administrator'){
                return view('administrator.home');
            }elseif (Auth::user()->role == 'RT'){
                return view('rt.home');
            }
        }else{
            return view('login');
        }
    }
}
