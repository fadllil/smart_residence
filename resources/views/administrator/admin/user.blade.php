@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Administrator
                </h4>
            </div>
        </div>
        <div class="row ">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary s-12" href="{{route('admin.formTambah')}}">
                        <i class="icon-plus"></i> <span>Tambah</span>
                    </a>
                </li>
            </ul>
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
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No Hp</th>
                                        <th style="width: 150px">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 0;
                                        foreach ($list_data as $data){
                                            $no++;
                                    ?>
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->no_hp}}</td>
                                        <td>
                                            <a href="/admin/formEdit/{{$data->id}}" class="btn btn-outline-primary btn-sm" style="width: 80px">
                                                <i class="icon icon-pencil"> Edit</i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger btn-sm" style="width: 80px" data-toggle="modal" data-target="#hapus{{$data->id}}">
                                                <i class="icon icon-trash"> Hapus</i>
                                            </a>
                                            <!-- Login modal -->
                                            <div class="modal fade" id="hapus{{$data->id}}" tabindex="-1"
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
                                                                <a href="/admin/hapus/{{$data->id}}" class="btn btn-primary btn-fab-md">Ya</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
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
