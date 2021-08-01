@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    RT
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
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Kelurahan</th>
                                        <th>Kecamatan</th>
                                        <th>Kab/Kota</th>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(function (){
            var table = $('.data-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: "{{ route('admin.rt') }}",
                columns: [
                    { "data": null,"sortable": false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'rt', name: 'rt'},
                    {data: 'rw', name: 'rw'},
                    {data: 'kelurahan', name: 'kelurahan'},
                    {data: 'kecamatan', name: 'kecamatan'},
                    {data: 'kab_kota', name: 'kab_kota'},
                    {data: 'provinsi', name: 'provinsi'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
