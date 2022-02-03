<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open_multipart('transaksi/tambah-external', array('id' => 'FormTambahbahan'));

$kode = $this->M_pinjaman->getKodeEks();
$id_user 		= $this->session->userdata('ap_id_user');
 ?>
 <input type='hidden' name='id_user' class='form-control' value='<?php echo $id_user; ?>'>
 <table width="100%" class="table" border="0">
  <tr>
  <td width="45%">
<div class='form-group required'>
<label class="control-label" for="">Nama </label>
<input type='text' name='nama' placeholder="Nama Peminjam" class='form-control'>
</div>
<div class='form-group required'>
<label class="control-label" for="">Type <small style="color:red;">Perusahaan / perorangan</small></label>
<select name='type' id='type' class='form-control input-sm' style='cursor: pointer;'>
<option value=''>-- Pilih Type Peminjam --</option>
<option value='Perusahaan'>Perusahaan</option>
<option value='Perorangan'>Perorangan</option>
</select>
</div>
<div class='form-group'>
	<label class="control-label">Alamat</label>
	<textarea name='alamat' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group required'>
<label class="control-label" for="">Telp</label>
<input type='text' name='telp_peminjam' placeholder="Telp Peminjam" class='form-control'>
</div>
<div class='form-group'>
<label class="control-label" for="">Jaminan  <small style="color:red;">Sertifikat etc</small></label>
<input type='file' name='file_jaminan' class='form-control'>
</div>
<div class='form-group'>
<label class="control-label" for="">Dokumen Perjanjian Hutang </label>
<input type='file' name='file_perjanjian' class='form-control'>
</div>

<div class="clearfix"></div>
</td>
  
  
  
  
  
  
  
  
  
  
    <td width="55%">
	<h4>
	<span class="badge badge-warning"><i class="fa fa-info fa-fw"></i></span> Keterangan Pinjaman</h4>
	<hr>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Kode Pinjaman</label>
<div class="col-md-7">
	<input type='text' name='kode_pinjam' class='form-control' value='<?php echo $kode; ?>' readonly>
	
	
</div>
</div>
<div class="clearfix"></div>
<p>
 <?php foreach($jenis->result() as $p)
			{ ?>

		
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Jumlah Pinjaman</label>
	<div class="col-md-7">
	<input type='hidden' name='maks_pinjam' class='form-control' value='<?php echo $p->maks_pinjam ;?>' readonly>
	<input type='hidden' name='kode_jenis_pinjam' class='form-control' value='<?php echo $p->kode_jenis_pinjam ;?>' readonly>
	<input type="text" name="besar_pinjaman" id="besar_pinjaman" class="form-control duit" autocomplete="off" placeholder="Jumlah Pinjaman" required=""/>
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Lama Angsuran</label>
	<div class="col-md-7">
		<div class="input-group">		  
		  <input type="number" name="lama_angsuran" id="lama_angsuran" class="form-control " autocomplete="off" placeholder="Lama Angsuran" required="" value="<?php echo $p->lama_angsuran ;?>" step="1" readonly>
		  <span class="input-group-addon" id="">Kali</span>
		</div>		
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Bunga</label>
	<div class="col-md-7">
		<div class="input-group">		  
		  <input type="number" name="bunga" id="" class="form-control " autocomplete="off" placeholder="Bunga Pinjaman" required="" value="<?php echo $p->bunga ;?>" step="0.1" readonly>
		  <span class="input-group-addon" id="">%</span>
		</div>		
	</div>
</div>
<div class="clearfix"></div>
	<?php } ?>
</td>

  </tr>
</table>
 
 
 

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
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
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahbahan').each(function(){
					this.reset();
				});
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanTambahbahan'>Simpan Data</button>";
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