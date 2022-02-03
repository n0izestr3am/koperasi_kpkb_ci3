<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('setting/pinjaman-edit/'.$data->kode_jenis_pinjam, array('id' => 'FormEditMerek')); 
$id_user 		= $this->session->userdata('ap_id_user');
?>

<div class='form-group required'>
<label class="col-sm-5 control-label" for="">Nama Pinjaman</label>
<div class="col-md-7">
<input type='text' name='nama_pinjaman' value="<?php echo $data->nama_pinjaman ;?>" class='form-control'>

<input type='hidden' name='user' value="<?php echo $id_user ;?>" class='form-control'>
</div>
</div>
<div class="clearfix"></div>
<br>
<div class="form-group">
	<label class="col-sm-5 control-label" for="">Lama Angsuran</label>
	<div class="col-md-7">
		<div class="input-group">		  
		  <input type="number" name="lama_angsuran" id="lama_angsuran" class="form-control " autocomplete="off" placeholder="Lama Angsuran" required="" value="<?php echo $data->lama_angsuran ;?>" step="1">
		  <span class="bg-hijau input-group-addon" id="">Kali</span>
		</div>		
	</div>
</div>

<div class="clearfix"></div>
<br>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Bunga</label>
	<div class="col-md-7">
		<div class="input-group">		  
		  <input type="number" name="bunga" id="bunga" class="form-control " autocomplete="off" placeholder="Bunga Pinjaman" required="" value="<?php echo $data->bunga ;?>" step="0.1">
		  <span class="bg-hijau input-group-addon" id="">%</span>
		</div>		
	</div>
</div>
<div class="clearfix"></div>
<br>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Maximal Pinjaman</label>
	<div class="col-md-7">
	<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp.</span>
     <input type="text" name="maks_pinjam" id="maks_pinjam" class="form-control duit" autocomplete="off" value="<?php echo $data->maks_pinjam ;?>"/>
  </div>		
	</div>
</div>
<div class="clearfix"></div>
<br>

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
				 setTimeout(function(){ location.reload(); }, 3000);
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