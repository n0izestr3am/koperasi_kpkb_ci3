<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Data Customer : <?php echo "".$kontrak->customer_nama."";?> </title>

   
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
  font-family: Arial, sans-serif; 
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
	  <img style="vertical-align: top" src="<?php echo config_item('img'); ?>logo.png" width="180" />
	 
            </div>
      <div id="company">
        <h2 class="name"></h2>
        <div></div>
        <div></div>
        <div><?php echo config_item('web_title'); ?></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">DATA KONTRAK :</div>
          <h2 class="name"><?php echo "".$kontrak->customer_nama."";?></h2>
          <div class="address"><?php echo "".$kontrak->customer_alamat."";?></div>
         
        </div>
        <div id="invoice">
		
          
          <div class="date">PERIODE KONTRAK : <?php echo "".tanggal($kontrak->pk)." s/d ".tanggal($kontrak->pa)."";?></div>
        <!--   <div class="date">Due Date: 30/06/2014</div> -->
        </div>
      </div>
      <table class="table" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">NO</th>
            <th class="desc">DESCRIPTION</th>
          

          </tr>
        </thead>
        <tbody>
         
		  <?php echo "
		  <tr><td class='no' >TERM OF PAYMENT</td><td class='desc' >".$kontrak->t_payment."</td></tr>
<tr><td class='no' >INVOICE SCHEDULE</td><td class='desc'>".$kontrak->invoice_schedule."</td></tr>
<tr><td class='no'>VIRTUAL ACCOUNT</td><td class='desc' >".$kontrak->virtual_acc."</td></tr>
<tr><td class='no' >VIRTUAL ACCOUNT BANK</td><td class='desc' >".$kontrak->virtual_acc_bank."</td></tr>
<tr><td class='no' >PICK UP SERVICE</td><td class='desc' ><b>Rp. ".str_replace(',', '.', number_format($kontrak->pickup_service))."</b></td></tr>
		  
		";  ?>
        <tr>
            <td class="no">PRODUK</td>
            <td class="desc"><?php
				foreach($produk->result() as $k)
				{
					
					if($kontrak->id_produk == $k->id_produk){
						echo '<div style="padding:2px;"> '.$k->nama_produk.'</div>';
					}
		
	
					
				}
				?>	</td>
           
          </tr>
		  
		  <tr>
            <td class="no">TRUK ACCESS</td>
            <td class="desc"><?php
		$q = $this->db->query("select * from customer_akses 
		left join truk_akses on customer_akses.id_truk_akses=truk_akses.id_truk_akses
		WHERE id_kontrak='".$kontrak->id_kontrak."'");
			foreach($akses->result() as $z) { 
foreach ($q->result_array() as $k)
{
	

					
					if($z->id_truk_akses == $k['id_truk_akses']){
					
	echo '<div style="text-align: left;"> '.$k['akses'].'</div>';
					}
					
					
	}
	
				}
				
				


				?></td>
           
          </tr>
		  
		  
		  
		  
		  
		  
		  
		  
        </tbody>
        
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