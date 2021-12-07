@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Kegiatan
                </h4>
                <h6>
                    Detail Iuran > {{$data['status']}}
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

                    @if($data['status'] == 'Wajib')
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Nominal Iuran : Rp. {{number_format($data['nominal'], 2)}}</p>
                            <p class="card-title">Terakhir Pembayaran : {{$data['tgl_terakhir_pembayaran']}}</p>
                        </div>
                    </div>
                    <br>
                    @endif
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h6 class="card-title">Tabel Data Iuran {{$data['status']}}</h6>
                        </div>
                        <div class="card-body">
                            <table id="datatableDetailIuran" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Dibayar</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
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

    <div class="modal fade" id="bayar" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">

    </div>
@endsection

@section('script')
    <script>
        function status(data){
            // console.log(data);
            $('#bayar').append('<div class="modal-dialog width-400" id="bayar-id" role="document">\n' +
                '            <div class="modal-content no-r "><a href="#" data-dismiss="modal" aria-label="Close"\n' +
                '                                                class="paper-nav-toggle active"><i></i></a>\n' +
                '                <div\n' +
                '                    class="modal-body no-p">\n' +
                '                    <div class="text-center p-40 p-b-0" style="margin-bottom: 10px">\n' +
                '                        <i class="icon s-48 icon-warning3 red-text"></i>\n' +
                '                        <p class="p-t-b-20">Apakah anda yakin ingin mengubah status pembayaran?</p>\n' +
                '                        <a href="#" class="danger btn btn-danger btn-fab-md" data-dismiss="modal" aria-label="Close">Tidak</a>\n' +
                '                        <a href="/rt/kegiatan/detail-iuran/status/'+ data +'" class="btn btn-primary btn-fab-md">Ya</a>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </div>');
        }

        $('#bayar').on('hidden.bs.modal', function () {
            $('#bayar-id').remove();
        });

        $(function() {
            $('#datatableDetailIuran').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                info: true,
                ajax: '/rt/kegiatan/detail-iuran/datatable/{{$data['id_kegiatan']}}',
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
                        data: 'uang',
                        name: 'uang'
                    },
                    {
                        data: 'tgl_pembayaran',
                        name: 'tgl_pembayaran'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
