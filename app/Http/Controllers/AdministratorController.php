<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class AdministratorController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $role = Auth::user()->role;
        $list_data = User::where('role', $role)->get();
        return view('administrator.user.admin', compact('list_data'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        unset($data['_token']);
        User::create($data);
        return redirect()->back()->with('succes','Berhasil Menambah Data Admin');
    }

    public function update($id, Request $request){
        unset($request['_token']);
        User::where('id', $id)->update($request->all());
        return redirect()->back()->with('succes','Berhasil Mengubah Data Admin');
    }

    public function delete($id){
        User::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data Admin');
    }
}
