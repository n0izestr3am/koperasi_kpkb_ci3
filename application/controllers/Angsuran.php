<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Angsuran extends MY_Controller
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
		$this->load->view('angsuran/data_eksternal');
	}
	public function external()
	{
		$this->load->view('angsuran/data_eksternal');
	}
	
	
	public function lunas()
	{
		$this->load->view('angsuran/lunas');
	}
	
	
	
	public function angsuran_json()
	{
		$this->load->model('M_angsuran');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_angsuran->fetch_data_angsuran_all($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$kode_anggota	= $row['kode_anggota'];
			$angsuran_ke 	= $this->M_angsuran->max_angsuran_ke($kode_anggota)->row()->angsuran_ke;
			$pengajuan = $this->db->query("SELECT * FROM pinjaman where kode_anggota='$kode_anggota' and status='belum lunas'");
            $ajuan = $pengajuan->num_rows();
			$nestedData[]	= $row['nomor'];
			if($ajuan>0)
			{
            $nestedData[]	= "".$row['kode_anggota']."<span style='position: absolute;background-color: #e6421d;' class='badge badge-warning'>".$ajuan."</span>";
			}else{
			$nestedData[]	= $row['kode_anggota'];
			}
			$nestedData[]	= $row['nama'];
			$nestedData[]	= "<center><span style='background-color: #1d6de6;' class='badge badge-warning'>".$angsuran_ke."</span></center>";
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= $row['sisa_pinjaman'];
		
			if($level == 'admin' OR $level == 'inventory')
			{
 $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('angsuran/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-search'></i> Detail & <i class='fa fa-print'></i> Print</a>";
if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-success btn-xs' disabled='disabled'>Sudah Lunas</a>";
				
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('angsuran/add/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
			}
			}
			$data[] = $nestedData;
		}
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
			);
		echo json_encode($json_data);
	}
	
	public function list_angsuran_json($kode_anggota = NULL)
	{
		$this->load->model('M_angsuran');
		$this->load->model('M_pinjaman');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_angsuran->fetch_data_angsuran($kode_anggota,$requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			
			$nestedData = array(); 
			$kd_p = $row['kode_pinjam'];
			
			$angsuran = $this->db->query("SELECT * FROM angsuran where kode_pinjam='$kd_p' and kode_anggota='$kode_anggota'");
			$ang = $angsuran->row();
			$nestedData[]	= $row['kode_pinjam'];
			$nestedData[]	= tanggal($row['tgl_entri']);
			$nestedData[]	= ucfirst($row['nama_pinjaman']);
			$nestedData[]	= $row['besar_pinjam'];
			$nestedData[]	= $row['besar_angsuran'];
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= tanggal($row['tgl_tempo']);
			$nestedData[]	= $row['status'];
			 $nestedData[]	= "<a class='btn btn-default btn-xs' href='".site_url('angsuran/view-angsuran/'.$row['kode_pinjam'])."' id='Print'><i class='fa fa-print'></i> Print</a>";
		    $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('angsuran/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-eye'></i> View</a>";

			if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-success btn-xs' disabled='disabled'>Lunas</a>";
				
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('angsuran/add/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}


public function list_angsuran_eksternal_json()
	{
		$this->load->model('M_angsuran');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_angsuran->fetch_data_angsuran_external($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$id_klien	= $row['id_klien'];
			$angsuran_ke 	= $this->M_angsuran->max_angsuran_eks_ke($id_klien)->row()->angsuran_ke;
			$pengajuan = $this->db->query("SELECT * FROM eks_pinjaman where id_klien='$id_klien' and status='belum lunas'");
            $ajuan = $pengajuan->num_rows();
			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id_klien'];
			if($ajuan>0)
			{
            $nestedData[]	= "".$row['nama']."<span style='position: absolute;background-color: #e6421d;' class='badge badge-warning'>".$ajuan."</span>";
			}else{
			$nestedData[]	= $row['nama'];
			}
			
			$nestedData[]	= "<center><span style='background-color: #1d6de6;' class='badge badge-warning'>".$angsuran_ke."</span></center>";
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= $row['sisa_pinjaman'];
		
			if($level == 'admin' OR $level == 'inventory')
			{
 $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('pinjaman/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-search'></i> Detail & <i class='fa fa-print'></i> Print</a>";
if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-success btn-xs' disabled='disabled'>Sudah Lunas</a>";
				
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
			}
			}
			$data[] = $nestedData;
		}
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
			);
		echo json_encode($json_data);
	}


//Angusan yang sudah lunas

public function list_angsuran_lunas_json()
	{
		$this->load->model('M_angsuran');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_angsuran->fetch_data_angsuran_lunas($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$id_klien	= $row['id_klien'];
			$angsuran_ke 	= $this->M_angsuran->max_angsuran_eks_ke($id_klien)->row()->angsuran_ke;
			$pengajuan = $this->db->query("SELECT * FROM eks_pinjaman where id_klien='$id_klien' and status='belum lunas'");
            $ajuan = $pengajuan->num_rows();
			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id_klien'];
			if($ajuan>0)
			{
            $nestedData[]	= "".$row['nama']."<span style='position: absolute;background-color: #e6421d;' class='badge badge-warning'>".$ajuan."</span>";
			}else{
			$nestedData[]	= $row['nama'];
			}
			
			$nestedData[]	= "<center><span style='background-color: #1d6de6;' class='badge badge-warning'>".$angsuran_ke."</span></center>";
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= $row['sisa_pinjaman'];
		
			if($level == 'admin' OR $level == 'inventory')
			{
 $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('pinjaman/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-search'></i> Detail & <i class='fa fa-print'></i> Print</a>";
if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-warning btn-xs' disabled='disabled'>Sudah Lunas</a>";
				
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
			}
			}
			$data[] = $nestedData;
		}
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
			);
		echo json_encode($json_data);
	}











		public function list_angsuran_eks_json($id_klien = NULL)
	{
		$this->load->model('M_angsuran');
		$this->load->model('M_pinjaman');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_angsuran->fetch_data_angsuran_eks($id_klien,$requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			
			$nestedData = array(); 
			$kd_p = $row['kode_pinjam'];
			
			$angsuran = $this->db->query("SELECT * FROM angsuran where kode_pinjam='$kd_p' and id_klien='$id_klien'");
			$ang = $angsuran->row();
			$nestedData[]	= $row['kode_pinjam'];
			$nestedData[]	= tanggal($row['tgl_entri']);
			$nestedData[]	= $row['besar_pinjam'];
			$nestedData[]	= $row['besar_angsuran'];
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= tanggal($row['tgl_tempo']);
			$nestedData[]	= $row['status'];
			 $nestedData[]	= "<a class='btn btn-default btn-xs' href='".site_url('angsuran/view-angsuran/'.$row['kode_pinjam'])."' id='Print'><i class='fa fa-print'></i> Print</a>";
		    $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('angsuran/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-eye'></i> View</a>";

			if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-success btn-xs' disabled='disabled'>Lunas</a>";
				
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('angsuran/add/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}

	//ANGSURANNNNN

public function add($kode_pinjam = NULL)
	{
		if( ! empty($kode_pinjam))
		{
		    $level = $this->session->userdata('ap_level');
		    $this->load->model('M_Anggota');
			$this->load->model('M_pinjaman');
			$this->load->model('M_angsuran');
			$this->load->model('M_simpanan');
			$this->load->model('m_user');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('besar_angsuran','Angsuran','trim|required|callback_cek_minus[besar_angsuran]');
				$this->form_validation->set_rules('kode_anggota','Kode','trim|required');
				$this->form_validation->set_message('required','%s harus diisi !');
                $this->form_validation->set_message('cek_minus', '%s tidak boleh kurang');
				if($this->form_validation->run() == TRUE)
				{
					
					$besar_pinjam 	    = $this->input->post('besar_pinjam');
					$besarangsu 	    = $this->input->post('besar_angsuran');
					$angsuran_ke 	    = $this->input->post('angsuran_ke');
					$denda 	            = $this->input->post('denda');
					//$kode_pinjam 	    = $this->input->post('kode_pinjam');
					$user 	        = $this->input->post('user');
					$lama_angsuran 	    = $this->input->post('lama_angsuran');
					$tempo 	            = $this->input->post('tempo_pinjaman');
					$kode_anggota 	    = $this->input->post('kode_anggota');
					$bunga 	            = $this->input->post('bunga');
					$pokok_asli 	            = $this->input->post('pokok_asli');
					$bunga_asli 	            = $this->input->post('bunga_asli');
					$sisa_angsur 	    = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->sisa_angsuran;
			       	$sisa_pinjaman 	    = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->sisa_pinjaman;
					$besar_angsuran     = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->besar_angsuran;
$kk = $this->db->query("SELECT * from pinjaman where kode_pinjam='$kode_pinjam' and kode_anggota='$kode_anggota'")->row_array();
                    //$tempo=$kk['tgl_tempo'];
					$sisa=$sisa_pinjaman-$besarangsu;
					$hasilangsur=$lama_angsuran-$angsuran_ke;
					$tgl_entri=date('Y-m-d');
					$id_klien='0';
					//$tempo=date('Y-m-d');
					
if($lama_angsuran==$angsuran_ke)
					{ $this->M_angsuran->update_angsuran_lunas($kode_pinjam,$sisa,$angsuran_ke);}
				   	else { $this->M_angsuran->update_angsuran_ke($kode_pinjam,$hasilangsur,$sisa,$tempo);}
							
$insert = $this->M_angsuran->tambah_angsur($kode_pinjam,$angsuran_ke,$besarangsu,$denda,$sisa,$kode_anggota,$id_klien,$user,$tgl_entri);
			
$sisa_pinjaman = $this->M_pinjaman->get_baris_pinjaman($kode_pinjam)->row()->sisa_pinjaman;
if($sisa_pinjaman==0)
{ $this->M_angsuran->angsuran_lunas($kode_pinjam);}
				if($insert)
					{   
					    $this->M_angsuran->transaksi($tgl_entri,$kode_anggota,$bunga,$user);
						$nilai 	= $pokok_asli;
						$this->M_simpanan->kas_koperasi($nilai);
					    $nama = $this->M_Anggota->get_nama($kode_anggota)->row()->nama;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil disimpan.</div>",				
						));
					    }
										
					else
					{
						$this->query_error();
					}
				  }
				
				
			else { $this->input_error();}
			}
			
			else
			{
			   
						$dt['kasirnya'] = $this->m_user->list_kasir();
						$dt['detail'] = $this->M_angsuran->get_detail($kode_pinjam);
						$dt['master'] = $this->M_pinjaman->get_detail_pinjaman($kode_pinjam)->row();
						$this->load->view('angsuran/add', $dt);
			}
		}
	}
}

public function cek_minus($besarangsu)
	{
		if($besarangsu > 0){
			return TRUE;
		}
		return FALSE;
	}




public function print_baris()
	{
		     $kode_anggota 	= $this->input->get('kode_anggota');
             $kode_pinjam 	= $this->input->get('kode_pinjam');
             $baris 	= $this->input->get('baris');
             // $this->load->helper('dompdf');
        	 $time = time();
		     $tgl2 = "%Y-%m-%d";
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_angsuran');
			 $this->load->model('M_Anggota');
			 $dt['baris'] = $baris;
			 $dt['detail'] = $this->M_angsuran->detail_angsuran_na($kode_pinjam);
			 $dt['master'] = $this->M_angsuran->detail_pinjaman_eksternal($kode_pinjam)->row();

	    $this->load->view('angsuran/print_baris', $dt);
		// $html = $this->load->view('angsuran/print_baris',$dt,true);
        // $filename = $tgl2;
        // $paper = 'A4';
        // $orientation = 'potrait';
        // pdf_create($html, $filename, $paper, $orientation);
	}


//ANGSURANNNNN

	
	public function view_angsuran($kode_pinjam)
	{
		// if($this->input->is_ajax_request())
		// {
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_angsuran');
			 $dt['detail'] = $this->M_angsuran->detail_angsuran_na($kode_pinjam);
			 $dt['master'] = $this->M_angsuran->detail_pinjaman_eksternal($kode_pinjam)->row();

			$this->load->view('angsuran/detail', $dt);
		// }
	}
	
	
	
}