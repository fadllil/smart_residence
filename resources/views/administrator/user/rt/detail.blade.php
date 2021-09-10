@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Admin Rukun Tetangga (RT)
                </h4>
                <h5>
                    Detail
                </h5>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Main content -->
    <div class="content-wrapper animatedParent animateOnce">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h6>Pengurus RT {{$data->detailRt->nama}} RW {{$data->detailRt->detailRw->nama}}</h6>
                            <p>{{$data->detailRt->detailRw->detailKelurahan->nama}}, {{$data->detailRt->detailRw->detailKelurahan->detailKecamatan->nama}}, {{$data->detailRt->detailRw->detailKelurahan->detailKecamatan->detailKabKota->nama}}, {{$data->detailRt->detailRw->detailKelurahan->detailKecamatan->detailKabKota->detailProvinsi->nama}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="image float-left">
                                        <img class="user_avatar" src="{{asset('assets/img/dummy/u2.png')}}" style="width: 350px" alt="User Image">
                                    </div>
                                </div>
                                <div class="col-md-6 p-10">
                                    <div class="row">
                                        <div class="col-3">
                                            <h6>Nama</h6>
                                            <h6>Email</h6>
                                            <h6>NIK</h6>
                                            <h6>No Hp</h6>
                                            <h6>Jabatan</h6>
                                            <h6>Alamat</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6>: {{$data['user']['nama']}}</h6>
                                            <h6>: {{$data['user']['email']}}</h6>
                                            <h6>: {{$data['nik']}}</h6>
                                            <h6>: {{$data['no_hp']}}</h6>
                                            <h6>: {{$data['jabatan']}}</h6>
                                            <h6>: {{$data['alamat']}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
{{--                        <div class="card-footer">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <a href="adminrt/detail/'.$row->id.'" class="btn btn-outline-primary btn-sm" style="width: 80px">--}}
{{--                                    <i class="icon icon-edit"> Edit</i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.content -->
@endsection
