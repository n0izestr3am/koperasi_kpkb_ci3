<style>


.table3 {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

.table3 th,
.table3 td {
	padding: 12px;
	text-align: center;
	border-bottom: 1px solid #FFFFFF;
	background-color: #FFFFFF;
}

.table3 th {
  white-space: nowrap;        
  font-weight: normal;
}

.table3 td {
  text-align: left;
}
</style>

<script src="<?php echo config_item('js'); ?>kpkb.js"></script>
<?php echo form_open_multipart('anggota/tambah-anggota', array('id' => 'FormTambahbahan'));
$kode = $this->M_Anggota->getKode();
$id_user 		= $this->session->userdata('ap_id_user');
$tanggal 		= date('Y-m-d');
 ?>
 <input type='hidden' name='user' class='form-control' value='<?php echo $id_user; ?>'>
 <input type='hidden' name='tgl' class='form-control' value='<?php echo $tanggal; ?>'>
 <table width="100%" class="table3" border="0">
  <tr>
  <td width="55%">
 <div class="col-md-3"> 
 <div class='form-group'>
<label class="control-label" for="">Kode Anggota </label>
<input type='text' id='kode_anggota' name='kode_anggota'  class='form-control' value='<?php echo $kode; ?>'readonly>

</div> 
</div> 
<div class="col-md-9">
<div class='form-group required'>
<label class="control-label" for="">Nama Anggota </label>
<input type='text' name='nama' placeholder="Nama Anggota" class='form-control'>
</div>
</div>
<div class="col-md-12">
<div class='form-group'>
	<textarea name='alamat' class='form-control' placeholder="Alamat" style='resize:vertical;'></textarea>
</div>
</div>
<div class="col-md-7">
<div class='form-group'>
     <div class="input-group">
    <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
     <input  class="form-control" type="text" name="tempat_lahir" placeholder="Tempat Lahir"/>
  </div>
  </div>
  </div>
<div class="col-md-5">
<div class='form-group'>
     <div class="input-group">
    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
     <input id="tanggal" class="form-control" type="text" name="tanggal_lahir" value="<?php echo $tanggal; ?>"/>
  </div>
  </div>
  </div>
  
 <div class="clearfix"></div>

<div class="col-md-7">
	<div class='form-group'>
 <label>N I P</label>
<div class="input-group">
    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
     <input name="nip" placeholder="Ketik No Induk Pegawai" class="form-control"  />
  </div>
</div>
  </div>
<div class="col-md-5">
	<div class='form-group'>
 <label>Gaji Bersih</label>
<div class="input-group">
    <span class="input-group-addon">Rp</span>
     <input id="gaji" name="gaji" id="harga" class="form-control duit"  />
  </div>
</div>
  </div>


<div class="clearfix"></div>





<div class="col-md-4">
<div class="form-group">
<label>Jenis Kelamin</label></br>

                <label class="radio-inline">
    <input type="radio" name="jenis_kelamin" value="Pria" checked>Pria
    </label>
              <label class="radio-inline">
               <input type="radio" name="jenis_kelamin" value="Wanita">Wanita
               </label>
        </div>
        </div>
<div class="col-md-8">
<div class='form-group required'>
<label class="control-label" for="">Telp Anggota </label>
<div class="input-group">
    <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
     <input id="no_telp" placeholder="Telp Anggota"  class="form-control" type="text" name="no_telp" />
  </div>
</div>
</div>

 <div class="clearfix"></div>
 
 <div class="col-md-8">
<div class="form-group">
<label class="control-label" for="">AHLI WARIS </label>
<div class="input-group">
    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
     <input id="nama_ahli_waris" placeholder="Nama Ahli Waris"  class="form-control" type="text" name="nama_ahli_waris" />
  </div>
        </div>
        </div>
<div class="col-md-4">
<div class="form-group">
           <label>HUB / AHLI WARIS</label></br>
          <select class="form-control" name="ahli_waris">
          <option value="">--Pilih--</option>
          <?php
		  $pilihan	= array("istri / Suami", "Anak", "Orang Tua", "Lain-lain");
          foreach ($pilihan as $nilai) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
        </div>
</div>

 <div class="clearfix"></div>
 
 
 

</td>
  
  
  
  
  
  
  
  
  
  
    <td width="45%">
	<br>
	
	 <div class="col-md-8">
		<div class="form-group">
           <label>UNIT KERJA</label>
        <select class="form-control" name="unit_kerja">
          <option value="">--Pilih--</option>
         <?php
									if($unit->num_rows() > 0)
									{
										foreach($unit->result() as $p)
										{
											echo "<option value='".$p->id_unit_kerja."'>".$p->unit_kerja."</option>";
										}
									}
									?>
        </select>
        </div>								
        </div>	
		
		
<div class="col-md-4">
		<div class="form-group">
           <label>GOLONGAN</label>
        <select class="form-control" name="golongan">
          <option value="">--Pilih--</option>
          <?php
		   $pilihan	= array("4C", "4D", "4A", "3D", "3C");
          foreach ($pilihan as $nilai) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
        </div>								
        </div>		




<div class="clearfix"></div>
			
<div class="doc">
<br>
<br>

<div class="col-md-6">
	<div class='form-group'>
 <label>Administrasi</label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
     <input id="admin" name="admin" class="form-control duit" value="2000" />
  </div>
</div>
</div>
 

<div class="col-md-6">
	<div class='form-group'>
 <label><?php echo ''.$pokok->nama_simpanan.'' ;?></label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
  <input name="besar_simpanan[]" id="harga" class="form-control duit" value="<?php echo ''.$pokok->besar_simpanan.'' ;?>" readonly>
   <input type="hidden" name="jenis_simpan[]" value="<?php echo ''.$pokok->nama_simpanan.'' ;?>"  />
  <input type='hidden' name='kode[]' value='<?php echo $kode; ?>'>
  </div>
</div>
</div>

<div class="col-md-6">
	<div class='form-group'>
 <label><?php echo ''.$wajib->nama_simpanan.'' ;?></label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
  <input name="besar_simpanan[]" class="form-control duit" value="<?php echo ''.$wajib->besar_simpanan.'' ;?>"  readonly>
  <input type="hidden" name="jenis_simpan[]" value="<?php echo ''.$wajib->nama_simpanan.'' ;?>"  />
  <input type='hidden' name='kode[]' value='<?php echo $kode; ?>'>
  </div>
</div>
</div>

<div class="col-md-6">
	<div class='form-group'>
 <label><?php echo ''.$sukarela->nama_simpanan.'' ;?></label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
  <input name="besar_simpanan[]" id="harga" class="form-control duit" value="<?php echo ''.$sukarela->besar_simpanan.'' ;?>" />
  <input type="hidden" name="jenis_simpan[]" value="<?php echo ''.$sukarela->nama_simpanan.'' ;?>"/>
 <input type='hidden' name='kode[]' value='<?php echo $kode; ?>'>
  </div>
</div>
</div>

<div class="col-md-6">
	<div class='form-group'>
 <label><?php echo ''.$juli->nama_simpanan.'' ;?></label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
  <input name="besar_simpanan[]" id="harga" class="form-control duit" value="<?php echo ''.$juli->besar_simpanan.'' ;?>" />
   <input type="hidden" name="jenis_simpan[]" value="<?php echo ''.$juli->nama_simpanan.'' ;?>"  />
  <input type='hidden' name='kode[]' value='<?php echo $kode; ?>'>
  </div>
</div>
</div>





<div class="col-md-6">
	<div class='form-group'>
 <label>Dana Kecelakaan </label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
     <input id="dk" name="dk" class="form-control duit" value="1500" />
  </div>
</div>
</div>
<div class="clearfix"></div>

<div class="col-md-6">
	<div class='form-group'>
 <label>Iuran Kematian</label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
     <input id="ik" name="ik" class="form-control duit" value="3500" />
  </div>
</div>
</div>

<div class="col-md-6">
		<div class='form-group'>
 <label>K T A </label>
<div class="input-group">
    <span class="input-group-addon bg-hijau">Rp</span>
     <input id="kta" name="kta" class="form-control duit" value="3500" />
  </div>
</div>				
</div>				
	<div class="clearfix"></div>
</div>
							
</td>

  </tr>
  
  
  
</table>
 
 
 

<?php echo form_close(); ?>

<div id='ResponseInput'></div>
<script>

$('#tanggal').datetimepicker({
	lang:'id',
	yearStart: 1970,
	yearEnd: 2010,
	timepicker:false,
	format:'Y-m-d'

});

$('#log_cp2_dob').datetimepicker({
	lang:'id',
	timepicker:false,
	format:'Y-m-d'

});

</script>
<script>

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
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
                $("#Cetaks").show(); 
				$("#SimpanTambahbahan").hide(); 
				/* $('#FormTambahbahan').each(function(){
					this.reset();
				});
				 */
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanTambahbahan'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	Tombol += "<button type='button' class='btn btn-danger' id='Cetaks'><i class='fa fa-print'></i> Cetak Nota Registrasi</button>";
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

$("#Cetaks").hide(); 
$(document).on('click', 'button#Cetaks', function(){
	CetakStruk();
});	
function CetakStruk()
{
	var FormData = "kode_anggota="+encodeURI($('#kode_anggota').val());
			FormData += "&dk="+$('#dk').val();
			FormData += "&admin="+$('#admin').val();
			FormData += "&ik="+$('#ik').val();
			FormData += "&kta="+$('#kta').val();
			
			window.open("<?php echo site_url('anggota/cetak/?'); ?>" + FormData,'_blank');
	
}
</script>