@extends('main.administrator')

@section('judul')
    <div class="container-fluid text-white">
        <div class="row p-t-b-10 ">
            <div class="col">
                <h4>
                    Edit Administrator
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
                    <form method="POST" action="/admin/edit/{{$data['id']}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputNama" class="col-form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="{{$data['nama']}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail" class="col-form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" value="{{$data['email']}}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputNo_Hp" class="col-form-label">Nomor Handphone</label>
                                <input type="number" class="form-control" name="no_hp" id="inputNo_Hp" placeholder="Nomor Handphone" value="{{$data['no_hp']}}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.content -->
    </div>
@endsection
