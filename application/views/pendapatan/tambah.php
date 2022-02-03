<?php echo form_open('bahan/tambah-bahan', array('id' => 'FormTambahbahan')); ?>
<div class='form-group'>
	<input type='text' name='nama' class='form-control'>
</div>
<div class='form-group'>
	<label>Isi</label>
	<textarea name='isi' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group'>
<label>Stok </label>
	<input type='text' name='stok' class='form-control'>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function Tambahbahan()
{
	$.ajax({
		url: $('#FormTambahbahan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahbahan').serialize(),
		dataType:'json',
		success: function(json){
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
	var Tombol = "<button type='button' class='btn btn-danger' id='SimpanTambahbahan'>Simpan Data</button>";
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