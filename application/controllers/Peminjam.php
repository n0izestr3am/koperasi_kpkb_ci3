<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Peminjam extends MY_Controller 
{

	public function index()
	{
		$this->load->view('peminjam/data');
	}

	public function list_anggota_json()
	{
		$this->load->model('M_Anggota');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_Anggota->fetch_data_klien($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['nama_pinjaman'];
			$nestedData[]	= $row['alamat'];
			$nestedData[]	= $row['telp'];
			$nestedData[]	= $row['status'];
			

			if($level == 'admin' OR $level == 'inventory')
			{
			
				$nestedData[]	= "<a href='".site_url('peminjam/edit-klien/'.$row['id_klien'])."' id='EditAnggota'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('peminjam/hapus-klien/'.$row['id_klien'])."' id='HapusAnggota'><i class='fa fa-trash-o'></i> Hapus</a>";
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
public function detail($kode_anggota)
	{
		// if($this->input->is_ajax_request())
		// {
			$this->load->model('M_Anggota');
			$this->load->model('M_simpanan');
			$dt['detail'] = $this->M_simpanan->ambil_simpanan($kode_anggota);
			$dt['master'] = $this->M_Anggota->baris($kode_anggota)->row();
			
			$this->load->view('peminjam/detail', $dt);
		// }
	}
	
	
	
	
	public function hapus_klien($id_klien)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_Anggota');
				$hapus = $this->M_Anggota->hapus_klien($id_klien);
				if($hapus)
				{
					//$this->M_Anggota->hapus_simp($id_klien);
					//$this->M_Anggota->hapus_trans($id_klien);
					//$this->M_Anggota->hapus_tab($id_klien);
					//$this->M_Anggota->hapus_jasa($id_klien);
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
	
	
	
	
	
	
	
	
	
	
	public function cetak()
	{
		$this->load->helper('dompdf');
        $time = time();
		$kode_anggota 	= $this->input->get('kode_anggota');
		$admin 	= $this->input->get('admin');
		$dk 	= $this->input->get('dk');
		$kta 	= $this->input->get('kta');
		$ik 	= $this->input->get('ik');
		$this->load->model('M_Anggota');
		$this->load->model('M_simpanan');
		$dt['admin'] = $admin;
		$dt['dk'] = $dk;
		$dt['kta'] = $kta;
		$dt['ik'] = $ik;
		$dt['master'] = $this->M_simpanan->ambil_detail_simpanan($kode_anggota)->row();
		// $this->load->view('cetak/anggota', $dt);
		 $html = $this->load->view('cetak/anggota',$dt,true);
        $filename = $kode_anggota;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
	}
	
	
	
	
	
	
	
	public function cetak_anggota()
	{
		$this->load->helper('dompdf');
        $time = time();
		$kode_anggota 	= $this->input->get('kode_anggota');
		$admin 	= $this->input->get('admin');
		$dk 	= $this->input->get('dk');
		$kta 	= $this->input->get('kta');
		$ik 	= $this->input->get('ik');
		$this->load->model('M_Anggota');
		$this->load->model('M_simpanan');
		$dt['admin'] = $admin;
		$dt['dk'] = $dk;
		$dt['kta'] = $kta;
		$dt['ik'] = $ik;
		$dt['detail'] = $this->M_Anggota->baris($kode_anggota)->row();
		$dt['master'] = $this->M_simpanan->ambil_detail_simpanan($kode_anggota)->row();
		// $this->load->view('cetak/anggota', $dt);
		 $html = $this->load->view('cetak/cetak_anggota',$dt,true);
        $filename = $kode_anggota;
        $paper = 'A4';
        $orientation = 'landscape';
        pdf_create($html, $filename, $paper, $orientation);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	

	
public function tambah_anggota()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
                $this->load->model('M_Anggota');
                
				$this->form_validation->set_rules('nama','Nama','trim|required');	
				$this->form_validation->set_rules('alamat','alamat','trim|required');	
				$this->form_validation->set_rules('no_telp','No Telp','trim|required');	
				$this->form_validation->set_rules('unit_kerja','Unit Kerja','required');	
				$this->form_validation->set_rules('golongan','Golongan','required');	
				$this->form_validation->set_rules('ahli_waris','Ahli Waris','required');	
				$this->form_validation->set_rules('nama_ahli_waris','Nama Ahli Waris','required');	
					
				$no = 0;
				foreach($_POST['kode'] as $kode)
				{
 $this->form_validation->set_rules('kode['.$no.']','Kode Anggota #'.($no + 1),'trim|required');
 $this->form_validation->set_rules('jenis_simpan['.$no.']','jenis_simpan #'.($no + 1),'trim|required');
 $this->form_validation->set_rules('besar_simpanan['.$no.']','besar_simpanan #'.($no + 1),'trim');
					$no++;
				}
				
				$this->form_validation->set_message('required','%s harus diisi !');
				
				if($this->form_validation->run() == TRUE)
				{
					$nama 	= $this->input->post('nama');
					$kode_anggota 	= $this->input->post('kode_anggota');
					$alamat 	= $this->input->post('alamat');
					$tempat_lahir 	= $this->input->post('tempat_lahir');
					$tanggal_lahir 	= $this->input->post('tanggal_lahir');
					$nip 	= $this->input->post('nip');
					$golongan 	= $this->input->post('golongan');
					$gaji 	= $this->input->post('gaji');
					$jenis_kelamin 	= $this->input->post('jenis_kelamin');
					$no_telp 	= $this->input->post('no_telp');
					$unit_kerja 	= $this->input->post('unit_kerja');
					$nama_ahli_waris 	= $this->input->post('nama_ahli_waris');
					$ahli_waris 	= $this->input->post('ahli_waris');
					$tgl 	= $this->input->post('tgl');
                    $user 	= $this->input->post('user');
					//biaya lain-lain
					$administrasi 	= $this->input->post('admin');
					$dana_kecelakaan 	= $this->input->post('dk');
					$iuran_kematian 	= $this->input->post('ik');
					$kta 	= $this->input->post('ik');
					$all 	= $administrasi+$dana_kecelakaan+$iuran_kematian+$kta;
					$master = $this->M_Anggota->tambah_anggota($nama,$alamat,$kode_anggota,$tempat_lahir,$tanggal_lahir,$golongan,$gaji,$nip,$jenis_kelamin,$no_telp, $unit_kerja,$nama_ahli_waris,$ahli_waris,$user,$tgl);
					//masukan ke table transaksi
					$this->load->model('M_transaksi_master');
					$this->M_transaksi_master->insert_master($tgl,$kode_anggota,$all,$user);
					//masukan ke table jasa
					//$this->load->model('M_transaksi_master');
					$id_transaksi 	= $this->M_transaksi_master->get_max($kode_anggota)->row()->id_transaksi;
					$this->M_transaksi_master->insert_jasa($id_transaksi,$kode_anggota,$tgl,$administrasi,$dana_kecelakaan,$iuran_kematian,$kta,$user);
					
					if($master)
					{
					$no_array = 0;
					$inserted = 0;
					foreach($_POST['kode'] as $k)
					{
						$kode = $_POST['kode'][$no_array];
						$jenis_simpan = $_POST['jenis_simpan'][$no_array];
						$besar_simpanan = $_POST['besar_simpanan'][$no_array];
                        $this->load->model('M_Anggota'); 
                        $insert = $this->M_Anggota->insert_simpan($kode,$jenis_simpan,$besar_simpanan, $user,$tgl);
						if($insert){
							$this->load->model('M_simpanan'); 
							//masukan ke tabungan 
							$this->M_simpanan->save($kode_anggota,$besar_simpanan);
							$inserted++;
						}
						$no_array++;
					}
                    //print_r($_POST);
					if($inserted > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data Anggota berhasil dismpan."
						));
					  }
					
					else
					{
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				  }
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->model('M_Anggota');
				$dt['pokok'] = $this->M_Anggota->pokok()->row();
				$dt['juli'] = $this->M_Anggota->juli()->row();
				$dt['sukarela'] = $this->M_Anggota->sukarela()->row();
				$dt['wajib'] = $this->M_Anggota->wajib()->row();
				$dt['unit'] = $this->M_Anggota->unit();
				$dt['simpanan'] = $this->M_Anggota->jenis_simpanan();
				$this->load->view('peminjam/tambah', $dt);
			}
		}
		else
		{
			exit();
		}
	}




	public function edit_klien($id_klien = NULL)
	{
		if( ! empty($id_klien))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_Anggota');
					$this->load->model('M_klien');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama','Nama','trim|required');	
						$this->form_validation->set_rules('alamat_debitur','Alamat','trim|required');	
				        $this->form_validation->set_message('required','%s harus diisi !');
						/* $this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !'); */
                     $this->load->model('M_Anggota');
					if($this->form_validation->run() == TRUE)
					{
					$nama 	    		         = strtoupper($this->input->post('nama'));
					$telp_peminjam 	    		 = $this->input->post('telp_peminjam');
					$typex 	    		 = $this->input->post('typex');
					$alamat_debitur		   		 = strtoupper($this->clean_tag_input($this->input->post('alamat_debitur')));
					//$insert 	         = $this->M_Anggota->update($nama,$alamat,$telp_peminjam,$typex);
					$insert 	= $this->M_klien->update($id_klien,$nama,$alamat_debitur,$telp_peminjam,$typex);
							if($insert)
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
						
						$this->load->model('M_Anggota');
						$this->load->model('M_klien');
						$this->load->model('M_pinjaman');
			          	$dt['pinjaman']= $this->M_pinjaman->pinjaman_non_anggota();
						$dt['anggota'] = $this->M_Anggota->get_baris($id_klien)->row();
						$this->load->view('peminjam/edit', $dt);
					}
				}
			}
		}
	}
	
	
	
	
}