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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">Komisi Penjualan (<?= date('d-m-Y', strtotime($tgl1)) ?> - <?= date('d-m-Y', strtotime($tgl2)) ?>)</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Komisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                     $ttl_komisi = 0;
                                    foreach ($komisi as $k) : 
                                        $ttl_komisi += $k->dt_komisi;
                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            
                                            <td><?= $k->nm_karyawan ?></td>
                                            <td><?= number_format($k->dt_komisi, 0) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="btn-costume">	
                                    <tr>	
                                        <th colspan="2" class="text-light">TOTAL</th>
                                        <th class="text-light"><?= number_format($ttl_komisi, 0); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
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






@endsection