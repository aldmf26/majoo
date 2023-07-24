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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Daftar Void Penjualan</h3>
                            <br><br>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table " width="100%" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NO NOTA</th>
                                                    <th>TOTAL</th>
                                                    <th>BAYAR</th>
                                                    <th>TANGGAL</th>
                                                    <th>Void</th>
                                                    <th>Ket Void</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach ($invoice as $a)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td><a href="{{ route('detail_invoice', ['invoice' => $a->no_nota]) }}">{{$a->no_nota}}</a></td>
                                                    <td>{{ number_format($a->total,0)}}</td>
                                                    <td>{{ number_format($a->bayar,0)}}</td>
                                                    <td>{{ date('d/m/Y', strtotime($a->tgl_jam))}}</td>
                                                    <td>{{ $a->nm_void}}</td>
                                                    <td>{{ $a->ket_void}}</td>


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

{{-- tambah --}}
<form action="" method="GET">
    <div class="modal fade" id="modal-view">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-costume">
                    <h4 class="modal-title text-light">View Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Dari</label>
                                <input class="form-control" type="date" value="" id="tgl1" name="tgl1">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Sampai</label>
                                <input class="form-control" type="date" value="" id="tgl2" name="tgl2">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-costume">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php foreach ($invoice as $a) : ?>
<form action="{{route('void_penjualan')}}" method="post">
    @csrf
    <div class="modal fade" id="modalvoid<?= $a->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Void</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="no_nota" value="<?= $a->no_nota ?>">
                    <input class="form-control" type="text" name="ket_void" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Void</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php endforeach; ?>

{{-- --------------------- --}}



@endsection
@section('script')

@endsection