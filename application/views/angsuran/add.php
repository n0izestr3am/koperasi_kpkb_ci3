<div class="row">
<script src="<?php echo config_item('js'); ?>kpkb.js"></script>

<?php echo form_open('angsuran/add/'.$master->kode_pinjam, array('id' => 'FormEditHalaman')); ?>
<?php
$user 		= $this->session->userdata('ap_id_user');
$kode_pinjam	  = $master->kode_pinjam;
$kode_anggota	  = $master->kode_anggota;
$kp = $this->db->query("select* from angsuran where kode_pinjam='$kode_pinjam'");
$total = $kp->num_rows();
$tgl_tempo   = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->tgl_tempo;

$besar_pinjaman = $master->besar_pinjam;	
$lama_angsuran = $master->lama_angsuran;	
$pokok = $besar_pinjaman/$lama_angsuran;	
$bung = $master->bunga;	
$bunga = (($besar_pinjaman*$bung)/100);	

?>
<input type="hidden" name="pokok_asli" value="<?php echo $pokok;?>">
<input type="hidden" name="bunga_asli" value="<?php echo $bunga;?>">
<input type="hidden" name="tempo_pinjaman" value="<?php echo $tgl_tempo;?>">
<?php
if( ! empty($master->kode_pinjam))
{
	echo "<input type='hidden' name='user' value='".html_escape($user)."'>
		<div class='col-md-5'>
		<table class='info_pelanggan'>
			
			<tr>
				<td>Nama / Perusahaan</td>
				<td>:</td>
				<td>".$master->nama."<input type='hidden' name='nama' value='".html_escape($master->nama)."'></td>
			</tr>
			
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."</td>
			</tr>
			<tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$master->no_telp."</td>
			</tr>
			<tr>
				<td>N I P</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->nip)."</td>
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
			<input type='hidden' name='kode_pinjam' value='".html_escape($master->kode_pinjam)."'>
			<input type='hidden' name='bunga' value='".$bunga."'>
				<tr>
				<td>Tanggal Pinjaman</td>
				<td>:</td>
				<td>".tanggal($master->tgl_entri)."<input type='hidden' name='tgl_entri' value='".html_escape($master->tgl_entri)."'></td>
			</tr>
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
		<td>Besar Angsuran</td>
		<td>:</td>
		<td>";
$besar	  = $master->besar_angsuran;		
$sisa	  = $master->sisa_pinjaman;		
if($besar>$sisa)
{
echo "<input type='text' min='".html_escape($master->besar_angsuran)."' name='besar_angsuran' id='Diambil' class='form-control duit'
	value='".html_escape($master->sisa_pinjaman)."' onkeypress='return check_int(event)'>";		
	
}else{
echo "<input type='text' min='".html_escape($master->besar_angsuran)."' name='besar_angsuran' id='Diambil' class='form-control duit'
	value='".html_escape($master->besar_angsuran)."' onkeypress='return check_int(event)'>";
}

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




?>
<input type='hidden' name='besar_tabungan' id='TotalTabungan' value='<?php echo $master->sisa_pinjaman; ?>' class='form-control' >



<?php 	
$kk = $this->db->query("SELECT * from pinjaman where kode_pinjam='$kode_pinjam' and kode_anggota='$kode_anggota'")->row_array();
$tempo=$kk['tgl_tempo'];
$dat=date("Y-m-d");
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
			    }, 3000);
				 setTimeout(function(){ location.reload(); }, 3000);
			}
			
			
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-success' id='SimpanEditHalaman'>Simpan Angsuran</button>";
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
