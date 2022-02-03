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
	border-color: #ddd;
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
	font-size: 11px;
	text-align: center;
	padding: 5px 8px;
	border-width: 1px;
	border-style: solid;
	border-color: #70b970;
	border-collapse: collapse;
	background-color: #009141;
}
td{
    font-weight:bold;
	font-family: "arial",Helvetica,Arial,sans-serif;
	padding: 3px;
	text-align: left;
	font-size: 12px;
	 padding: 5px 8px;
	vertical-align: top;
	border-width: 1px;
	border-style: solid;
	border-color: #ddd;
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
if( ! empty($master->kode_pinjam))
{
	$tanggal = date('Y-m-d');
	$unit = $master->id_unit_kerja;
	$un = $this->M_Anggota->get_unit($unit)->row()->unit_kerja;

	?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
	<div id="logo">
	  	<img style=vertical-align: top src="<?php echo config_item('img'); ?>logo.png" width=60px />
            </div>
</td>
    <td align="right">
  

	<div id=company>
        <h2 class=name>Nama : <?php echo "".$master->nama."";?></h2>
        <div>Alamat :<?php echo "".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat)."";?> </div>
        <div>NIP : <?php echo "".$master->nip."";?></div>
        <div>UNIT KERJA : <?php echo "".$un."";?></div>
		
		</td>
  </tr>
</table>


<hr size="2" noshade align="center" width="100%"/>
 <div align="center">
 <center>
<table align="center" width="100%" class="table" style='margin-bottom: 0px; margin-top: 7px;'  bordercolor='#333333'>
	<thead>
		<tr>
			 <th style="width:5%;">NO</th>
		
			<th>TGL ANGSUR</th>
			<th >ANGSURAN KE</th>
			<th>BESAR ANGSURAN</th>
			
			
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
				
				<td>".tanggal($d->tgl_entri)." </td>
				<td align='center'><div align='center'><span style='background-color: #1d6de6;' class='badge badge-warning'>".$d->angsuran_ke." </span></div></td>
				<td>Rp. ".Rp($d->besar_angsuran)." </td>
				
			</tr>
		";

		$no++;
	}

	echo "<tr style='background:#b7efd0;'>
			<td colspan='3' style='text-align:right;'><b>Sisa Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->sisa_pinjaman))."</b></td>
		</tr>
		<tr style='background:#b7efd0;'>
			<td colspan='3' style='text-align:right;'><b>Pokok Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->besar_pinjam))."</b></td>
		</tr>
		<tr>
			<td colspan='3' style='text-align:right; border:0px;'>Total Pinjaman beserta Bunga</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</td>
		</tr>";?>
	

	
	
	
  

	</tbody>
</table>
 </center>
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
	try {
		this.print();
	}
	catch(e) {
		window.onload = window.print;
	}
</script>
