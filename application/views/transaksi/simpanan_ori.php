<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4><span class='glyphicon glyphicon-briefcase'></span> Laporan Simpanan Anggota : <?php echo $nama; ?> 	<?php 
 $wajib = $this->db->query("SELECT *FROM simpanan where kode_anggota='$kode' and jenis_simpan='wajib' order by kode_simpan desc");
 $total = $wajib->num_rows();
  
 echo'<kbd style="background-color:#d9534f;">'.$total.'</kbd>';
  
  ?></h4>
		
			<span style="float:right;">
			<?php
		$no=1;	
	foreach ($jenis->result_array() as $p){
if($p['nama_simpanan']=='wajib')
 {
 $baru = $this->db->query("SELECT * FROM simpanan where kode_anggota='$kode' and jenis_simpan='wajib' order by kode_simpan desc");
 $row = $baru->row();
 $total = $baru->num_rows();
 $data=$row->tgl_entri;
 $now=date("Y-m-d");
 $wajib=date('Y-m-d',strtotime('+30 day',strtotime($data)));
 

 	if($data==$wajib)
 	{
echo '<a class="btn btn-danger" href="'.site_url('transaksi/wajib/'.$kode).'" id="wajib">
<i class="fa fa-warning"></i> Wajib '.tanggal($data).' </a> ';
 	}	
	
	else if($data<=0)
 	{
echo '<a class="btn btn-danger"  href="'.site_url('transaksi/wajib/'.$kode).'" id="wajib">
<i class="fa fa-warning"></i> Wajib '.tanggal($now).'</a> ';
 	}
	else if($data<$wajib)
 	{
 		echo '<a class="btn btn-xs btn-danger" disabled="disabled" >
		<i class="fa fa-warning"></i> Wajib '.tanggal($wajib).'</a> ';
 	}
	else if($data>$wajib)
 	{
 		echo '<a class="btn btn-xs btn-danger"  btn-xsdisabled="disabled"  href="'.site_url('transaksi/wajib/'.$kode).'" id="wajib">
		<i class="fa fa-warning"></i> Wajib '.tanggal($data).'</a> ';
 	}
}
 else if($p['nama_simpanan']=='sukarela')
 {
 	echo '<a class="btn btn-xs btn-success" href="'.site_url('transaksi/sukarela/'.$kode).'" id="sukarela" ><i class="glyphicon glyphicon-link"></i> Sukarela</a> ';
 }
 
 else if($p['nama_simpanan']=='pokok')
 {
 	echo '<a class="btn btn-xs btn-success" href="'.site_url('transaksi/pokok/'.$kode).'" id="pokok" ><i class="glyphicon glyphicon-link"></i> Pokok</a> ';
 }
 else if($p['nama_simpanan']=='12 juli')
 {
 	echo '<a class="btn btn-xs btn-success" href="'.site_url('transaksi/pokok/'.$kode).'" id="pokok" ><i class="glyphicon glyphicon-link"></i> Pokok</a> ';
 }
 
 $no++;

	 }?>
<a href="laporan/print_show_simpanan.php?kode=<?php echo $kode;?>" target="_blank" class="btn btn-xs btn-primary"><span class='glyphicon glyphicon-print'></span> Print</a> 
                    </span>
					
		<div class="clearfix"></div>			
			<hr />
	

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				
				<table class="table table-striped table-bordered table-hover" id="my-grid">
				<thead>
						<tr>
			<th >No</th>
             <th>Tanggal</th>
             <th>Nama Simpanan</th>
			 <th>Besar Simpanan</th>
			 <th style="width:8%">Cetak</th>
						</tr>
					</thead>
                      <tbody>
                                    <?php
									
				 $simpanan = $this->db->query("SELECT * from simpanan where kode_anggota='$kode' order by kode_simpan desc");
				 $no = 1;
                 foreach ($simpanan->result_array() as $u){
                                    ?>
            <tr class="odd gradeX">
            <td><?php echo $no;?></td>
            <td><?php echo tanggal($u['tgl_entri']);?></td>
			<td><?php echo ucfirst($u['jenis_simpan']);?></td>
            <td>Rp. <?php echo Rp($u['besar_simpanan']);?></td>
 <td ><a href="<?php echo site_url('cetak/cetak-sukarela/'.$u['kode_simpan'].''); ?>" target="_blank" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-print"></span> Cetak</a></td>
                                          
                                        </tr>
                                    <?php 
									 $no++;
									}
                                    
									?>
<tr class="info">

<td colspan="2" align="center"></td>
<td align="center">Total</td>
  <td>Rp. <?php 
  $bu = $this->db->query("SELECT sum(besar_simpanan) as besar_simpan from simpanan where kode_anggota='$kode'")->row_array();
  echo Rp($bu['besar_simpan']);
  echo '</br><b>';
  echo terbilang($bu['besar_simpan']);
  echo '</b></td>';?>
  <td align="center"></td>
</tr>
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
	
	$(document).on('click', '#HapusBahan', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus <br /><b>'+$(this).parent().parent().find('td:nth-child(2)').html()+'</b> ?');
		$('#ModalFooter').html("<button type='button' class='btn btn-success' id='YesDeleteBahan' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDeleteBahan', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
			success: function(data){
				$('#Notifikasi').html(data.pesan);
				$("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
				//$('#my-grid').ajax.reload( null, false );
			}
		});
	});

	$(document).on('click', '#sukarela, #wajib','#angsuran', function(e){
		e.preventDefault();

		$('.modal-dialog').addClass('modal-lg');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahBahan')
		{
			$('#ModalHeader').html('Tambah Anggota');
		}
		if($(this).attr('id') == 'wajib')
		{
			$('#ModalHeader').html('Simpanan Wajib');
		}
		if($(this).attr('id') == 'sukarela')
		{
			$('#ModalHeader').html('Simpanan Sukarela');
		}
		
		
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>