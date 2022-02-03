<link href="<?php echo config_item('css'); ?>nota.css" rel="stylesheet">
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
font-family: "verdana",Helvetica,Arial,sans-serif;
	font-size: 11pt;
	margin: 10px 0px;
}
table tbody tr:last-child td {
  border: none;
}
#ok {
  float: right;
 }
th{
font-family: "verdana",Helvetica,Arial,sans-serif;
	color: #FFFFFF;
	font-size: 11px;
	text-align: center;
	padding: 12px 11px;
	border-width: 1px;
	border-style: solid;
	border-color: #70b970;
	border-collapse: collapse;
	background-color: #009141;
}
td{
    font-weight:bold;
	font-family: "verdana",Helvetica,Arial,sans-serif;
	padding: 3px;
	text-align: left;
	font-size: 12px;
	 padding: 11px 9px;
	vertical-align: top;
	
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
if( ! empty($master->kode_anggota))
{
	$tanggal = date('Y-m-d');
	$un = $master->unit_kerja;

	?>
<table class="info_pelanggan" width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
	<div id="logo">
	  	<img style=vertical-align: top src="<?php echo config_item('img'); ?>logo.png" width=60px />
            </div>
</td>
    <td align="right" width="30%">
  

	 
        <div style="padding:2px;"><?php echo config_item('web_title'); ?></div>
        <div class="judul-header">DATA KEANGGOTAAN</div>
		
		</td>
  </tr>
</table>
<hr class="hr5">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td style="width:60%;" align="left">
       <?php
 echo "<table class='info_pelanggan'>
		<tr>
		
				<td style='width:50%;'>Kode</td>
				<td>:</td>
				<td>".$detail->kode_anggota."</td>
			</tr>
			<tr>
				<td>Nama Anggota</td>
				<td>:</td>
				<td>".$detail->nama."</td>
			</tr>
			<tr>
				<td>NIP</td>
				<td>:</td>
				<td>".$detail->nip."</td>
			</tr>
			
			
			<tr>
				<td>Tempat tgl Lahir</td>
				<td>:</td>
				<td>".$detail->tempat_lahir." ,".tanggal($detail->tanggal_lahir)." </td>
			</tr>
			
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $detail->alamat)."</td>
			</tr>
			<tr>
				<td>No Telp</td>
				<td>:</td>
				<td>".$detail->no_telp."</td>
			</tr>
			
			
		</table>";
 
 ?>
       
</td>

    <td align="right">
 <?php
 echo "<table class='info_pelanggan'>
		<tr>
		
				<td style='width:50%;'>Unit Kerja</td>
				<td>:</td>
				<td>".$detail->unit_kerja."</td>
			</tr>
			<tr>
				<td>GOLONGAN</td>
				<td>:</td>
				<td>".$detail->golongan."</td>
			</tr>
			<tr>
				<td>Gaji</td>
				<td>:</td>
				<td>Rp. ".Rp($detail->gaji)."</td>
			
			</tr>
			
			
			
			<tr>
				<td>Nama Ahli Waris</td>
				<td>:</td>
				<td>".$detail->nama_ahli_waris." </td>
			</tr>
			
			<tr>
			<td >Hubungan Ahli Waris</td>
				<td>:</td>
				<td>".$detail->ahli_waris."</td>
			</tr>
			<tr>
			<td >Tgl Pendaftaran</td>
				<td>:</td>
					<td>".tanggal($detail->tgl_pendaftaran)."</td>
			</tr>
			<tr>
				<td>Status Keanggotaan</td>
				<td>:</td>
				<td>".$detail->status."</td>
			</tr>
			
		</table>";
 
 ?>
		</td>
  </tr>
</table>
<hr class="hr10">


 <div style="margin-top: 5px;">
                            <table class="new_grid">
                                <tr>
			  <td style="background:#009141; color:#FFFFFF; width: 25px;">No</td>
      
              <td style="background:#009141; color:#FFFFFF; text-align:center; width: 100px;">Simpanan Pokok</td>
              <td style="background:#009141;  color:#FFFFFF;text-align:center; width: 100px;">Simpanan Wajib</td>
     <td style="background:#009141; color:#FFFFFF; text-align:center; width: 150px;">Simpanan Sukarela</td>
		   <td style="background:#009141; color:#FFFFFF; text-align:center; width: 150px;">Simpanan 12 Juli</td>
		   <td style="background:#009141; color:#FFFFFF; text-align:center; width: 150px;">Sub Total</td>
                                  
                                </tr>
                                <tbody>
   <?php
	$no 			= 1;
			echo "
			<tr >
			<td>".$no."</td>
			
				<td>Rp. ".Rp($master->pokok)."</td>
				<td>Rp. ".Rp($master->wajib)."</td>
				<td>Rp. ".Rp($master->sukarela)."</td>
				<td>Rp. ".Rp($master->juli)."</td>
				<td>Rp. ".Rp($master->per_total)."</td>
				
			</tr>";

		$no++;
	
?>
                                         
                                     
                            </tbody>
                            </table>

<hr class="hr10">
					
                        </div>

<div style="float:right; position:absolute;bottom:256px;">
	<table width="100%" cellpadding="5" id="ok" cellspacing="8" style='float:right; margin-top: 17px;' border="0">
   <tr>
    <td>&nbsp;</td>
    <td><div align="center">Mengetahui</div></td>
    <td><div align="center">Bagian Keangotaan</div></td>
    <td><div align="center">Bandung , <?php echo tanggal($tanggal) ;?><br>
	Hormat Saya</div></td>
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
    <td><div align="center"><?php echo "".$master->nama."";?></div></td>
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
	// try {
		// this.print();
	// }
	// catch(e) {
		// window.onload = window.print;
	// }
</script>
