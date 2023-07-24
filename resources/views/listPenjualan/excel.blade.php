<?php
$file = "LAPORAN_KOMISI_".date('d_M_y',strtotime($tgl1))."_sd_".date('d_M_y',strtotime($tgl2)).".xls";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$file");
?>
<table class="table" border="1">
<thead class="thead-light">
    <tr>
        <th colspan="4">Laporan komisi penjualan majoo <?= date('d M Y', strtotime($tgl1)) ?> - <?= date('d M Y', strtotime($tgl2)) ?></th>
    </tr>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Komisi</th>
            <th>Komisi Target</th>
        </tr>
	</thead>
	
	<tbody>
    <?php $i = 1;
        $ttl_komisi = 0;
        $ttl_komisi_trg = 0;
        foreach ($komisi as $k) :
        if($k->nm_karyawan == 'SDB' || $k->nm_karyawan == 'TKMR'){
            continue;
        }    
        
        if($rules_active){

            if($rules_active->jenis == 'komisi'){
                if($k->dt_komisi >= $rules_active->jumlah){
                    $trg_komisi = $k->dt_komisi * $rules_active->persen;            
                }else{
                    $trg_komisi = $k->dt_komisi;
                }
            }else if($rules_active->jenis == 'pendapatan'){
                if($total_penjualan->ttl_penjualan >= $rules_active->jumlah){
                    $trg_komisi = $k->dt_komisi * $rules_active->persen;
                }else{
                    $trg_komisi = $k->dt_komisi;
                }
            }else{
                $trg_komisi = $k->dt_komisi;
            }

        }else{
            $trg_komisi = $k->dt_komisi;
        }

        $ttl_komisi_trg += $trg_komisi;
        $ttl_komisi += $k->dt_komisi;     
        
        ?>
            <tr>
                <td><?= $i++ ?></td>
                
                <td><?= $k->nm_karyawan ?></td>
                <td><?= number_format($k->dt_komisi, 0) ?></td>
                <td><?= number_format($trg_komisi, 0) ?></td>
               
            </tr>
        <?php endforeach ?>
	</tbody>
	<tfoot class="bg-secondary text-light">
        <tr>	
			<th colspan="2">TOTAL</th>
			<th><?= number_format($ttl_komisi, 0); ?></th>
            <th><?= number_format($ttl_komisi_trg, 0); ?></th>
		</tr>
        <tr>
            <th colspan="2">Beban Resto</th>
            <th><?= number_format($komisi_resto->beban_komisi, 0); ?></th>
            <?php 
            $persen_resto = ($komisi_resto->beban_komisi*100)/$ttl_komisi;
            $beban_target_resto = ($ttl_komisi_trg * $persen_resto)/100;
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
            @else
            <th><?= number_format(0, 0); ?></th>
            <th><?= number_format(0, 0); ?></th>
            @endif
        </tr>
	</tfoot>
</table>


