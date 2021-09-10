<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\KabKota;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KabKotaController extends Controller
{
    public function index(){
        $provinsi = Provinsi::all();
        $data = KabKota::all();
        return view('administrator.master.kabkota', compact('data', 'provinsi'));
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = KabKota::with('detailProvinsi')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#edit' . $row->id . '" style="width: 80px">
                                                <i class="icon icon-pencil"> Edit</i></a>' .
                        '<a href="#" class="btn btn-outline-danger btn-sm" style="width: 80px" data-toggle="modal" data-target="#hapus' . $row->id . '">
                                                <i class="icon icon-trash"> Hapus</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_provinsi' => 'required',
            'nama' => 'required|unique:kab_kota'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        unset($request['_token']);
        KabKota::create($request->all());

        return redirect()->back()->with('succes', 'Berhasil Menambah Data Kab/Kota');
    }

    public function update($id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        KabKota::where('id', $id)->update($data);

        return redirect()->back()->with('succes', 'Berhasil Mengubah Data Kab/Kota');
    }

    public function delete($id){
        KabKota::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data Kab/Kota');
    }
}
