@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Kuangan
                </h4>
                <h6>
                    Pemasukan
                </h6>
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
                            <div class="row">
                                <div class="col-10">
                                    <h6 class="card-title">Tabel Data Keuangan Pemasukan</h6>
                                </div>
{{--                                <div class="col-2 text-right">--}}
{{--                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#tambah">--}}
{{--                                        <i class="icon icon-add"> Tambah</i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatableKeuanganPemasukan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Total Pemasukan</th>
                                    <th style="width: 180px">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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

