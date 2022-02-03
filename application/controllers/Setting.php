<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Setting extends MY_Controller 
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
		$this->load->view('setting/data');
	}

	public function pinjaman()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->view('setting/pinjaman');
		}
	}
	
	public function kas()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->model('M_home');
			$dt['kas'] = $this->M_home->total_kas()->result();
			$this->load->view('setting/kas',$dt);
		}
	}
	
	
	
	
	
public function simpanan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->view('setting/simpanan');
		}
	}
	
	public function unit()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->view('setting/unitkerja');
		}
	}
	
	public function kas_json()
	{
		$this->load->model('M_setting');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_setting->fetch_data_kas($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= tanggal($row['tgl_entri']);
			$nestedData[]	= $row['keterangan'];
			
			$nestedData[]	= "".$row['jumlah']."";
			$nestedData[]	= "".$row['nama']."";
			

			if($level == 'admin') 
			{
				$nestedData[]	= "<a href='".site_url('setting/kas-hapus/'.$row['id_kas'])."' id='HapusPinjaman'><i class='fa fa-trash-o'></i> Hapus</a>";
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
	
	
	
	
	public function pinjaman_json()
	{
		$this->load->model('M_setting');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_setting->fetch_data_pinjaman($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_jenis_pinjam'];
			$nestedData[]	= $row['nama_pinjaman'];
			$nestedData[]	= "".$row['lama_angsuran']." Kali";
			$nestedData[]	= $row['maks_pinjam'];
			$nestedData[]	= "".$row['bunga']." %";
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('setting/pinjaman-edit/'.$row['kode_jenis_pinjam'])."' id='EditPinjaman'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if($level == 'admin') 
			{
				$nestedData[]	= "<a href='".site_url('setting/pinjaman-hapus/'.$row['kode_jenis_pinjam'])."' id='HapusPinjaman'><i class='fa fa-trash-o'></i> Hapus</a>";
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


	public function tambah_kas()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('jumlah','jumlah Dana','trim|required');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_setting');
					$keterangan 		= $this->input->post('keterangan');
					$jumlah 		= $this->input->post('jumlah');
					$user		= $this->session->userdata('ap_id_user');
					$tgl=date("Y-m-d");
	                $insert 	= $this->M_setting->tambah_kas($keterangan,$jumlah, $user, $tgl);
					$this->M_setting->kas_update($jumlah);
					if($insert)
					{
						
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$jumlah."</b> berhasil ditambahkan .</div>",
							
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
			    $this->load->model('M_setting');
				$this->load->view('setting/kas/tambah');
			}
		}
	}





public function kas_hapus($id_kas)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_setting');
				$hapus = $this->M_setting->hapus_kas($id_kas);
				if($hapus)
				{
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
















	public function tambah_pinjaman()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_pinjaman','Nama Pinjaman','trim|required|max_length[90]');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_setting');
					$kode_jenis_pinjam 		= $this->input->post('kode_jenis_pinjam');
					$lama_angsuran 		= $this->input->post('lama_angsuran');
					$nama_pinjaman 		= $this->input->post('nama_pinjaman');
					$maks_pinjam 		= $this->input->post('maks_pinjam');
					$bunga 		= $this->input->post('bunga');
					$user		= $this->session->userdata('ap_id_user');
					$tgl=date("Y-m-d");
	$insert 	= $this->M_setting->tambah_pinjaman($kode_jenis_pinjam,$nama_pinjaman,$lama_angsuran,$maks_pinjam,$bunga, $user, $tgl);
					if($insert)
					{
						
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama_pinjaman."</b> berhasil ditambahkan .</div>",
							
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
			    $this->load->model('M_setting');
				$this->load->view('setting/pinjaman/tambah');
			}
		}
	}
	
	
	
	
	public function simpanan_json()
	{
		$this->load->model('M_setting');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_setting->fetch_data_simpanan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_jenis_simpan'];
			$nestedData[]	= $row['nama_simpanan'];
			$nestedData[]	= $row['besar_simpanan'];
			
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('setting/simpanan-edit/'.$row['kode_jenis_simpan'])."' id='EditSimpanan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if($level == 'admin') 
			{
				$nestedData[]	= "<a href='".site_url('setting/simpanan-hapus/'.$row['kode_jenis_simpan'])."' id='Hapus'><i class='fa fa-trash-o'></i> Hapus</a>";
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
	
	public function tambah_simpanan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_simpanan','Nama Simpanan','trim|required|max_length[90]');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_setting');
					$kode_jenis_simpan 		= $this->input->post('kode_jenis_simpan');
					$nama_simpanan 		= $this->input->post('nama_simpanan');
					$besar_simpanan 		= $this->input->post('besar_simpanan');
					$user		= $this->session->userdata('ap_id_user');
					$tgl=date("Y-m-d");
					$insert 	= $this->M_setting->tambah_simpanan($kode_jenis_simpan,$nama_simpanan,$besar_simpanan,$user,$tgl);
					if($insert)
					{
						
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama_simpanan."</b> berhasil ditambahkan .</div>",
							
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
			    $this->load->model('M_setting');
				$this->load->view('setting/simpanan/tambah');
			}
		}
	}
	
	public function simpanan_edit($kode_jenis_simpan = NULL)
	{
		if( ! empty($kode_jenis_simpan))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_setting');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama_simpanan','Nama','trim|required|max_length[40]');
						$this->form_validation->set_rules('besar_simpanan','Nama','trim|required|max_length[90]');
						$this->form_validation->set_message('required','%s harus diisi !');

						if($this->form_validation->run() == TRUE)
						{
							$nama_simpanan 		= $this->input->post('nama_simpanan');
							$besar_simpanan 		= $this->input->post('besar_simpanan');
							
							$update 	= $this->M_setting->update_simpanan($kode_jenis_simpan,$nama_simpanan,$besar_simpanan);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
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
						$dt['data'] = $this->M_setting->get_baris_simpanan($kode_jenis_simpan)->row();
						$this->load->view('setting/simpanan/edit', $dt);
					}
				}
			}
		}
	}
	
	
	public function pinjaman_edit($kode_jenis_pinjam = NULL)
	{
		if( ! empty($kode_jenis_pinjam))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_setting');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama_pinjaman','Nama pinjaman','trim|required|max_length[40]');
						$this->form_validation->set_rules('maks_pinjam','Maks pinjam','trim|required|max_length[90]');
						$this->form_validation->set_message('required','%s harus diisi !');

						if($this->form_validation->run() == TRUE)
						{
							$this->load->model('M_setting');
							//$kode_jenis_pinjam 	= $this->input->post('kode_jenis_pinjam');
					        $lama_angsuran 		= $this->input->post('lama_angsuran');
					        $nama_pinjaman 		= $this->input->post('nama_pinjaman');
					        $maks_pinjam 		= $this->input->post('maks_pinjam');
					        $bunga 		= $this->input->post('bunga');
					        $user 		= $this->input->post('user');
							//print_r($_POST);
						     //echo $this->db->last_query();
							$update = $this->M_setting->update_pinjaman($kode_jenis_pinjam,$nama_pinjaman,$lama_angsuran,$maks_pinjam,$bunga, $user);
							 //echo $this->db->last_query();
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
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
						$dt['data'] = $this->M_setting->get_baris_pinjaman($kode_jenis_pinjam)->row();
						$this->load->view('setting/pinjaman/edit', $dt);
					}
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	public function simpanan_hapus($kode_jenis_simpan)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_setting');
				$hapus = $this->M_setting->hapus_simpanan($kode_jenis_simpan);
				if($hapus)
				{
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
	
	
	public function pinjaman_hapus($kode_jenis_simpan)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_setting');
				$hapus = $this->M_setting->hapus_pinjaman($kode_jenis_simpan);
				if($hapus)
				{
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
	
	
	
	public function unit_json()
	{
		$this->load->model('M_setting');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_setting->fetch_data_unit($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['unit_kerja'];
			
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('setting/unit-edit/'.$row['id_unit_kerja'])."' id='EditUnit'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if($level == 'admin') 
			{
				$nestedData[]	= "<a href='".site_url('setting/unit-hapus/'.$row['id_unit_kerja'])."' id='HapusUnit'><i class='fa fa-trash-o'></i> Hapus</a>";
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
	
	
	public function tambah_unit()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('unit_kerja','Unit Kerja','trim|required|max_length[90]');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_setting');
					$unit_kerja 		= $this->input->post('unit_kerja');
					$user		= $this->session->userdata('ap_id_user');
					$tgl=date("Y-m-d");
					$insert 	= $this->M_setting->tambah_unit($unit_kerja, $user, $tgl);
					if($insert)
					{
						
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$unit_kerja."</b> berhasil ditambahkan .</div>",
							
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
				$this->load->view('setting/unit/tambah');
			}
		}
	}
	
	public function unit_hapus($id_unit_kerja)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_setting');
				$hapus = $this->M_setting->hapus_unit($id_unit_kerja);
				if($hapus)
				{
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
	
	public function unit_edit($id_unit_kerja = NULL)
	{
		if( ! empty($id_unit_kerja))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_setting');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('unit_kerja','Nama','trim|required|alpha_spaces|max_length[40]');
						$this->form_validation->set_message('required','%s harus diisi !');

						if($this->form_validation->run() == TRUE)
						{
							$unit_kerja 		= $this->input->post('unit_kerja');
							
							$update 	= $this->M_setting->update_unit($id_unit_kerja,$unit_kerja);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
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
						$dt['unit'] = $this->M_setting->get_baris_unit($id_unit_kerja)->row();
						$this->load->view('setting/unit/edit', $dt);
					}
				}
			}
		}
	}
	
	
	
	
	
	
}