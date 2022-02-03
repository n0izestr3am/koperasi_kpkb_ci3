<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Pengajuan extends MY_Controller 
{

	public function index()
	{
		$this->load->view('pengajuan/data');
	}






public function list_external_json()
	{
		$this->load->model('M_pinjaman');
		$this->load->model('M_pengajuan');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_pengajuan->fetch_data_external_baru($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$kode_pinjam	= $row['kode_pinjam'];
			$status	= $row['acc'];
            $pengajuan = $this->db->query("SELECT * FROM eks_pinjaman where kode_pinjam='$kode_pinjam' and acc='Belum'");
            $ajuan = $pengajuan->num_rows();
			$nestedData[]	= $row['nomor'];
			if($ajuan>0)
			{
            $nestedData[]	= "".$row['kode_pinjam']."<span style='position: absolute;background-color: #e6421d;' class='badge badge-warning'>".$ajuan."</span>";
			}else{
			$nestedData[]	= $row['kode_pinjam'];
			}
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['besar_pinjam'];
			$nestedData[]	= tanggal($row['tgl_entri']);
			$nestedData[]	= tanggal($row['tgl_tempo']);
			if($level == 'staff' OR $level == 'admin')
			{
			
			if($status == 'Belum')
			{
$nestedData[]	= "<a class='btn btn-danger btn-xs' href='".site_url('pinjaman/acc/'.$row['kode_pinjam'])."' id='Pending'>
<i class='glyphicon glyphicon-alert'></i>  Belum di ACC</a>";
$nestedData[]	= "<a class='btn btn-warning btn-xs disabled' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."'id='Angsur' ><i class='glyphicon glyphicon-share'></i>  Angsur</a>";


			}else{
$nestedData[]	= "<a class='btn btn-info btn-xs' href='".site_url('pinjaman/view-pinjaman/'.$row['kode_pinjam'])."' id='View'><i class='glyphicon glyphicon-search'></i> View | <i class='glyphicon glyphicon-print'></i> Cetak</a>";

	$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."'id='Angsur'><i class='glyphicon glyphicon-share'></i>  Angsur</a>";
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
	



















	public function list_pengajuan_json()
	{
		$this->load->model('M_pinjaman');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_pinjaman->fetch_data_pengajuan_na($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id_klien'];
			$nestedData[]	= tanggal($row['tgl_pengajuan']);
			$nestedData[]	= $row['nama'];
			$nestedData[]	= ucfirst($row['nama_pinjaman']);
			$nestedData[]	= $row['besar_pinjam'];
			if($row['status'] == 'Di Terima')
			{
			$nestedData[]	= "<a class='btn btn-warning btn-xs' disabled='disabled'>Sudah di Terima</a>";
			}else{
			$nestedData[]	= "<a class='btn btn-danger btn-xs' href='".site_url('pengajuan/terima/'.$row['kode_pengajuan'])."' id='Terima'><i class='fa fa-edit'></i> Terima Pengajuan</a>";	
			}

			if($level == 'admin' OR $level == 'staff')
			{
			$nestedData[]	= "<a href='".site_url('pengajuan/hapus-pengajuan/'.$row['kode_anggota'])."' id='HapusPengajuan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_anggota()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama','Nama','trim|required');				
				$this->form_validation->set_message('required','%s harus diisi !');
				/* $this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !'); */

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_Anggota');
					$nama 	= $this->input->post('nama');
					$isi 	= $this->input->post('isi');
					$insert 	= $this->M_Anggota->tambah_bahan($judul,$isi);
					if($insert)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil ditambahkan.</div>"
						));
					}
					else
					{
						$this->query_error();
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->view('anggota/tambah');
			}
		}
	}

	public function hapus_pengajuan($kode_anggota)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pinjaman');
				$hapus = $this->M_pinjaman->hapus_pengajuan_pinjaman($kode_anggota);
				if($hapus)
				{
					$this->M_pinjaman->hapus_pengajuan_pinjaman($kode_anggota);
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}

	public function tolak_pengajuan($kode_anggota)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pinjaman');
				$hapus = $this->M_pinjaman->tolak($kode_anggota);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Pengajuan di Tolak !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}
	
	
	
	
	public function terima_pengajuan($kode_anggota)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pinjaman');
				$terima = $this->M_pinjaman->terima($kode_anggota);
				if($terima)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Pengajuan diterima !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}
	
	
	public function nota()
	{
		$kode_anggota 	= $this->input->get('kode_anggota');
		$kode_pinjam		= $this->input->get('kode_pinjam');
		$this->load->helper('dompdf');
		$this->load->model('M_pinjaman');
		$this->load->model('M_anggota');
		$dt['detail'] = $this->M_pinjaman->get_detail_pinjaman($kode_pinjam);
		$dt['master'] = $this->M_anggota->baris($kode_anggota)->row();
       // $this->load->view('cetak/nota_pinjaman', $dt);
		$html = $this->load->view('cetak/nota_pinjaman',$dt,true);
        $filename = $kode_anggota;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
	
	}
	
	
	public function detail_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			 $this->load->model('M_pinjaman');
			 $this->load->model('M_simpanan');
			 $dt['detail'] = $this->transaksi_detail->get_detail($id_penjualan);
			 $dt['master'] = $this->m_transaksi_master->get_baris($id_penjualan)->row();

			$this->load->view('pengajuan/detail', $dt);
		}
	}
	
	
	
	public function terima($kode_pengajuan = NULL)
	{
		if( ! empty($kode_pengajuan))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory')
			{
				if($this->input->is_ajax_request())
				{
					
					$this->load->model('M_pinjaman');
					$this->load->model('M_simpanan');
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('status','Status','trim|required');
                       	$besar_pinjaman 	= $this->input->post('besar_pinjaman');
                       	$kode_anggota 	= $this->input->post('kode_anggota');
						$jenis 	= $this->input->post('kode_jenis_pinjam');
						$kode_p 	= $this->input->post('kode_pinjaman');
						$lama_angsuran 	= $this->input->post('lama_angsuran');
						$tempo 	= $this->input->post('tempo');
					    $id_user 	= $this->input->post('id_user');						
					    $status 	= $this->input->post('status');
					    $total 	= $this->input->post('total');
					    $total_pinjam 	= $this->input->post('total_pinjam');
						$date=date("Y-m-d");
						if($this->form_validation->run() == TRUE)
						{
		     
			 		
	        // $insert = $this->M_pinjaman->terima($kode_anggota);
	         $insert = $this->M_pinjaman->terima($kode_anggota);
			 $this->M_pinjaman->insert_pinjaman($kode_anggota,$kode_p,$jenis,$besar_pinjaman,$total_pinjam,$total,$lama_angsuran, $date, $tempo, $id_user);
			 $nilai 	= $besar_pinjaman;
			 $this->M_simpanan->ambil_kas_koperasi($nilai);
							if($insert)
							{
								
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data Pengajuan berhasil diupdate.</div>"
								));
							}
							else
							{
								$this->query_error();
							}
						}
						else
						{
							$this->input_error();
						}
					}
					else
					{
					    $this->load->model('M_pinjaman');
					    $this->load->model('M_simpanan');
						$dt['master'] = $this->M_pinjaman->get_detail_pengajuan($kode_pengajuan)->row();
						
						$this->load->view('pengajuan/detail', $dt);
					}
				}
			}
		}
	}
}