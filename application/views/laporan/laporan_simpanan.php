<?php if($penjualan->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Wajib</th>
				<th>Pokok</th>
				<th>Sukarela</th>
				<th>12 Juli</th>
				<th>Total Transaksi </th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".$p->kode_anggota."</td>
						<td>".$p->nama."</td>
						<td>Rp.&nbsp;".Rp($p->wajib)."</td>
						<td>Rp.&nbsp;".Rp($p->pokok)."</td>
						<td>Rp.&nbsp;".Rp($p->sukarela)."</td>
						<td>Rp.&nbsp;".Rp($p->juli)."</td>
						<td>Rp.&nbsp;".str_replace(",", ".", number_format($p->per_total))."</td>
						
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->per_total;
				$no++;
			}

			echo "
				<tr>
					<td colspan='6'><b>Total Seluruh Transaksi Simpanan</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<em>".terbilang($total_penjualan)." Rupiah</em>
					</td>
				</tr>
			";
			
			
			
			
			
			?>
		</tbody>
	</table>

	<p>
		<?php
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		?>
		<a href="<?php echo site_url('laporan/simpanan-pdf/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a>
		<a href="<?php echo site_url('laporan/simpanan-excel/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
		<a href="<?php echo site_url('laporan/cetak/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default btnPrint'><img src="<?php echo config_item('img'); ?>btn_print2.png"> Cetak Transaksi</a>
	</p>
	<br />
<?php } ?>

<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.printPage.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".btnPrint").printPage();
        })
    </script>