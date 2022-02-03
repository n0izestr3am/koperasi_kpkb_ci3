<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<style>
    .modal .modal-dialog { width: 60%; }
    .container { width: 100%; }
</style>
<?php
$level = $this->session->userdata('ap_level');
$pn = $this->db->query("SELECT * FROM eks_pinjaman where status='belum acc' and id_klien='$kode' order by id_klien desc");
$pengajuan = $pn->num_rows(); 
if($pengajuan>0){ $pengajuan ='<div class="span9"><span class="pesan"><a href='.site_url('pengajuan').'>Pengajuan pinjaman yg belum di Proses </a></span><span class="notif badge badge-warning">'.$pengajuan.'</span> </div>';
}else{$pengajuan ='';}

?>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='glyphicon glyphicon-briefcase'></i> Master Pinjaman : <?php echo $nama; ?> </h5>
			<?php echo''.$pengajuan.'';?>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
			
             <th>Kode Pinjam</th>
			 <th>Tgl Pinjam</th>
              <th>Besar Pinjam</th>
             <th>Besar Angsuran</th>
             <th>Lama Angsuran</th>
             <th>Jatuh Tempo</th>
             <th>Status</th>
			 <th>Aksi</th>
			 <th>Aksi</th>
			
							
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

        <?php 
$tambahan = '';	
$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";		
$baru = $this->db->query("SELECT * FROM eks_pinjaman where id_klien='$kode' order by id_klien desc");
$df = $baru->row();



$p = $this->db->query("SELECT * FROM eks_pinjaman where id_klien='$kode'");
$ajuan = $p->num_rows();
if($df==null)
        {
        $tambahan .= nbs(2)."<a href='".site_url('pinjaman/ajukan-pinjaman/'.$kode)."' id='pinjam' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-plus'></span> Tambah Pinjaman</a>";	
			
        }
    else if($df->status=='belum lunas')
        {
        	$tambahan .= nbs(2)."<a href='' disabled='disabled' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-plus'></span> Tambah Pinjaman</a>";
			
        }
       else if($df->status=='lunas')
        {
        	
$tambahan .= nbs(2)."<a href='".site_url('pinjaman/ajukan-pinjaman/'.$kode)."' id='pinjam' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-plus'></span> Tambah Pinjaman</a>";
		
        } 
		else if($ajuan>0)
        {
        	$tambahan .= nbs(2)."<a href='' disabled='disabled' class='btn btn-xs btn-default'><kbd style='background-color:#d9534f;'>".$ajuan."</kbd>  Pinjaman masih di Proses</a>";
        } 
		
		 else 
        {
        	
$tambahan .= nbs(2)."<a href='".site_url('pinjaman/ajukan-pinjaman/'.$kode)."' id='pinjam' class='btn btn-xs btn-primary'><span class='glyphicon glyphicon-plus'></span> Tambah Pinjaman</a>";
		
        } 
		
	
		
		?>



<script type="text/javascript" language="javascript" >
 	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data <?php echo $tambahan; ?>",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)", 
				"sZeroRecords": "Pencarian tidak ditemukan", 
				"sEmptyTable": "Data kosong", 
				"sLoadingRecords": "Harap Tunggu...", 
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting": [[ 0, "asc" ]],
			"columnDefs": [ 
				{
					"targets": 'no-sort',
					"orderable": false,
				}
	        ],
			"sPaginationType": "simple_numbers", 
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url :"<?php echo site_url('angsuran/list-angsuran-eks-json/'.$kode.''); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});
	
	$(document).on('click', '#pinjam,#lihat, #angsuran,#view', function(e){
		e.preventDefault();

		$('.modal-dialog').addClass('modal-lg');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'view')
		{
			$('#ModalHeader').html('View Angsuran');
		}
		if($(this).attr('id') == 'angsuran')
		{
			$('#ModalHeader').html('Angsuran');
		}
		if($(this).attr('id') == 'pinjam')
		{
			$('#ModalHeader').html('Pinjaman ');
		}
		if($(this).attr('id') == 'lihat')
		{
			$('#ModalHeader').html('Angsuran ');
		}
		
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
	

</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>