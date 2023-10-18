<style>
    .invoice {
        margin: auto;
        width: 80mm;
        background: #FFF;
    }

    .huruf {
        font-size: 18px;
    }
</style>


<?php $lokasi = Session::get('id_lokasi') == '1' ? 'TAKEMORI' : 'SOONDOBU'; ?>







<div class="invoice">
    <br>
    <center>
        <img width="100"
            src="https://majoo.putrirembulan.com/assets/img/{{ Session::get('id_lokasi') == '1' ? 'takemori.jpg' : 'soondobu.jpg' }}"
            alt="AdminLTE Logo" class="brand-image image-center elevation-3" style="opacity: .8">
    </center>
    <p align="center" class="huruf"><?= $lokasi ?></p>
    <p style=" margin-top: -10px;" align="center" class="huruf">Jalan M.T. Haryono No.16</p>
    <p style=" margin-top: -10px;" align="center" class="huruf">Hotel Aria Barito Lantai 1</p>


    <table width="100%">
        <tr>
            <td width="40%" class="huruf">No Nota</td>
            <td style="text-align: left; " class="huruf">: <?= $invoice->no_nota ?></td>
        </tr>
        <tr>
            <td width="40%" class="huruf">Waktu</td>
            <td style="text-align: left; " class="huruf">: <?= date('d M Y', strtotime($invoice->tgl_jam)) ?>
                <?= date('H:i') ?></td>
        </tr>
        <tr>
            <td width="40%" class="huruf">Kasir</td>
            <td style="text-align: left; " class="huruf">: <?= $invoice->nama ?></td>
        </tr>
        <tr>
            <td width="40%" class="huruf">Meja</td>
            <td style="text-align: left; " class="huruf">: <?= $invoice->no_meja ?></td>
        </tr>


    </table>

    <hr>
    <table width="100%">
        <?php
        $total_produk = 0;
        $qty_produk = 0;
        ?>
        <?php if(!empty($produk)): ?>
        <?php foreach($produk as $p): ?>
        <?php
        $total_produk += $p->jumlah * $p->harga;
        $qty_produk += $p->jumlah;
        $nm_produk = strtolower($p->nm_produk);
        $hrg_produk = $p->jumlah * $p->harga;
        $hrg_asli = $p->jumlah * $p->harga_asli;
        ?>
        <tr class="huruf" style="margin-bottom: 2px;">
            <td width="10%"><?= $p->jumlah ?></td>
            <td width="50%"><?= ucwords($nm_produk) ?> <br>
                <?php if($hrg_asli > $hrg_produk): ?>
                Discount (- <?= number_format($hrg_asli - $hrg_produk, 0) ?>)
                <?php endif; ?>
            </td>

            <td width="40%" style="text-align: right;">
                <?php if($hrg_asli > $hrg_produk): ?>

                <strike><?= number_format($hrg_asli, 0) ?></strike><br>
                <?= number_format($hrg_produk, 0) ?>

                <?php else: ?>
                <?= number_format($hrg_produk, 0) ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><?= strtolower($p->nm_karyawan) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>



    </table>
    <hr>
    <table width="100%">
        <?php if($qty_produk != 0): ?>
        <tr class="huruf">
            <td>Subtotal <?= $qty_produk ?> Product</td>
            <td style="text-align: right;"><?= number_format($total_produk, 0) ?></td>
        </tr>
        <?php endif; ?>

        <tr class="huruf">
            <td><strong>Total Tagihan</strong></td>
            <td style="text-align: right;"><strong><?= number_format($total_produk, 0) ?></strong></td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <?php if($invoice->diskon !=0): ?>
        <tr class="huruf">
            <td>Diskon</td>
            <td style="text-align: right;"><?= number_format($invoice->diskon, 0) ?></td>
        </tr>
        <?php endif; ?>

        <?php if($invoice->dp !=0): ?>
        <tr class="huruf">
            <td>Kredit BCA</td>
            <td style="text-align: right;"><?= number_format($invoice->dp, 0) ?></td>
        </tr>
        <?php endif; ?>
      
        @foreach ($pembayaran as $d)
            <tr class="huruf">
                <td>{{ $d->nm_klasifikasi }} {{ $d->nm_akun }}</td>
                <td style="text-align: right;"><?= number_format($d->nominal, 0) ?></td>
            </tr>
        @endforeach


        {{-- pembayaran bahari --}}
        {{-- @if ($invoice->bca_kredit != 0)
            <tr class="huruf">
                <td>Kredit BCA</td>
                <td style="text-align: right;">{{ number_format($invoice->bca_kredit, 0) }}</td>
            </tr>
        @endif

        @if ($invoice->bca_debit != 0)
            <tr class="huruf">
                <td>Debit BCA</td>
                <td style="text-align: right;">{{ number_format($invoice->bca_debit, 0) }}</td>
            </tr>
        @endif

        @if ($invoice->mandiri_kredit != 0)
            <tr class="huruf">
                <td>Kredit Mandiri</td>
                <td style="text-align: right;">{{ number_format($invoice->mandiri_kredit, 0) }}</td>
            </tr>
        @endif

        @if ($invoice->mandiri_debit != 0)
            <tr class="huruf">
                <td>Debit Mandiri</td>
                <td style="text-align: right;">{{ number_format($invoice->mandiri_debit, 0) }}</td>
            </tr>
        @endif

        @if ($invoice->cash != 0)
            <tr class="huruf">
                <td>Cash</td>
                <td style="text-align: right;">{{ number_format($invoice->cash, 0) }}</td>
            </tr>
        @endif --}}

        {{-- end pembayaran bahari --}}

        <tr class="huruf">
            <td><strong>Total Pembayaran</strong></td>
            <td style="text-align: right;"><strong><?= number_format($invoice->bayar, 0) ?></strong></td>
        </tr>
        <tr class="huruf">
            <td>Kembalian</td>
            <td style="text-align: right;"><?= number_format($invoice->bayar - $invoice->total, 0) ?></td>
        </tr>
    </table>
    <hr>
    <hr>

    <p class="huruf" align="center">Terbayar</p>
    <p class="huruf" align="center" style="margin-top: -10px;"><-------- <?= date('d M Y h:i') ?> --------></p>

    <p class="huruf" align="center">** Thank you. See you next time! **</p>
    <script>
        window.print();
    </script>
    <!-- <script>
        var url = document.getElementById('url').value;
        var count = 5; // dalam detik
        function countDown() {
            if (count > 0) {
                count--;
                var waktu = count + 1;
                $('#pesan').html('Anda akan di redirect ke ' + url + ' dalam ' + waktu + ' detik.');
                setTimeout("countDown()", 1000);
            } else {
                window.location.href = url;
            }
        }
        countDown();
    </script>  -->
