<?php
if( ! empty($master->kode_pinjam))
{
$besar_pinjaman = $master->besar_pinjam;	
$lama_angsuran = $master->lama_angsuran;	
$bung = $master->bunga;	
$bunga = (($besar_pinjaman*$bung)/100);	
$ang = $bunga*$lama_angsuran;	
	echo "<div class='col-md-5'>
		<table class='info_pelanggan'>
			<tr>
				<td>Nama Pelanggan</td>
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
				<td>".$master->no_telp."</td>
			</tr>
			<tr>
				<td>N I P</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->nip)."</td>
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
				
				<td>Rp. ".Rp($bunga)." (".$master->bunga." %)</td>
			</tr>
			<tr>
				<td>Lama Angsuran</td>
				<td>:</td>
				
				<td>".$master->lama_angsuran." Kali</td>
			</tr>
			<tr>
				<td>Total Bunga</td>
				<td>:</td>
				<td>Rp. ".Rp($ang)."</td>
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

<input type="hidden" id="kode_anggota" value="<?php echo html_escape($master->kode_anggota); ?>">
<input type="hidden" id="kode_pinjam" value="<?php echo html_escape($master->kode_pinjam); ?>">


<table id="my-grid" class="table tabel-transaksi table-bordered" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>No</th>
			<th>Tgl Angsuran</th>
			<th>Angsuran Ke</th>
			<th>Besar Angsuran</th>
			
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
				<td><span style='background-color: #1d6de6;' class='badge badge-warning'>".$d->angsuran_ke." </span><input type='hidden' name='kode_barang[]' value='".html_escape($d->angsuran_ke)."'></td>
				<td>Rp. ".Rp($d->besar_angsuran)." <input type='hidden' name='kode_barang[]' value='".html_escape($d->besar_angsuran)."'></td>
				
			</tr>
		";

		$no++;
	}

	echo "
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Sisa Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->sisa_pinjaman))."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Pokok Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->besar_pinjam))."</b></td>
		</tr>
		
		<tr>
			<td colspan='3' style='text-align:right; border:0px;'>Total Pinjaman beserta Bunga</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</td>
		</tr>
		
	";
	
	
	
	
	
	
	
	
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('button#Cetaks').click(function(){
		var FormData = "kode_anggota="+encodeURI($('#kode_anggota').val());
		var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
	
		

		window.open("<?php echo site_url('cetak/angsuran/?'); ?>" + FormData,'_blank');
	});
});
</script>