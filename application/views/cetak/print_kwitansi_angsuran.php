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
.badge {
    display: inline-block;
    min-width: 13px;
    padding: 5px 8px;
    font-size: 13px;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #777;
    border-radius: 10px;
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
if( ! empty($master->kode_pinjam))

	
{
$tanggal = date('Y-m-d');
$besar_pinjaman = $master->besar_pinjam;	
$lama_angsuran = $master->lama_angsuran;	
$bung = $master->bunga;	
$bunga = (($besar_pinjaman*$bung)/100);	
$ang = $bunga*$lama_angsuran;

$pokok  = $besar_pinjaman/$lama_angsuran;
$margin = $pokok*($bung/100);
$total=$pokok+$margin;
$totalasli=$total*$lama_angsuran;
$margin_bulat = round($margin, -3); //pembulatan bunga
$pokok_bulat = round($pokok, -3); //pembulatan angsuran pokok
$jml_bayar   = $pokok_bulat+$margin_bulat; //jumlah bayar angsuran perbulan
$total_bunga  = $margin_bulat*$lama_angsuran;
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
	<p class=kwitansi>K  W  I  T  A  N  S  I</p>
	<?php
	
	echo"	<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
			
			<tr>
				<td>NOMOR</td>
				<td>:</td>
				
				<td>".$kode_pinjam."/Ang.02-KPKB/2019</td>
			</tr>
					<tr>
				<td>TANGGAL</td>
				<td>:</td>
				<td>".tanggal($tgl)."</td>
			</tr>
			
				<tr>
				<td>ANGSURAN KE</td>
				<td>:</td>
				<td><span style='background-color: #1d6de6;' class='badge'>".$ke."</span></td>
			</tr>
		</table>";
	
	?>
	
</td>
    <td align="right">
  <input type="hidden" name="nama_klien" id="nama_klien" value="<?php echo html_escape($master->nama); ?>">

	<div id=company>
        <h2 class=name><?php echo "".$nama_klien."";?></h2>
        <div>Alamat :<?php echo "".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."";?> </div>
        <div>Telp : <?php echo "".$master->telp."";?></div>
        <div>Jenis Pinjaman : <?php echo "".$master->nama_pinjaman."";?></div>
       
		</p>
		</p>
		</p>
		</p>
		
      <?php
	  if($master->status=='belum lunas')
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
			 <th style="width:15%;">NO</th>
		
			<th>DESCRIPTION</th>
			
			
			
		</tr>
	</thead>
	<tbody>
		<?php

		echo "
			<tr>
			<td>".$kode_pinjam."</td>
			<td  align=\"center\">  Angsuran Pinjaman :  ".$nama_klien." Rp. ".Rp($Diambil)." </td>
				
			</tr>
		";?>
	

	
	
	
  

	</tbody>
</table>

 </center>
</div>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
	
	<?php
	
	echo"	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					<tr>
				<td>Besarnya</td>
				<td>:</td>
				<td>Rp. ".Rp($Diambil)."</td>
			</tr>
			
					<tr>
				<td>Terbilang </td>
				<td>:</td>
<td><em>( ".terbilang($Diambil)." Rupiah )</em></td>
			
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
    <td><div align="center">Bandung , <?php echo tanggal($tanggal) ;?><br>
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
    <td><div align="center"><?php echo "".$master->staff."";?></div></td>
    <td><div align="center"><?php echo "".$nama_klien."";?></div></td>
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
