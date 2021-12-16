<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Provinsi;
use App\Models\RT;
use App\Models\RW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RtController extends Controller
{
    public function index(){
        $provinsi = Provinsi::pluck("nama","id");
        $data = RT::all();
        return view('administrator.master.rt', compact('data', 'provinsi'));
    }

    public function getRw(Request $request){
        $rw = RW::where("id_kelurahan",$request->id_kelurahan)
            ->pluck("nama","id");
        return response()->json($rw);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_provinsi' => 'required',
            'id_kabkota' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'id_rw' => 'required',
            'nama' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        unset($request['_token']);

        $rt = RT::where('id_rw', $request->id_rw)->get();
        foreach ($rt as $r){
            if (strcasecmp($r->nama, $request->nama) == 0) {
                return redirect()->back()->with('warning', 'Nama RT sudah terdaftar di RW tersbut');
            }
        }

        unset($request['id_provinsi']);
        $data = RT::create($request->all());
        Keuangan::create([
            'id_rt' => $data->id,
            'nominal' => 0,
        ]);
        return redirect()->back()->with('succes', 'Berhasil Menambah Data RT');
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = RT::with('detailRw.detailKelurahan.detailKecamatan.detailKabKota.detailProvinsi')->get();
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
        unset($data['id_kelurahan']);
        RT::where('id', $id)->update($data);

        return redirect()->back()->with('sukses', 'Berhasil Mengubah Data RT');
    }

    public function delete($id){
        RT::FindOrFail($id)->delete();
        return redirect()->back()->with('succes','Berhasil Menghapus Data RT');
    }
}
