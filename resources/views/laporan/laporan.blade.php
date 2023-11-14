@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-sm btn-costume float-right ml-2" data-toggle="modal"
                                    data-target="#view"><i class="fas fa-eye text-light"></i> View</button>
                                <button type="button" class="btn btn-sm btn-costume float-right ml-2" data-toggle="modal"
                                    data-target="#excel"><i class="fas fa-file-excel text-light"></i> Excel</button>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    {{-- <li class="nav-item">
                                        <a class="nav-link {{ $jenis == '' ? 'active' : '' }}" id="all-tab"
                                            href="<?= route('laporan') ?>" role="tab" aria-controls="all"
                                            aria-selected="true">All</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link {{ $jenis == 'tkm' ? 'active' : '' }}" id="tkmr-tab"
                                            href="<?= route('laporan', ['jenis' => 'tkm', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>"
                                            role="tab" aria-controls="tkmr" aria-selected="false">Takemori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $jenis == 'sdb' ? 'active' : '' }}" id="sdb-tab"
                                            href="<?= route('laporan', ['jenis' => 'sdb', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>"
                                            role="tab" aria-controls="sdb" aria-selected="false">Soondobu</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $jenis == '6' ? 'active' : '' }}" id="6-tab"
                                            href="<?= route('laporan', ['jenis' => '6', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>"
                                            role="tab" aria-controls="sdb" aria-selected="false">Orchard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $jenis == '11' ? 'active' : '' }}" id="11-tab"
                                            href="<?= route('laporan', ['jenis' => '11', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>"
                                            role="tab" aria-controls="sdb" aria-selected="false">Upperclass Birdnest</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="card-body">


                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="all" role="tabpanel"
                                        aria-labelledby="all-tab">

                                        @if ($jenis == '6' || $jenis == '11')
                                            <h5><strong>Laporan {{ $jenis == '6' ? 'Orchad' : 'Upperclass Birdnest' }}
                                                    <?= $tgl1 ?> - <?= $tgl2 ?></strong> (Dijual di
                                                Takemori)</h5>
                                            <table class="table table">
                                                <thead>
                                                    <tr>
                                                        <th>KATEGORI</th>
                                                        <th>NAMA PRODUK</th>
                                                        <th>Harga Satuan</th>
                                                        <th>QTY</th>
                                                        <th>Satuan</th>
                                                        <th>TOTAL TAKEMORI</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                        $ttl_tkmr = 0;
                                                        foreach ($takemori as $k): 
                                                            $ttl_tkmr += $k->total;
                                                            ?>
                                                    <tr>
                                                        <td><?= $k->nm_kategori ?></td>
                                                        <td><?= $k->nm_produk ?></td>
                                                        <td><?= number_format($k->rt_harga, 0) ?></td>
                                                        <td><?= number_format($k->jlh, 0) ?></td>
                                                        <td><?= $k->satuan ?></td>
                                                        <td><?= number_format($k->total, 0) ?></td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5">TOTAL</th>
                                                        <th><?= number_format($ttl_tkmr, 0) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <h5><strong>Laporan {{ $jenis == '6' ? 'Orchad' : 'Upperclass Birdnest' }}
                                                    <?= $tgl1 ?> - <?= $tgl2 ?></strong> (Dijual di
                                                Soondobu)</h5>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>KATEGORI</th>
                                                        <th>NAMA PRODUK</th>
                                                        <th>Harga Satuan</th>
                                                        <th>QTY</th>
                                                        <th>Satuan</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                        $ttl_sdb = 0;
                                                        foreach ($soondobu as $k): 
                                                            $ttl_sdb += $k->total;
                                                            ?>
                                                    <tr>
                                                        <td><?= $k->nm_kategori ?></td>
                                                        <td><?= $k->nm_produk ?></td>
                                                        <td><?= number_format($k->rt_harga, 0) ?></td>
                                                        <td><?= number_format($k->jlh, 0) ?> </td>
                                                        <td><?= $k->satuan ?></td>
                                                        <td><?= number_format($k->total, 0) ?></td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5">TOTAL TAKEMORI & SOONDOBU</th>
                                                        <th><?= number_format($ttl_tkmr + $ttl_sdb, 0) ?></th>
                                                    </tr>
                                                </tfoot>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5">TOTAL SOONDOBU</th>
                                                        <th><?= number_format($ttl_sdb, 0) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        @else
                                            <h5><strong>Laporan penjualan Takemori, Soondobu, Orchard <?= $tgl1 ?> -
                                                    <?= $tgl2 ?></strong></h5>
                                            <input type="text" class="form-control" placeholder="pencarian.."
                                                id="pencarian">
                                            <table class="table" id="tblALdi">
                                                <thead>
                                                    <tr>
                                                        <th>KATEGORI</th>
                                                        <th>NAMA PRODUK</th>
                                                        <th>Harga Satuan</th>
                                                        <th>QTY</th>
                                                        <th>Satuan</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                                $ttl = 0;
                                                                $ttl_orchard = 0;
                                                                foreach ($all as $k): 
                                                                $ttl += $k->total;
                                                                $ttl_orchard += $k->nm_kategori == 'Orchard' ? $k->total : 0;
                                                            ?>
                                                    <tr>
                                                        <td><?= $k->nm_kategori ?></td>
                                                        <td><?= $k->nm_produk ?></td>
                                                        <td><?= number_format($k->rt_harga, 0) ?></td>
                                                        <td><?= number_format($k->jlh, 0) ?> </td>
                                                        <td><?= $k->satuan ?></td>
                                                        <td><?= number_format($k->total, 0) ?></td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5">TOTAL TS</th>
                                                        <th><?= number_format($ttl - $ttl_orchard, 0) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="5">TOTAL Orchard</th>
                                                        <th><?= number_format($ttl_orchard, 0) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="5">TOTAL</th>
                                                        <th><?= number_format($ttl, 0) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        @endif


                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <style>
        .modal-lg-max {
            max-width: 600px;
        }
    </style>
    <!-- /.content-wrapper -->

    <form action="" method="GET">
        <div class="modal fade" id="view">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header btn-costume">
                        <h4 class="modal-title text-light">View Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input class="form-control" type="date" value="" name="tgl1">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input class="form-control" type="date" value="" name="tgl2">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-costume">View</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>

    <form action="<?= route('laporanExcel') ?>" method="POST">
        @csrf
        <div class="modal fade" id="excel">
            <div class="modal-dialog modal-lg-max">
                <div class="modal-content">
                    <div class="modal-header btn-costume">
                        <h4 class="modal-title text-light">Export Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Dari</label>
                                    <input required class="form-control" type="date" value="" name="tgl1">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Sampai</label>
                                    <input required class="form-control" type="date" value="" name="tgl2">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <select name="lokasi" class="form-control select" disabled>
                                        <option {{ $jenis == '' }} value="1" selected>All</option>
                                        <option {{ $jenis == 'tkm' ? 'selected' : '' }} value="2">Takemori</option>
                                        <option {{ $jenis == 'sdb' ? 'selected' : '' }} value="3">Soondobu</option>
                                        <option {{ $jenis == 'orc' ? 'selected' : '' }} value="4">Orchard</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-costume">Export</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
    @section('script')
        <script>
            pencarian('pencarian', 'tblALdi')
    
            function pencarian(inputId, tblId) {
                $(document).on('keyup', "#" + inputId, function() {
                    var value = $(this).val().toLowerCase();
                    $(`#${tblId} tbody tr`).filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                })
            }
        </script>
    @endsection
@endsection
