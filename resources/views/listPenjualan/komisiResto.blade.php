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
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-left">Laporan komisi penjualan majoo <?= date('d M Y', strtotime($tgl1)) ?> - <?= date('d M Y', strtotime($tgl2)) ?></h4>

                            <button data-toggle="modal" data-target="#modal-view" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-eye majoo"></i> View</button>
                            <!-- <button data-toggle="modal" data-target="#modal-summary" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-print majoo"></i> Summary</button>
				            <button data-toggle="modal" data-target="#modal-excel" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-file-excel majoo"></i> Excel</button> -->
                            <a href="<?= route('excel_komisi_penjualan') ?>?tgl1=<?= $tgl1 ?>&tgl2=<?= $tgl2 ?>" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-file-excel majoo"></i> Excel</a>
                            <button data-toggle="modal" data-target="#rules" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-cog majoo"></i> Setting</button>
                            <br><br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link " id="all-tab" href="<?= route('komisiPenjualan', ['tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="all" aria-selected="true">All</a>
                                </li>
                                <?php if ($lokasi == 'TAKEMORI') : ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tkmr-tab" href="<?= route('resto', ['lokasi' => 'TAKEMORI', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="tkmr" aria-selected="false">Takemori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sdb-tab" href="<?= route('resto', ['lokasi' => 'SOONDOBU', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="sdb" aria-selected="false">Soondobu</a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tkmr-tab" href="<?= route('resto', ['lokasi' => 'TAKEMORI', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="tkmr" aria-selected="false">Takemori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="sdb-tab" href="<?= route('resto', ['lokasi' => 'SOONDOBU', 'tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="sdb" aria-selected="false">Soondobu</a>
                                    </li>
                                <?php endif ?>

                                <li class="nav-item">
                                    <a class="nav-link" id="orc-tab" href="<?= route('orchard', ['tgl1' => $tgl1, 'tgl2' => $tgl2]) ?>" role="tab" aria-controls="sdb" aria-selected="false">Orchard</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Komisi Penjualan</th>
                                        <th>Komisi</th>
                                        <th>Komisi Target</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $ttl_komisi = 0;
                                    $ttl_komisi_trg = 0;
                                    $ttl_komisiPenjualan = 0;
                                    foreach ($komisi as $k) :
                                        if ($k->nm_karyawan == 'SDB' || $k->nm_karyawan == 'TKMR') {
                                            continue;
                                        }
                                        if ($rules_active) {
                                            if ($rules_active->jenis == 'komisi') {
                                                if ($k->dt_komisi >= $rules_active->jumlah) {
                                                    $trg_komisi = $k->dt_komisi * $rules_active->persen;
                                                } else {
                                                    $trg_komisi = $k->dt_komisi;
                                                }
                                            } else if ($rules_active->jenis == 'pendapatan') {
                                                if ($total_penjualan->ttl_penjualan >= $rules_active->jumlah) {
                                                    $trg_komisi = $k->dt_komisi * $rules_active->persen;
                                                } else {
                                                    $trg_komisi = $k->dt_komisi;
                                                }
                                            } else {
                                                $trg_komisi = $k->dt_komisi;
                                            }
                                        } else {
                                            $trg_komisi = $k->dt_komisi;
                                        }

                                        $ttl_komisi_trg += $trg_komisi;
                                        $ttl_komisi += $k->dt_komisi;
                                        $ttl_komisiPenjualan += $k->komisi_penjualan;

                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>

                                            <td><?= $k->nm_karyawan ?></td>
                                            <td><?= number_format($k->komisi_penjualan,0) ?></td>
                                            <td><?= number_format($k->dt_komisi, 0) ?></td>
                                            <td><?= number_format($trg_komisi, 0) ?></td>

                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">TOTAL</th>
                                        <th><?= number_format($ttl_komisiPenjualan, 0); ?></th>
                                        <th><?= number_format($ttl_komisi, 0); ?></th>
                                        <th><?= number_format($ttl_komisi_trg, 0); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Beban Resto</th>
                                        <th><?= number_format($komisi_resto->beban_penjualan, 0); ?></th>
                                        <th><?= number_format($komisi_resto->beban_komisi, 0); ?></th>
                                        <?php
                                        if($ttl_komisi == 0) {
                                                $persen_resto = 0;
                                            } else {
                                                $persen_resto = $komisi_resto->beban_komisi ? ($komisi_resto->beban_komisi * 100) / $ttl_komisi : 0;
                                            }
                                        $beban_target_resto = $ttl_komisi_trg ? ($ttl_komisi_trg * $persen_resto) / 100 : 0;
                                        ?>
                                        <th><?= number_format($beban_target_resto, 0); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Beban Orchard</th>
                                        @if ($komisi_orchard)
                                        <th><?= number_format($komisi_orchard->beban_komisi, 0); ?></th>
                                        <?php if ($komisi_orchard->beban_komisi > 0) {
                                            if($ttl_komisi == 0) {
                                                $persen_orchard = 0;
                                            } else {
                                                $persen_orchard = ($komisi_orchard->beban_komisi * 100) / $ttl_komisi;
                                            }
                                                $beban_target_orchard = ($ttl_komisi_trg * $persen_orchard) / 100;
                                            } else {
                                                $beban_target_orchard = 0;
                                            } ?>
                                        <th><?= number_format($beban_target_orchard, 0); ?></th>
                                        <th><?= number_format($beban_target_orchard, 0); ?></th>
                                        @else
                                        <th><?= number_format(0, 0); ?></th>
                                        <th><?= number_format(0, 0); ?></th>
                                        <th><?= number_format(0, 0); ?></th>
                                        @endif
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

<form action="<?= route('edit_rules_komisi') ?>" method="POST">
    @csrf
    <div class="modal fade" id="rules">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-costume">
                    <h4 class="modal-title text-light">Setting Target Komisi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tgl1" value="<?= $tgl1 ?>">
                    <input type="hidden" name="tgl2" value="<?= $tgl2 ?>">

                    <?php
                    $pendapatan = 0;
                    $komisi = 0;
                    foreach ($dt_rules as $d) {
                        if ($d->status == 1) {
                            if ($d->jenis == 'komisi') {
                                $komisi++;
                            } else {
                                $pendapatan++;
                            }
                        }
                    } ?>

                    <div class="row justify-content-center">
                        <div class="col-5 form-group">
                            <div class="form-check">
                                <!-- <input class="form-check-input" type="radio" name="rules[]" value="" checked> -->
                                <input class="form-check-input pilih_rules" type="radio" name="rules" value="komisi" lawan="pendapatan" <?= $komisi >= 1 ? 'checked' : '' ?>>
                                <label class="form-check-label"><strong>Komisi</strong></label>
                            </div>
                        </div>
                        <div class="col-5 form-group">
                            <div class="form-check">
                                <!-- <input class="form-check-input" type="radio" name="rules[]" value="" checked> -->
                                <input class="form-check-input pilih_rules" type="radio" name="rules" value="pendapatan" lawan="komisi" <?= $pendapatan >= 1 ? 'checked' : '' ?>>
                                <label class="form-check-label"><strong>Pendapatan</strong></label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        <div class="col-5">
                            <?php foreach ($dt_rules as $d) :
                                if ($d->jenis != 'komisi') {
                                    continue;
                                }
                            ?>
                                <div class="form-check">
                                    <!-- <input class="form-check-input" type="radio" name="permission[]" value="" checked> -->
                                    <input class="form-check-input komisi" type="radio" name="komisi" value="<?= $d->id_rules ?>" <?= $d->status == 1 ? 'checked required' : '' ?>>
                                    <label class="form-check-label"><strong><?= number_format($d->jumlah, 0) ?> = koimisi x <?= $d->persen ?></strong></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-5">
                            <?php foreach ($dt_rules as $d) :
                                if ($d->jenis != 'pendapatan') {
                                    continue;
                                }
                            ?>
                                <div class="form-check">
                                    <!-- <input class="form-check-input" type="radio" name="permission[]" value="" checked> -->
                                    <input class="form-check-input pendapatan" type="radio" name="komisi" value="<?= $d->id_rules ?>" <?= $d->status == 1 ? 'checked required' : '' ?>>
                                    <label class="form-check-label"><strong><?= number_format($d->jumlah, 0) ?> = komisi x <?= $d->persen ?></strong></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <button class="btn btn-sm btn-primary mt-2 float-right" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-chevron-down text-light"></i>
                    </button>
                    <br><br>

                    <div class="mt-2 collapse" id="collapseExample">
                        <div class="card">
                            <div class="card-header">
                                <strong>Edit</strong>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Jenis</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Nominal</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Perkalian</label>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($dt_rules as $d) : ?>
                                    <div class="row">
                                        <input type="hidden" name="id_rules[]" value="<?= $d->id_rules ?>">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control" name="jenis[]">
                                                    <option value="komisi" <?= $d->jenis == 'komisi' ? 'selected' : '' ?>>Komisi</option>
                                                    <option value="pendapatan" <?= $d->jenis == 'pendapatan' ? 'selected' : '' ?>>Pendapatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="jumlah[]" value="<?= $d->jumlah ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">x</div>
                                                </div>
                                                <input type="number" class="form-control" name="persen[]" value="<?= $d->persen ?>" required>

                                            </div>
                                        </div>

                                        <div class="col-1">
                                            <?php if ($d->status != 1) : ?>
                                                <a href="<?= route('drop_rules', ['id_rules' => $d->id_rules, 'tgl1' => $tgl1, 'tgl2' => $tgl2])?>" onclick="return confirm('Apakah anda yakin');" class="btn btn-xs btn-danger"><i class="fas fa-trash text-light"></i></a>
                                            <?php else : ?>
                                                <button class="btn btn-xs btn-success" type="button" aria-readonly=""><i class="fas fa-check-circle text-light"></i></button>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah</strong>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Jenis</label>
                                            <select class="form-control" name="jenis_tambah">
                                                <option value="">- Pilih jenis -</option>
                                                <option value="komisi">Komisi</option>
                                                <option value="pendapatan">Pendapatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Nominal</label>
                                            <input type="number" class="form-control" name="jumlah_tambah">
                                        </div>
                                    </div>
                                    <div class="col-4">

                                        <div class="form-group">
                                            <label for="">Perkalian</label>
                                            <div class="input-group">

                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">x</div>
                                                </div>
                                                <input type="number" class="form-control" name="persen_tambah">

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
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
                <input type="hidden" name="lokasi" value="{{ $lokasi }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" name="tgl1" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" name="tgl2" class="form-control">
                        </div>
                      
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-costume">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="<?= route('summary_komisi_penjualan') ?>" method="GET">
    <div class="modal fade" id="modal-summary">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-costume">
                    <h4 class="modal-title majoo">Export Summary</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" name="tgl1" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" name="tgl2" class="form-control">
                        </div>
                      
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-costume majoo">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<form action="<?= route('excel_komisi_penjualan') ?>" method="GET">
    <div class="modal fade" id="modal-excel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-costume">
                    <h4 class="modal-title majoo">Export Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" name="tgl1" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" name="tgl2" class="form-control">
                        </div>
                      
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-costume majoo">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@section('script')
<script>
    $(document).ready(function () {
        function cek_rules() {
            var komisi = <?= $komisi ?>;
            var pendapatan = <?= $pendapatan ?>;
            if (komisi >= 1) {
                $('.pendapatan').attr('disabled', 'true');
            } else if (pendapatan >= 1) {
                $('.komisi').attr('disabled', 'true');
            }
        }

        cek_rules();

        $(document).on('click', '.pilih_rules', function(){
            var jenis = $(this).val();
            var lawan = $(this).attr('lawan');

            $('.' + lawan).attr('disabled', 'true');
            $('.' + jenis).removeAttr('disabled', 'true');
        })
    });
</script>
@endsection