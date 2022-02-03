<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}




?>

<?php echo form_open('transaksi/wajib/'.$anggota->kode_anggota, array('id' => 'FormEditHalaman')); ?>
<div class="form-group">
           <label class="col-sm-5 control-label">Kode Anggota</label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type="text" name="kode_anggota" class="form-control" size="54" value="<?php echo $anggota->kode_anggota;?>" readonly />
        </div>
        </div>

<div class='form-group'>
<label class="col-sm-5 control-label">Nama Anggota</label>
<div style="padding:2px;" class="col-sm-7">
	<?php
	echo form_input(array(
		'name' => 'judul', 
		'class' => 'form-control',
		'value' => $anggota->nama
	));
	?>
</div>
</div>
<div class='form-group'>
<label class="col-sm-5 control-label">Jumlah Simpanan Wajib</label>
<div style="padding:2px;" class="col-sm-7">
	<?php
	echo form_input(array(
		'name' => 'besar_simpanan', 
		'class' => 'form-control',
		'value' => $simp->besar_simpanan
	));
	?>
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
<?php
date_default_timezone_set("Asia/Jakarta");
$jenis_simpan=$simp->nama_simpanan;
if($jenis_simpan=='wajib')
{
    $baru = $this->db->query("SELECT * FROM simpanan where kode_anggota='$kode' and jenis_simpan='wajib' order by kode_simpan desc");
    $row = $baru->row();
    $total = $baru->num_rows();
	$data=$row->tgl_mulai;
	
	if($ambil<=0)
	{
	$mulai=date("Y-m-d");
	$banding=date('Y-m-d',strtotime('+7 day',strtotime($mulai)));
	
	}
	else if($ambil>0)
	{
	$mulai=$data;
	$banding=date('Y-m-d',strtotime('+7 day',strtotime($mulai)));
	
	}
}
else
{
	$banding=date("Y-m-d");
	
	
}


?>
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
				 setTimeout(function(){ location.reload(); }, 5000);
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