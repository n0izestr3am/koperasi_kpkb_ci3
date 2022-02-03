<?php
if( ! empty($master->kode_anggota))
{
	//$kodep = $master->kode_pinjam;
	
	echo "
		<table class='info_pelanggan'>
			<tr>
				<td>Kode Anggota</td>
				<td>:</td>
				<td>".$master->kode_anggota."</td>
			</tr>
			<tr>
				<td>Kode Pinjaman</td>
				<td>:</td>
				<td>".$master->kode_pinjam."</td>
			</tr>
			
			
			
			<tr>
				<td>Nama Anggota</td>
				<td>:</td>
				<td>".$master->nama."</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>Golongan</td>
				<td>:</td>
				<td>".$master->golongan."</td>
			</tr>
			<tr>
				<td>Gaji</td>
				<td>:</td>
				<td>".$master->gaji."</td>
			</tr>
			
			<tr>
				<td>Tanggal Pengajuan Pinjaman</td>
				<td>:</td>
				<td>".tanggal($master->tgl_pengajuan)."</td>
			</tr>
			<tr>
				<td>Jenis Pinjaman</td>
				<td>:</td>
				<td>".$master->nama_pinjaman."</td>
			</tr>
			<tr>
				<td>Bunga Pinjaman</td>
				<td>:</td>
				<td>".$master->bunga." %</td>
			</tr>
		</table>
		<hr />
	";
}
else
{
	echo "Pelanggan : Umum";
}




?>
<?php echo form_open('pengajuan/terima/'.$master->kode_anggota, array('id' => 'FormEditStatus')); ?>
<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			
			<th>Besar Pinjaman</th>
			<th>Angsuran / Bulan</th>
			<th>Bunga / Bulan</th>
			<th>Pokok</th>
		
			
			
			
		</tr>
	</thead>
	<tbody>
	<?php
	$id = $this->session->userdata('ap_id_user');
	$date=date("Y-m-d");
	$jenis=$master->kode_jenis_pinjam;
	$besar_pinjam=$master->besar_pinjam;
	$p = $this->db->query("SELECT * FROM jenis_pinjam where kode_jenis_pinjam='$jenis'");
    $d = $p->row();
	$lama_angsuran=$d->lama_angsuran;
	$bunga=$d->bunga;
	$angsuranPokok=$besar_pinjam/$lama_angsuran;
    $bung=$bunga/100;
    $bungaPerBulan=$besar_pinjam*$bung;
    $total=$angsuranPokok+$bungaPerBulan;
    $totalasli=$total*$lama_angsuran;
    $tempo=date('Y-m-d',strtotime('+30 day',strtotime($date)));
		echo "
			<tr>
				
				<td>Rp.".Rp($master->besar_pinjam)." <input type='hidden' name='besar_pinjaman' value='".$master->besar_pinjam."'></td>
				<td>Rp.".Rp($total)." / ".$lama_angsuran." Bulan <input type='hidden' name='total' value='".$total."'></td>
				<td>Rp.".Rp($bungaPerBulan)."</td>
				<td>Rp.".Rp($angsuranPokok)." </td>
				
			</tr>";


			

	echo "<tr style='background:#deeffc;'>
			<td >"?><div class='form-group'>
	<select name='status' class='form-control'>
		<option value="Diterima" <?php if($master->status == 'Diterima') { echo 'selected'; } ?>>Diterima</option>
		<option value="DiTolak" <?php if($master->status == 'DiTolak') { echo 'selected'; } ?>>Di Tolak</option>
	</select>
</div><?php echo "</td>
			<td colspan='2' style='text-align:right;'><b>T o t a l</b></br><b>Total Pinjaman beserta Bunga</b></td>
			<td><b>Rp. ".Rp($total)."</b></br><b>Rp. ".Rp($totalasli)."</b></td>"; 
			
			
			
			?>
	</tbody>
</table>
<hr>
<input type="hidden" name="kode_anggota" id="kode_anggota" value="<?php echo html_escape($master->kode_anggota); ?>">

<input type="hidden" name="tempo" value="<?php echo $tempo; ?>">
<input type="hidden" name="kode_pinjaman" id="kode_pinjam" value="<?php echo $master->kode_pinjam; ?>">
<input type="hidden" name="lama_angsuran" value="<?php echo $lama_angsuran; ?>">
<input type="hidden" name="total" value="<?php echo $total; ?>">
<input type="hidden" name="kode_jenis_pinjam" value="<?php echo $jenis; ?>">
<input type="hidden" name="total_pinjam" value="<?php echo $totalasli; ?>">
<input type="hidden" name="id_user" value="<?php echo $id; ?>">

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-danger' id='Cetaks'><i class='fa fa-print'></i> Cetak Nota Pinjaman</button>";
	Tombol += "<button type='button' class='btn btn-warning'  id='SimpanEditStatus'>Terima</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);
if($(this).hasClass('disabled'))
		{
			return false;
		}
		
	$('#SimpanEditStatus').click(function(){
		$.ajax({
			url: $('#FormEditStatus').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditStatus').serialize(),
			dataType:'json',
			beforeSend:function(){
						$('#SimpanEditStatus').html("Menyimpan Data, harap tunggu ...");
					},
			success: function(json){
				if(json.status == 1){ 
					$('#ResponseInput').html(json.pesan);
					    setTimeout(function(){ 
				   		$('#ResponseInput').html('');
						$('#SimpanEditStatus').html("Data Sudah di Simpan");
						$("#SimpanEditStatus").hide(); 
				    },2000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				    $("#Cetaks").show(); 
				    $("#kode_pinjam").show(); 
				}
				else {
					$('#ResponseInput').html(json.pesan);
					
				}
			}
			
			
			
		});
	});
	

$("#Cetaks").hide(); 
$("#kode_pinjam").hide(); 
$(document).on('click', 'button#Cetaks', function(){
	CetakStruk();
});	

function CetakStruk()
{
	var FormData = "kode_anggota="+encodeURI($('#kode_anggota').val());
		FormData += "&kode_pinjam="+encodeURI($('#kode_pinjam').val());
		
			window.open("<?php echo site_url('pengajuan/nota/?'); ?>" + FormData,'_blank');
	
}
});
</script>



