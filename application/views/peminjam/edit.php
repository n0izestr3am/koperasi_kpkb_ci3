<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('peminjam/edit-klien/'.$anggota->id_klien, array('id' => 'FormEditHalaman'));

 ?>
 
  <div class='form-group required'>
<label class="control-label" for="">Nama </label>
<input type='text' id='nama' name='nama'  class='form-control' value="<?php echo html_escape($anggota->nama); ?>">

</div>


<div class='form-group'>
	<label class="control-label">Alamat</label>
	<textarea name='alamat_debitur' class='form-control' placeholder="Alamat" style='resize:vertical;'><?php echo html_escape($anggota->alamat); ?></textarea>
</div>
<div class='form-group required'>
<label class="control-label" for="">Telp</label>
<input type='text' name='telp_peminjam' placeholder="Telp Peminjam" class='form-control' value="<?php echo html_escape($anggota->telp); ?>">
</div>
<div class='form-group required'>
<label class="control-label" for="">Type <small style="color:red;">Perusahaan / Personal</small></label>

<select name='typex' id='' class='form-control input-sm' style='cursor: pointer;'>
<option value="P0006" <?php if($anggota->type == 'P0006') { echo 'selected'; } ?>>Personal</option>	
<option value="P0005" <?php if($anggota->type == 'P0005') { echo 'selected'; } ?>>Perusahaan</option>	


</select>
</div>




<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditHalaman()
{
	$.ajax({
		url: $('#FormEditHalaman').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditHalaman').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 2000);
				setTimeout(function(){ location.reload(); }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanEditHalaman'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditHalaman").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditHalaman').click(function(e){
		e.preventDefault();
		EditHalaman();
	});

	$('#FormEditHalaman').submit(function(e){
		e.preventDefault();
		EditHalaman();
	});
});
</script>