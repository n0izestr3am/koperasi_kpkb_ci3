<?php echo form_open('setting/unit-edit/'.$unit->id_unit_kerja, array('id' => 'FormEditMerek')); ?>
<div class='form-group'>
	<?php
	echo form_input(array(
		'name' => 'unit_kerja', 
		'class' => 'form-control',
		'value' => $unit->unit_kerja
	));
	?>
</div>
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