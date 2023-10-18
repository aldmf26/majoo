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
                    <div class="col-sm-5">
                        <div class="card">

                            <div class="card-header">
                                <p class="float-left"><strong>#<?= $invoice->no_nota ?></strong></p>
                                <p class="float-right"><?= date('d/M/Y', strtotime($invoice->tgl_jam)) ?></p>

                            </div>

                            <div class="card-body">

                                <?php
                                $total_produk = 0;
                                $qty_produk = 0;
                                ?>

                                <h4 class="text-center mb-2">--Product--</h4>
                                <br>
                                <div class="row">

                                    <?php foreach($produk as $p): ?>
                                    <?php
                                    $total_produk += $p->harga * $p->jumlah;
                                    $qty_produk += $p->jumlah; ?>
                                    <div class="col-md-8">
                                        <p class="text-dark"><?= $p->jumlah ?> &nbsp <?= $p->nm_produk ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="float-right text-dark"><?= number_format($p->harga * $p->jumlah, 0) ?></p>
                                    </div>

                                    <?php endforeach; ?>
                                </div>



                            </div>

                            <div class="card-footer">

                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="float-left">Total <?= $qty_produk ?> Product</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="float-right"><?= $total_produk ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <p class="float-left">Total</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="float-right"><?= number_format($total_produk) ?></p>
                                    </div>
                                </div>

                                <input type="hidden" name="total" id="total" value="<?= $total_produk ?>">
                                <hr>
                                <form action="<?= route('edit_pembayaran') ?>" method="POST">
                                    @csrf

                                    <input type="hidden" name="id_invoice" value="<?= $invoice->id ?>">
                                    <input type="hidden" name="no_nota" value="<?= $invoice->no_nota ?>">
                                    @php
                                        $invCash = DB::table('pembayaran')
                                            ->where([['no_nota', request()->get('invoice')], ['id_akun_pembayaran', 13]])
                                            ->first();
                                        $ttlBayar = $invCash->nominal ?? 0;
                                    @endphp
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-md-4 col-form-label">Cash</label>
                                        <div class="col-md-6">
                                            <input type="number" name="pembayaran[]" class="form-control pembayaran"
                                                value="{{ $invCash->nominal ?? 0 }}" id="cash">
                                            <input type="hidden" name="id_akun[]" value="13">
                                            <input type="hidden" name="pengirim[]" value="">
                                        </div>
                                    </div>



                                    @foreach ($pembayaran as $d)
                                        @php
                                            $bayar = DB::table('akun_pembayaran')
                                                ->where('id_klasifikasi', $d->id_klasifikasi_pembayaran)
                                                ->get();
                                            $subkategoriHasValue = false;
                                        @endphp
                                        @foreach ($bayar as $i => $b)
                                            @php
                                                $inv = DB::table('pembayaran')
                                                    ->where([['no_nota', request()->get('invoice')], ['id_akun_pembayaran', $b->id_akun_pembayaran]])
                                                    ->first();

                                                // Check if subkategori has value
                                                if (($inv && !empty($inv->nominal)) || !empty($inv->pengirim)) {
                                                    $subkategoriHasValue = true;
                                                }
                                            @endphp
                                        @endforeach

                                        <div x-data="{
                                            open: false
                                        }">
                                            <div class="form-group row">
                                                <label @click="open = !open" for="staticEmail"
                                                    class="col-md-4 col-form-label">{{ $d->nm_klasifikasi }}
                                                    @if ($subkategoriHasValue)
                                                        <i class="fas fa-check" style="color: green;"></i>
                                                    @endif
                                                </label>
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
                                                    @php
                                                        $inv = DB::table('pembayaran')
                                                            ->where([['no_nota', request()->get('invoice')], ['id_akun_pembayaran', $b->id_akun_pembayaran]])
                                                            ->first();
                                                        $ttlBayar += $inv->nominal ?? 0;

                                                    @endphp
                                                    <div class="form-group row">
                                                        <label for="staticEmail"
                                                            class="col-md-4 col-form-label">{{ $b->nm_akun }}</label>
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="id_akun[]"
                                                                value="{{ $b->id_akun_pembayaran }}">
                                                            <input type="number" name="pembayaran[]"
                                                                class="form-control pembayaran" count="{{ $i }}"
                                                                value="{{ $inv->nominal ?? 0 }}" id="{{ $i }}">
                                                            <input type="{{ $b->id_klasifikasi == 4 ? 'text' : 'hidden' }}"
                                                                name="pengirim[]" class="form-control pembayaran_pengirim"
                                                                count="{{ $i }}"
                                                                value="{{ $inv->pengirim ?? '' }}"
                                                                placeholder="nama pengirim" id="{{ $i }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <label for="kembalian" class="col-md-4 col-form-label">Kembalian</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="kembalian"
                                                value="{{ $ttlBayar - $invoice->total }}" disabled>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="cash" class="col-md-4 col-form-label">Cash</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control pembayaran" id="cash"
                                                value="<?= $invoice->cash ?>" name="cash">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mandiri_kredit" class="col-md-4 col-form-label">Mandiri Kredit</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control pembayaran" id="mandiri_kredit"
                                                value="<?= $invoice->mandiri_kredit ?>" name="mandiri_kredit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mandiri_debit" class="col-md-4 col-form-label">Mandiri Debit</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control pembayaran" id="mandiri_debit"
                                                value="<?= $invoice->mandiri_debit ?>" name="mandiri_debit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bca_kredit" class="col-md-4 col-form-label">BCA Kredit</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control pembayaran" id="bca_kredit"
                                                value="<?= $invoice->bca_kredit ?>" name="bca_kredit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bca_debit" class="col-md-4 col-form-label">BCA Debit</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control pembayaran" id="bca_debit"
                                                value="<?= $invoice->bca_debit ?>" name="bca_debit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kembalian" class="col-md-4 col-form-label">Kembalian</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="kembalian"
                                                value="<?= $invoice->bayar - $invoice->total ?>" disabled>
                                        </div>
                                    </div> --}}

                                    <input type="hidden" name="total" id="total" value="<?= $invoice->total ?>">

                                    <input type="hidden" name="tgl_jam" id="tgl_jam" value="<?= $invoice->tgl_jam ?>">

                                    <hr>

                                    <a href="<?= route('nota', ['invoice' => $no_nota]) ?>"
                                        class="btn btn-costume float-right"><i class="fas fa-print majoo"></i> Print</a>
                                    <button class="btn btn-costume float-right mr-2" id="edit_pembayaran" disabled
                                        type="submit"><i class="fas fa-edit majoo"></i> Edit</button>
                                </form>

                            </div>

                        </div>

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
                var bayar = totalPembayaran;
                $("#kembalian").val(bayar - total);
                if (total <= bayar) {
                    $('#edit_pembayaran').removeAttr('disabled');
                } else {
                    $('#edit_pembayaran').attr('disabled', 'true');
                }
                
            });
            // $('.pembayaran').keyup(function() {
            //     var cash = parseInt($("#cash").val());
            //     var mandiri_kredit = parseInt($("#mandiri_kredit").val());
            //     var mandiri_debit = parseInt($("#mandiri_debit").val());
            //     var bca_kredit = parseInt($("#bca_kredit").val());
            //     var bca_debit = parseInt($("#bca_debit").val());
            //     var total = parseInt($("#total").val());
            //     var bayar = mandiri_kredit + mandiri_debit + cash + bca_kredit + bca_debit;
            //     $("#kembalian").val(bayar - total);
            //     if (total <= bayar) {
            //         $('#edit_pembayaran').removeAttr('disabled');
            //     } else {
            //         $('#edit_pembayaran').attr('disabled', 'true');
            //     }


            // });
        });
    </script>
@endsection
