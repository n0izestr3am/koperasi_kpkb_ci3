<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('setting/simpanan-edit/'.$data->kode_jenis_simpan, array('id' => 'FormEditMerek')); ?>
<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Nama Simpanan</label>
<div class="col-md-7">
	<input type='text' name='nama_simpanan'  class='form-control' value="<?php echo $data->nama_simpanan; ?>"/>
</div>
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Besar Pinjaman</label>
	<div class="col-md-7">
<input type="text" name="besar_simpanan" id="besar_simpanan" class="form-control duit" autocomplete="off"  value="<?php echo $data->besar_simpanan; ?>"/>
	</div>
</div>
<div class="clearfix"></div>
<p>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditMerek()
{
	$.ajax({
		url: $('#FormEditMerek').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditMerek').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanEditMerek'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditMerek").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditMerek').click(function(e){
		e.preventDefault();
		EditMerek();
	});

	$('#FormEditMerek').submit(function(e){
		e.preventDefault();
		EditMerek();
	});
});
</script>