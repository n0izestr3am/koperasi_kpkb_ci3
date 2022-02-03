<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('setting/tambah-pinjaman', array('id' => 'FormTambahMerek')); 
$kode = $this->M_setting->getKodePinjaman();
?>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Kode Pinjaman</label>
<div class="col-md-7">
	<input type='text' name='kode_jenis_pinjam' class='form-control' value='<?php echo $kode; ?>' readonly>
</div>
</div>
<div class="clearfix"></div>
<p>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Nama Pinjaman</label>
<div class="col-md-7">
	<input type='text' name='nama_pinjaman' placeholder="Nama Pinjaman" class='form-control'>
</div>
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Max Pinjaman</label>
	<div class="col-md-7">
	<input type="text" name="maks_pinjam" id="maks_pinjam" class="form-control duit" autocomplete="off" placeholder="Max Pinjaman" required="" value="<?php echo set_value('maks_pinjam'); ?>"/>
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Lama Angsuran</label>
	<div class="col-md-5">
		<div class="input-group">		  
		  <input type="number" name="lama_angsuran" id="lama_angsuran" class="form-control " autocomplete="off" placeholder="Lama Angsuran" required="" value="<?php echo set_value('lama_angsuran',0); ?>" step="1"/>
		  <span class="input-group-addon" id="">Kali</span>
		</div>		
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Bunga</label>
	<div class="col-md-5">
		<div class="input-group">		  
		  <input type="number" name="bunga" id="" class="form-control " autocomplete="off" placeholder="Bunga Pinjaman" required="" value="<?php echo set_value('bunga',0); ?>" step="0.1"/>
		  <span class="input-group-addon" id="">%</span>
		</div>		
	</div>
</div>
<div class="clearfix"></div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahMerek()
{
	$.ajax({
		url: $('#FormTambahMerek').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahMerek').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahMerek').each(function(){
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
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanTambahMerek'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahMerek").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahMerek').click(function(e){
		e.preventDefault();
		TambahMerek();
	});

	$('#FormTambahMerek').submit(function(e){
		e.preventDefault();
		TambahMerek();
	});
});
</script>