<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<style>
    .modal .modal-dialog { width: 60%; }
    .container { width: 100%; }
</style>
<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4><span class='glyphicon glyphicon-briefcase'></span> Transaksi : <?php echo $nama; ?> 
			<?php 
 $wajib = $this->db->query("select* from pinjaman where kode_anggota='$kode'");
 $total = $wajib->num_rows();
  
 echo'<kbd style="background-color:#d9534f;">'.$total.'</kbd>';
  
  ?></h4>
		
		 <span style="float:right;">
        <?php 
$baru = $this->db->query("SELECT * FROM pinjaman where kode_anggota='$kode' order by kode_pinjam desc");
$df = $baru->row();
$pengajuan = $this->db->query("SELECT * FROM pengajuan where kode_anggota='$kode'");
$ajuan = $pengajuan->num_rows();
         if($df->status=='belum lunas')
        {
        	echo '<a href="href=index.php?pilih=2.1&aksi=pinjam" disabled="disabled" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pinjaman</a> ';
        }
        else if($df->status=='lunas')
        {
        	echo '<a href="'.site_url('transaksi/pinjam/'.$kode).'" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pinjaman</a> ';
        } 
		else if($ajuan>0)
        {
        	echo '<a href="'.site_url('transaksi/pinjam/'.$kode).'" disabled="disabled" class="btn btn-sm btn-default"><kbd style="background-color:#d9534f;">'.$ajuan.'</kbd>  Pinjaman masih di Proses</a> ';
        } 
		
        else if($total<=0)
        {
        	echo '<a class="btn btn-sm btn-primary" href="'.site_url('transaksi/pinjam/'.$kode).'" id="pinjam" ><i class="glyphicon glyphicon-plus"></i> Tambah Pinjaman</a> ';
			
        }?>
 
                    </span>
		
		
		
			
					
		<div class="clearfix"></div>			
			<hr />
	

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				
				<table class="table table-striped table-bordered table-hover" id="my-grid">
				<?php echo $tambahan; ?>
                                    <thead>
                                        <tr>
             <th>No</th>
             <th>Kode Pinjam</th>
			 <th>Tangggal Pinjam</th>
             <th>Jenis Pinjam</th>
             <th>Besar Pinjam</th>
             <th>Besar Angsuran</th>
             <th>Lama Angsuran</th>
             <th>Jatuh Tempo</th>
             <th>Status</th>
			 <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
									
	    $pinjaman = $this->db->query("SELECT * FROM pinjaman a 
		LEFT JOIN jenis_pinjam b ON a.kode_jenis_pinjam=b.kode_jenis_pinjam 
		where a.kode_anggota='".$this->db->escape_str($kode)."'");
		$kd_p = $u['kode_pinjam'];
		
				 $no = 1;
                 foreach ($pinjaman->result_array() as $u){
				 $angsuran = $this->db->query("SELECT * FROM angsuran where kode_pinjam='$kd_p' and kode_anggota='$kode'");
				 $ang = $angsuran->row();
                                    ?>
            <tr class="odd gradeX">
            <td><?php echo $no;?></td>
			<td><?php echo $u['kode_pinjam'];?></td>
            <td><?php echo tanggal($u['tgl_entri']);?></td>
			<td><?php echo $u['nama_pinjaman'];?></td>
			<td>Rp. <?php echo Rp($u['besar_pinjam']);?></td>
			<td>Rp. <?php echo Rp($u['besar_angsuran']);?></td>
			<td><?php echo $u['sisa_angsuran'];?> Bulan Dari <?php echo $u['lama_angsuran'];?> Bulan</td>
			<td><?php echo tanggal($u['tgl_tempo']);?></td>
			 <td><?php echo $u['status'];?></td>
			
			 <td>
			 <?php echo '<a class="btn btn-primary btn-xs" href=index.php?pilih=3.3&aksi=show&kode_anggota='.$u['kode_anggota'].'&kode_pinjam='.$u['kode_pinjam'].'>View</a>';?>
			 <?php if($ang->lama_angsuran==$u['lama_angsuran'])
			{
				echo '<a class="btn btn-warning btn-xs" disabled="disabled">Angsur</a>';
			}
			else
			{
echo '<a class="btn btn-warning btn-xs" href="'.site_url('transaksi/angsuran/'.$u['kode_anggota']).'" id="angsuran"><i class="fa fa-pencil"></i> Angsur</a>';
			}
			?></td>
			
            
                                          
                                        </tr>
                                    <?php 
									 $no++;
									}
                                    
									?>

</tbody>   
									
                                 
                                </table>
				
				
				
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = '';
if($level == 'admin' OR $level == 'inventory')
{
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
?>

<script type="text/javascript" language="javascript" >
 
	$(document).on('click', '#pinjam, #angsuran','#Angsur', function(e){
		e.preventDefault();

		$('.modal-dialog').addClass('modal-lg');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahBahan')
		{
			$('#ModalHeader').html('Tambah Anggota');
		}
		if($(this).attr('id') == 'angsuran')
		{
			$('#ModalHeader').html('Angsuran');
		}
		if($(this).attr('id') == 'pinjam')
		{
			$('#ModalHeader').html('Pinjaman ');
		}
		
		
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
	

</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>