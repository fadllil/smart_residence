@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Warga
                </h4>
            </div>
        </div>
        <div class="row ">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary s-12" href="#">
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
                        <div class="card-body table-responsive" style="height: auto">
                            <table id="example" class="table table-bordered table-striped data-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Foto</th>
                                    <th>Jumlah Anggota <br> Keluarga</th>
                                    <th>Email</th>
                                    <th>No KK</th>
                                    <th style="width: 160px">Aksi</th>
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
    <script type="text/javascript">
        $(function (){
            var table = $('.data-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: "{{ route('admin.warga') }}",
                columns: [
                    { "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama', name: 'nama'},
                    {data: 'nik', name: 'nik'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'no_hp', name: 'no_hp'},
                    {data: 'foto', name: 'foto'},
                    {data: 'jml_anggota_keluarga', name: 'jml_anggota_keluarga'},
                    {data: 'email', name: 'email'},
                    {data: 'no_kk', name: 'no_kk'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
