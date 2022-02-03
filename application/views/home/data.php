<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
$eks = $this->db->query("SELECT * FROM eks_pinjaman where acc='belum' order by kode_pinjam desc");
$total_eks = $eks->num_rows(); 
if($total_eks>0)
{$total_eks ='<span class="notif badge badge-warning">'.$total_eks.'</span>';}else{$total_eks ='';}

$pn = $this->db->query("SELECT * FROM eks_pinjaman where status='Belum di acc' order by kode_pinjam desc");
$pengajuan = $pn->num_rows(); 
if($pengajuan>0){ $pengajuan ='<span class="notif badge badge-warning">'.$pengajuan.'</span>';
}else{$pengajuan ='<span class="notif-kosong badge badge-warning">Belum ada</span>';}

$pin = $this->db->query("SELECT * FROM eks_pinjaman where status='belum lunas' order by kode_pinjam desc");
$pinjam = $pin->num_rows(); 
if($pinjam>0){ $pinjam ='<span class="notif badge badge-warning">'.$pinjam.'</span>';
}else{$pinjam ='<span class="notif-kosong badge badge-warning">Tidak ada</span>';}












?>
<style type="text/css">
${demo.css}
.highcharts-credits{
display:none;
}
		</style>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-home fa-fw'></i> Home </h5>
<?php
foreach($kas as $res) {
echo "<div class=\"text-muted\">Total Kas Koperasi saat ini :  <b>Rp. ".Rp($res->total_kas)." </b><br>
<p style='color: red;line-height: 1;font-size: 10px;'>".terbilang($res->total_kas)." Rupiah</p></div>";
}?>	



			<hr class="hr5"/>
	 <!-- /.row -->
   
        
			
			
			
			
			
			
			
			
			
			
	<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
					<i class="glyph fa fa-dollar" style="font-size:30px;margin-top: 10px;"></i>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
<div class="standard">Pinjaman <?php echo''.$pinjam.'';?></div>
							<?php
$p = $this->db->query("SELECT SUM(besar_pinjam) as besar_pinjam from eks_pinjaman")->row_array();
echo "<div class=\"text-muted\" style=\"font-size:12px;\">Rp. ".Rp($p['besar_pinjam'])."</div>";
?>
							<a class="btn btn-default btn-xs" href="<?php echo site_url('pinjaman'); ?>"><i class="glyphicon glyphicon-edit"></i> Detail</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<i class="glyph fa fa-users" style="font-size:30px;margin-top: 10px;"></i>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="standard">Debitur</div>
<?php
$a = $this->db->query("SELECT count(id_klien) as total_anggota from klien")->row_array();
echo "<div class=\"text-muted\" style=\"font-size:11px;\">".$a['total_anggota']." Orang</div>";
?>
<a class="btn btn-default btn-xs" href="<?php echo site_url('peminjam'); ?>"><i class="glyphicon glyphicon-edit"></i> Detail</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
						<i class="glyph fa fa-share" style="font-size:30px;margin-top: 10px;"></i>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="standard">Angsuran</div>
<?php
$d = $this->db->query("SELECT SUM(besar_angsuran) as total_angsuran from angsuran")->row_array();
echo "<div class=\"text-muted\" style=\"font-size:11px;\">Rp. ".Rp($d['total_angsuran'])."</div>";
?>
							<a class="btn btn-default btn-xs" href="<?php echo site_url('angsuran/external'); ?>"><i class="glyphicon glyphicon-edit"></i> Detail</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<i class="glyph fa fa-save" style="font-size:30px;margin-top: 10px;"></i>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="standard">Kas</div>
<?php
$row1 = $this->db->query("SELECT SUM(nilai) as total_tabungan from shu")->row_array();
echo "<div class=\"text-muted\" style=\"font-size:11px;\">Rp. ".Rp($row1['total_tabungan'])."</div>";
?>
							
							<a class="btn btn-default btn-xs" href="<?php echo site_url('tabungan'); ?>"><i class="glyphicon glyphicon-search"></i> Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>		
			
		<hr class='hr5'>	
	    <!-- /.row -->				
			
		
 <div class="row-fluid">
      <div class="col-sm-6">
<div class="text-muted"><b>Data Debitur yang jatuh Tempo / Telat</b>
<br>
<br>
</div>
  <table class="table table-bordered table-striped table-condensed">
    <thead>
		<tr class="info">
             <th><a href="#">No</a></th>
  			 <th><a href="#">Debitur</a></th>
             <th><a href="#">Jatuh Tempo</a></th>
             <th><a href="#">Telat</a></th>
             <th><a href="#">Denda</a></th>
       
       	</tr>
    </thead>
    <tbody>	
<?php
$nomer=1;
foreach($telat->result() as $e){
$a=$e->tgl_tempo;
$tgl=$e->tgl_entri;
$dat=date("Y-m-d");	
if($dat>$a)
{
$go=round($telat=((abs(strtotime($dat)-strtotime($a)))/(60*60*24))); $denda=$go * 1000;
			$kd_a=$e->id_klien;
    		$anggota=$this->db->query("SELECT nama from klien where id_klien='$kd_a'")->row_array();
			$kd_j=$e->kode_jenis_pinjam;
			$jenis=$this->db->query("SELECT nama_pinjaman from jenis_pinjam where kode_jenis_pinjam='$kd_j'")->row_array();

echo'<tr>
    		<td>'.$nomer.'</td>
			<td>'.$anggota['nama'].'</td>
			<td>'.tanggal($a).'</td>
			
			<td>'.$go.' Hari</td>
			<td>Rp. '.Rp($denda).'</td>
			
        </tr>';
}else
			{
			
			}
    	$nomer++;
		}

?>	
	 <!-- /.bts -->
	</tbody>   
	</table>	
					
	</div>
	
	
	 <div class="col-sm-6">
		<div class="text-muted"><b>Data Debitur Lancar</b>
		<br>
		<br>
</div>
  <table class="table table-bordered table-striped table-condensed">
    <thead>
		<tr class="warning">
             <th><a href="#">No</a></th>
  			 <th><a href="#">Debitur</a></th>
             <th><a href="#">Jenis Pinjaman</a></th>
           
       
       	</tr>
    </thead>
    <tbody>	
<?php
$nomer=1;
foreach($lancar->result() as $d){
$a=$d->tgl_tempo;
$aq=$d->id_klien;
$tgl=$d->tgl_entri;
$dat=date("Y-m-d");	

    		$anggota=$this->db->query("SELECT nama from klien where id_klien='$aq'")->row_array();
			$kd_j=$e->kode_jenis_pinjam;
			$jenis=$this->db->query("SELECT nama_pinjaman from jenis_pinjam where kode_jenis_pinjam='$kd_j'")->row_array();

echo'<tr>
    		<td>'.$nomer.'</td>
			<td>'.$anggota['nama'].'</td>
			<td>'.$jenis['nama_pinjaman'].'</td>
			
			
        </tr>';

    	$nomer++;
		}

?>	
	 <!-- /.bts -->
	</tbody>   
	</table>	
	</div>
	</div>
	
	
	
	
	
	 <!-- /.BATAS  -->
	

	
	
	</div>
	
	
	
		<div class="panel-body">
	<hr class="hr5">	
		
		 <div class="col-sm-6">

	<div class="pemberitahuan">
		
                        <!-- /.panel-heading -->
                    
                            <div class="list-group">
  
           <a href="<?php echo site_url('pengajuan'); ?>" class="list-group-item">
  <i class="glyphicon glyphicon-th"></i> Pinjaman yang belum di Acc
					<?php echo''.$pengajuan.'';?></a>                        
          <a href="<?php echo site_url('pinjaman'); ?>" class="list-group-item">
  <i class="glyphicon glyphicon-th"></i> Pinjaman yang belum Lunas
					<?php echo''.$pinjam.'';?></a>           
                            </div>
                            <!-- /.list-group -->
                           
                        
                        </div>
					
	</div>
		
		
			
<div class="col-sm-3">
<div class="pinjaman">
<?php
foreach($eksternal->result() as $e){
echo "<div class=\"text-bulan\">Periode Bulan :  ".bulanan($bulanan)."</div>";	
echo "<div class=\"text-muted\">Total Jumlah Pinjaman : </br><b>Rp. ".Rp($e->per_total)."</b></div>";

}
?>	


	
<?php
foreach($orang->result() as $e){
echo "<div class=\"text-muted\">Total Peminjam : ".$e->total_anggota." Orang</div>";

}
?>		
<a class="btn btn-info btn-sm" href="<?php echo site_url('pinjaman/add'); ?>"><i class="glyphicon glyphicon-plus"></i> Buat Pengajuan Baru</a>
					
	</div>
	</div>
		
		
		
	<div class="col-sm-3">
<div class="pendapatan">
	<?php
foreach($kasbulanan->result() as $e){
echo "<div class=\"text-muted\">Periode Bulan :  ".bulanan($bulanan)."</div></br>";	
echo "<div class=\"text-muted\">Total  :  Rp. ".Rp($e->nilai)."</br>";

}
?>	<a class="btn btn-warning btn-sm" href="<?php echo site_url('pendapatan'); ?>"><i class="glyphicon glyphicon-search"></i> Detail</a></div>
<hr class='hr-hijau'>	
					
	</div>	
	</div>	
		
		
		
		
	</div>
	<!--FF -->
	
	<hr class="hr5">
	
	</div>
	
	
	
	
	
	
	
  
	

		

   

   
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>
  <!-- Morris Charts JavaScript -->
  	
<?php $this->load->view('include/footer2'); ?>