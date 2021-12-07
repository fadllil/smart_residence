@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Pelaporan
                </h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="custom-tab-1">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if (Session::get('menu') != 'proses' && Session::get('menu') != 'selesai') { ?>
                    active
                    <?php } ?>"
                   data-toggle="tab" href="#belum-diproses"><i class="icon icon-agenda"></i> Belum Diproses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Session::get('menu') == 'proses') { ?>
                    active
                    <?php } ?>"
                   data-toggle="tab" href="#diproses"><i class="icon icon-refresh"></i>
                    Diproses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (Session::get('menu') == 'proses') { ?>
                    active
                    <?php } ?>"
                   data-toggle="tab" href="#selesai"><i class="icon icon-check"></i>
                    Selesai</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="belum-diproses" role="tabpanel">
                <!-- Main content -->
                <div class="content-wrapper animatedParent animateOnce">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-header">
                                        <div class="row">
                                            <h6 class="card-title">Tabel Data Pelaporan</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatablePelaporan" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Pelapor</th>
                                                <th>Tanggal</th>
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
            </div>
            <div class="tab-pane fade show" id="diproses" role="tabpanel">
                    <!-- Main content -->
                    <div class="content-wrapper animatedParent animateOnce">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">

                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-header">
                                            <div class="row">
                                                <h6 class="card-title">Tabel Data Pelaporan > Diproses</h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="datatablePelaporanDiproses" class="table table-bordered table-striped" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul</th>
                                                    <th>Pelapor</th>
                                                    <th>Tanggal</th>
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
                </div>
            <div class="tab-pane fade show" id="selesai" role="tabpanel">
                <!-- Main content -->
                <div class="content-wrapper animatedParent animateOnce">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-header">
                                        <div class="row">
                                            <h6 class="card-title">Tabel Data Pelaporan > Selesai</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatablePelaporanSelesai" class="table table-bordered table-striped" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Pelapor</th>
                                                <th>Tanggal</th>
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
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('#datatablePelaporan').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/pelaporan/datatable',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'user.nama',
                        name: 'pelapor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });

        $(function() {
            $('#datatablePelaporanDiproses').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/pelaporan/datatable/diproses',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'user.nama',
                        name: 'pelapor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
        $(function() {
            $('#datatablePelaporanSelesai').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/pelaporan/datatable/selesai',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'user.nama',
                        name: 'pelapor'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    }
                ]
            });
        });
    </script>
@endsection
