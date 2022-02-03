<?php echo form_open('halaman/tambah-halaman', array('id' => 'FormTambahHalaman')); ?>
<div class='form-group'>
	<input type='text' name='judul' class='form-control'>
</div>
<div class='form-group'>
	<label>Isi</label>
	<textarea name='isi' class='form-control' style='resize:vertical;'></textarea>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahHalaman()
{
	$.ajax({
		url: $('#FormTambahHalaman').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahHalaman').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahHalaman').each(function(){
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
	var Tombol = "<button type='button' class='btn btn-danger' id='SimpanTambahHalaman'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahHalaman").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahHalaman').click(function(e){
		e.preventDefault();
		TambahHalaman();
	});

	$('#FormTambahHalaman').submit(function(e){
		e.preventDefault();
		TambahHalaman();
	});
});
</script>