<?php if($pinjaman->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th style="width:4%;">#</th>
				<th style="width:14%;">Tanggal</th>
				<th >Nama / Perusahaan</th>
				<th style="width:17%;"> Pinjaman</th>
				
				<th style="width:17%;">Pinjaman + Bunga</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$total_penjualan = 0;
			foreach($pinjaman->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
					
						<td>".trim($p->nama)."</td>
						
						<td>Rp. ".str_replace(",", ".", number_format($p->besar_pinjam))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_pinjam))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_pinjam;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi Pinjaman</b></td>
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
		<a href="<?php echo site_url('laporan/pinjaman-pdf/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a>
		<a href="<?php echo site_url('laporan/pinjaman-msword/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>word.png"> Export ke MsWord</a>
		<a href="<?php echo site_url('laporan/pinjaman-excel/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
		<a href="<?php echo site_url('laporan/cetak-pinjaman/'.$debitur.'/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default btnPrint'><img src="<?php echo config_item('img'); ?>btn_print2.png"> Cetak Transaksi</a>
	</p>
	<br />
<?php } ?>

<?php if($pinjaman->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data  dari tanggal <b><?php echo $from; ?></b> Sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.printPage.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".btnPrint").printPage();
        })
    </script>