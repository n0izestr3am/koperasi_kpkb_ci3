<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<style>
    .modal .modal-dialog { width: 70%; }
    .container { width: 100%; }
</style>
<?php
$level = $this->session->userdata('ap_level');

?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-share fa-fw'></i> Transaksi Angsuran Pinjaman </h5>
			<hr />
<div class="well"><i class='fa fa-info fa-fw'></i> Halaman Angusan Pinjaman Non Anggota yang belum lunas</div>
			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:2%;">#</th>
							<th style="width:8%;">ID</th>
							<th style="width:22%;">Nama</th>
							<th style="width:11%;">Angsuran Ke</th>
							<th style="width:18%;">Sisa Angsuran</th>
							<th>Sisa Pinjaman</th>
						
							<?php if($level == 'admin' OR $level == 'inventory') { ?>
							<th style="width:6%;" class='no-sort'>Detail </th>
							<th style="width:6%;" class='no-sort'>Angsur</th>
							<?php } ?>
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
if($level == 'admin' OR $level == 'inventory')
{
	$tambahan .= nbs(2)."<a href='".site_url('angsuran/lunas')."' class='btn btn-sm btn-info' id=''><i class='fa fa-share fa-fw'></i> Data Angsuran yang sudah Lunas</a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
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
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data  <?php echo $tambahan; ?>",
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
				url :"<?php echo site_url('angsuran/list-angsuran-eksternal-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});

	$(document).on('click', '#pinjam,#lihat,#Detail, #angsuran,#view', function(e){
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
		
		if($(this).attr('id') == 'Detail')
		{
			$('#ModalHeader').html('Detail Angsuran');
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