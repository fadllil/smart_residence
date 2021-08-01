<?php

namespace App\Http\Controllers;

use App\Models\RT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AdminRtController extends Controller
{
    public function __construct()
    {
    }

    public function getAuth(Request $request){
        $auth = $request->session()->get('auth');
        return $auth;
    }

    public function index(Request $request){
        if ($request->session()->has('auth')){
            $auth = $this->getAuth($request);
            $nama = $auth['nama'];

            if ($request->ajax()){
                $data = DB::table('rt')->orderBy('id', 'DESC')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row){
                        $btn = '<a style="width:80px" href="pemesanan/formEdit/'. $row->id.'" class="btn btn-outline-primary btn-sm">Edit</a>'.
                            '<a style="width:80px" href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal"
                            data-target="#modal">Hapus</a>'.
                            '<!-- Login modal -->
                        <div class="modal fade" id="modal" tabindex="-1"
                             role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog width-400" role="document">
                                <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                                    class="paper-nav-toggle active"><i></i></a>
                                    <div
                                            class="modal-body no-p">
                                        <div class="text-center p-40 p-b-0" style="margin-bottom: 10px">
                                            <i class="icon s-48 icon-warning3 red-text"></i>
                                            <p class="p-t-b-20">Apakah anda yakin ingin menghapus data?</p>
                                            <a href="#" class="danger btn btn-danger btn-fab-md" data-dismiss="modal" aria-label="Close">Tidak</a>
                                            <a href="pemesanan/hapus/' . $row->id . '" class="btn btn-primary btn-fab-md">Ya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>'
                        ;
                        return $btn;
                    })
                    ->rawColumns(['undangan', 'action'])
                    ->make(true);
            }

            $list_data = RT::all();
            return view('administrator.rt', compact('list_data', 'nama'));
        }else{
            return view('login');
        }
    }
}
