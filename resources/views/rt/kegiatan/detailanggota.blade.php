@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Kegiatan
                </h4>
                <h6>
                    Detail Anggota > {{$data['status']}}
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
                    @if($data['status'] == 'Peserta')
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title">Maksimal Peserta : {{$data['maksimal_anggota']}}</p>
                            </div>
                        </div>
                        <br>
                    @endif
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    <h6 class="card-title">Tabel Data {{$data['status']}}</h6>
                                </div>
                                @if($data->kegiatan->status == 'Belum Selesai')
                                    <div class="col-2 text-right">
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#tambah">
                                            <i class="icon icon-add"> Tambah</i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatableDetailAnggota" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    @if($data['status'] == "Peserta")
                                        <th>Nama Pendaftar</th>
                                        <th>Nama Didaftarkan</th>
                                    @else
                                        <th>Nama</th>
                                    @endif
                                    <th>Keterangan</th>
                                    @if($data->kegiatan->status == 'Belum Selesai')
                                        <th style="width: 180px">Aksi</th>
                                    @endif
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
                        <form action="/rt/kegiatan/detail-anggota/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="iuran">Jenis Anggota</label>
                                <select class="form-control"  id="nama_anggota" name="id_user" required>
                                    <option selected disabled>Pilih Anggota</option>
                                    @foreach($warga as $w)
                                        <option value="{{$w->user->id}}">{{$w->user->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="id_kegiatan_anggota" class="form-control" value="{{$data['id']}}" required>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                            </div>
                            <div class="text-right">
                                <input type="button" class="btn btn-danger btn-fab-md" data-dismiss="modal" value="Batal">
                                <input type="submit" class="btn btn-primary btn-fab-md" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($data['detailAnggota'] as $d)
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
                            <a href="#" class="danger btn btn-danger btn-fab-md" data-dismiss="modal" aria-label="Close">Tidak</a>
                            <a href="/rt/kegiatan/detail-anggota/delete/{{$d->id}}" class="btn btn-primary btn-fab-md">Ya</a>
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
                            <form action="/rt/kegiatan/detail-anggota/update/{{$d->id}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="iuran">Jenis Anggota</label>
                                    <select class="form-control"  id="nama_anggota" name="id_user" required>
                                        <option selected disabled>Pilih Anggota</option>
                                        @foreach($warga as $w)
                                            <option @if($d->id_user == $w->user->id) selected @endif value="{{$w->user->id}}">{{$w->user->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" value="{{$d->keterangan}}" class="form-control" placeholder="Keterangan" required>
                                </div>
                                <div class="text-right">
                                    <input type="button" class="btn btn-danger btn-fab-md" data-dismiss="modal" value="Batal">
                                    <input type="submit" class="btn btn-primary btn-fab-md" value="Simpan">
                                </div>
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
            $('#datatableDetailAnggota').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/kegiatan/detail-anggota/datatable/{{$data['id_kegiatan']}}',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    @if($data['status'] == "Peserta")
                    {
                        data: 'user.nama',
                        name: 'nama'
                    },
                    {
                        data: 'nama_didaftarkan',
                        name: 'nama_didaftarkan'
                    },
                    @else
                    {
                        data: 'user.nama',
                        name: 'nama'
                    },
                    @endif

                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    @if($data->kegiatan->status == 'Belum Selesai')
                        {
                            data: 'action',
                            name: 'action'
                        },
                    @endif
                ]
            });
        });

    </script>
@endsection
