<?php echo form_open('pinjaman/tambah-klien', array('id' => 'FormTambahKlien')); ?>
 <div class='form-group required'>
<label class="control-label" for="">Nama </label>
<input type='text' name='nama' placeholder="Nama Peminjam" class='form-control'>
</div>


<div class='form-group'>
	<label class="control-label">Alamat</label>
	<textarea name='alamat' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group required'>
<label class="control-label" for="">Telp</label>
<input type='text' name='telp_peminjam' placeholder="Telp Peminjam" class='form-control'>
</div>
<div class='form-group required'>
<label class="control-label" for="">Type <small style="color:red;">Perusahaan / Personal</small></label>

<select name='type' id='' class='form-control input-sm' style='cursor: pointer;'>
<option value=''>-- Pilih Type Peminjam --</option>
<?php
									if($pinjaman->num_rows() > 0)
									{
										foreach($pinjaman->result() as $p)
										{
											echo "<option value='".$p->kode_jenis_pinjam."'>".ucfirst($p->nama_pinjaman)."</option>";
										}
									}
									?>
</select>
</div>



<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
jQuery.noConflict();
(function( $ ) {
function TambahKlien()
{
	$.ajax({
		url: $('#FormTambahKlien').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahKlien').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				 setTimeout(function(){ location.reload(); }, 1000);

			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanTambahKlien'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahKlien").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahKlien').click(function(e){
		e.preventDefault();
		TambahKlien();
	});

	$('#FormTambahKlien').submit(function(e){
		e.preventDefault();
		TambahKlien();
	});
});
})(jQuery);
</script>