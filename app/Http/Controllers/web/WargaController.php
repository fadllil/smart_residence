<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WargaController extends Controller
{
    public function index(){
        $data = User::where('role', "Warga")->get();
        return view('administrator.user.warga', compact('data'));
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = User::where('role', 'Warga')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#detail' . $row->id . '" style="width: 80px">
                                                <i class="icon icon-details"> Detail</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
