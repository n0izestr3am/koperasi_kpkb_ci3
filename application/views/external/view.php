<?php
if( ! empty($master->id_klien))
{
	echo "
		<table class='info_pelanggan'>
			
			<tr>
				<td>Kode Pinjaman</td>
				<td>:</td>
				<td>".$master->kode_pinjam." <input type='hidden' id='kode_pinjam' value='".$master->kode_pinjam."'></td>
			</tr>
			<tr>
				<td>Nama Peminjam</td>
				<td>:</td>
				<td><input type='hidden' id='nama' value='".$master->nama."'>".$master->nama."</td>
			</tr>
			
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>Type</td>
				<td>:</td>
				<td>".$master->type."</td>
			</tr>
			
			<tr>
				<td>Tanggal Pengajuan Pinjaman</td>
				<td>:</td>
				<td><input type='hidden' id='tanggal' value='".tanggal($master->tgl_entri)."'><i class='glyphicon glyphicon-time'></i> ".tanggal($master->tgl_entri)."   <i class='glyphicon glyphicon-calendar'></i> Jatuh Tempo : ".tanggal($master->tgl_tempo)."</td>
			</tr>
			
			<tr>
				<td>Bunga Pinjaman</td>
				<td>:</td>
				<td>".$master->bunga." %</td>
			</tr>
			<tr>
				<td>Jaminan</td>
				<td>:</td>
				<td>".$master->jaminan."</td>
			</tr>
					<tr>
				<td>Download Dokumen</td>
				<td>:</td>
				<td>";
if( ! empty($master->file_jaminan))
{
echo "<a class='btn btn-info btn-xs' href='".base_url('assets/upload/'.$master->file_jaminan)."' target='_blank'>
<i class='glyphicon glyphicon-download'></i> Download Jaminan</a>";

}
else{
echo "<button class='btn btn-danger btn-xs'>
<i class='glyphicon glyphicon-download'></i> Tidak ada Dokumen</button>";	
}
echo "</td>
			</tr>
			
			<tr>
				<td>Download Dokumen Perjanjian</td>
				<td>:</td>
				<td>";
if( ! empty($master->file_perjanjian))
{
echo "<a class='btn btn-warning btn-xs' href='".base_url('assets/upload/'.$master->file_perjanjian)."' target='_blank'>
<i class='glyphicon glyphicon-download'></i> Download Dokumen Perjanjian</a>";
}

else{
echo "<button class='btn btn-danger btn-xs'>
<i class='glyphicon glyphicon-download'></i> Tidak ada Dokumen</button>";	
}
echo "</td>
			</tr>
			
	<tr>
				<td>Status Pinjaman</td>
				<td>:</td>
				<td>".$master->acc."</td>
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
<div class='row'>
								<div class='col-sm-9'><p style="color: red;line-height: 1;font-size: 12px;">* Tombol Download Dokumen sebelah kanan utk Print Surat Perjanjian Pinjaman  >>>></p></div>
								
							<div class='col-sm-3'>
								<button type='button' class='btn btn-primary' id='CetakPerjanjian'>
											<i class='fa fa-download'></i> Download Dokumen
										</button>
								</div>
								
							</div> 

<?php echo form_open('pinjaman/terima/'.$master->kode_pinjam, array('id' => 'FormEditStatus')); ?>
<table id="my-grid" class="table tabel-transaksi table-bordered" style='margin-bottom: 0px; margin-top: 10px;'>
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
	$kode_pinjam=$master->kode_pinjam;
	$besar_pinjam=$master->besar_pinjam;
	$angsuran_plus_bunga=$master->besar_angsuran;
	$total_pinjam=$master->total_pinjam;
	$p = $this->db->query("SELECT * FROM jenis_pinjam where kode_jenis_pinjam='$jenis'");
    $d = $p->row();
	$lama_angsuran=$d->lama_angsuran;
	$bunga=$d->bunga;
	$pokok  = $besar_pinjam/$lama_angsuran;
    $margin = $pokok*($bunga/100);
	$total=$pokok+$margin;
    $totalasli=$total*$lama_angsuran;
    $margin_bulat = round($margin, -3); //pembulatan bunga
    $pokok_bulat = round($pokok, -3); //pembulatan angsuran pokok
    $jml_bayar   = $pokok_bulat+$margin_bulat; //jumlah bayar angsuran perbulan
	 	
    $tempo=date('Y-m-d',strtotime('+90 day',strtotime($date)));
		echo "
			<tr>
				
				<td>Rp.".Rp($master->besar_pinjam)." <input type='hidden' id='besar_pinjaman' name='besar_pinjaman' value='".$master->besar_pinjam."'></td>
				<td>Rp.".Rp($jml_bayar)." / ".$lama_angsuran." Bulan <input type='hidden' name='besar_angsuran' value='".$jml_bayar."'></td>
				<td>Rp.".Rp($margin)." <input type='hidden' name='total' value='".$margin."'></td>
				<td>Rp.".Rp($pokok_bulat)."  <input type='hidden' name='total' value='".$pokok_bulat."'></td>
			
				
			</tr>";


			

	echo "<tr style='background:#deeffc;'>
			<td >"?><?php echo "</td>
			<td style='text-align:right;'><b>T o t a l</b></br><b>Total Pinjaman beserta Bunga</b></br>
			 <small class='text-muted'>( ".terbilang($total_pinjam)." Rupiah )</small>
			</td>
			<td colspan='2' style='text-align:right;'><b>Rp. ".Rp($besar_pinjam)."</b></br><b>Rp. ".Rp($total_pinjam)."</b></td>";
			?>
			
			
			
			
			
			
	</tbody>
</table>
<hr>
<input type="hidden" name="id_klien" id="id_klien" value="<?php echo html_escape($master->id_klien); ?>">
<input type="hidden" name="tempo" value="<?php echo $tempo; ?>">
<input type="hidden" name="lama_angsuran" value="<?php echo $lama_angsuran; ?>">
<input type="hidden" name="total" value="<?php echo $jml_bayar; ?>">
<input type="hidden" name="kode_jenis_pinjam" value="<?php echo $jenis; ?>">
<input type="hidden" name="kode_pinjam" value="<?php echo $kode_pinjam; ?>">
<input type="hidden" name="total_pinjam" value="<?php echo $total_pinjam; ?>">
<input type="hidden" name="id_user" value="<?php echo $id; ?>">

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-sm btn-danger' id='Cetaks'><i class='fa fa-print'></i> Print Detail Pinjaman</button>";
	//Tombol += "<button type='button' class='btn btn-sm btn-success'  id='SimpanEditStatus'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-sm btn-default' data-dismiss='modal'>Tutup</button>";
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
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
					 //$('#CetakPerjanjian').removeAttr("disabled");
					 //$('#CetakSurat').removeAttr("disabled");
				   // $("#Cetaks").show(); 
				}
				else {
					$('#ResponseInput').html(json.pesan);
					
				}
			}
			
			
			
		});
	});
	

//$("#Cetaks").hide(); 

//$('#CetakPerjanjian').attr("disabled","disabled");
//$('#CetakSurat').attr("disabled","disabled");
$(document).on('click', 'button#CetakPerjanjian', function(){
	CetakPerjanjian();
});	
function CetakPerjanjian()
{
	var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&nama="+$('#nama').val();
			FormData += "&besar_pinjaman="+$('#besar_pinjaman').val();
			window.open("<?php echo site_url('pinjaman/cetak-perjanjian/?'); ?>" + FormData,'_blank');

	
}

$(document).on('click', 'button#CetakSurat', function(){
	CetakSurat();
});	
function CetakSurat()
{
	var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&nama="+$('#nama').val();
			FormData += "&besar_pinjaman="+$('#besar_pinjaman').val();
			window.open("<?php echo site_url('pinjaman/cetak-surat-perintah/?'); ?>" + FormData,'_blank');

	
}












$(document).on('click', 'button#Cetaks', function(){
	CetakStruk();
});	
function CetakStruk()
{
	var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
			

			window.open("<?php echo site_url('pinjaman/cetak/?'); ?>" + FormData,'_blank');
	
}
});
</script>