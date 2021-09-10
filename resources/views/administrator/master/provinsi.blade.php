@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Provinsi
                </h4>
            </div>
        </div>
        <div class="row ">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary s-12" href="#" data-toggle="modal"
                       data-target="#tambah">
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
                        <form action="/provinsi/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Provinsi</label>
                                <input id="nama" name="nama" type="text" class="form-control form-control-lg"
                                       placeholder="Nama Provinsi" required>
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
                            <table id="datatableProvinsi" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Provinsi</th>
                                    <th style="width: 150px">Aksi</th>
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

    <!-- Hapus modal -->
    @foreach($data as $d)
    <div class="modal fade" id="hapus{{$d->id}}" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog width-400" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-40 p-b-0" style="margin-bottom: 10px">
                        <i class="icon s-48 icon-warning3 red-text"></i>
                        <p class="p-t-b-20">Apakah anda yakin ingin menghapus data?</p>
                        <a href="#" class="danger btn btn-danger btn-fab-md" data-dismiss="modal" aria-label="Close" style="width: 80px">Tidak</a>
                        <a href="provinsi/delete/{{$d->id}}" class="btn btn-primary btn-fab-md" style="width: 80px">Ya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit{{$d->id}}" tabindex="-1"
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
                        <form action="/provinsi/update/{{$d->id}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Provinsi</label>
                                <input id="nama" name="nama" type="text" class="form-control form-control-lg"
                                       placeholder="Nama Provinsi" value="{{$d->nama}}" required>
                            </div>
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Simpan">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(function() {
            $('#datatableProvinsi').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: 'provinsi/datatable',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'nama',
                        name: 'nama'
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
