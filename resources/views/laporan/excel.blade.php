<?php
if ($jenis == 'tkm') {
    $lokasi2 = 'Takemori';
} elseif ($jenis == 'sdb') {
    $lokasi2 = 'SOONDOBU';
} elseif ($jenis == 'orc') {
    $lokasi2 = 'ORCHARD';
} else {
    $lokasi2 = 'TSO';
}
$file = 'PENJUALAN_PRODUK_' . $lokasi2 . '_' . date('d_M_y', strtotime($tgl1)) . '_sd_' . date('d_M_y', strtotime($tgl2)) . '.xls';
header('Content-type: application/vnd-ms-excel');
header("Content-Disposition: attachment; filename=$file");

?>
@if ($jenis == 'orc')
    <table class="table" border="1">
        <thead style="text-align: center;">
            <th colspan="6">SUMMARY PENJUAL PRODUK <?= $lokasi2 ?> <?= $sort ?> (Dijual di Takemori)</th>
        </thead>
        <thead class="thead-light">
            <tr>
                <th>KATEGORI</th>
                <th>NAMA PRODUK</th>
                <th>QTY</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>TOTAL</th>
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
                <td><?= $k->jumlah ?></td>
                <td><?= $k->satuan ?></td>
                <td><?= $k->total ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot class="bg-secondary text-light">
            <tr>
                <th colspan="5">TOTAL</th>
                <th><?= $ttl_tkmr ?></th>
            </tr>
        </tfoot>
    </table>
    <br>

    <table class="table" border="1">
        <thead style="text-align: center;">
            <th colspan="6">SUMMARY PENJUAL PRODUK <?= $lokasi2 ?> <?= $sort ?> (Dijual di Soondobu)</th>
        </thead>
        <thead class="thead-light">
            <tr>
                <th>KATEGORI</th>
                <th>NAMA PRODUK</th>
                <th>QTY</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
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
                <td><?= $k->jumlah ?></td>
                <td><?= $k->satuan ?></td>
                <td><?= $k->total ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot class="bg-secondary text-light">
            <tr>
                <th colspan="5">TOTAL</th>
                <th><?= $ttl_sdb ?></th>
            </tr>
        </tfoot>
        <tfoot class="bg-secondary text-light">
            <tr>
                <th colspan="5">TOTAL</th>
                <th><?= $ttl_tkmr + $ttl_sdb ?></th>
            </tr>
        </tfoot>
    </table>
@else
    <table class="table" border="1">
        <thead style="text-align: center;">
            <th colspan="6">SUMMARY PENJUAL PRODUK <?= $lokasi2 ?> <?= $sort ?></th>
        </thead>
        <thead class="thead-light">
            <tr>
                <th>KATEGORI</th>
                <th>NAMA PRODUK</th>
                <th>QTY</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>TOTAL</th>
            </tr>
        </thead>

        <tbody>
            <?php
                        $ttl = 0;
                        $ttl_orchard = 0;
                        foreach ($penjualan as $k): 
                            $ttl += $k->total;
                            $ttl_orchard += $k->nm_kategori == 'Orchard' ? $k->total : 0;
                            ?>
            <tr>
                <td><?= $k->nm_kategori ?></td>
                <td><?= $k->nm_produk ?></td>
                <td><?= $k->jlh ?></td>
                <td><?= $k->satuan ?></td>
                <td><?= $k->rt_harga ?></td>
                <td><?= $k->total ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot class="bg-secondary text-light">
            <tr>
                <th colspan="5">TOTAL TS</th>
                <th><?= $ttl - $ttl_orchard ?></th>
            </tr>
            <tr>
                <th colspan="5">TOTAL Orchard</th>
                <th><?= $ttl_orchard ?></th>
            </tr>
            <tr>
                <th colspan="5">TOTAL</th>
                <th><?= $ttl ?></th>
            </tr>
        </tfoot>
    </table>
@endif
