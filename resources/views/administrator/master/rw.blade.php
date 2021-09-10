@extends('main.administrator')

@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
@endsection

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Rukun Warga (RW)
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
                        <form action="rw/create" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="provinsi">Nama Provinsi</label>
                                <select class="form-control" id="provinsi" name="id_provinsi" required>
                                    <option selected disabled>Pilih Provinsi</option>
                                    @foreach($provinsi as $id => $nama)
                                        <option value="{{$id}}">{{$nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kabkota">Nama Kab/Kota</label>
                                <select class="form-control" id="kabkota" name="id_kabkota" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Nama Kecamatan</label>
                                <select class="form-control" id="kecamatan" name="id_kecamatan" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kelurahan">Nama Kelurahan</label>
                                <select class="form-control" id="kelurahan" name="id_kelurahan" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama RW</label>
                                <input id="nama" name="nama" type="text" class="form-control form-control-lg"
                                       placeholder="Nama RW" required>
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
                            <table id="datatableRW" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Provinsi</th>
                                    <th>Kab/Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>RW</th>
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
                            <a href="rw/delete/{{$d->id}}" class="btn btn-primary btn-fab-md" style="width: 80px">Ya</a>
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
                            <form action="rw/update/{{$d->id}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="provinsi">Nama Provinsi</label>
                                    <select class="form-control" id="provinsi{{$d->id}}" name="id_provinsi" required>
                                        <option selected disabled>Pilih Provinsi</option>
                                        @foreach($provinsi as $id => $nama)
                                            <option value="{{$id}}">{{$nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kabkota">Nama Kab/Kota</label>
                                    <select class="form-control" id="kabkota{{$d->id}}" name="id_kabkota" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan">Nama Kecamatan</label>
                                    <select class="form-control" id="kecamatan{{$d->id}}" name="id_kecamatan" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kelurahan">Nama Kelurahan</label>
                                    <select class="form-control" id="kelurahan{{$d->id}}" name="id_kelurahan" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama RW</label>
                                    <input id="nama" name="nama" type="text" class="form-control form-control-lg"
                                           placeholder="Nama Kelurahan" value="{{$d->nama}}" required>
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
    <script type=text/javascript>
        $(function() {
            $('#datatableRW').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: 'rw/datatable',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'detail_kelurahan.detail_kecamatan.detail_kab_kota.detail_provinsi.nama',
                        name: 'provinsi'
                    },
                    {
                        data: 'detail_kelurahan.detail_kecamatan.detail_kab_kota.nama',
                        name: 'kabkota'
                    },
                    {
                        data: 'detail_kelurahan.detail_kecamatan.nama',
                        name: 'kecamatan'
                    },
                    {
                        data: 'detail_kelurahan.nama',
                        name: 'kelurahan'
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

        $('#provinsi').change(function(){
            var provinsiId = $(this).val();
            if(provinsiId){
                $.ajax({
                    type:"GET",
                    url:"kecamatan/getKota?id_provinsi="+provinsiId,
                    success:function(res){
                        if(res){
                            $("#kabkota").empty();
                            $("#kabkota").append('<option selected disabled>Pilih Kab/Kota</option>');
                            $.each(res,function(key,value){
                                $("#kabkota").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kabkota").empty();
                        }
                    }
                });
            }else{
                $("#kabkota").empty();
            }
        });

        $('#kabkota').change(function(){
            var kabkotaID = $(this).val();
            if(kabkotaID){
                $.ajax({
                    type:"GET",
                    url:"kelurahan/getKecamatan?id_kabkota="+kabkotaID,
                    success:function(res){
                        if(res){
                            $("#kecamatan").empty();
                            $("#kecamatan").append('<option selected disabled>Pilih Kecamatan</option>');
                            $.each(res,function(key,value){
                                $("#kecamatan").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kecamatan").empty();
                        }
                    }
                });
            }else{
                $("#kecamatan").empty();
            }
        });

        $('#kecamatan').change(function(){
            var kecamatanID = $(this).val();
            if(kecamatanID){
                $.ajax({
                    type:"GET",
                    url:"rw/getKelurahan?id_kecamatan="+kecamatanID,
                    success:function(res){
                        if(res){
                            $("#kelurahan").empty();
                            $("#kelurahan").append('<option selected disabled>Pilih Kelurahan</option>');
                            $.each(res,function(key,value){
                                $("#kelurahan").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kelurahan").empty();
                        }
                    }
                });
            }else{
                $("#kelurahan").empty();
            }
        });

        @foreach($data as $d)
        $('#provinsi{{$d->id}}').change(function(){
            var provinsiId = $(this).val();
            if(provinsiId){
                $.ajax({
                    type:"GET",
                    url:"kecamatan/getKota?id_provinsi="+provinsiId,
                    success:function(res){
                        if(res){
                            $("#kabkota{{$d->id}}").empty();
                            $("#kabkota{{$d->id}}").append('<option selected disabled>Pilih Kab/Kota</option>');
                            $.each(res,function(key,value){
                                $("#kabkota{{$d->id}}").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kabkota{{$d->id}}").empty();
                        }
                    }
                });
            }else{
                $("#kabkota{{$d->id}}").empty();
            }
        });

        $('#kabkota{{$d->id}}').change(function(){
            var kabkotaID = $(this).val();
            if(kabkotaID){
                $.ajax({
                    type:"GET",
                    url:"kelurahan/getKecamatan?id_kabkota="+kabkotaID,
                    success:function(res){
                        if(res){
                            $("#kecamatan{{$d->id}}").empty();
                            $("#kecamatan{{$d->id}}").append('<option selected disabled>Pilih Kecamatan</option>');
                            $.each(res,function(key,value){
                                $("#kecamatan{{$d->id}}").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kecamatan{{$d->id}}").empty();
                        }
                    }
                });
            }else{
                $("#kecamatan{{$d->id}}").empty();
            }
        });

        $('#kecamatan{{$d->id}}').change(function(){
            var kecamatanID = $(this).val();
            if(kecamatanID){
                $.ajax({
                    type:"GET",
                    url:"rw/getKelurahan?id_kecamatan="+kecamatanID,
                    success:function(res){
                        if(res){
                            $("#kelurahan{{$d->id}}").empty();
                            $("#kelurahan{{$d->id}}").append('<option selected disabled>Pilih Kecamatan</option>');
                            $.each(res,function(key,value){
                                $("#kelurahan{{$d->id}}").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#kelurahan{{$d->id}}").empty();
                        }
                    }
                });
            }else{
                $("#kelurahan{{$d->id}}").empty();
            }
        });
        @endforeach
    </script>
@endsection
