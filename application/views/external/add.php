<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open_multipart('pinjaman/ajukan', array('id' => 'FormTambahbahan'));

$kode = $this->M_pinjaman->getKodeEks();
$id_user 		= $this->session->userdata('ap_id_user');
 ?>
 <input type='hidden' name='id_user' class='form-control' value='<?php echo $id_user; ?>'>
 <table width="100%" class="info_pelanggan" border="0" style="padding:16px;">
  <tr>
  <td width="45%" style="padding:10px;">
 <div class='form-group required'>
<label class="col-sm-5 control-label" for="">Kode Pinjaman</label>
<div class="col-md-7">
	<input type='text' name='kode_pinjam' class='form-control' value='<?php echo $kode; ?>' readonly>
	
	
</div>
</div> 
  <div class='form-group required'>
<label class="control-label" for="">Nama </label>
<input type='text' name='nama' placeholder="Nama Peminjam" class='form-control'>
</div>


<div class='form-group'>
	<label class="control-label">Alamat</label>
	<textarea name='alamat' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group required'>
<label class="control-label" for="">Telp</label>
<input type='text' name='telp_peminjam' placeholder="Telp Peminjam" class='form-control'>
</div>

</td>
  
  
  
  
  
  
  
  
  
  
    <td width="55%" style="padding:10px;">
	<label class="control-label" for=""><h4>Keterangan Pinjaman</h4></label><br>
	<div class='form-group required'>
<label class="control-label" for="">Type <small style="color:red;">Perusahaan / Personal</small></label>

<select name='type_peminjam' id='type' class='form-control input-sm' style='cursor: pointer;'>
<option value=''>-- Pilih Type Peminjam --</option>
<?php
									if($pinjaman->num_rows() > 0)
									{
										foreach($pinjaman->result() as $p)
										{
											echo "<option value='".$p->kode_jenis_pinjam."'>".ucfirst($p->nama_pinjaman)."</option>";
										}
									}
									?>
</select>
</div>

<div style="font-weight:bold;" id='nama_pinjaman'></div>
<div style="font-weight:bold;" id='maks_pinjam'></div>
	<?php foreach($jenis->result() as $p)
			{ ?>
	
	<div class="form-group required">
<div class="col-md-5">
	<label class="control-label" for="">Jumlah Pinjaman</label><br>
	<div style="color: red;line-height: 1;font-size: 10px; font-weight:bold;" id='max'></div>
	
	</div>
	<div class="col-md-7">
	<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
   
	<input type='hidden' name='kode_jenis_pinjam' class='form-control' value='<?php echo $p->kode_jenis_pinjam ;?>' readonly>
	<input type="text" name="besar_pinjaman" id="besar_pinjaman" class="form-control duit" autocomplete="off" placeholder="Jumlah Pinjaman" required=""/>
  </div>
		
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Lama Angsuran</label>
	<div class="col-md-7">
		
          <div id='lama_angsuran'></div>      		
		 
			
	</div>
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Bunga</label>
	<div class="col-md-7">
	   <div id='bunga'></div>    
	</div>
</div>
<div class="clearfix"></div>
	<?php } ?>
<hr>	
	
<div class='form-group required'>
<label class="control-label" for="">Nama Jaminan</label>
<input type='text' name='jaminan' placeholder="Contoh : Sertifikat / BPKB" class='form-control'>
</div>	
<div class='form-group'>
<label class="control-label" for="">Jaminan  <small style="color:red;">Upload Dokumen Jaminan : Sertifikat etc</small></label>
<input type='file' name='file_jaminan' class='form-control'>
</div>
<div class='form-group'>
<label class="control-label" for="">Dokumen Perjanjian Hutang </label>
<input type='file' name='file_perjanjian' class='form-control'>
</div>

<div class="clearfix"></div>
<p>
 

		
</div>
<div class="clearfix"></div>
<p>

</td>

  </tr>
</table>
 
 
 

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$('#type').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('pinjaman/ajax-type'); ?>",
				type: "POST",
				cache: false,
				data: "kode_jenis_pinjam="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_pinjaman').html(json.nama_pinjaman);
					$('#maks_pinjam').html(json.maks_pinjam);
					$('#lama_angsuran').html(json.lama_angsuran);
					$('#bunga').html(json.bunga);
					$('#max').html(json.max);
				
					
				}
			});
		}
		else
		{
			$('#nama_pinjaman').html('<small><i>Tidak ada</i></small>');
			$('#lama_angsuran').html('<small><i>Tidak ada</i></small>');
			$('#bunga').html('<small><i>Tidak ada</i></small>');
			$('#maks_pinjam').html('<small><i>Tidak ada</i></small>');
			$('#max').html('<small><i>Tidak ada</i></small>');
			
			
		}
	});

 




function Tambahbahan()
{
	$.ajax({
		url: $('#FormTambahbahan').attr('action'),
		type: "POST",
		data: new FormData($('#FormTambahbahan')[0]),
        processData: false,
        contentType: false,
		cache: false,
		mimeType:'multipart/form-data',
		dataType:'json',success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				 setTimeout(function(){ location.reload(); }, 3000)
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-sm btn-danger' id='SimpanTambahbahan'>Ajukan Pinjaman</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahbahan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahbahan').click(function(e){
		e.preventDefault();
		Tambahbahan();
	});

	$('#FormTambahbahan').submit(function(e){
		e.preventDefault();
		Tambahbahan();
	});
});
</script>