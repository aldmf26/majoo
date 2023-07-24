<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
<div class="row">
    <div class="col-12">
        <h3>Laporan Invoice Periode <?= date('d M Y', strtotime($tgl1)) ?> - <?= date('d M Y', strtotime($tgl2)) ?></h3>
    </div>
    <div class="col-12">
        <p class="float-right">Waktu Cetak</p>
        <br><br>
        <p class="float-right"><?= date('d M Y, H:i') ?></p>
    </div>
    <div class="col-12">
    <table class="table" width="100%">
        <thead class="thead-light">
		<tr>
			<th rowspan="2">#</th>
            <th rowspan="2">TANGGAL</th>
			<th rowspan="2">NO NOTA</th>
			<th colspan="2" class="text-center">MANDIRI</th>
            <th colspan="2" class="text-center">BCA</th>
			<th rowspan="2">CASH</th>
            <th rowspan="2">TOTAL</th>
            <th rowspan="2">BAYAR</th>
            <th rowspan="2">KEMBALIAN</th>
		</tr>
        <tr>
            <th>KREDIT</th>
            <th>DEBIT</th>
            <th>KREDIT</th>
            <th>DEBIT</th>
        </tr>
	</thead>
        <tbody>
        <?php
        $i = 1;
        $mandiri_debit = 0;
        $mandiri_kredit = 0;
        $bca_debit = 0;
        $bca_kredit = 0;
        $cash = 0;
        $total = 0;
        $bayar = 0;
        $ttlkembalian = 0; 
        ?>
            <?php foreach($invoice as $d): ?>
            <?php
                $kembalian = $d->bayar - $d->total; 
                $mandiri_debit += $d->mandiri_debit;
                $mandiri_kredit += $d->mandiri_kredit;
                $bca_debit += $d->bca_debit;
                $bca_kredit += $d->bca_kredit;
                $cash += $d->cash;
                $total += $d->total;
                $bayar += $d->bayar;
                $ttlkembalian += $kembalian;    
            ?>
            <tr>
            <td><?= $i++ ?></td>
            <td><?= date('d-m-Y', strtotime($d->tgl_jam)) ?></td>
            <td><?= $d->no_nota ?></td>
            <td><?= number_format($d->mandiri_kredit,0) ?></td>
            <td><?= number_format($d->mandiri_debit,0) ?></td>
            <td><?= number_format($d->bca_kredit,0) ?></td>
            <td><?= number_format($d->bca_debit,0) ?></td>
			<td><?= number_format($d->cash,0) ?></td>
            <td><?= number_format($d->total,0) ?></td>
            <td><?= number_format($d->bayar,0) ?></td>
            <td><?= number_format($kembalian,0) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-secondary text-light">
            <tr>
                <td colspan = "3" class="text-center">Total</td>
                <td><?= number_format($mandiri_kredit,0) ?></td>
                <td><?= number_format($mandiri_debit,0) ?></td>
                <td><?= number_format($bca_kredit,0) ?></td>
                <td><?= number_format($bca_debit,0) ?></td>
                <td><?= number_format($cash,0) ?></td>
                <td><?= number_format($total,0) ?></td>
                <td><?= number_format($bayar,0) ?></td>
                <td><?= number_format($ttlkembalian,0) ?></td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
</div>
    

</body>
</html>