<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}


$banding=date("Y-m-d");

?>
<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open('transaksi/sukarela/'.$anggota->kode_anggota, array('id' => 'FormEditHalaman')); ?>
<div class="form-group">
           <label class="col-sm-5 control-label">Kode Anggota</label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type="text" name="kode_anggota" id="kode_anggota" class="form-control" size="54" value="<?php echo $anggota->kode_anggota;?>" readonly />
        </div>
        </div>
<div class="form-group">
           <label class="col-sm-5 control-label">Nama </label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type="text" name="nama" id="nama" class="form-control" size="54" value="<?php echo $anggota->nama;?>" readonly />
            <input type="hidden" name="alamat" id="alamat" class="form-control" value="<?php echo $anggota->alamat;?>">
        </div>
        </div>

<div class='form-group'>
<label class="col-sm-5 control-label">Jumlah Simpanan Sukarela</label>
<div style="padding:2px;" class="col-sm-7">
<input type="text" name="besar_simpanan" id="besar_simpanan" class="form-control duit">
<input type="hidden" name="jenis_simpan" id="jenis_simpan" value="Sukarela">
	
</div>
</div>

<div style="padding:2px;" class="form-group">
									<label class="col-sm-4 control-label">Staff</label>
									<div style="padding:2px;" class="col-sm-8">
										<select name='id_user' id='id_user' class='form-control input-sm' <?php echo $disabled; ?>>
											<?php
											if($kasirnya->num_rows() > 0)
											{
												foreach($kasirnya->result() as $k)
												{
													$selected = '';
													if($k->id_user == $this->session->userdata('ap_id_user')){
														$selected = 'selected';
													}

													echo "<option value='".$k->id_user."' ".$selected.">".$k->nama."</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
			
				<div class='clearfix'></div>				

 <input type="hidden" name="tgl_mulai" value="<?php echo $banding; ?>" />
<?php echo form_close();?>

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
				
			 $('#Notifikasi').html('Sukses Update Data');
			 $("#Notifikasi").fadeIn('fast').show().delay(5000).fadeOut('fast');	
			 $("#Cetaks").show();
			 
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
var Tombol = "<button type='button' class='btn btn-danger' id='Cetaks'><i class='fa fa-print'></i> Cetak Nota Pinjaman</button>";
	Tombol += "<button type='button' class='btn btn-success'  id='SimpanEditHalaman'>Update Data</button>";
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


$("#Cetaks").hide(); 
$(document).on('click', 'button#Cetaks', function(){
	CetakStruk();
	setTimeout(function(){ 
			 
			 location.reload();
               
			 }, 3000);
});	
function CetakStruk()
{
	
			window.open("<?php echo site_url('cetak/sukarela/'); ?>");
	
}

</script>