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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Data Karyawan</h3>
                            <a href="#" class="btn btn-costume btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Waitress</a>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table" id="table"> 
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Nama</td>
                                                    <td>Posisi</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($karyawan as $k)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $k->nm_karyawan }}</td>
                                                        <td>{{ $k->posisi }}</td>
                                                        <td>
                                                            {{-- <a href="#" class="btn btn-sm btn-costume" data-target="#edit{{$k->id_kategori}}" data-toggle="modal"><i class="fa fa-edit"></i></a> --}}
                                                            <a onclick="return confirm('Apkaha anda yakin ?')" href="{{ route('hapusKaryawan', ['kd_karyawan' => $k->kd_karyawan]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
<form action="{{ route('tambahKaryawan') }}" method="post">
    @csrf
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Tambah Karyawan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <div class="row form-group">
                        <label for="">nama</label>
                        <input type="text" class="form-control" name="nm_karyawan">
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
