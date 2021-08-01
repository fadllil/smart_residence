<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AdministratorController extends Controller
{
    public function __construct()
    {
    }

    public function getAuth(Request $request){
        $auth = $request->session()->get('auth');
        return $auth;
    }

    public function user(Request $request){
        if ($request->session()->has('auth')){
            $auth = $this->getAuth($request);
            $nama = $auth['nama'];
            $list_data = Administrator::all();
            return view('administrator.admin.user', compact('list_data', 'nama'));
        }else{
            return view('login');
        }
    }

    public function formTambah(Request $request){
        $auth = $this->getAuth($request);
        $nama = $auth['nama'];
        return view('administrator.admin.tambah', compact('nama'));
    }

    public function tambah(Request $request){
        $data = new Administrator();
        $data->nama = $request->nama;
        $data->password = Hash::make($request->password);
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->save();
        return redirect('admin/user')->with('succes','Berhasil Menambah Data administrator');
    }

    public function formEdit(Request $request, $id){
        $auth = $this->getAuth($request);
        $nama = $auth['nama'];
        $data = Administrator::where('id', $id)->first();
        return view('administrator.admin.edit', compact('nama', 'data'));
    }

    public function edit($id, Request $request){
        $data = Administrator::where('id', $id)->first();
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->update();
        return redirect('admin/user')->with('succes','Berhasil Mengubah Data administrator');
    }

    public function hapus($id){
        $data = Administrator::FindOrFail($id);
        $data->delete();
        return redirect('admin/user')->with('succes','Berhasil Menghapus Data administrator');
    }
}
