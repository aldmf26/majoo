@extends('template.master')
@section('content')
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
                    <div class="col-sm-7">
                        {{-- <?= $this->session->flashdata('message') ?> --}}
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">Rincian Product</h3>

                                <hr>

                                <form action="<?= route('checkout') ?>" method="post">
                                    @csrf
                                    <?php foreach ($nota as $n) :
                                    $not = $n->maxKode; ?>

                                    <?php endforeach ?>
                                    <?php if (empty($not)) : ?>
                                    <input type="hidden" name="nota" value="TS<?= date('ymd') ?>1">
                                    <?php else : ?>
                                    <input type="hidden" name="nota" value="TS{{ date('ymd') . $not + 1 }}">
                                    <?php endif ?>
                                    <div class="row">
                                        <?php
                                        $subtotal_produk = 0;
                                        $jumlah_produk = 0;
                                        ?>
                                        <?php foreach ($cart as $k) : ?>
                                        <input type="hidden" name="id[]" value="<?= $k->id ?>">
                                        <?php
                                        if ($k->options->type == 'barang') :
                                            $subtotal_produk += $k->price * $k->qty;
                                            $jumlah_produk += $k->qty;
                                        ?>
                                        <div class="col-md-8">
                                            <?php foreach($k->options->nm_karyawan as $key => $nm_karyawan): ?>
                                            @foreach ($nm_karyawan as $d)
                                                <span class="badge badge-secondary mr-1"><?= $d ?></span>
                                            @endforeach

                                            <?php endforeach; ?>
                                            <br><br>
                                            <img width="80" class="img-thumbnail"
                                                src="<?= asset('assets') ?>/uploads/produk/<?= $k->options->picture ?>"
                                                alt="">
                                            <span style="margin-left: 20px;"><?= $k->name ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="margin-top: 55px;" class="float-right"><?= $k->qty ?> x
                                                <strong>Rp.<?= number_format($k->price) ?></strong>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach ?>
                                        <div class="container">

                                            <strong style="font-size: 20px;">Subtotal <?= $jumlah_produk ?> produk</strong>
                                            <strong style="float: right;font-size: 20px;">Rp.
                                                <?= number_format($subtotal_produk) ?></strong>
                                            <hr>

                                        </div>

                                        <hr>
                                        <?php
                                        $subtotal_order = 0;
                                        $jumlah_servis = 0;
                                        ?>
                                        <?php $total = $subtotal_produk + $subtotal_order; ?>


                                        <div class="container">
                                            <h3 class="text-center mb-4">Pembayaran</h3>
                                            <hr>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">Cash</label>
                                                <div class="col-md-6">
                                                    <input type="number" name="pembayaran[]"
                                                        class="form-control pembayaran" value="0" id="cash">
                                                    <input type="hidden" name="id_akun[]" value="13">
                                                    <input type="hidden"
                                                        name="pengirim[]" value="">
                                                </div>
                                            </div>
                                            @foreach ($pembayaran as $d)
                                                <div x-data="{
                                                    open: false
                                                }">
                                                    <div class="form-group row">
                                                        <label @click="open = !open" for="staticEmail"
                                                            class="col-md-4 col-form-label">{{ $d->nm_klasifikasi }}</label>
                                                        <button @click="open = !open" type="button"
                                                            class="btn btn-sm btn-primary float-end"><i
                                                                class="fas fa-caret-down"></i></button>
                                                    </div>
                                                    @php
                                                        $bayar = DB::table('akun_pembayaran')
                                                            ->where('id_klasifikasi', $d->id_klasifikasi_pembayaran)
                                                            ->get();
                                                    @endphp
                                                    <div x-show="open">
                                                        @foreach ($bayar as $i => $b)
                                                            <div class="form-group row">
                                                                <label for="staticEmail"
                                                                    class="col-md-4 col-form-label">{{ $b->nm_akun }}</label>
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="id_akun[]"
                                                                        value="{{ $b->id_akun_pembayaran }}">
                                                                    <input type="number" name="pembayaran[]"
                                                                        class="form-control pembayaran"
                                                                        count="{{ $i }}" value="0"
                                                                        id="{{ $i }}">
                                                                    <input
                                                                        type="{{ $b->id_klasifikasi == 4 ? 'text' : 'hidden' }}"
                                                                        name="pengirim[]"
                                                                        class="form-control pembayaran_pengirim"
                                                                        count="{{ $i }}"
                                                                        placeholder="nama pengirim"
                                                                        id="{{ $i }}">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- pembayaran lama --}}
                                            {{-- <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">BCA Debit</label>
                                                <div class="col-md-6">
                                                    <input type="number" name="bca_debit" class="form-control pembayaran"
                                                        value="0" id="bca_debit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">BCA Kredit</label>
                                                <div class="col-md-6">
                                                    <input type="number" name="bca_kredit" class="form-control pembayaran"
                                                        value="0" id="bca_kredit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">Mandiri
                                                    Debit</label>
                                                <div class="col-md-6">
                                                    <input type="number" name="mandiri_debit"
                                                        class="form-control pembayaran" value="0" id="mandiri_debit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">Mandiri
                                                    Kredit</label>
                                                <div class="col-md-6">
                                                    <input type="number" name="mandiri_kredit"
                                                        class="form-control pembayaran" value="0" id="mandiri_kredit">
                                                </div>
                                            </div> --}}
                                            {{-- end pembayaran lama --}}

                                            <!-- <div class="form-group row">
                                                                                            <label for="staticEmail" class="col-md-4 col-form-label">Lokasi</label>
                                                                                            <div class="col-md-6">
                                                                                            <select name="lokasi" class="form-control select" required>
                                                                                                    <option value="" >--Pilih Lokasi--</option>
                                                                                                    <option value="TAKEMORI">TAKEMORI</option>
                                                                                                    <option value="SOONDOBU">SOONDOBU</option>

                                                                                            </select>
                                                                                            </div>
                                                                                        </div> -->

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">No Meja</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="no_meja" class="form-control ">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-md-4 col-form-label">No Nota</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="invoice" class="form-control ">
                                                </div>
                                            </div>

                                            <hr>
                                            <input type="hidden" name="total" id="total" value="<?= $total ?>">

                                            <button class="btn  btn-costume btn-block" id="btn_bayar" disabled>PROSES
                                                BAYAR <i class="fas fa-money-check-alt majoo"></i> <i
                                                    class="fa fa-chevron-right majoo" style="float: right; "></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php $total = $subtotal_produk + $subtotal_order; ?>
                    </div>
                </div>
            </div>

    </div>
    <!--/. container-fluid -->
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#cash').on('change blur', function() {
                if ($(this).val().trim().length === 0) {
                    $(this).val(0);
                }
            });
            $('#mandiri_kredit').on('change blur', function() {
                if ($(this).val().trim().length === 0) {
                    $(this).val(0);
                }
            });
            $('#mandiri_debit').on('change blur', function() {
                if ($(this).val().trim().length === 0) {
                    $(this).val(0);
                }
            });
            $('#bca_kredit').on('change blur', function() {
                if ($(this).val().trim().length === 0) {
                    $(this).val(0);
                }
            });
            $('#bca_debit').on('change blur', function() {
                if ($(this).val().trim().length === 0) {
                    $(this).val(0);
                }
            });
            $('.pembayaran').keyup(function() {

                var totalPembayaran = 0;

                $('.pembayaran').each(function() {
                    var nilaiInput = parseFloat($(this).val()) || 0;
                    totalPembayaran += nilaiInput;
                });
                console.log(totalPembayaran)

                var total = parseInt($("#total").val());
                if (total <= totalPembayaran) {
                    $('#btn_bayar').removeAttr('disabled');
                } else {
                    $('#btn_bayar').attr('disabled', 'true');
                }
            });

            function bayar_default() {
                var cash = parseInt($("#cash").val());
                var mandiri_debit = parseInt($("#mandiri_debit").val());
                var mandiri_kredit = parseInt($("#mandiri_kredit").val());
                var bca_debit = parseInt($("#bca_debit").val());
                var bca_kredit = parseInt($("#bca_kredit").val());

                var bayar = cash + mandiri_debit + mandiri_kredit + bca_kredit + bca_debit;

                var total = parseInt($("#total").val());
                if (total <= bayar) {
                    $('#btn_bayar').removeAttr('disabled');
                    // alert('tes')
                } else {
                    // alert('tes1')
                    $('#btn_bayar').attr('disabled', 'true');
                }
            }

            bayar_default();
        });
    </script>
@endsection
