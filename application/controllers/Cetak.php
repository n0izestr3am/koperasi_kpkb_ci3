<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('M_Anggota');
		$this->load->model('M_simpanan');
		$this->load->model('m_user');
		$this->load->database();
	}
	function index()
	{
	   	   $this->load->view('monika/home');
	}
	public function sukarela()
	{
	
                $kode_anggota 	= $this->input->get('kode_anggota');
                $besar_simpanan 	= $this->input->get('besar_simpanan');
                $jenis_simpan 	= $this->input->get('jenis_simpan');
                $nama 	= $this->input->get('nama');
                $alamat 	= $this->input->get('alamat');
                $this->load->helper('dompdf');
        	    $time = time();
		        $tgl2 = "%Y-%m-%d";
		        $this->load->model('M_Anggota');
				$this->load->model('M_simpanan');
				$this->load->model('m_user');
				$dt['besar_simpanan']= $besar_simpanan;
				$dt['kode_anggota']= $kode_anggota;
				$dt['jenis_simpan']= $jenis_simpan;
				$dt['alamat']= $alamat;
				$dt['nama']= $nama;
	        	$dt['simpanan'] = $this->M_simpanan->get_detail_simpanan($kode_anggota)->row();
			
        $html = $this->load->view('pdf/sukarela',$dt,true);
        // create pdf using dompdf
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
		
    }
	
	
	
	public function angsuran_eks()
	{
		     $kode_anggota 	= $this->input->get('kode_anggota');
             $kode_pinjam 	= $this->input->get('kode_pinjam');
             $this->load->helper('dompdf');
        	 $time = time();
		     $tgl2 = "%Y-%m-%d";
			 $dt['kode_anggota']= $kode_anggota;
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_angsuran');
			 $this->load->model('M_Anggota');
			 $dt['detail'] = $this->M_angsuran->get_detail_eksternal($kode_pinjam);
			 $dt['master'] = $this->M_angsuran->detail_pinjaman_eksternal($kode_pinjam)->row();

	    // $this->load->view('angsuran/detail', $dt);
		$html = $this->load->view('cetak/print_angsuran_eks',$dt,true);
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);
	}
	
	
	
	
	
	
	
	
	public function angsuran()
	{
		     $kode_anggota 	= $this->input->get('kode_anggota');
             $kode_pinjam 	= $this->input->get('kode_pinjam');
             $nama_klien 	= date('Y-m-d');
             $this->load->helper('dompdf');
        	 $time = time();
		     $tgl2 = "%Y-%m-%d";
			 $dt['kode_anggota']= $kode_anggota;
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_angsuran');
			 $this->load->model('M_Anggota');
			 $dt['detail'] = $this->M_angsuran->detail_angsuran_na($kode_pinjam);
			 $dt['master'] = $this->M_angsuran->detail_pinjaman_eksternal($kode_pinjam)->row();

	    // $this->load->view('angsuran/detail', $dt);
		$html = $this->load->view('cetak/print_angsuran_eks',$dt,true);
        $filename = 'Angsuran_Pinjaman_'.$kode_pinjam.'_'.$nama_klien;
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);
	}
	
	
	public function kwitansi_angsuran()
	{
		     $Diambil 	= $this->input->get('Diambil');
             $kode_pinjam 	= $this->input->get('kode_pinjam');
             $nama_klien 	= $this->input->get('nama_klien');
             $ke 	= $this->input->get('ke');
             $tgl 	= date('Y-m-d');
             $this->load->helper('dompdf');
        	 $time = time();
		     $tgl2 = "%Y-%m-%d";
			 $dt['Diambil']= $Diambil;
			 $dt['kode_pinjam']= $kode_pinjam;
			 $dt['nama_klien']= $nama_klien;
			 $dt['ke']= $ke;
			 $dt['tgl']= $tgl;
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_angsuran');
			 $this->load->model('M_Anggota');
			 $dt['detail'] = $this->M_angsuran->detail_angsuran_na($kode_pinjam);
			 $dt['master'] = $this->M_angsuran->detail_pinjaman_eksternal($kode_pinjam)->row();

	    // $this->load->view('angsuran/detail', $dt);
		$html = $this->load->view('cetak/print_kwitansi_angsuran',$dt,true);
        $filename = 'Kwitansi_Angsuran_Pinjaman_'.$kode_pinjam.'_'.$nama_klien;
        $paper = 'letter';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);
	}
	
	
	
	
	public function cetak_simpanan($kode_anggota = NULL)
	{
	
               
                $this->load->helper('dompdf');
        	    $time = time();
		        $tgl2 = "%Y-%m-%d";
		        $this->load->model('M_Anggota');
				$this->load->model('M_simpanan');
				$this->load->model('m_user');
				
	        	$dt['master'] = $this->M_simpanan->ambil_detail_simpanan($kode_anggota)->row();
		 // $this->load->view('pdf/simpanan',$dt);	
        $html = $this->load->view('pdf/simpanan',$dt,true);
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
		
    }
	
	public function cetak_sukarela($kode_simpan = NULL)
	{
	
               
                $this->load->helper('dompdf');
        	    $time = time();
		        $tgl2 = "%Y-%m-%d";
		        $this->load->model('M_Anggota');
				$this->load->model('M_simpanan');
				$this->load->model('m_user');
				
	        	$dt['data'] = $this->M_simpanan->get_detail_simpanan($kode_simpan)->row();
			
        $html = $this->load->view('pdf/sukarela',$dt,true);
        // create pdf using dompdf
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
		
    }
	public function cetak_tes($kode_simpan = NULL)
	{
	
               
               
        	    $time = time();
		        $tgl2 = "%Y-%m-%d";
		        $this->load->model('M_Anggota');
				$this->load->model('M_simpanan');
				$this->load->model('m_user');
				
	        	$dt['data'] = $this->M_simpanan->get_detail_simpanan($kode_simpan)->row();
			
       $this->load->view('pdf/sukarela',$dt);
       
		
    }
	
	
	public function pinjaman($id_kontrak = NULL)
	{
	
        // load dompdf
        $this->load->helper('dompdf');
        //load content html
		
	    $time = time();
		$tgl2 = "%Y-%m-%d";
			$this->load->model('M_Delivery_orders');
					
				
				$this->load->model('M_customer');
				$this->load->model('M_Rute');
				$this->load->model('M_kontrak');
				$this->load->model('M_produk');
	          	$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan']= $this->M_customer->get_all();
				$dt['produk']= $this->M_produk->get_all();
				$dt['rute']= $this->M_Rute->get_all();
				$dt['akses']= $this->M_kontrak->get_akses();
				$dt['kontrak'] = $this->M_kontrak->get_detail($id_kontrak)->row();
				
        $html = $this->load->view('kontrak/pdf',$dt,true);
        // create pdf using dompdf
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
		
    }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
