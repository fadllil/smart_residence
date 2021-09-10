@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Kegiatan
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
    <div class="modal fade" id="tambah"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog width-900" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-t-20 p-b-0">
                        <h4>Tambah Kegiatan</h4>
                    </div>
                    <div class="light p-10 b-t-b">
                        <form action="/rt/kegiatan/create" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="nama">Nama Kegiatan</label>
                                        <input hidden name="id_rt" type="text" class="form-control form-control-lg"
                                               value="{{$rt->id_rt}}" required>
                                        <input name="nama" type="text" class="form-control form-control-lg"
                                               placeholder="Nama" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="tgl_mulai">Tanggal Mulai</label>
                                        <input name="tgl_mulai" type="date" class="form-control form-control-lg"
                                               placeholder="Tanggal Mulai" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="tgl_selesai">Tanggal Selesai</label>
                                        <input name="tgl_selesai" type="date" class="form-control form-control-lg"
                                               placeholder="Tanggal Selesai" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi</label>
                                        <input name="lokasi" type="text" class="form-control form-control-lg"
                                               placeholder="Lokasi" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <input name="catatan" type="text" class="form-control form-control-lg"
                                               placeholder="Nominal" value="-" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <h5>Iuran</h5>
                            </div>
                            <div class="iuran">

                            </div>
                            <div class="form-group">
                                <button type="button" onclick="showIuran()" class="btn btn-rounded btn-primary btn-fab-md" id="tambah-iuran">Tambah
                                    Iuran</button>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="hapusIuran()" class="btn btn-rounded btn-danger" id="hapus-iuran">Hapus Iuran</button>
                            </div>
                            <hr>
                            <div class="text-center">
                                <h5>Detail Anggota</h5>
                            </div>
                            <div class="anggota">

                            </div>
                            <div class="row detail-anggota">

                            </div>
                            <div class="form-group">
                                <button type="button" onclick="generateAnggota()" class="btn btn-rounded btn-primary btn-fab-md" id="detail-anggota">Tambah
                                    Anggota</button>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="hapusAnggota()" class="btn btn-rounded btn-danger" id="hapus-detail-anggota">Hapus Anggota</button>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="generateDetail()" class="btn btn-rounded btn-primary btn-fab-md" id="tambah-detail">Detail
                                    Anggota</button>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="hapusDetail()" class="btn btn-rounded btn-danger" id="hapus-detail">Hapus Detail Anggota</button>
                            </div>
                            <div class="text-right">
                                <input type="submit" class="btn btn-primary btn-fab-md" value="Tambah">
                            </div>
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
                            <table id="datatableKegiatan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
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

    @foreach($data as $d)
        <div class="modal fade" id="edit{{$d->id}}"
             role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog width-900" role="document">
                <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                    class="paper-nav-toggle active"><i></i></a>
                    <div
                        class="modal-body no-p">
                        <div class="text-center p-t-20 p-b-0">
                            <h4>Edit Kegiatan</h4>
                        </div>
                        <div class="light p-10 b-t-b">
                            <form action="/rt/kegiatan/update/{{$d->id}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="nama">Nama Kegiatan</label>
                                            <input name="nama" type="text" class="form-control form-control-lg" value="{{$d->nama}}"
                                                   placeholder="Nama" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="tgl_mulai">Tanggal Mulai</label>
                                            <input name="tgl_mulai" type="date" class="form-control form-control-lg" value="{{$d->tgl_mulai}}"
                                                   placeholder="Tanggal Mulai" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="tgl_selesai">Tanggal Selesai</label>
                                            <input name="tgl_selesai" type="date" class="form-control form-control-lg" value="{{$d->tgl_selesai}}"
                                                   placeholder="Tanggal Selesai" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="lokasi">Lokasi</label>
                                            <input name="lokasi" type="text" class="form-control form-control-lg" value="{{$d->lokasi}}"
                                                   placeholder="Lokasi" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <input name="catatan" type="text" class="form-control form-control-lg"
                                                   placeholder="Nominal" value="{{$d->catatan}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="submit" class="btn btn-primary btn-fab-md" value="Tambah">
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
        let i = 0;
        $("#detail-anggota").hide();
        $("#hapus-detail-anggota").hide();
        $("#hapus-detail").hide();
        $("#hapus-iuran").hide();

        function generateDetail(){
            $('.anggota').append(`
            <div id="anggota-c" class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="iuran">Jenis Anggota</label>
                        <select class="form-control"  id="status_anggota" name="status_anggota" required>
                            <option selected disabled>Pilih Jenis Anggota</option>
                            <option value="Pengurus">Pengurus</option>
                            <option value="Pendaftaran">Pendaftaran</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="maksimal_anggota">Maksimal Anggota</label>
                        <input name="maksimal_anggota" type="number" class="form-control form-control-lg"
                               placeholder="Maksimal Anggota" required>
                    </div>
                </div>
            </div>
             `);
            $("#tambah-detail").hide();
            $("#hapus-detail").show();
            $("#detail-anggota").show();
        }

        function hapusDetail() {
            i--;
            for (i ; i >= 0; i--){
                $(`#anggota-${i}`).remove();
            }
            $(`#anggota-c`).remove();
            $("#detail-anggota").hide();
            $("#hapus-detail-anggota").hide();
            $("#tambah-detail").show();
            $("#hapus-detail").hide();
        }

        function generateAnggota() {
            $('.detail-anggota').append(`<div id="anggota-${i}" class="col-4" >
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_anggota[]" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan[]" class="form-control" required>
        </div></div>`);
            i++;
            $("#hapus-detail-anggota").show();
        }

        function hapusAnggota() {
            i--;
            $(`#anggota-${i}`).remove();
            if (i == 0) {
                $("#hapus-detail-anggota").hide();
            }
        }

        function showIuran(){
            $('.iuran').append(`
            <div id="iuran-c" class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="iuran">Jenis Iuran</label>
                        <select class="form-control"  id="iuran" name="status" required>
                            <option selected disabled>Pilih Jenis Iuran</option>
                            <option value="Wajib">Wajib</option>
                            <option value="Tidak Wajib">Tidak Wajib</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="nominal">Nominal Iuran</label>
                        <input name="nominal" type="number" class="form-control form-control-lg"
                               placeholder="Nominal" required>
                    </div>
                </div>
            </div>
             `);
            $("#tambah-iuran").hide();
            $("#hapus-iuran").show();
        }

        function hapusIuran() {
            $(`#iuran-c`).remove();
            $("#tambah-iuran").show();
            $("#hapus-iuran").hide();
        }

        $(function() {
            $('#datatableKegiatan').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/kegiatan/datatable',
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
                        data: 'tgl_mulai',
                        name: 'tgl_mulai'
                    },
                    {
                        data: 'tgl_selesai',
                        name: 'tgl_selesai'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
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
