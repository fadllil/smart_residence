@extends('main.rt')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Informasi
                </h4>
                <h6>
                    Detail Informasi
                </h6>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Main content -->
    <div class="content-wrapper animatedParent animateOnce">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Judul Informasi: {{$data['judul']}}</h5>
                    <p class="card-subtitle">Tanggal : {{$data['tanggal']}}</p>
                </div>
            </div>
            <br>
            @if($data['gambar'])
            <div class="card">
                <div class="card-body">
                    <img src="{{url($data['gambar'])}}" alt="">
                </div>
            </div>
                <br>
            @endif
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Isi Informasi</h6>
                                <hr>
                                <p class="card-subtitle">{{$data['isi']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Keterangan</h6>
                                <hr>
                                <p class="card-subtitle">{{$data['keterangan']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.card -->

            <!-- /.row -->
        </div>
    </div>
    <!-- /.content -->

    <div class="modal fade" id="bayar" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">

    </div>
@endsection
