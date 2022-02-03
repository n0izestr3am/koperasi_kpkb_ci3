<?php
if( ! empty($master->kode_pinjam))
{
$besar_pinjaman = $master->besar_pinjam;	
$lama_angsuran = $master->lama_angsuran;	
$bung = $master->bunga;	
$bunga = (($besar_pinjaman*$bung)/100);	
$ang = $bunga*$lama_angsuran;

$pokok  = $besar_pinjaman/$lama_angsuran;
$margin = $pokok*($bung/100);
$total=$pokok+$margin;
$totalasli=$total*$lama_angsuran;
$margin_bulat = round($margin, -3); //pembulatan bunga
$pokok_bulat = round($pokok, -3); //pembulatan angsuran pokok
$jml_bayar   = $pokok_bulat+$margin_bulat; //jumlah bayar angsuran perbulan
$total_bunga  = $margin_bulat*$lama_angsuran;

	
	echo "<div class='col-md-5'>
		<table class='info_pelanggan'>
			<tr>
				<td>Nama </td>
				<td>:</td>
				<td>".$master->nama."</td>
			</tr>
			
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$master->telp."</td>
			</tr>
			<tr>
				<td>Jenis Peminjam</td>
				<td>:</td>
				<td>".ucfirst($master->nama_pinjaman)."</td>
			</tr>	
			
			<tr>
				<td>Status Pinjaman</td>
				<td>:</td>";
		if($master->status=='belum lunas')
        {
        	echo "<td><img style='vertical-align: top' src='".config_item('img')."belum-lunas.png' width='180' /></td>";
			
        }
      
		else 
        {
          echo "<td><img style='vertical-align: top' src='".config_item('img')."lunas.png' width='100' /></td>";
	
        } 
				
				
	
			echo "</tr>	
		</table>
		</div>	
		<div class='pinjaman col-md-7'>
		<br>
		
			<table class='info_pelanggan'>
			<tr>
				<td style='width:50%;'>Jenis Pinjaman</td>
				<td>:</td>
				<td>".ucfirst($master->nama_pinjaman)."</td>
			</tr>
			<tr>
				<td>Besar Pinjaman</td>
				<td>:</td>
				<td>Rp. ".Rp($master->besar_pinjam)."</td>
			</tr>
			<tr>
				<td>Bunga</td>
				<td>:</td>
				
				<td>Rp. ".Rp($margin_bulat)." (".$master->bunga." %)</td>
			</tr>
			<tr>
				<td>Lama Angsuran</td>
				<td>:</td>
				
				<td>".$master->lama_angsuran." Kali</td>
			</tr>
			<tr>
				<td>Jumlah Bayar Angsuran / Bulan</td>
				<td>:</td>
				<td>Rp. ".Rp($jml_bayar)."</td>
			</tr>
			<tr>
				<td>Total Bunga </td>
				<td>:</td>
				<td>Rp. ".Rp($total_bunga)."</td>
			</tr>
		</table>
		
		
		</div>
		
		<div class='clearfix'></div>
		<hr />
	";
}
else
{
	echo "none";
}
?>

<input type="hidden" id="id_klien" value="<?php echo html_escape($master->id_klien); ?>">
<input type="hidden" id="kode_pinjam" value="<?php echo html_escape($master->kode_pinjam); ?>">
<input type="hidden" name="nama_klien" id="nama_klien" value="<?php echo $master->nama; ?>">


<table id="my-grid" class="table tabel-transaksi table-bordered" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th style="width:5%;">No</th>
			<th style="width:19%;">Tgl Angsur</th>
			<th style="width:15%;">Angsuran Ke</th>
			<th>Besar Angsuran</th>
			<th style="width:5%;">Cetak</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".tanggal($d->tgl_entri)." <input type='hidden' name='tgl_entri' id='tgl_entri' value='".html_escape($d->tgl_entri)."'></td>
				<td><span style='background-color: #1d6de6;' class='badge badge-warning'>".$d->angsuran_ke." </span><input type='hidden' name='angsuran_ke[]' value='".html_escape($d->angsuran_ke)."'></td>
				<td>Rp. ".Rp($d->besar_angsuran)." <input type='hidden' name='kode_barang[]' value='".html_escape($d->besar_angsuran)."'></td>
<td><a class='btn btn-warning btn-xs btnPrint' href='".site_url('angsuran/print-baris/?kode_pinjam='.$master->kode_pinjam)."&id_klien=".$master->id_klien."&baris=".$no."' id='Print' target='_blank'><i class='fa fa-print'></i> Print Baris ke ".$no."</a></td>
				
			</tr>
		";

		$no++;
	}

	echo "
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Sisa Pinjaman</b></td>
			<td colspan='2'><b>Rp. ".str_replace(',', '.', number_format($master->sisa_pinjaman))."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Pokok Pinjaman</b></td>
			<td colspan='2'><b>Rp. ".str_replace(',', '.', number_format($master->besar_pinjam))."</b></td>
		</tr>
		
		<tr>
			<td colspan='3' style='text-align:right; border:0px;'>Total Pinjaman beserta Bunga</td>
			<td colspan='2' style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</td>
		</tr>
		
	";
	
	
	
	
	
	
	
	
	
	?>
	</tbody>
</table>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.printPage.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".btnPrint").printPage();
        })
    </script>
<script>


$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-sm btn-danger' id='Cetaks'><i class='fa fa-print'></i> Cetak Semua Data</button>";
	Tombol += "<button type='button' class='btn btn-sm btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);
$('button#Cetaks').click(function(){
		var FormData = "kode_anggota="+encodeURI($('#kode_anggota').val());
		var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
	
		

		window.open("<?php echo site_url('cetak/angsuran/?'); ?>" + FormData,'_blank');
	});

});
</script>
