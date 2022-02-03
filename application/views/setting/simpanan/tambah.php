<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('setting/tambah-simpanan', array('id' => 'FormTambahMerek')); 
$kode = $this->M_setting->getKodeSimpanan();
?>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Kode Simpanan</label>
<div class="col-md-7">
	<input type='text' name='kode_jenis_simpan' class='form-control' value='<?php echo $kode; ?>' readonly>
</div>
</div>
<div class="clearfix"></div>
<p>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Nama Simpanan</label>
<div class="col-md-7">
	<input type='text' name='nama_simpanan' placeholder="Nama Pinjaman" class='form-control'>
</div>
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Besar Simpanan</label>
	<div class="col-md-7">
	<input type="text" name="besar_simpanan" id="besar_simpanan" class="form-control duit" autocomplete="off" placeholder="Besar Simpanan" required="" value="<?php echo set_value('besar_simpanan'); ?>"/>
	</div>
</div>
<div class="clearfix"></div>
<p>

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