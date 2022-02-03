<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>
<style>
    .modal .modal-dialog { width: 70%; }
    .container { width: 100%; }
</style>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-users fa-fw'></i> Transaksi Pinjaman Non Anggota </h5>
			<hr />

  
<div class='table-responsive'>
<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
<h6>Pencarian Berdasarkan Jumlah Nominal Pinjaman </h6>
<form class="form-inline">
	 <div class="form-group">
    <label for="exampleInputName2">Minimum</label>
    <input type="text" class="form-control" id="min" placeholder="10">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">Maximum</label>
    <input type="text" class="form-control" id="max" placeholder="15">
  </div>			
</form>
<hr />				
				
				
				
				
				
				
				
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:2%;">#</th>
							<th style="width:8%;">ID</th>
							<th >Nama</th>
							<th style="width:12%;">Besar Pinjaman</th>
							<th>Tgl Pinjam</th>
							<th>Jatuh tempo</th>
							
							<?php if($level == 'admin' OR $level == 'staff') { ?>
							<th style="width:12%;" class='no-sort'>Status Pinjaman</th>
							<th style="width:8%;" class='no-sort'>Angsur</th>
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
	$tambahan .= nbs(2)."<a href='".site_url('pinjaman/add')."' class='btn btn-sm btn-default' id=''><i class='fa fa-plus fa-fw'></i> Buat Pengajuan Pinjaman Baru </a>";
	$tambahan .= nbs(2)."<a href='".site_url('angsuran/external')."' class='btn btn-sm btn-primary' id=''><i class='fa fa-plus fa-fw'></i> Angsuran </a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
?>

<script type="text/javascript" language="javascript" >
$('#min, #max').keyup(function() {
   var min = parseInt( $('#min').val(), 10 );
   var max = parseInt( $('#max').val(), 10 );
   $('#my-grid tbody tr').each(function() {
     var age = parseFloat( $('td:eq(3)', this).text() ) || 0; 
if (( isNaN( min ) && isNaN( max )) ||
         ( isNaN( min ) && age <= max ) ||
         ( min <= age   && isNaN( max )) ||
         ( min <= age   && age <= max )) {
        $(this).show()
     } else {
        $(this).hide()
     }   
   })
});
	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per <?php echo $tambahan; ?>",
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
				url :"<?php echo site_url('pinjaman/list-external-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
		
	
		
	});
	
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
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
		});
	});

	$(document).on('click', '#TambahBahan, #Pending,#View, #Angsur', function(e){
		e.preventDefault();

		$('.modal-dialog').addClass('modal-lg');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahBahan')
		{
			$('#ModalHeader').html('Transaksi Pinjaman Non Anggota');
		}
		if($(this).attr('id') == 'Angsur')
		{
			$('#ModalHeader').html('Angsur Pinjaman');
		}
		if($(this).attr('id') == 'Pending')
		{
			$('#ModalHeader').html('Transaksi Pending');
		}
		if($(this).attr('id') == 'View')
		{
			$('#ModalHeader').html('Detail Pinjaman');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/1.10.16/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>