<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KecamatanController extends Controller
{
    public function index(){
        $provinsi = Provinsi::pluck("nama","id");
        $data = Kecamatan::all();
        return view('administrator.master.kecamatan', compact('data', 'provinsi'));
    }

    public function getKota(Request $request){
        $states = KabKota::where("id_provinsi",$request->id_provinsi)
            ->pluck("nama","id");
        return response()->json($states);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = Kecamatan::with('detailKabKota.detailProvinsi')->get();
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
            'id_kabkota' => 'required',
            'nama' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        unset($request['_token']);

        $kecamatan = Kecamatan::where('id_kabkota', $request->id_kabkota)->get();
        foreach ($kecamatan as $k){
            if (strcasecmp($k->nama,$request->nama) == 0){
                return redirect()->back()->with('warning', 'Nama Kecamatan sudah terdaftar di Kabupaten/Kota tersbut');
            }
        }
        unset($request['id_provinsi']);
        Kecamatan::create($request->all());
        return redirect()->back()->with('succes', 'Berhasil Menambah Data Kecamatan');
    }

    public function update($id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        unset($data['id_provinsi']);
        Kecamatan::where('id', $id)->update($data);

        return redirect()->back()->with('sukses', 'Berhasil Mengubah Data Kecamatan');
    }

    public function delete($id){
        Kecamatan::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data Kecamatan');
    }
}
