<?php if($penjualan->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th style="width:4%;">#</th>
				<th style="width:21%;">Tanggal</th>
			
				<th>Nama / Perusahaan</th>
				<th style="width:20%;">Angsuran</th>
				<th style="width:20%;">Sisa</th>
			</tr>
			
			
			
		
		</thead>

			<?php
			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
						
						
						<td>".trim($p->nama)."</td>
					
						<td>Rp. ".str_replace(",", ".", number_format($p->angsur))." &nbsp; 	<span style=\"position: absolute;background-color: #e6421d;\" class=\"badge badge-warning\"> ".$p->angsuran_ke."</span> </td>
						<td>Rp. ".str_replace(",", ".", number_format($p->saldo))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->angsur;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Angsuran Pinjaman</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<b>".terbilang($total_penjualan)." Rupiah</b>
					</td>
				</tr>
			";
			?>
		</tbody>
	</table>

	<p>
		<?php
		if (empty($debitur)){
$debitur = 'all';}	else{
$debitur 	= $debitur;
			}
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		?>
		<a href="<?php echo site_url('laporan/angsuran-pdf/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a>
		<a href="<?php echo site_url('laporan/angsuran-msword/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>word.png"> Export ke MsWord</a>
		<a href="<?php echo site_url('laporan/angsuran-excel/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
		<a href="<?php echo site_url('laporan/cetak-angsuran/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default btnPrint'><img src="<?php echo config_item('img'); ?>btn_print2.png"> Cetak Transaksi</a>
	</p>
	<br />
<?php } ?>

<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> Sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.printPage.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".btnPrint").printPage();
        })
    </script>