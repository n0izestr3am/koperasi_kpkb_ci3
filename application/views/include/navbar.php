<?php
$controller = $this->router->fetch_class();
$level = $this->session->userdata('ap_level');
$eks = $this->db->query("SELECT * FROM eks_pinjaman where acc='belum' order by kode_pinjam desc");
$total_eks = $eks->num_rows(); 
if($total_eks>0)
{$total_eks ='<span class="notif badge badge-warning">'.$total_eks.'</span>';}else{$total_eks ='';}

$pn = $this->db->query("SELECT * FROM eks_pinjaman where status='Belum di acc' order by kode_pinjam desc");
$pengajuan = $pn->num_rows(); 
if($pengajuan>0){ $pengajuan ='<span class="notif badge badge-warning">'.$pengajuan.'</span>';
}else{$pengajuan ='';}

?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a  href="<?php echo site_url(); ?>">
			<img alt="<?php echo config_item('web_title'); ?>" src="<?php echo config_item('img'); ?>logo_small.png" style="width:40px;margin-top: 3px;float:left;" width="40">
			</a>
		
		</div>

		

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<p class="navbar-text"><b>KPKB</b></p>
		
			<ul class="nav navbar-nav">
<li class="<?php if($controller == 'home' ) { echo 'active'; } ?>"><a href="<?php echo site_url('home'); ?>"><i class='fa fa-home fa-fw'></i> Dashboard</a></li>
				<?php if($level == 'admin' OR $level == 'staff') { ?>
<li class="dropdown <?php if($controller == 'anggota' OR $controller == 'peminjam' OR $controller == 'pendapatan'  OR $controller == 'user') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='glyphicon glyphicon-th'></i> Master Data <span class="caret"></span></a>
					<ul class="dropdown-menu">
						
						
						<li><a href="<?php echo site_url('user'); ?>">Data User</a></li>
						<li><a href="<?php echo site_url('peminjam'); ?>">Data Peminjam</a></li>
						<li><a href="<?php echo site_url('pendapatan'); ?>">Pendapatan</a></li>
					</ul>
				</li>
				<?php } ?>

				
	
		<li class="dropdown <?php if($controller == 'transaksi' OR $controller == 'angsuran' OR $controller == 'pinjaman' OR $controller == 'external' OR $controller == 'pengajuan') { echo 'active'; } ?>">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
<i class='fa fa-dollar fa-fw'></i> Transaksi <span class="caret"></span></a>
					<ul class="dropdown-menu">
				<?php if($level == 'admin' OR $level == 'staff') { ?>
				<li><a href="<?php echo site_url('pengajuan'); ?>">Data Pengajuan
					<?php echo''.$total_eks.'';?></a></li>
					<li><a href="<?php echo site_url('angsuran'); ?>">Data Angsuran</a></li>
					<li><a href="<?php echo site_url('pinjaman'); ?>">Data Pinjaman</a></li>
						<?php } ?>	
					
					</ul>
				</li>
			
			
			
			
					
				
				
<li class="dropdown <?php if($controller == 'setting' ) { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-wrench fa-fw'></i> Pengaturan <span class="caret"></span></a>
					<ul class="dropdown-menu">
				
					<li><a href="<?php echo site_url('setting/unit'); ?>">Setting Unit</a></li>
						<li><a href="<?php echo site_url('setting/pinjaman'); ?>">Setting Pinjaman</a></li>
						<li><a href="<?php echo site_url('setting/kas'); ?>">KAS KPKB</a></li>
						
					</ul>
				</li>
				
				<li class="dropdown <?php if($controller == 'laporan') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-file-text-o fa-fw'></i> Laporan <span class="caret"></span></a>
					<ul class="dropdown-menu">
				
						<li><a href="<?php echo site_url('laporan/pinjaman'); ?>">Laporan Pinjaman</a></li>
						<li><a href="<?php echo site_url('laporan/angsuran'); ?>">Laporan Angsuran</a></li>
						
					</ul>
				</li>
				
				

			
				
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-user fa-fw'></i> <?php echo $this->session->userdata('ap_nama'); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('user/ubah-password'); ?>" id='GantiPass'>Ubah Password</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url(); ?>"><i class='fa fa-sign-out fa-fw'></i> Lihat Web</a></li>
						<li><a href="<?php echo site_url('secure/logout'); ?>"><i class='fa fa-sign-out fa-fw'></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script>
$(document).on('click', '#GantiPass', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Ubah Password');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});
</script>


<div class="container">
