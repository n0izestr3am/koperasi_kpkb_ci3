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
    background-color: #000;
    border-radius: 10px;
}
table {
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size: 11pt;
	border-width: 1px;
	border-style: solid;
	border-color: #fff;
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
	border-color: #fff;
	border-collapse: collapse;
	background-color: #fff;
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
	border-color: #fff;
	border-collapse: collapse;
}

footer {
  color: #fff;
  width: 100%;
  height: 30px;
  font-size: 11px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #fff;
  padding: 8px 0;
  text-align: center;
}
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
.hr{
 
  border-top: 1px solid #fff; 
}
.blok{
  color: #FFFFFF;
  
  border: 1px solid #ffffff; 
}

@media print {
	color: #FFFFFF;
    #logo2,
    #company2,
    #print-area {
        display: none;
    }
}

</style>
<?php
if( ! empty($master->kode_pinjam))
{
	$tanggal = date('Y-m-d');
	// $unit = $master->id_unit_kerja;
	// $un = $this->M_Anggota->get_unit($unit)->row()->unit_kerja;

	?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
	<div id="logo">
	  	
            </div>
</td>
    <td align="right">
  

	<div style="color: #FFFFFF;" id=company>
        <h2 class=name></h2>
        <div> </div>
        <div></div>
        <div></div>
       
		
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
		
		if($no==$baris)
        {
        	echo "
			<tr>
				<td>".$baris."</td>
				
				<td>".tanggal($d->tgl_entri)." </td>
				<td align='center'><div align='center'>".$d->angsuran_ke."</div></td>
				<td>Rp. ".Rp($d->besar_angsuran)." </td>
				
			</tr>
		";
			
        }else{
			echo "
			<tr class='blok'>
				<td style='color: #FFFFFF; background:#ffffff;'>".$no."</td>
				
				<td style='color: #FFFFFF; background:#ffffff;'>".tanggal($d->tgl_entri)." </td>
				<td >".$d->angsuran_ke." </td>
				<td>Rp. ".Rp($d->besar_angsuran)." </td>
				
			</tr>
		";	
			
		}
		
		

		$no++;
	}

	echo "<tr style='color: #FFFFFF; background:#ffffff;'>
			<td colspan='3' style='text-align:right;'><b>Sisa Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->sisa_pinjaman))."</b></td>
		</tr>
		<tr style='color: #FFFFFF; background:#ffffff;'>
			<td colspan='3' style='text-align:right;'><b>Pokok Pinjaman</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->besar_pinjam))."</b></td>
		</tr>
		<tr>
			<td colspan='3' style='color: #FFFFFF; text-align:right; border:0px;'>Total Pinjaman beserta Bunga</td>
			<td style='color: #FFFFFF; border:0px;'>Rp. ".str_replace(',', '.', number_format($master->total_pinjam))."</td>
		</tr>";
		
		?>
	

	
	
	
  

	</tbody>
</table>
 </center>
</div>



  <footer>
      <?php echo config_item('web_footer'); ?>
    </footer> 
<?php

}
else
{
	echo "kosong";
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
