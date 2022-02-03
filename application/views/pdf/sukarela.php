<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Bukti Transaksi Simpanan : <?php echo "".$data->nama."";?> </title>

   
 <STYLE>
   @font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
	color: #035461;
	text-decoration: none;
}

body {
  position: relative;
   margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: tahoma,arial,verdana,sans-serif;
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
	padding-left: 6px;
	float: left;
	border-left-width: 6px;
	border-left-style: solid;
	border-left-color: #035461;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
	color: #990000;
	font-size: 2.4em;
	line-height: 1em;
	font-weight: normal;
	margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
	padding: 12px;
	text-align: center;
	border-bottom: 1px solid #FFFFFF;
	background-color: #E8E8E8;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
	color: #FF0000;
	font-size: 1.2em;
	font-weight: normal;
	margin: 0 0 0.2em 0;
}

table .no {
	color: #FFFFFF;
	font-size: 1.0em;
	width: 20%;
	 text-align: left;
	background-color: #035461;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #035461;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #035461;
  font-size: 1.4em;
  border-top: 1px solid #035461; 

}

table tfoot tr td:first-child {
  border: none;
}





table2 {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table2 th,
table2 td {
	padding: 12px;
	text-align: center;
	border-bottom: 1px solid #c0c0c0;
	background-color: #FFFFFF;
}

table2 th {
  white-space: nowrap;        
  font-weight: normal;
}

table2 td {
  text-align: right;
}

table2 td h3{
	color: #FF0000;
	font-size: 1.2em;
	font-weight: normal;
	margin: 0 0 0.2em 0;
}

table2 .no {
	color: #FFFFFF;
	font-size: 1.0em;
	width: 20%;
	 text-align: left;
	background-color: #FFFFFF;
}

table2 .desc {
  text-align: left;
}

table2 .unit {
  background: #DDDDDD;
}

table2 .qty {
}

table2 .total {
  background: #FFFFFF;
  color: #FFFFFF;
}

table2 td.unit,
table2 td.qty,
table2 td.total {
  font-size: 1.2em;
}

table2 tbody tr:last-child td {
  border: none;
}

table2 tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table2 tfoot tr:first-child td {
  border-top: none; 
}

table2 tfoot tr:last-child td {
  color: #035461;
  font-size: 1.4em;
  border-top: 1px solid #035461; 

}

table2 tfoot tr td:first-child {
  border: none;
}



.hr{
 
  border-top: 1px solid #AAAAAA; 
}



#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
	padding-left: 6px;
	border-left-width: 6px;
	border-left-style: solid;
	border-left-color: #990000;
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

   </STYLE>
      
</head>
<body>
    <header class="clearfix">
      <div id="logo">
	  <img style="vertical-align: top" src="<?php echo config_item('img'); ?>logo.png" width="100" />
	 
            </div>
      <div id="company">
        <h2 class="name"></h2>
        <div></div>
        <div>Bukti Transaksi Simpanan : <?php echo "".ucfirst($data->jenis_simpan).""?></div>
        <div><?php echo config_item('web_title'); ?></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">KODE ANGGOTA : <?php echo "".$data->kode_anggota."";?></div>
          <h2 class="name">Nama : <?php echo "".$data->nama."";?></h2>
          <div class="address">NIP :<?php echo "".$data->nip."";?></div>
          <div class="address">Alamat :<?php echo "".preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat)."";?></div>
         
        </div>
        <div id="invoice">
		
          
          <div class="date">TANGGAL : <?php echo "".tanggal($data->tgl_entri)."";?></div>
        <!--   <div class="date">Due Date: 30/06/2014</div> -->
        </div>
      </div>
      <table class="table" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
        
        <tbody>
         
		  <?php echo "
<tr><td class='no' >JENIS SIMPANAN</td><td class='desc' >".$data->jenis_simpan."</td></tr>
<tr><td class='no' >BESAR SIMPANAN</td><td class='desc' >Rp. ".Rp($data->besar_simpanan)." ( ".terbilang($data->besar_simpanan)." Rupiah)</td></tr>
		  
		"; 


		
		


		?>
 
		  
		  
		  
		  
		  
		  
		  
        </tbody>
        
      </table>
	  
	  <table style="width:80%;  background: #FFFFFF;" border="0" cellspacing="0" cellpadding="0">
  <tr style="background:#FFFFFF;">
    <td width="100">&nbsp;</td>
    <td width="160">&nbsp;</td>
    <td width="190">&nbsp;</td>
   
    <td style="text-align:center;background: #FFFFFF;"></td>
  </tr>
  <tr style="background:#FFFFFF;">
  <td>&nbsp;</td>
 
  <td>&nbsp;</td>
    <td style="text-align:center; width:200px; background: #FFFFFF;">Bagian Keanggotaan,</td>
    
    <td width="70">&nbsp;</td>
    <td style="text-align:center; width:200px; background: #FFFFFF;">Diterima oleh,</td>
  </tr>
  <tr style="background: #FFFFFF;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
  </tr>
  <tr style="background:#FFFFFF;">
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background:#FFFFFF;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  
  </tr>
  <tr style="background:#FFFFFF;">
  <td>&nbsp;</td>
  <td>&nbsp;</td>
    <td style="text-align:center">-------------------------------</td>
    
    <td>&nbsp;</td>
    <td style="text-align:center"><?php echo "".$data->nama."";?></td>
  </tr>
</table>
	   <div class="clearfix"></div>
	  
	  
	  
    
	
	
	
	
	
        <div class="clearfix"></div>
    </main>
	
	  <div class="clearfix"></div>
    <footer>
      <?php echo config_item('web_footer'); ?>
    </footer>
</body>
</html>