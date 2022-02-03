<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<style>
.footer {
	margin-bottom: 22px;
}
.panel-primary .form-group {
	margin-bottom: 10px;
}
.form-control {
	border-radius: 0px;
	box-shadow: none;
}
.error_validasi { margin-top: 0px; }
</style>

<?php echo form_open_multipart('pinjaman/add', array('id' => 'FormTambahbahan'));
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}

$kode = $this->M_pinjaman->getKodeEks();
$id_user 		= $this->session->userdata('ap_id_user');

?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
			<div class='col-sm-12'>
				<h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Pinjaman <i class='fa fa-angle-right fa-fw'></i> Pengajuan Pinjaman Baru
						<a href="<?php echo site_url('pinjaman/add'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					<hr>
					
					<?php
foreach($kas as $res) {
echo "<div class=\"text-muted\">Total Kas Koperasi saat ini :  <b>Rp. ".Rp($res->total_kas)." </b><br>
<p style='color: red;line-height: 1;font-size: 12px;'>".terbilang($res->total_kas)." Rupiah</p></div>";
}?>	
				<hr>	
					
			</div>
			
				<div class='col-sm-5'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">No. Nota</label>
									<div class="col-sm-8">
										<input type='text' name='kode_pinjam' class='form-control input-sm' id='kode_pinjam' value="<?php echo $kode; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d'); ?>" <?php echo $disabled; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Staff</label>
									<div class="col-sm-8">
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
							</div>

						</div>
					</div>
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Informasi Peminjam</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Peminjam</label>
								<a href="<?php echo site_url('pinjaman/tambah-klien'); ?>" class='pull-right' id='TambahKlien'>Tambah Baru ?</a>
								<select name='id_klien' id='id_klien' class='form-control input-sm' style='cursor: pointer;'>
									<option value=''>-- Umum --</option>
									<?php
									if($klien->num_rows() > 0)
									{
										foreach($klien->result() as $p)
										{
											echo "<option value='".$p->id_klien."'>".$p->nama."</option>";
										}
									}
									?>
								</select>
							</div>

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">Telp / HP</label>
									<div class="col-sm-8">
										<div style="margin-top: 6px;" id='telp'><small><i>Peminjam belum di pilih</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Alamat</label>
									<div class="col-sm-8">
										<div style="margin-top: 6px;" id='alamat'><small><i>Peminjam belum di pilih</i></small></div>
									</div>
								</div>
								
							</div>

						</div>
					</div>
				</div>
				<div class='col-sm-6'>
				
						<label class="control-label" for=""><h4>Keterangan Pinjaman</h4></label><br>
	<div class='form-group required'>
<label class="control-label" for="">Type <small style="color:red;">Perusahaan / Personal</small></label>

<select name='kode_jenis_pinjam' id='type' class='form-control input-sm' style='cursor: pointer;'>
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

<div style="font-weight:bold; display:none;" id='nama_pinjaman'></div>
<div style="font-weight:bold;display:none;" id='maks_pinjam2'></div>
	<?php foreach($jenis->result() as $p)
			{ ?>
	
	<div class="form-group required">
<div class="col-md-5">
	<label class="control-label" for="">Jumlah Pinjaman</label><br>
	<div style="color: red;line-height: 1;font-size: 12px; font-weight:bold;" id='max'></div>
	
	</div>
	<div class="col-md-7">
	<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
   

	<input type="text" name="besar_pinjaman" id="besar_pinjaman" class="form-control duit" autocomplete="off" placeholder="Jumlah Pinjaman" required=""/>
  </div>
		
	</div>
</div>
<div class="clearfix"></div>
<p>


<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Lama Angsuran</label>
	<div class="col-md-7">
		
          <div id='lama_angsuran2'><small><i>Jenis Pinjaman belum di pilih</i></small></div>      		
		 
			
	</div>
</div>
<div class="clearfix"></div>
<p>
<div class="form-group required">
	<label class="col-sm-5 control-label" for="">Bunga</label>
	<div class="col-md-7">
	   <div id='bunga2'><small><i>Jenis Pinjaman belum di pilih</i></small></div>    
	</div>
</div>
<div class="clearfix"></div>
	<?php } ?>
<hr>	
	
<div class='form-group required'>
<label class="control-label" for="">Nama Jaminan</label>
<input type='text' name='jaminan' id='jaminan' placeholder="Contoh : Sertifikat / BPKB" class='form-control'>
</div>	
<div class='form-group'>
<label class="control-label" for="">Jaminan  <small style="color:red;">Upload Dokumen Jaminan : Sertifikat etc</small></label>
<input type='file' name='file_jaminan' id='file_jaminan' class='form-control'>
</div>
<div class='form-group'>
<label class="control-label" for="">Dokumen Perjanjian Hutang </label>
<input type='file' name='file_perjanjian' id='file_perjanjian' class='form-control'>
</div>

<div class="clearfix"></div>
<p>
 

		

					

					<div class='row'>
						<div class='col-sm-8'>
					
							<p><i class='fa fa-keyboard-o fa-fw'></i> <b>Jika sudah di lengkapi semua silahkan klik tombol Simpan : </b></p>
							
						</div>
						<div class='col-sm-3'>
							<div class="form-horizontal">
							
								<div class='row'>
									
								
										<button type='button' class='btn btn-success btn-block' id='SimpanTambahbahan'>
											<i class='fa fa-floppy-o'></i> Simpan 
										</button>
								
								</div>
							</div>
						</div>
					</div>

					<br />
				
					</div>
<div class="clearfix"></div>
<p>

					
				</div>
			</div>

		</div>
	</div>
</div>
<?php echo form_close(); ?>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('#id_klien').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('pinjaman/ajax-klien'); ?>",
				type: "POST",
				cache: false,
				data: "id_klien="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#telp').html(json.telp);
					$('#alamat').html(json.alamat);
				
				}
			});
		}
		else
		{
			$('#telp').html('<small><i>Peminjam belum di pilih</i></small>');
			$('#alamat').html('<small><i>Peminjam belum di pilih</i></small>');
		
		}
	});



$('#type').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('pinjaman/ajax-type'); ?>",
				type: "POST",
				cache: false,
				data: "kode_jenis_pinjam="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_pinjaman').html(json.nama_pinjaman);
					$('#maks_pinjam2').html(json.maks_pinjam2);
					$('#lama_angsuran2').html(json.lama_angsuran2);
					$('#bunga2').html(json.bunga2);
					$('#max').html(json.max);
				
					
				}
			});
		}
		else
		{
			$('#nama_pinjaman').html('<small><i>Jenis Pinjaman belum di pilih</i></small>');
			$('#lama_angsuran2').html('<small><i>Jenis Pinjaman belum di pilih</i></small>');
			$('#bunga2').html('<small><i>Jenis Pinjaman belum di pilih</i></small>');
			$('#maks_pinjam2').html('<small><i>Jenis Pinjaman belum di pilih</i></small>');
			$('#max').html('<small><i>Jenis Pinjaman belum di pilih</i></small>');
			
			
		}
	});
 




function Tambahbahan()
{
	$.ajax({
		url: $('#FormTambahbahan').attr('action'),
		type: "POST",
		data: new FormData($('#FormTambahbahan')[0]),
        processData: false,
        contentType: false,
		cache: false,
		mimeType:'multipart/form-data',
		dataType:'json',success: function(json){
			if(json.status == 1){ 
			    alert(json.pesan);
				window.location.href="<?php echo site_url('pengajuan'); ?>";
				//setTimeout(function(){ location.reload(); }, 3000)
				//$("#CetakStruk").show(); 
			}
			else {
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(json.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-success' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
				
			}
		}
	});
}


$(document).on('click', '#TambahKlien', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Peminjam');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});



$(document).ready(function(){
	

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


//$("#CetakStruk").hide(); 
$(document).on('click', 'button#CetakStruk', function(){
	CetakStruk();
});
function CetakStruk()
{
	if($('#besar_pinjaman').val() > 0)
	{
		if($('#id_klien').val() !== '')
		{
			var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_klien="+$('#id_klien').val();
			FormData += "&besar_pinjaman="+$('#besar_pinjaman').val();
			window.open("<?php echo site_url('pinjaman/cetak-nota/?'); ?>" + FormData,'_blank');
		}
		else
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap masukan Total Bayar');
			$('#ModalFooter').html("<button type='button' class='btn btn-danger' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		}
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap Lengkapi Pengajuan terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-success' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}
</script>
<?php $this->load->view('include/footer2'); ?>
