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
                            <h3 class="float-left">Daftar Invoice Penjualan</h3>
                            <button data-toggle="modal" data-target="#modal-view"
                                class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-eye majoo"></i>
                                View</button>
                            <button data-toggle="modal" data-target="#modal-summary"
                                class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-print majoo"></i>
                                Summary</button><br><br>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table " width="100%" id="table">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">#</th>
                                                    <th rowspan="2">NO NOTA</th>
                                                    <th rowspan="2">LOKASI</th>
                                                    <th rowspan="2">JAM</th>
                                                    
                                                    <th colspan="2" class="text-center">MANDIRI</th>
                                                    <th colspan="2" class="text-center">BCA</th>
                                                    <th rowspan="2">CASH</th>
                                                    <th rowspan="2">TOTAL</th>
                                                    <th rowspan="2">BAYAR</th>
                                                    <th rowspan="2">TANGGAL</th>
                                                    <th rowspan="2">AKSES </th>
                                                </tr>
                                                <tr>
                                                    <th>KREDIT</th>
                                                    <th>DEBIT</th>
                                                    <th>KREDIT</th>
                                                    <th>DEBIT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach ($invoice as $a)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td><a href="{{ route('detail_invoice', ['invoice' => $a->no_nota]) }}">{{$a->no_nota}}</a></td>
                                                    <td>{{$a->lokasi}}</td>
                                                    <td>{{date('H:i', strtotime($a->tgl_input))}}</td>
                                                    <td>{{ number_format($a->mandiri_kredit,0)}}</td>
                                                    <td>{{ number_format($a->mandiri_debit,0)}}</td>
                                                    <td>{{ number_format($a->bca_kredit,0)}}</td>
                                                    <td>{{ number_format($a->bca_debit,0)}}</td>
                                                    <td>{{ number_format($a->cash,0)}}</td>
                                                    <td>{{ number_format($a->total,0)}}</td>
                                                    <td>{{ number_format($a->bayar,0)}}</td>
                                                    <td>{{ date('d/m/Y', strtotime($a->tgl_jam))}}</td>

                                                    <td>
                                                        <?php if(Session::get('role_id') == '3'): ?>
                                                        <?php else: ?>
                                                        <button type="button" class="btn btn-costume btn-sm void"
                                                            data-toggle="modal" data-target="#modalvoid<?= $a->id ?>">
                                                            <i class="fas fa-exclamation text-light"></i> Void
                                                        </button>
                                                        <?php endif ?>
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

<form action="{{ route('invoiceSummary') }}" method="GET">
    <div class="modal fade" id="modal-summary">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-costume">
                    <h4 class="modal-title text-light">Export Summary</h4>
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