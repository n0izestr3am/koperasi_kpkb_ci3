<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('setting/tambah-kas', array('id' => 'FormTambahMerek')); 
$kode = $this->M_setting->getKodePinjaman();
?>


<div class="form-group required">
	<label class="control-label" for="">Jumlah Dana</label>
	
	<input type="text" name="jumlah" id="jumlah" class="form-control duit" autocomplete="off" placeholder="Masukan jumlah Dana" required="" value="<?php echo set_value('jumlah'); ?>"/>
	
</div>
<div class="clearfix"></div>
<p>

<div class="form-group required">
	<label>Keterangan / Asal Sumber Dana</label>
	<textarea name='keterangan' class='form-control' style='resize:vertical;'></textarea>
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