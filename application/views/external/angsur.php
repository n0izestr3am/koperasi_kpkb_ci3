<div class="row">
<script src="<?php echo config_item('js'); ?>kpkb.js"></script>

<?php echo form_open('pinjaman/angsur/'.$master->kode_pinjam, array('id' => 'FormEditHalaman')); ?>
<?php
$user 		= $this->session->userdata('ap_id_user');
$kode_pinjam	  = $master->kode_pinjam;
$id_klien	  = $master->id_klien;
$kp = $this->db->query("select* from angsuran where kode_pinjam='$kode_pinjam'");
$total = $kp->num_rows();
$tgl_tempo          = $this->M_pinjaman->get_baris_pinjaman_external($kode_pinjam)->row()->tgl_tempo;



$besar_pinjaman = $master->besar_pinjam;	
$lama_angsuran = $master->lama_angsuran;	
$bung = $master->bunga;	
$bunga = (($besar_pinjaman*$bung)/100);	

?>
<input type="hidden" name="kode" value="<?php echo $kode_pinjam;?>">
<input type="hidden" name="tempo_pinjaman" value="<?php echo $tgl_tempo;?>">
<?
if( ! empty($master->kode_pinjam))
{
	echo "<input type='hidden' name='user' value='".html_escape($user)."'>
	<input type='hidden' name='id_klien' value='".html_escape($master->id_klien)."'>
		<div class='col-md-5'>
		<table class='info_pelanggan'>
			
			<tr>
				<td>Nama / Perusahaan</td>
				<td>:</td>
				<td>".$master->nama."<input type='hidden' name='nama' id='nama_klien' value='".html_escape($master->nama)."'></td>
			</tr>
			
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$master->telp."</td>
			</tr>
			<tr>
				<td>Jenis</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->nama_pinjaman)."</td>
			</tr>	
			
				<tr>
				<td>Tanggal Pinjaman</td>
				<td>:</td>
				<td>".tanggal($master->tgl_entri)."<input type='hidden' name='tgl_entri' value='".html_escape($master->tgl_entri)."'></td>
			</tr>
			
			
			
			
			
			
			
			
			
			<tr>
				<td>Status Pinjaman</td>
				<td>:</td>";
		if($master->status=='belum lunas')
        {
        	echo "<td><img style='vertical-align: top' src='".config_item('img')."belum-lunas.png' width='180' /></td>";
			
        }
      
		else 
        {
          echo "<td><img style='vertical-align: top' src='".config_item('img')."lunas.png' width='100' /></td>";
	
        } 
				
				
	
			echo "</tr>	
		</table>
		</div>
		<div class='col-md-6'>
			<table class='info_pelanggan'>
			<input type='hidden' name='kode_pinjam' id='kode_pinjam' value='".html_escape($master->kode_pinjam)."'>
			<input type='hidden' name='bunga' value='".$bunga."'>
			
			<tr>
		<td>Pinjaman</td>
		<td>:</td>
		<td>Rp. ".Rp($master->besar_pinjam)."<input type='hidden' name='besar_pinjam' value='".html_escape($master->besar_pinjam)."'></td>
			</tr>
			
			<tr>
				<td>Lama Angsuran</td>
				<td>:</td>
	<td>".$master->lama_angsuran." Kali<input type='hidden' name='lama_angsuran' value='".html_escape($master->lama_angsuran)."'></td>
			</tr>
			<tr>
				<td>Angsuran Ke</td>
				<td>:</td>
	<td>".html_escape($total+1)." dari ".$master->lama_angsuran." Kali<input type='hidden' name='angsuran_ke' value='".html_escape($total+1)."'></td>
			</tr>
			
			<tr>
				<td>Nominal Angsuran per Bulan</td>
				<td>:</td>
	<td>".Rp($master->besar_angsuran)."</td>
			</tr>	
			
			
		<tr>
		<td>Besar Angsuran</td>
		<td>:</td>
		<td>";
$besar	  = $master->besar_angsuran;		
$sisa	  = $master->sisa_pinjaman;		
$sisa_angsuran	  = $master->sisa_angsuran;		
$lama_angsuran	  = $master->lama_angsuran;		
$angsuran_pertama = $sisa-$besar;		
if($besar>$sisa)
{
echo "<input type='text' min='".$master->besar_angsuran."' name='besar_angsuran' id='Diambil' class='form-control duit'
	value='".html_escape($master->sisa_pinjaman)."' onkeypress='return check_int(event)'>";		
	
}else{
	//fsfsfsf
echo "<input type='text' min='".$master->besar_angsuran."' name='besar_angsuran' id='Diambil' class='form-control duit'
	value='".$master->besar_angsuran."' onkeypress='return check_int(event)'>";
}

//hitungan angsuran pertama
if($sisa_angsuran==$lama_angsuran)
{

echo "</td>
</tr>

		<tr>
		<td>Sisa Angsuran</td>
		<td>:</td>
		<td>
<input type='text' id='SisaTabungan' class='form-control' value='Rp.".Rp($angsuran_pertama)."' disabled>
<input type='hidden' id='asli' name='sisa_pinjaman' value='".html_escape($master->sisa_pinjaman)."'></td>
</tr>

";		
	
}else{
	//fsfsfsf
echo "</td>
</tr>
<tr>
		<td>Sisa Angsuran</td>
		<td>:</td>
		<td>
<input type='text' id='SisaTabungan' class='form-control' value='Rp.".Rp($master->sisa_pinjaman)."' disabled>
<input type='hidden' id='asli' name='sisa_pinjaman' value='".html_escape($master->sisa_pinjaman)."'></td>
</tr>

";
}








?>
<input type='hidden' name='besar_tabungan' id='TotalTabungan' value='<?php echo $master->sisa_pinjaman; ?>' class='form-control' >



<?php 	
$kk = $this->db->query("SELECT * from eks_pinjaman where kode_pinjam='$kode_pinjam' and id_klien='$id_klien'")->row_array();
$tempo=$kk['tgl_tempo'];
$dat=date("Y-m-d");

//angsuran ke 


if($dat>$tempo)
{
$go=round($telat=((abs(strtotime($dat)-strtotime($tempo)))/(60*60*24)));
$denda=$go * 1000;
?>
	<tr>
      <td>Denda</td>
	  <td>:</td>
      <td>
    <input type="text" class="form-control" name="denda" value="<?php echo $denda; ?>" readonly>
      </td>
    </tr>
	
<?php }
else
{ ?>
	
	<input type="hidden" class="form-control" name="denda" value="0">

<?php }
echo "</table></div>";
?>	

</div>
<hr />
<div class="alert bg-danger" id="alert" role="alert">
					Angsuran  Berhasil di simpan silahkan cetak Kwitansi Angsuran dan tutup halaman <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				
<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>No</th>
			<th>Tgl Angsur</th>
			<th>Angsuran Ke</th>
			<th>Besar Angsuran</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				
				<td>".tanggal($d->tgl_entri)." <input type='hidden' name='tgl_entri' value='".html_escape($d->tgl_entri)."'></td>
				<td><span style='background-color: #1d6de6;' class='badge badge-warning'>".$d->angsuran_ke." </span><input type='hidden' name='angsuran_ke' value='".html_escape($d->angsuran_ke)."'></td>
				<td>Rp. ".Rp($d->besar_angsuran)." <input type='hidden' name='besar_angsuran' value='".html_escape($d->besar_angsuran)."'></td>
				
			</tr>
		";

		$no++;
	}

	echo "
		<tr style='background:#deeffc;'>
			<td colspan='3' style='text-align:right;'><b>Pokok Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->besar_pinjam))."</b></td>
		</tr>
		<tr>
			<td colspan='3' style='text-align:right; border:0px;'>Total Pinjaman beserta Bunga</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</td>
		</tr>
		
	";
	
	
	?>
	</tbody>
</table>


<input type="hidden" name="total_pinjam" value="<?php echo $master->total_pinjam;?>">		
<input type="hidden" name="ke" id="ke" value="<?php echo html_escape($total+1);?>">		
		
<?php 				

}
else
{
	echo "data : tidak ada";
}

?>
 
<?php echo form_close();?>

<div id='ResponseInput'></div>
  
<script>

$(document).on('keyup', '#Diambil', function(){
	HitungTotalTabungan();
});


function HitungTotalTabungan()
{
	var Diambil = $('#Diambil').unmask().val();
	var TotalTabungan = $('#TotalTabungan').val();
if(parseInt(TotalTabungan) >= parseInt(Diambil)){
		var Selisih = parseInt(TotalTabungan) - parseInt(Diambil);
		$('#SisaTabungan').val(to_rupiah(Selisih));
		$('#asli').val(Selisih);
	} else {
		$('#SisaTabungan').val('');
		$('#asli').val('');
	}
	
}

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}


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
			    }, 5000);
				$("#CetakAngsuran").show(); 
				$("#alert").show(); 
				 //setTimeout(function(){  window.location.href="<?php echo site_url('angsuran'); ?>"; }, 5000);
				$('#my-grid').DataTable().ajax.reload( null, false );
				$('#SimpanEditHalaman').attr("disabled","disabled");
				
			}
			
			
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}


$(document).on('click', 'button#CetakAngsuran', function(){
	CetakAngsuran();
});	
function CetakAngsuran()
{
	var FormData = "kode_pinjam="+encodeURI($('#kode_pinjam').val());
			FormData += "&nama_klien="+$('#nama_klien').val();
			FormData += "&Diambil="+$('#Diambil').val();
			FormData += "&ke="+$('#ke').val();
			window.open("<?php echo site_url('cetak/kwitansi-angsuran/?'); ?>" + FormData,'_blank');

	
}








$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-info' id='CetakAngsuran'>Cetak Kwitansi</button><button type='button' class='btn btn-success' id='SimpanEditHalaman'>Simpan Angsuran</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);
if($(this).hasClass('disabled'))
		{
			return false;
		}
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


$("#CetakAngsuran").hide(); 
$("#alert").hide(); 

</script>
