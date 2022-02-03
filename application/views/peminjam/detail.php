<?php
if( ! empty($master->kode_anggota))
{
	echo "
		<div class='col-md-6'>
		<table class='info_pelanggan'>
		<tr>
		<td style='width:50%;'>Kode</td>
				<td>:</td>
	<td>".$master->kode_anggota."<input type='hidden' id='kode_anggota' value='".html_escape($master->kode_anggota)."'></td>
			</tr>
			<tr>
				<td>Nama Anggota</td>
				<td>:</td>
				<td>".$master->nama."<input type='hidden' id='nama' value='".html_escape($master->nama)."'></td>
			</tr>
			<tr>
				<td>NIP</td>
				<td>:</td>
				<td>".$master->nip."</td>
			</tr>
			<tr>
				<td>Tempat tgl Lahir</td>
				<td>:</td>
				<td>".$master->tempat_lahir." ,".tanggal($master->tanggal_lahir)." </td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>No Telp</td>
				<td>:</td>
				<td>".$master->no_telp."</td>
			</tr>
			
			
			
		</table>
		</div>
		<div class='col-md-6'>
		<table class='info_pelanggan'>
		<tr>
		<tr>
				<td style='width:50%;'>Unit Kerja</td>
				<td>:</td>
				<td>".$master->unit_kerja."</td>
			</tr>
			<tr>
				<td>GOLONGAN</td>
				<td>:</td>
				<td>".$master->golongan."</td>
			</tr>
			<tr>
				<td>Gaji</td>
				<td>:</td>
				<td>Rp. ".Rp($master->gaji)."</td>
			
			</tr>
		
		<td>Nama Ahli Waris</td>
				<td>:</td>
				<td>".$master->nama_ahli_waris."</td>
			</tr>
		<td >Hubungan Ahli Waris</td>
				<td>:</td>
				<td>".$master->ahli_waris."</td>
			</tr>	
			<tr>
				<td>Tgl Pendaftaran</td>
				<td>:</td>
				<td>".tanggal($master->tgl_pendaftaran)."</td>
			</tr>
			<tr>
				<td>Status Keanggotaan</td>
				<td>:</td>
				<td>".$master->status."</td>
			</tr>
		</table>
		</div>
		<div class='clearfix'></div>
		<hr />
	";


?>




<table id="my-grid" class="table table-bordered tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th  style='width:6%;'>#</th>
			<th>TANGGAL</th>
			<th style='width:15%;'>WAJIB</th>
			<th style='width:15%;'>POKOK</th>
			<th style='width:15%;' >SUKARELA</th>
			<th style='width:15%;'>12 JULI</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
<td><center><span style='background-color: #1d6de6;' class='badge badge-warning'>".$no."</span></center></td>
<td>".tanggal($d->tgl_entri)." <input type='hidden' name='kode_simpan[]' value='".html_escape($d->kode_simpan)."'></td>
<td>Rp. ".Rp($d->wajib)." <input type='hidden' name='wajib[]' value='".html_escape($d->wajib)."'></td>
<td>Rp. ".Rp($d->pokok)." <input type='hidden' name='pokok[]' value='".html_escape($d->pokok)."'></td>
<td>Rp. ".Rp($d->sukarela)." <input type='hidden' name='sukarela[]' value='".html_escape($d->sukarela)."'></td>
<td>Rp. ".Rp($d->juli)." <input type='hidden' name='juli[]' value='".html_escape($d->juli)."'></td>
				
			</tr>
		";

		$no++;
		echo "
		<tr style='background:#deeffc;'>
			<td colspan='5' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".Rp($d->per_total)."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='4' style='text-align:right;'></td>
			<td colspan='2' style='text-align:right;'><b>".terbilang($d->per_total)." Rupiah</b></td>
		</tr>
	";
		
	}
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
		//FormData += "&nama="+encodeURI($('#nama').val());
		

		window.open("<?php echo site_url('anggota/cetak-anggota/?'); ?>" + FormData,'_blank');
	});
});
</script>

<?php	
}
else
{
	echo "Kosong";
}
	?>