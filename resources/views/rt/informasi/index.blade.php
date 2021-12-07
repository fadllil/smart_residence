@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Informasi
                </h4>
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
                                    <h6 class="card-title">Tabel Data Informasi</h6>
                                </div>
                                <div class="col-2 text-right">
                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#tambah">
                                        <i class="icon icon-add"> Tambah</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatableInformasi" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
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

    <!-- Modal -->
    <div class="modal fade" id="tambah"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog width-900" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-t-20 p-b-0">
                        <h4>Tambah Informasi</h4>
                    </div>
                    <div class="light p-10 b-t-b">
                        <form action="/rt/informasi/create" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input name="id_rt" type="hidden" value="{{$admin_rt['id_rt']}}"
                                               class="form-control form-control-lg" required>
                                        <input name="judul" type="text" class="form-control form-control-lg"
                                               placeholder="Judul" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input name="tanggal" type="date" class="form-control form-control-lg"
                                               placeholder="Tanggal" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isi">Isi</label>
                                <textarea class="form-control" name="isi" id="isi" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="isi">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3">-</textarea>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <br>
                                <input name="gambar" type="file" accept="image">
                            </div>

                            <div class="text-right">
                                <input type="button" class="btn btn-danger btn-fab-md" data-dismiss="modal" value="Batal">
                                <input type="submit" class="btn btn-primary btn-fab-md" value="Tambah">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hapus modal -->
        <div class="modal fade" id="hapus" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel">

        </div>
@endsection

@section('script')
    <script>
        function hapus(data){
            // console.log(data);
            $('#hapus').append('<div class="modal-dialog width-400" id="hapus-id" role="document">\n' +
                '            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"\n' +
                '                                                class="paper-nav-toggle active"><i></i></a>\n' +
                '                <div\n' +
                '                    class="modal-body no-p">\n' +
                '                    <div class="text-center p-40 p-b-0" style="margin-bottom: 10px">\n' +
                '                        <i class="icon s-48 icon-warning3 red-text"></i>\n' +
                '                        <p class="p-t-b-20">Apakah anda yakin ingin menghapus data informasi?</p>\n' +
                '                        <a href="#" class="danger btn btn-danger btn-fab-md" data-dismiss="modal" aria-label="Close">Tidak</a>\n' +
                '                        <a href="/rt/informasi/delete/'+ data +'" class="btn btn-primary btn-fab-md">Ya</a>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </div>');
        }

        $('#hapus').on('hidden.bs.modal', function () {
            $('#hapus-id').remove();
        });

        $(function() {
            $('#datatableInformasi').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/informasi/datatable/{{$admin_rt['id_rt']}}',
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
    </script>
@endsection
