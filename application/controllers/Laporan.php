<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Laporan extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('admin', 'keuangan');

		if( ! in_array($level, $allowed))
		{
			redirect();
		}
	}

	public function index()
	{
		  $this->load->model('M_klien');
		$dt['klien']= $this->M_klien->get_all(); 
		$this->load->view('laporan/form_pinjaman', $dt);
	}
   public function simpanan()
	{
		$this->load->view('laporan/form_simpanan');
	}
	public function pinjaman()
	{
		$this->load->model('M_klien');
		$dt['klien']= $this->M_klien->get_all(); 
		$this->load->view('laporan/form_pinjaman', $dt);
	}
	
	public function angsuran()
	{
		
		$this->load->model('M_klien');
		$dt['klien']= $this->M_klien->get_all(); 
		$this->load->view('laporan/form_angsuran_pinjaman', $dt);
		
	}
	
	
	
	public function tabungan()
	{
		$this->load->view('laporan/form_tabungan');
	}
	public function penjualan($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->laporan_penjualan($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan', $dt);
	}

	
	public function cek_tabungan($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->laporan_tabungan($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_tabungan', $dt);
	}
	
	//cetak pinjaman
	public function cek_angsuran_anggota($debitur, $from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->ambil_laporan_angsuran_non($debitur, $from, $to);
		$dt['debitur']		= $debitur;

		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_angsuran_non', $dt);
	}
	public function cek_angsuran_semua($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->ambil_laporan_angsuran_semua($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_angsuran_non', $dt);
	}
		
	
	public function cek_pinjaman($debitur, $from, $to)
	{
		$this->load->model('m_transaksi_master');
	
		$dt['pinjaman'] 	= $this->m_transaksi_master->laporan_pinjaman_non_anggota($debitur, $from, $to);
		$dt['debitur']		= $debitur;

		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_pinjaman', $dt);
	}
	
	

	
	public function cetak_angsuran($debitur,$from, $to)
	{
		$this->load->model('m_transaksi_master');
	   if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_semua($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_non($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			
?>
<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?php echo config_item('font_awesome'); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo config_item('css'); ?>style-gue.css" rel="stylesheet">
		<script src="<?php echo config_item('js'); ?>jquery.min.js"></script>
		

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" style="width:15%;">
	<div id="logo">
	  	<img style=vertical-align: top src="<?php echo config_item('img'); ?>logo.png" width=80px />
            </div>
</td>
    <td align="left">
  

	<div id=company>
   <p align="center"><strong>KOPERASI PEGAWAI PEMERINTAH</strong><br />
          <strong>        KOTA  BANDUNG</strong><br />
          <strong>       ( K P K B  )</strong><br /></p>
  <p align="center" style="font-size:10px;"> Badan Hukum Paling  Akhir No. 1552/KEP/KWK-10/XI 24 November 1997<br />
    Jl. Wastukancana No.5 ,Telp. (Hunting)+6222-5206476. (Hunting)  +6222-4232338 ext.277</p>
		</td>
  </tr>
</table>
<hr>
				<?php 
				
				echo "
		
				<h4>Laporan Transaksi Angsuran Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<hr>
				<table class='table table-hover' width='100%' style='padding:2px;font-size: 12px;'>
					<thead>
						<tr>
<th style=\"width: 5%;\">No</th>
<th style=\"width: 21%;\">Tanggal</th>
<th style=\"\">Nama / Perusahaan</th>
<th style=\"width: 17%;\">Angsuran</th><th style=\"width: 17%;\">Sisa</th>
</tr>
					</thead>
					<tbody>
					
					
			";
			
			
			?>
			
			
			
			
			<?php

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tgl_entri))."</td>
						<td>".$p->nama."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->angsur))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->saldo))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->angsur;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Transaksi</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			</tbody>
			</table>
			";
		}
	}


public function angsuran_msword($debitur,$from, $to)
	{
		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_semua($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_non($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Transaksi_Angsuran_'.$from.'_'.$to;
			header("Content-type: application/vnd.ms-word");
			header("Content-Disposition: attachment; filename=".$filename.".doc");



			echo "
				<h4>Laporan Transaksi Angsuran Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='80%' style='padding:8px;'>
					<thead>
						<tr>
			<tr>
<th style=\"width: 5%;\">No</th>
<th style=\"width: 19%;\">Tanggal</th>
<th style=\"\">Nama / Perusahaan</th>
<th style=\"width: 15%;\">Angsuran</th><th style=\"width: 15%;\">Sisa</th>
</tr>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
					
						<td>".$p->nama."</td>
						
						<td>Rp. ".str_replace(",", ".", number_format($p->angsur))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->saldo))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->angsur;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi Pinjaman</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<b>".terbilang($total_penjualan)." Rupiah</b>
					</td>
				</tr>
			
			</tbody>
			</table>
			";
		}
	}
	
	
	
public function angsuran_excel($debitur, $from, $to)
	{
		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_semua($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_non($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Transaksi_Angsuran_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Transaksi Angsuran Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'  style='padding:8px;'>
					<thead>
										<tr>
<th style=\"width: 5%;\">No</th>
<th style=\"width: 19%;\">Tanggal</th>
<th style=\"\">Nama / Perusahaan</th>
<th style=\"width: 15%;\">Angsuran</th><th style=\"width: 15%;\">Sisa</th>
</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
					
						<td>".$p->nama."</td>
						
						<td>Rp. ".str_replace(",", ".", number_format($p->angsur))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->saldo))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->angsur;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi Pinjaman</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<b>".terbilang($total_penjualan)." Rupiah</b>
					</td>
				</tr>
			
			</tbody>
			</table>
			";
		}
	}





public function angsuran_pdf($debitur, $from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Transaksi Angsuran Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(85, 7, 'Tanggal', 1, 0, 'L');
		$pdf->Cell(85, 7, 'Total Transaksi', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_semua($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->ambil_laporan_angsuran_non($debitur, $from, $to);
		}
		
		 
		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(85, 7, date('d F Y', strtotime($p->tgl_entri)), 1, 0, 'L');
			$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($p->angsur)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->angsur;
			$no++;
		}

		$pdf->Cell(100, 7, 'Total Seluruh Transaksi', 1, 0, 'L'); 
		$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	










//end Angsuran
	
		//cetak pinjaman
		
public function cek_pinjaman_semua($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['pinjaman'] 	= $this->m_transaksi_master->laporan_pinjaman_semua_anggota($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_pinjaman', $dt);
	}
		
		
		
		
		
		
		public function pinjaman_excel($debitur,$from, $to)
	{
		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_semua_anggota($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_non_anggota($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Transaksi_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");


				
				echo "
				<h4>Laporan Transaksi Pinjaman Tanggal  :".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%' style='padding:8px'>
					<thead>
						<tr>
							<th>#</th>
				<th>Tanggal</th>
				<th>Nama / Perusahaan</th>
				<th>Pinjaman</th>
				
				<th>Pinjaman + Bunga</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
					
						<td>".$p->nama."</td>
						
						<td>Rp. ".str_replace(",", ".", number_format($p->besar_pinjam))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_pinjam))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_pinjam;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi Pinjaman</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<b>".terbilang($total_penjualan)." Rupiah</b>
					</td>
				</tr>
			
			</tbody>
			</table>
			";
		}
	}
	
			
		
	public function cetak_pinjaman($debitur, $from, $to)
	{
		$this->load->model('m_transaksi_master');
	    if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_semua_anggota($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_non_anggota($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			
?>
<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?php echo config_item('font_awesome'); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo config_item('css'); ?>style-gue.css" rel="stylesheet">
		<script src="<?php echo config_item('js'); ?>jquery.min.js"></script>
		

				<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" style="width:15%;">
	<div id="logo">
	  	<img style=vertical-align: top src="<?php echo config_item('img'); ?>logo.png" width=80px />
            </div>
</td>
    <td align="left">
  

	<div id=company>
   <p align="center"><strong>KOPERASI PEGAWAI PEMERINTAH</strong><br />
          <strong>        KOTA  BANDUNG</strong><br />
          <strong>       ( K P K B  )</strong><br /></p>
  <p align="center" style="font-size:10px;"> Badan Hukum Paling  Akhir No. 1552/KEP/KWK-10/XI 24 November 1997<br />
    Jl. Wastukancana No.5 ,Telp. (Hunting)+6222-5206476. (Hunting)  +6222-4232338 ext.277</p>
		</td>
  </tr>
</table>
<hr>
				<?php 
				
				echo "
				<p align=\"left\" style=\"font-size:14px;\">Laporan Transaksi Pinjaman Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</p><hr>";
				echo"
				
				<table class='table table-hover' width='100%' style='padding: 5px;font-size: 13px;'>
					<thead>
<tr>
<th style=\"width: 5%;\">No</th>
<th style=\"width: 21%;\">Tanggal</th>
<th style=\"\">Nama / Perusahaan</th>
<th style=\"width: 22%;\">Pinjaman</th>

</tr>
						
					</thead>
					<tbody>
					
					
			";
			
			
			?>
			
			
			
			
			<?php

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tgl_entri))."</td>
						<td>".trim($p->nama)."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->besar_pinjam))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_pinjam;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			</tbody>
			</table>
			";
		}
	}


	public function pinjaman_pdf($debitur,$from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Transaksi Pinjaman Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(85, 7, 'Tanggal', 1, 0, 'L');
		$pdf->Cell(85, 7, 'Total Transaksi', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_semua_anggota($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_non_anggota($debitur, $from, $to);
		}
		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(85, 7, date('d F Y', strtotime($p->tgl_entri)), 1, 0, 'L');
			$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($p->besar_pinjam)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_pinjam;
			$no++;
		}

		$pdf->Cell(100, 7, 'Total Seluruh Transaksi', 1, 0, 'L'); 
		$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	
	public function pinjaman_msword($debitur,$from, $to)
	{
		$this->load->model('m_transaksi_master');
		if($debitur == 'all')
		{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_semua_anggota($from, $to);
		}else{$penjualan 	= $this->m_transaksi_master->laporan_pinjaman_non_anggota($debitur, $from, $to);
		}
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Transaksi_'.$from.'_'.$to;
			header("Content-type: application/vnd.ms-word");
			header("Content-Disposition: attachment; filename=".$filename.".doc");



			echo "
				<h4>Laporan Transaksi Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>#</th>
				<th>Tanggal</th>
				<th>Nama / Perusahaan</th>
				<th>Pinjaman</th>
				
				<th>Pinjaman + Bunga</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".tanggal($p->tgl_entri)."</td>
					
						<td>".$p->nama."</td>
						
						<td>Rp. ".str_replace(",", ".", number_format($p->besar_pinjam))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_pinjam))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_pinjam;
				$no++;
			}

			echo "
				<tr>
					<td colspan='3'><b>Total Seluruh Transaksi Pinjaman</b></td>
					<td colspan='2'><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<b>".terbilang($total_penjualan)." Rupiah</b>
					</td>
				</tr>
			
			</tbody>
			</table>
			";
		}
	}
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	public function cek_pinjaman_anggota($debitur,$from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->ambil_laporan_pinjaman($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_pinjaman', $dt);
	}
	
	
	
	
	
	
	
	
	
	public function cetak($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$penjualan 	= $this->m_transaksi_master->laporan_penjualan($from, $to);
		if($penjualan->num_rows() > 0)
		{
			
?>
<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?php echo config_item('font_awesome'); ?>css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo config_item('css'); ?>style-gue.css" rel="stylesheet">
		<script src="<?php echo config_item('js'); ?>jquery.min.js"></script>
		
		
		
<?
			echo "
				<h4>Laporan Transaksi Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table class='table table-hover' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Total Transaksi</th>
						</tr>
					</thead>
					<tbody>
					
					
			";?>
			
			
			
			
			<?php

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tanggal))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_penjualan))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_penjualan;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Transaksi</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			</tbody>
			</table>
			";
		}
	}

	
	
	
	public function tanggal($tgl)
	{
		$this->load->model('m_transaksi_master');
		$penjualan 	= $this->m_transaksi_master->laporan_penjualan($tgl);
		if($penjualan->num_rows() > 0)
		{
			

			echo "
				<h4>Laporan Transaksi Tanggal ".date('d/m/Y', strtotime($tgl))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Total Transaksi</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tanggal))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_penjualan))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_penjualan;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Transaksi</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			</tbody>
			</table>
			";
		}
	}

	
	
	public function cek_simpanan($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$dt['penjualan'] 	= $this->m_transaksi_master->ambil_laporan_simpanan($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_simpanan', $dt);
	}
	
	public function simpanan_pdf($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 10, "Laporan Transaksi Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(25, 7, 'Kode', 1, 0, 'L');
		$pdf->Cell(75, 7, 'nama', 1, 0, 'L');
		$pdf->Cell(25, 7, 'wajib', 1, 0, 'L');
		$pdf->Cell(30, 7, 'pokok', 1, 0, 'L');
		
		$pdf->Cell(25, 7, 'Total Transaksi', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('m_transaksi_master');
		$penjualan 	= $this->m_transaksi_master->ambil_laporan_simpanan($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(25, 7, $p->kode_anggota, 1, 0, 'L');
			$pdf->Cell(75, 7, $p->nama, 1, 0, 'L');
			$pdf->Cell(25, 7, Rp($p->wajib), 1, 0, 'L');
			$pdf->Cell(30, 7, Rp($p->pokok), 1, 0, 'L');
			
			
			$pdf->Cell(25, 7, "Rp. ".str_replace(",", ".", number_format($p->per_total)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->per_total;
			$no++;
		}

		$pdf->Cell(165, 7, 'Total Seluruh Transaksi', 1, 0, 'L'); 
		$pdf->Cell(25, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function simpanan_excel($from, $to)
	{
		$this->load->model('m_transaksi_master');
		$penjualan 	= $this->m_transaksi_master->ambil_laporan_simpanan($from, $to);
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Transaksi_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Transaksi Simpanan ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
				<th>#</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Wajib</th>
				<th>Pokok</th>
				<th>Sukarela</th>
				<th>12 Juli</th>
				<th>Total Transaksi </th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
		    foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".$p->kode_anggota."</td>
						<td>".$p->nama."</td>
						<td>Rp.&nbsp;".Rp($p->wajib)."</td>
						<td>Rp.&nbsp;".Rp($p->pokok)."</td>
						<td>Rp.&nbsp;".Rp($p->sukarela)."</td>
						<td>Rp.&nbsp;".Rp($p->juli)."</td>
						<td>Rp.&nbsp;".str_replace(",", ".", number_format($p->per_total))."</td>
						
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->per_total;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Transaksi</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b><br>
					<em>".terbilang($total_penjualan)." Rupiah</em>
					</td>
				</tr>
			";
			
		}
	}

	
	

	public function pdf($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Transaksi Angsuran Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(85, 7, 'Tanggal', 1, 0, 'L');
		$pdf->Cell(85, 7, 'Total Transaksi', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('m_transaksi_master');
		$penjualan 	= $this->m_transaksi_master->laporan_angsuran_non_anggota($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(85, 7, date('d F Y', strtotime($p->tanggal)), 1, 0, 'L');
			$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(100, 7, 'Total Seluruh Transaksi', 1, 0, 'L'); 
		$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
}