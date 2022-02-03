<?php echo form_open('halaman/edit-halaman/'.$halaman->id_halaman, array('id' => 'FormEditHalaman')); ?>
<div class='form-group'>
	<?php
	echo form_input(array(
		'name' => 'judul', 
		'class' => 'form-control',
		'value' => $halaman->judul
	));
	?>
</div>
<div class='form-group'>
	<label>Keterangan</label>
	<?php
	echo form_textarea(array(
		'name' => 'isi', 
		'class' => 'form-control',
		'value' => $halaman->isi,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
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
	var Tombol = "<button type='button' class='btn btn-danger' id='SimpanEditHalaman'>Update Data</button>";
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