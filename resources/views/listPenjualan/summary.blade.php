<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<center>
<h3>SUMMARY PENJUALAN PRODUK</h3>
<h4>{{$lokasi}}</h4>
<p><?= $sort ?></p>
</center>

<table class="table">
	<thead class="thead-light">
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
		foreach ($penjualan as $k): 
			$ttl += $k->total;
			?>
			<tr>
                <td><?= $k->nm_kategori; ?></td>
                <td><?= $k->nm_produk; ?></td>
				<td><?= number_format($k->rt_harga, 0) ?></td>
                <td><?= number_format($k->jumlah, 0) ?></td>
				<td><?= $k->satuan; ?></td>
                <td><?= number_format($k->total, 0) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot class="bg-secondary text-light">	
		<tr>	
			<th colspan="5">TOTAL</th>
			<th><?= number_format($ttl, 0); ?></th>
		</tr>
	</tfoot>
</table>
<br><br>