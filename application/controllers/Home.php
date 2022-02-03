<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('ap_level') == 'inventory'){
			redirect();
		}
	}

	public function index()
	{
	
	$this->load->model('M_pinjaman');
	$this->load->model('M_home');
	
		$bulanan 	= date('m');
		$dt['bulanan'] = $bulanan;
		$dt['total_transaksi'] = $this->M_home->total_transaksi()->result();
		$dt["kasbulanan"] = $this->M_home->ambil_kas_bulanan($bulanan);  
		$dt['kas'] = $this->M_home->total_kas()->result();
	    $dt['pinj'] = $this->M_home->get_p();
	    $dt['telat'] = $this->M_home->telat();
	    $dt['lancar'] = $this->M_home->lancar();
	   	$dt["eksternal"] = $this->M_pinjaman->ambil_pinjaman_bulanan_eksternal($bulanan); 
	    $dt["orang"] = $this->M_pinjaman->ambil_pinjaman_bulanan_orang($bulanan);  
	   
		$this->load->view('home/data',$dt);
	}



public function c()
	{
		$this->load->view('home/chart2');
	}















	
}