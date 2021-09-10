<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\RW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RwController extends Controller
{
    public function index(){
        $provinsi = Provinsi::pluck("nama","id");
        $data = RW::all();
        return view('administrator.master.rw', compact('data', 'provinsi'));
    }

    public function getKelurahan(Request $request){
        $kelurahan = Kelurahan::where("id_kecamatan",$request->id_kecamatan)
            ->pluck("nama","id");
        return response()->json($kelurahan);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_provinsi' => 'required',
            'id_kabkota' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'nama' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        unset($request['_token']);

        $rw = RW::where('id_kelurahan', $request->id_kelurahan)->get();
        foreach ($rw as $r){
            if (strcasecmp($r->nama, $request->nama) == 0) {
                return redirect()->back()->with('warning', 'Nama RW sudah terdaftar di Kelurahan tersbut');
            }
        }
        unset($request['id_provinsi']);
        RW::create($request->all());
        return redirect()->back()->with('succes', 'Berhasil Menambah Data RW');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = RW::with('detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->get();
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

    public function update($id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        unset($data['id_provinsi']);
        unset($data['id_kabkota']);
        unset($data['id_kecamatan']);
        RW::where('id', $id)->update($data);

        return redirect()->back()->with('sukses', 'Berhasil Mengubah Data RW');
    }

    public function delete($id){
        RW::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data RW');
    }
}
