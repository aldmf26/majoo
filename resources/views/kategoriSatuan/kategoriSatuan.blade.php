@extends('template.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Daftar Kategori</h3>
                            <a href="#" class="btn btn-costume btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Kategori</a>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table" id="table"> 
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Kategori</td>
                                                    <td>Akses</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($kategori as $k)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $k->nm_kategori }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-costume" data-target="#edit{{$k->id_kategori}}" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                            <a onclick="return confirm('Apkaha anda yakin ?')" href="{{ route('hapusKategori', ['id_kategori' => $k->id_kategori]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Daftar Satuan</h3>
                            <a href="#" class="btn btn-costume btn-sm float-right" data-toggle="modal" data-target="#tambahSatuan"><i class="fa fa-plus"></i> Satuan</a>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table" id="table1"> 
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Satuan</td>
                                                    <td>Akses</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($satuan as $k)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $k->satuan }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-costume" data-target="#editSatuan{{$k->id_satuan}}" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                            <a onclick="return confirm('Apkaha anda yakin ?')" href="{{ route('hapusSatuan', ['id_satuan' => $k->id_satuan]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>


{{-- tambah kategori --}}
<form action="{{ route('tambahKategori') }}" method="post">
    @csrf
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Tambah Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <div class="row form-group ">
                        <label for="">Kategori</label>
                        <input type="text" class="form-control" name="nm_kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</form>

{{-- edit kategori --}}
@foreach ($kategori as $k)
<form action="{{ route('editKategori') }}" method="post">
    @csrf
    <div class="modal fade" id="edit{{$k->id_kategori}}">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Edit Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="id_kategori" value="{{ $k->id_kategori }}">
                <div class="modal-body">
                    <div class="row form-group ">
                        <label for="">Kategori</label>
                        <input type="text" class="form-control" name="nm_kategori" value="{{ $k->nm_kategori }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</form> 
@endforeach
{{-- --------------------- --}}

{{-- tambah satuan --}}
<form action="{{ route('tambahSatuan') }}" method="post">
    @csrf
    <div class="modal fade" id="tambahSatuan">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Tambah Satuan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <div class="row form-group ">
                        <label for="">Satuan</label>
                        <input type="text" class="form-control" name="satuan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</form>

{{-- edit satuan --}}
@foreach ($satuan as $k)
<form action="{{ route('editSatuan') }}" method="post">
    @csrf
    <div class="modal fade" id="editSatuan{{$k->id_satuan}}">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Edit Satuan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="id_satuan" value="{{ $k->id_satuan }}">
                <div class="modal-body">
                    <div class="row form-group ">
                        <label for="">Satuan</label>
                        <input type="text" class="form-control" name="satuan" value="{{ $k->satuan }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</form> 
@endforeach
{{-- --------------------- --}}



@endsection
@section('script')
@if (Session::get('sukses'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        icon: 'success',
        title: "{{Session::get('sukses')}}"
    });
</script>  
@endif
@if (Session::get('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        icon: 'error',
        title: "{{Session::get('error')}}"
    });
</script>  
@endif
@endsection
