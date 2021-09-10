@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Admin Rukun Tetangga (RT)
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
        <div class="modal-dialog width-900" role="document">
            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"
                                                class="paper-nav-toggle active"><i></i></a>
                <div
                    class="modal-body no-p">
                    <div class="text-center p-40 p-b-0">
                        <h4>Tambah Data</h4>
                    </div>
                    <div class="light p-10 b-t-b">
                        <form action="adminrt/create" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="provinsi">Nama Provinsi</label>
                                        <select class="form-control" id="provinsi" name="id_provinsi" required>
                                            <option selected disabled>Pilih Provinsi</option>
                                            @foreach($provinsi as $id => $nama)
                                                <option value="{{$id}}">{{$nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="kabkota">Nama Kab/Kota</label>
                                        <select class="form-control" id="kabkota" name="id_kabkota" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="kecamatan">Nama Kecamatan</label>
                                        <select class="form-control" id="kecamatan" name="id_kecamatan" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="kelurahan">Nama Kelurahan</label>
                                        <select class="form-control" id="kelurahan" name="id_kelurahan" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="rw">Nama RW</label>
                                        <select class="form-control" id="rw" name="id_rw" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="rt">Nama RT</label>
                                        <select class="form-control" id="rt" name="id_rt" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input name="nama" type="text" class="form-control form-control-lg"
                                               placeholder="Nama" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" type="email" class="form-control form-control-lg"
                                               placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input name="password" type="password" class="form-control form-control-lg"
                                               placeholder="Password" required>
                                        <input hidden name="role" type="text" class="form-control form-control-lg"
                                               value="RT" required>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-fab-md btn-block" value="Tambah">
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
                            <table id="datatableAdminRt" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>RT</th>
                                    <th>Nama</th>
                                    <th>Email</th>
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

@endsection

@section('script')
    <script>
        $(function() {
            $('#datatableAdminRt').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: 'adminrt/datatable',
                columns: [{
                    "data": null,
                    'sortable': false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'detail_rt.nama',
                        name: 'rt'
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

        $('#kelurahan').change(function(){
            var kelurahanID = $(this).val();
            if(kelurahanID){
                $.ajax({
                    type:"GET",
                    url:"rt/getRw?id_kelurahan="+kelurahanID,
                    success:function(res){
                        if(res){
                            $("#rw").empty();
                            $("#rw").append('<option selected disabled>Pilih RW</option>');
                            $.each(res,function(key,value){
                                $("#rw").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#rw").empty();
                        }
                    }
                });
            }else{
                $("#rw").empty();
            }
        });

        $('#rw').change(function(){
            var rwID = $(this).val();
            if(rwID){
                $.ajax({
                    type:"GET",
                    url:"adminrt/getRt?id_rw="+rwID,
                    success:function(res){
                        if(res){
                            $("#rt").empty();
                            $("#rt").append('<option selected disabled>Pilih RT</option>');
                            $.each(res,function(key,value){
                                $("#rt").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#rt").empty();
                        }
                    }
                });
            }else{
                $("#rt").empty();
            }
        });
    </script>
@endsection
