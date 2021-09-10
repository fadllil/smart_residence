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
                    <a class="nav-link btn btn-outline-primary s-12" data-toggle="modal" data-target="#tambah">
                        <i class="icon-plus"></i> <span>Tambah</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambah" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog width-400" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-40 p-b-0">
                        <h4>Tambah Data</h4>
                    </div>
                    <div class="light p-10 b-t-b">
                        <form action="admin/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input name="nama" type="text" class="form-control form-control-lg"
                                       placeholder="Nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control form-control-lg"
                                       placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control form-control-lg"
                                       placeholder="Password" required>
                                <input hidden name="role" type="text" class="form-control form-control-lg"
                                       value="Administrator" required>
                            </div>
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Tambah">
                        </form>
                    </div>
                </div>
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
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
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
                                    <td>
                                        <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#edit{{$data->id}}" style="width: 80px">
                                            <i class="icon icon-pencil"> Edit</i>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit{{$data->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog width-400" role="document">
                                                <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                                                    class="paper-nav-toggle active"><i></i></a>
                                                    <div
                                                        class="modal-body no-p">
                                                        <div class="text-center p-40 p-b-0">
                                                            <h4>Edit Data</h4>
                                                        </div>
                                                        <div class="light p-10 b-t-b">
                                                            <form action="admin/update/{{$data->id}}" method="post">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="nama">Nama</label>
                                                                    <input name="nama" type="text" class="form-control form-control-lg"
                                                                           placeholder="Nama" value="{{$data->nama}}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input name="email" type="email" class="form-control form-control-lg"
                                                                           placeholder="Email" value="{{$data->email}}" required>
                                                                    <input hidden name="role" type="text" class="form-control form-control-lg"
                                                                           value="Administrator" required>
                                                                </div>
                                                                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Tambah">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                            <a href="/admin/delete/{{$data->id}}" class="btn btn-primary btn-fab-md">Ya</a>
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
