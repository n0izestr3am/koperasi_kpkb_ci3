


<!-- ANGSURAN -->

<?php
$level 		= $this->session->userdata('ap_level');
$id 		= $this->session->userdata('ap_id_user');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
	
}

$kode	          = $master->kode_anggota;
$kode_pinjam	  = $master->kode_pinjam;


$kp = $this->db->query("select* from angsuran where kode_pinjam='$kode_pinjam'");
$total = $kp->num_rows();
$tgl_tempo          = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->tgl_tempo;
?>

<?php echo form_open('transaksi/angsuran/'.$master->kode_anggota, array('id' => 'FormEditHalaman')); ?>
 <div class="row-fluid">
      <div class="col-sm-6">
<table class="table" width="100%">
      <tr>
      <td style="width:40%;" >Kode Anggota</td>
      <td>
	 <input type="text" name="kode_anggota" class="form-control" size="54" value="<?php echo $master->kode_anggota;?>" readonly />
      </td>
    
	 <tr id=''>
      <td>Nama Anggota</td>
      <td>
    <input type="hidden" name="nama" class="form-control" size="54" value="<?php echo $master->nama;?>" readonly />
	<?php echo $master->nama;?>
      </td>
    </tr>
	 <tr id=''>
      <td>Kode Pinjaman</td>
      <td>
   <input type="text" name="kode_pinjam" class="form-control" size="54" value="<?php echo $master->kode_pinjam;?>" readonly />
      </td>
    </tr>
	
	<tr id=''>
      <td>Tanggal Pinjaman</td>
      <td>
     <input type="hidden" name="tgl_entri" class="form-control" size="54" value="<?php echo $master->tgl_entri;?>" readonly />
	 <?php echo tanggal($master->tgl_entri);?>
      </td>
    </tr>
	<tr id=''>
      <td>Pinjaman</td>
      <td>
     <input type="hidden" name="tgl_entri" class="form-control" size="54" value="<?php echo $master->besar_pinjam;?>" readonly />
	 <?php echo Rp($master->besar_pinjam);?>
      </td>
    </tr>
	<tr id=''>
      <td>Lama Angsuran</td>
      <td>
    <input type="hidden" class="form-control" name="lama_angsuran" value="<?php echo $master->lama_angsuran;?>" id="lama_angsuran" size="54" readonly />
	<?php echo $master->lama_angsuran;?> Kali
      </td>
    </tr>
	<tr id=''>
      <td>Besar Angsuran</td>
      <td>
    <input type="hidden" name="besar_angsuran" class="form-control" size="54" value="<?php echo $master->besar_angsuran;?>" readonly />
	Rp. <?php echo Rp($master->besar_angsuran);?>
      </td>
    </tr>
	<tr id=''>
      <td>Angsuran Ke</td>
      <td>
    <input type="hidden" name="angsuran_ke" class="form-control" size="54" value="<?php echo $total+1;?>" readonly />
    Angsuran Ke <b><?php echo $total+1;?></b> dari <b><?php echo $master->lama_angsuran;?></b> Kali Angsuran
      </td>
    </tr>
	
	
	<?php 	

$kk = $this->db->query("SELECT * from pinjaman where kode_pinjam='$kode_pinjam' and kode_anggota='$kode'")->row_array();
$tempo=$kk['tgl_tempo'];
$dat=date("Y-m-d");
if($dat>$tempo)
{
	$go=round($telat=((abs(strtotime($dat)-strtotime($tempo)))/(60*60*24))); $denda=$go * 1000;?>
	<tr id=''>
      <td>Denda</td>
      <td>
    <input type="text" class="form-control" name="denda" value="<?php echo $denda; ?>" readonly>
      </td>
    </tr>
	
<?php }
else
{ ?>
	
	<input type="hidden" class="form-control" name="denda" value="0">

<?php }
?>	
	
	
	
	
	
	
    </table>
</div>
 <div class="col-sm-6">
<table id="my-grid"  width="100%" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Tgl</th>
			<th>Angsuran ke</th>
			<th>Sisa Angsuran</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			    = 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".$d->tgl_entri."</td>
				<td>".$d->angsuran_ke."</td>
				<td>Rp. ".str_replace(',', '.', number_format($d->sisa_pinjam))."</td>
				
			</tr>
		";

		$no++;
	}

	echo "
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</b></td>
		</tr>";
		
		
		
		
	
	?>
	</tbody>
</table>
</div>


</div>
<div class='clearfix'></div>

	
<input type="hidden" class="form-control" name="tgl_tempo" value="<?php echo $tempo;?>">
<input type="hidden" class="form-control" name="id_user" value="<?php echo $id;?>">
<input type="hidden" name="total_pinjam" value="<?php echo $master->total_pinjam;?>">		
		

 
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
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanEditHalaman'>Angsur</button>";
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