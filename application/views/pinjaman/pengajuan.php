<!-- PINJAMAN -->
<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
	<script language="JavaScript">
	$('#kode_jenis_pinjam').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('transaksi/ajax-pinjam'); ?>",
				type: "POST",
				cache: false,
				data: "kode_jenis_pinjam="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_pinjaman').html(json.nama_pinjaman);
					$('#lama_angsuran').html(json.lama_angsuran);
					$('#maks_pinjam').html(json.maks_pinjam);
					$('#bunga').html(json.bunga);
					
				}
			});
		}
		else
		{
			$('#nama_pinjaman').html('<small><i>Tidak ada</i></small>');
			$('#lama_angsuran').html('<small><i>Tidak ada</i></small>');
			$('#maks_pinjam').html('<small><i>Tidak ada</i></small>');
			$('#bunga').html('<small><i>Tidak ada</i></small>');
			
		}
	});
	
	
		// fungsi untuk get besar_simpanan
	function ambil_pinjaman(kode_jenis_pinjam){
		$.ajax({
			type : "POST",
			data : "kode_jenis_pinjam="+kode_jenis_pinjam,
			url : "<?php echo site_url('transaksi/ajax-pinjaman'); ?>",
			success : function(msg){
				hasil = jQuery.parseJSON(msg);
				if(hasil.nama_pinjaman!=""){
					$('#lama_angsuran').val(hasil.lama_angsuran);
					
				}else{		
					$('#lama_angsuran').val("");
					
				}
			}
		})
	}
	// menghitung pinjaman
		function startCalc(){
			interval = setInterval("calc()",1);
		}
	//menghitung ansuran
		function calc(){
			a = document.frmAdd.besar_pinjaman.value;
			f = document.frmAdd.bunga.value/100;
			e = document.frmAdd.maks_pinjam.value;
			b = document.frmAdd.lama_angsuran.value;
			g = a * f;
			i = a / b;
			h = parseInt(g)+parseInt(i);
			c = document.frmAdd.besar_angsuran.value = h ;
		} 
		function stopCalc(){
			clearInterval(interval);
		} 
	</script>

<?php
$level 		= $this->session->userdata('ap_level');


$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}

$kode = $this->M_pinjaman->getKodeAng();


?>

<?php echo form_open('pinjaman/ajukan-pinjaman/'.$anggota->kode_anggota, array('id' => 'FormEditHalaman')); ?>

<div class="form-group">
           <label class="col-sm-5 control-label">Kode Pinjaman</label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type='text' name='kode_pinjam' class='form-control' value='<?php echo $kode; ?>' readonly>
        </div>
        </div>


<div class="form-group">
           <label class="col-sm-5 control-label">Kode Anggota</label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type="text" name="kode_anggota" class="form-control" size="54" value="<?php echo $anggota->kode_anggota;?>" readonly />
        </div>
        </div>
<div class="form-group">
           <label class="col-sm-5 control-label">Nama Anggota</label>
		   <div style="padding:2px;" class="col-sm-7">
            <input type="text" name="nama" class="form-control" size="54" value="<?php echo $anggota->nama;?>" readonly />
        </div>
        </div>

<div class="form-group">
									<label class="col-sm-5 control-label">Jenis Pinjaman</label>
									<div style="padding:2px;" class="col-sm-7">
<select name='kode_jenis_pinjam' id='kode_jenis_pinjam' class='form-control input-sm' style='cursor: pointer;'>
<option value=''>-- Pilih jenis Pinjaman --</option>
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
							</div>
							<div class='clearfix'></div>
<div class="form-group">
           <label class="col-sm-5 control-label">Lama Angsuran (Bulan)</label>
		   <div style="padding:2px;" class="col-sm-7">
		   
            <div style="font-weight:bold;" id='lama_angsuran'><small><i>Belum dipilih</i></small></div>
        </div>
        </div>
		<div class='clearfix'></div>
	<div class="form-group">
           <label class="col-sm-5 control-label">Maks Pinjaman</label>
		   <div style="padding:2px;" class="col-sm-7">
            <div style="font-weight:bold;" id='maks_pinjam'><small><i>Belum dipilih</i></small></div>
        </div>
        </div>						
			<div class='clearfix'></div>				
		<div class="form-group">
           <label class="col-sm-5 control-label">Bunga (%)</label>
		   <div style="padding:2px;" class="col-sm-7">
            <div style="font-weight:bold;" id='bunga'><small><i>Belum dipilih</i></small></div>
        </div>
        </div>		
<div class='clearfix'></div>
<div class="form-group">
           <label class="col-sm-5 control-label">Besar Pinjaman </label>
		   <div style="padding:2px;" class="col-sm-7">
	<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp.</span>
     <input type="text" name="besar_pinjaman" id="besar_pinjaman" class="form-control duit" autocomplete="off" placeholder="Jumlah Pinjaman" required=""/>
  </div>

            
        </div>
        </div>
	
<div class='clearfix'></div>	


		
<div class="form-group">
									<label class="col-sm-5 control-label">Staff</label>
									<div style="padding:2px;" class="col-sm-7">
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
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanEditHalaman'>Ajukan Pinjaman</button>";
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