<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KelurahanController extends Controller
{
    public function index(){
        $provinsi = Provinsi::pluck("nama","id");
        $data = Kelurahan::all();
        return view('administrator.master.kelurahan', compact('data', 'provinsi'));
    }

    public function getKecamatan(Request $request){
        $kecamatan = Kecamatan::where("id_kabkota",$request->id_kabkota)
            ->pluck("nama","id");
        return response()->json($kecamatan);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_provinsi' => 'required',
            'id_kabkota' => 'required',
            'id_kecamatan' => 'required',
            'nama' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        unset($request['_token']);

        $kelurahan = Kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();
        foreach ($kelurahan as $k){
            if (strcasecmp($k->nama,$request->nama) == 0){
                return redirect()->back()->with('warning', 'Nama Kelurahan sudah terdaftar di Kecamatan tersbut');
            }
        }
        unset($request['id_provinsi']);
        Kelurahan::create($request->all());
        return redirect()->back()->with('succes', 'Berhasil Menambah Data Kelurahan');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = Kelurahan::with('detailKecamatan.detailKabKota.detailProvinsi')->get();
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
        Kelurahan::where('id', $id)->update($data);

        return redirect()->back()->with('sukses', 'Berhasil Mengubah Data Kelurahan');
    }

    public function delete($id){
        Kelurahan::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data Kelurahan');
    }
}
