<link href="<?php echo config_item('css'); ?>fonts.css" rel="stylesheet">
<style type="text/css">
.badge {
    display: inline-block;
    min-width: 10px;
    width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #777;
    border-radius: 10px;
}
table {
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size: 11pt;
	border-width: 1px;
	border-style: solid;
	border-color: #000000;
	border-collapse: collapse;
	margin: 10px 0px;
}
table tbody tr:last-child td {
  border: none;
}
#ok {
  float: right;
 }
th{
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	color: #FFFFFF;
	font-size: 14px;
	text-align: center;
	padding: 5px 8px;
	border-width: 1px;
	border-style: solid;
	border-color: #333333;
	border-collapse: collapse;
	background-color: #009141;
}
td{
    font-weight:bold;
	font-family: "arial",Helvetica,Arial,sans-serif;
	padding: 3px;
	text-align: left;
	font-size: 14px;
	 padding: 5px 8px;
	vertical-align: top;
	border-width: 1px;
	border-style: solid;
	border-color: #333333;
	border-collapse: collapse;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  font-size: 11px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}
.kwitansi{
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	color: #333333;
	font-weight: bold;
	font-size: 24px;
	letter-spacing: 0px;
	text-decoration: underline;
}
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
.hr{
 
  border-top: 1px solid #AAAAAA; 
}

</style>
<?php
if( ! empty($data->kode_pinjam))

	
{

	?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" style="width:20%;">
	<div id="logo">
	  	<img style=vertical-align: top src="<?php echo config_item('img'); ?>logo.png" width=90px />
            </div>
</td>
    <td align="left">
  

	<div id=company>
   <p align="center"><strong>KOPERASI PEGAWAI PEMERINTAH</strong><br />
          <strong>        KOTA  BANDUNG</strong><br />
          <strong>       ( K P K B  )</strong><br /></p>
       <p align="center" style="font-size:10px;"> Badan Hukum Paling  Akhir No. 1552/KEP/KWK-10/XI 24 November 1997<br />
    Jl. Wastukancana No.5 ,Telp. (Hunting)+6222-5206476. (Hunting)  +6222-4232338 ext.277</p>
		</td>
  </tr>
</table>
 <hr align="center" style="border-bottom:solid" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
	<p class=kwitansi>TRANSAKSI PINJAMAN</p>
	<?php
	$date=date("Y-m-d");
	echo"	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
			
			<tr>
				<td>NOMOR</td>
				<td>:</td>
				
				<td>".$data->kode_pinjam."/Pinj.02-KPKB/2019</td>
			</tr>
					<tr>
				<td>TANGGAL</td>
				<td>:</td>
				<td>".tanggal($date)."</td>
			</tr>
		</table>";
	
	?>
	
</td>
    <td align="right">
  <input type="hidden" name="nama_klien" id="nama_klien" value="<?php echo "".$data->nama."";?>">

	<div id=company>
        <h2 class=name><?php echo "".$data->nama."";?></h2>
        <div>Alamat :<?php echo "".preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat)."";?> </div>
        <div>Telp : <?php echo "".$data->telp."";?></div>
        <div>Jenis Pinjaman : <?php echo "".$data->nama_pinjaman."";?></div>
		</p>
		</p>
		</p>
		</p>
		
      <?php
	  if($data->status=='belum lunas')
        {
        	echo "<img style='vertical-align: top' src='".config_item('img')."belum-lunas.png' width='180' />";
			
        }
      
		else 
        {
          echo "<img style='vertical-align: top' src='".config_item('img')."lunas.png' width='180' />";
	
        } 
	  
	  ?>
		
		</td>
  </tr>
</table>
<hr size="2" noshade align="center" width="100%"/>


<table align="center" width="100%" class="table" style='margin-bottom: 0px; margin-top: 2px;'  bordercolor='#000000'>
	<thead>
		<tr>
			 <th style="width:5%;">NO</th>
		
			<th class='no'>Besar Pinjaman</th>
			<th style="width:40%;" class='no'>Angsuran / Bulan</th>
			<th class='no'>Bunga </th>
			<th class='no'>Pokok</th>
			
			
			
		</tr>
	</thead>
	<tbody>
		<?php

		$id = $this->session->userdata('ap_id_user');
	$date=date("Y-m-d");
	$jenis=$data->kode_jenis_pinjam;
	$besar_pinjam=$data->besar_pinjam;
	$p = $this->db->query("SELECT * FROM jenis_pinjam where kode_jenis_pinjam='$jenis'");
    $d = $p->row();
	$lama_angsuran=$d->lama_angsuran;
	$bunga=$d->bunga;
	$angsuranPokok=$besar_pinjam/$lama_angsuran;
    //$bungaPerBulan=$besar_pinjam*$bung;
    
	$bungaPerBulan = $angsuranPokok*($bunga/100);
	$total=$angsuranPokok+$bungaPerBulan;
	$totalasli=$total*$lama_angsuran;
	
    $margin_bulat = round($bungaPerBulan, -3); //pembulatan bunga
    $pokok_bulat = round($angsuranPokok, -3); //pembulatan angsuran pokok
    $jml_bayar   = $pokok_bulat+$margin_bulat; //jumlah bayar angsuran perbulan
	
    $tempo=date('Y-m-d',strtotime('+90 day',strtotime($date)));
		echo "
			<tr>
					<td class='no'>1</td>
				<td class='desc'>Rp.".Rp($data->besar_pinjam)." </td>
				<td class='desc'>Rp.".Rp($jml_bayar)." / ".$lama_angsuran." Bulan</td>
				<td class='desc'>Rp.".Rp($bungaPerBulan)." </td>
				<td class='desc' >Rp.".Rp($pokok_bulat)." </td>
				
			</tr>";
			?>
	

	
	
	
  

	</tbody>
</table>

 </center>
</div>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
	
	<?php
	
	echo"	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr>
				<td>T O T A L</td>
				<td>:</td>
				<td>Rp. ".Rp($jml_bayar)."</td>
			</tr>
					<tr>
				<td>Terbilang </td>
				<td>:</td>
<td><em>( ".terbilang($jml_bayar)." Rupiah )</em></td>
			
		</table>";
	
	?>
	 <p align="left" style="font-size:11px;"><em>Keterangan *(diisi oleh Ur.Keuangan) : …………………………………………………………………………</em></p>
</td>
    <td align="right">
  </td>
  </tr>
</table>
<div style="float:right; position:absolute;bottom:276px;">
	<table width="100%" cellpadding="5" id="ok" cellspacing="8" style='float:right; margin-top: 17px;' border="0">
   <tr>
    <td>&nbsp;</td>
    <td><div align="center">Mengetahui</div></td>
    <td><div align="center">Urusan Keuangan</div></td>
    <td><div align="center">Bandung , <?php echo tanggal($date) ;?><br>
	Peminjam</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">--------------------------------------</div></td>
    <td><div align="center"><?php echo "".$data->admin."";?></div></td>
    <td><div align="center"><?php echo "".$data->nama."";?></div></td>
  </tr>
</table>
</div>


  <footer>
      <?php echo config_item('web_footer'); ?>
    </footer> 
<?php

}
else
{
	echo "";
}


?>
<script type="text/javascript">
	/* try {
		this.print();
	}
	catch(e) {
		window.onload = window.print;
	} */
</script>
