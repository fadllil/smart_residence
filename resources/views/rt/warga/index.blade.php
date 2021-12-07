@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Warga
                </h4>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <!-- Main content -->
    <div class="custom-tab-1">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if (Session::get('menu') != 'proses' && Session::get('menu') != 'selesai') { ?>
                    active
                    <?php } ?>"
                   data-toggle="tab" href="#home1"><i class="icon icon-check"></i> Aktif</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if (Session::get('menu') == 'proses') { ?>
                    active
                    <?php } ?>"
                   data-toggle="tab" href="#profile1"><i class="icon icon-close"></i>
                    Tidak Aktif</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="home1" role="tabpanel">
                <div class="content-wrapper animatedParent animateOnce">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <h6 class="card-title">Tabel Data Warga</h6>
                                            </div>
                                            <div class="col-2 text-right">
                                                <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#tambah">
                                                    <i class="icon icon-add"> Tambah</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatableWarga" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Status</th>
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
            </div>
            <div class="tab-pane fade" id="profile1">
                <div class="content-wrapper animatedParent animateOnce">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-header">
                                                <h6 class="card-title">Tabel Data Warga Tidak Aktif</h6>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatableWargaTidakAktif" class="table table-bordered table-striped" style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Status</th>
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
            </div>
        </div>
    </div>

    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="tambah" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-40 p-b-0">
                        <h4>Tambah Data</h4>
                    </div>
                    <div class="light p-10 b-t-b">
                        <form action="/rt/warga/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input name="nama" type="text" class="form-control form-control-lg"
                                       placeholder="Nama" required>
                                <input hidden name="id_rt" type="text" class="form-control form-control-lg"
                                       value="{{$rt->id_rt}}" required>
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
                                       value="Warga" required>
                            </div>
                            <input type="submit" class="btn btn-primary btn-fab-md btn-block" value="Tambah">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('#datatableWarga').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/warga/datatable',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'user.nama',
                        name: 'nama'
                    },
                    {
                        data: 'user.email',
                        name: 'email'
                    },
                    {
                        data: 'user.status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });

        $(function() {
            $('#datatableWargaTidakAktif').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/warga/datatableTidakAktif',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'user.nama',
                        name: 'nama'
                    },
                    {
                        data: 'user.email',
                        name: 'email'
                    },
                    {
                        data: 'user.status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>
@endsection
