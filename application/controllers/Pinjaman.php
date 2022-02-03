<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');


class Pinjaman extends MY_Controller 
{

	public function index()
	{
		$this->load->view('external/data');
	}

	public function list_external_json()
	{
		$this->load->model('M_pinjaman');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_pinjaman->fetch_data_external($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
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
			$nestedData[]	= "".Rp($row['besar_pinjam'])."";
			$nestedData[]	= tanggal($row['tgl_entri']);
			$nestedData[]	= tanggal($row['tgl_tempo']);
			
			
			if($status == 'Belum')
			{
$nestedData[]	= "<a class='btn btn-danger btn-xs' href='".site_url('pinjaman/acc/'.$row['kode_pinjam'])."' id='Pending'>
<i class='glyphicon glyphicon-alert'></i>  Pinjaman belum di acc</a>";
$nestedData[]	= "<a class='btn btn-warning btn-xs disabled' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."'id='Angsur' ><i class='glyphicon glyphicon-share'></i>  Angsur</a>";


			}else{
$nestedData[]	= "<a class='btn btn-info btn-xs' href='".site_url('pinjaman/view-pinjaman/'.$row['kode_pinjam'])."' id='View'><i class='glyphicon glyphicon-search'></i> View | <i class='glyphicon glyphicon-print'></i> Cetak</a>";

	$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('pinjaman/angsur/'.$row['kode_pinjam'])."'id='Angsur'><i class='glyphicon glyphicon-share'></i>  Angsur</a>";
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
	
	
	public function terima($kode_pinjam)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pinjaman');
				$this->load->model('M_simpanan');
				$nilai 	= $this->input->post('besar_pinjaman');
				$id_klien            = $this->input->post('id_klien');
				$id_user            = $this->input->post('id_user');
				$kode_pinjam            = $this->input->post('kode_pinjam');
				$besar_angsuran         = $this->input->post('besar_angsuran');
				$acc         = $this->input->post('acc');
				$terima = $this->M_pinjaman->terima_eks($kode_pinjam,$id_klien,$besar_angsuran,$id_user,$acc);
				if($acc == 'ACC'){
					 $this->M_simpanan->ambil_kas_koperasi($nilai); 	
					} 
				// print_r($listbooking);
				
				if($terima)
				{
					echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Pengajuan Berhasil di <b>".$acc."</b>.</div>"
								));
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
	
	
	public function add()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir')
		{
			if($_POST)
			{
				        $this->load->model('M_pinjaman');   
						$this->load->library('form_validation');
$this->form_validation->set_rules('kode_pinjam','Kode Pinjam','trim|required|max_length[40]|alpha_numeric|callback_cek_kode_pinjam[kode_pinjam]');
						$this->form_validation->set_rules('type','Type Peminjam','trim|required');
						$this->form_validation->set_rules('id_klien','Klien','trim|required');
						$this->form_validation->set_rules('jaminan','Nama Jaminan','trim|required');
						$this->form_validation->set_rules('besar_pinjaman','Jumlah Pinjaman','trim|required');
						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_pinjam', '%s sudah ada');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
						if($this->form_validation->run() == TRUE)
						{
						
							$id_klien            = $this->input->post('id_klien');
							$kode_pinjam         = $this->input->post('kode_pinjam');
							$nama_jaminan        = strtoupper($this->input->post('jaminan'));
							$kode_jenis_pinjam   = $this->input->post('kode_jenis_pinjam');
							$type		         = $this->input->post('type_pinjaman');
							$besar_pinjaman		 = $this->input->post('besar_pinjaman');
							$maks_pinjam	     = $this->input->post('maks_pinjam');
							$lama_angsuran	     = $this->input->post('lama_angsuran');
							$bunga_asli	         = $this->input->post('bunga');
							$id_user	         = $this->input->post('id_user');
							//
	                        $pokok  = $besar_pinjaman/$lama_angsuran;
                            $margin = $pokok*($bunga_asli/100);
	                        $angsuran_plus_bunga=$pokok+$margin;
                            $totalasli=$angsuran_plus_bunga*$lama_angsuran;
							//
							//pembulatan							
							$margin_bulat = round($totalasli, -3);
	                        $ap = round($margin, -3);
							//
							$date=date("Y-m-d");
                            $tempo=date('Y-m-d',strtotime('+90 day',strtotime($date)));
						
							$kas= $this->M_pinjaman->nilai_kas()->row()->nilai;
									
							if($besar_pinjaman > $maks_pinjam)
							{
							$this->query_error("Pinjaman melebihi Batas");
								//$this->query_error();
							}
							else if($besar_pinjaman > $kas)
							{
						
						$this->query_error("Maaf Kas sedang Kosong, total kas saat ini : <b>Rp. ".Rp($kas)."</b>");
						//$this->query_error();
							}else{
			        $file_jaminan = $_FILES['file_jaminan']['name'];
		            $file_perjanjian = $_FILES['file_perjanjian']['name'];
                  				
					if (empty($file_jaminan)){
						$jaminan = '';			
					} else {
						$file_jaminan = stripslashes($file_jaminan);
			            $file_jaminan = str_replace("'","",$file_jaminan);
			            $file_jaminan = str_replace(" ","_",$file_jaminan);
			            $file_jaminan = $kode_pinjam.".".strtolower($file_jaminan);
						$jaminan =  $file_jaminan;
					}

					if (empty($file_perjanjian)){
						  $perjanjian = '';				
					} else {
						$file_perjanjian = stripslashes($file_perjanjian);
			            $file_perjanjian = str_replace("'","",$file_perjanjian);
			            $file_perjanjian = str_replace(" ","_",$file_perjanjian);
			            $file_perjanjian = $kode_pinjam.".".strtolower($file_perjanjian);
						$perjanjian = $file_perjanjian;
					}
					
		
		$this->load->model('M_pinjaman');
		$master = $this->M_pinjaman->ajuan_external($kode_pinjam,$id_klien,$kode_jenis_pinjam,$type,$totalasli,$angsuran_plus_bunga,$besar_pinjaman,
		$lama_angsuran,$date,$tempo,$nama_jaminan,$id_user,$jaminan,$perjanjian);
		$this->save_image($jaminan);
		$this->save_image2($perjanjian);
									if($master > 0)
									{
				echo json_encode(array('status' => 1, 'pesan' => "Pengajuan berhasil disimpan !"));
									}
									else
									{
										$this->query_error();
									}
								}					
						}
						else
						{
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
						}
					}
			else
			{
				$this->load->model('m_user');
				$this->load->model('M_klien');
				$this->load->model('M_pinjaman');
				$this->load->model('M_home');
			    $dt['kas'] = $this->M_home->total_kas()->result();
				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['jenis'] = $this->M_pinjaman->get_external();
				$dt['klien']= $this->M_klien->get_all();
				$dt['pinjaman']= $this->M_pinjaman->pinjaman_non_anggota();
				$this->load->view('external/input', $dt);
			}
		}
	}
	
	
public function ajax_type()
	{
		if($this->input->is_ajax_request())
		{
		$kode_jenis_pinjam = $this->input->post('kode_jenis_pinjam');
		$this->load->model('M_pinjaman');
		$data = $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row();
		$json['nama_pinjaman']=( ! empty($data->nama_pinjaman)) ? 
		"<input type='hidden' name='type_pinjaman' id='type_pinjaman' value='".$data->nama_pinjaman."'>
		<input type='hidden' name='type' id='type' value='".$data->nama_pinjaman."' class='form-control' readonly>": "<small><i>Jenis Pinjaman belum di pilih</i></small>";
		$json['maks_pinjam2']=( ! empty($data->maks_pinjam)) ? 
		"<input type='hidden' name='maks_pinjam' id='maks_pinjam' value='".$data->maks_pinjam."' class='form-control' readonly>": "<small><i>Jenis Pinjaman belum di pilih</i></small>";	
		$json['lama_angsuran2']=( ! empty($data->lama_angsuran)) ? 
"<div class='input-group'><input type='number' name='lama_angsuran' id='lama_angsuran' value='".$data->lama_angsuran."' class='form-control'
step='1' readonly><span class='input-group-addon bg-hijau' id=''>Kali</span></div>": "<small><i>Jenis Pinjaman belum di pilih</i></small>";	
$json['bunga2']=( ! empty($data->bunga)) ? 
"<div class='input-group'><input type='number' name='bunga' id='bunga' value='".$data->bunga."' class='form-control'
step='0.1' readonly><span class='input-group-addon bg-hijau' id=''>%</span></div>": "<small><i>Jenis Pinjaman belum di pilih</i></small>";	
$json['max']= ( ! empty($data->maks_pinjam)) ? "Max Pinjaman  : Rp.".Rp($data->maks_pinjam)."" : "<small><i>Jenis Pinjaman belum di pilih</i></small>";	
			echo json_encode($json);
		}
	}
	
	
	
	public function tambah_klien()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('alamat','Alamat', 'trim|required|max_length[1000]');
				$this->form_validation->set_rules('type','Type Peminjam','trim|required');
				$this->form_validation->set_rules('telp_peminjam','Telepon','trim|required');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_klien');
					$nama 	    		 = strtoupper($this->input->post('nama'));
					$type 	    		 = $this->input->post('type');
					$telp_peminjam 	     = $this->input->post('telp_peminjam');
					$alamat		   		 = $this->clean_tag_input($this->input->post('alamat'));
					$user		= $this->session->userdata('ap_id_user');
					$tgl=date("Y-m-d");
					$insert 	= $this->M_klien->save_klien($nama,$alamat,$telp_peminjam,$type);
				
					if($insert)
					{
						
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil ditambahkan .</div>",
							
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
			    $this->load->model('M_klien');
			    $this->load->model('M_pinjaman');
				$dt['pinjaman']= $this->M_pinjaman->pinjaman_non_anggota();
				$this->load->view('klien/tambah', $dt);
				
			}
		}
	}

	
	
	
	
	
	
	
	
	
public function ajukan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir')
		{
			if($_POST)
			{
				        $this->load->model('M_pinjaman');   
						$this->load->library('form_validation');
$this->form_validation->set_rules('kode_pinjam','Kode Pinjam','trim|required|max_length[40]|alpha_numeric|callback_cek_kode_pinjam[kode_pinjam]');
						$this->form_validation->set_rules('alamat','Alamat', 'trim|required|max_length[1000]');
						$this->form_validation->set_rules('type','Type Peminjam','trim|required');
						$this->form_validation->set_rules('telp_peminjam','Telepon','trim|required');
						$this->form_validation->set_rules('jaminan','Nama Jaminan','trim|required');
						$this->form_validation->set_rules('besar_pinjaman','Jumlah Pinjaman','trim|required');
						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_pinjam', '%s sudah ada');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
						if($this->form_validation->run() == TRUE)
						{
							
							
							$nama 	    		 = $this->input->post('nama');
							$type 	    		 = $this->input->post('type');
							$telp_peminjam 	     = $this->input->post('telp_peminjam');
							$alamat		   		 = $this->clean_tag_input($this->input->post('alamat'));
							$kode_pinjam         = $this->input->post('kode_pinjam');
							$nama_jaminan         = $this->input->post('jaminan');
							$kode_jenis_pinjam   = $this->input->post('kode_jenis_pinjam');
							$besar_pinjaman		 = $this->input->post('besar_pinjaman');
							$maks_pinjam	     = $this->input->post('maks_pinjam');
							$lama_angsuran	     = $this->input->post('lama_angsuran');
							$bunga_asli	         = $this->input->post('bunga');
							$id_user	         = $this->input->post('id_user');
							$angsuranPokok=$besar_pinjaman/$lama_angsuran;
                            $bunga=$bunga_asli/1000;
                            $bungaPerBulan=$besar_pinjaman*$bunga;
                            $total=$angsuranPokok+$bungaPerBulan;
                            $totalasli=$total*$lama_angsuran;
												
							
							$date=date("Y-m-d");
                            $tempo=date('Y-m-d',strtotime('+90 day',strtotime($date)));
							$kas= $this->M_pinjaman->nilai_kas()->row()->nilai;
                           						
							if($besar_pinjaman > $maks_pinjam)
							{
								$this->query_error("Pinjaman melebihi batas");
							}
							else if($besar_pinjaman > $kas)
							{
						$this->query_error("Maaf Kas sedang Kosong, total kas saat ini : <b>Rp. ".Rp($kas)."</b>");
							}else{
			        $file_jaminan = $_FILES['file_jaminan']['name'];
		            $file_perjanjian = $_FILES['file_perjanjian']['name'];
                  				
					if (empty($file_jaminan)){
						$jaminan = '';			
					} else {
						$file_jaminan = stripslashes($file_jaminan);
			            $file_jaminan = str_replace("'","",$file_jaminan);
			            $file_jaminan = str_replace(" ","_",$file_jaminan);
			            $file_jaminan = $kode_pinjam.".".strtolower($file_jaminan);
						$jaminan =  $file_jaminan;
					}

					if (empty($file_perjanjian)){
						  $perjanjian = '';				
					} else {
						$file_perjanjian = stripslashes($file_perjanjian);
			            $file_perjanjian = str_replace("'","",$file_perjanjian);
			            $file_perjanjian = str_replace(" ","_",$file_perjanjian);
			            $file_perjanjian = $kode_pinjam.".".strtolower($file_perjanjian);
						$perjanjian = $file_perjanjian;
					}
					
		
		$this->load->model('M_pinjaman');
		$this->M_pinjaman->save_klien($nama,$alamat,$telp_peminjam,$type);
		$id_klien 	= $this->db->insert_id();
		$master = $this->M_pinjaman->ajuan_external($id_klien,$kode_pinjam,$kode_jenis_pinjam,$type,$total,$totalasli,$besar_pinjaman,
		$lama_angsuran,$date,$tempo,$nama_jaminan,$id_user,$jaminan,$perjanjian);
		$this->save_image($jaminan);
		$this->save_image2($perjanjian);
									if($master > 0)
									{
				echo json_encode(array('status' => 1, 'pesan' => "Pengajuan berhasil disimpan !"));
									}
									else
									{
										$this->query_error();
									}
								}					
						}
						else
						{
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
						}
					}
			else
			{
				$this->load->model('m_user');
				$this->load->model('M_Anggota');
				$this->load->model('M_pinjaman');
				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['jenis'] = $this->M_pinjaman->get_external();
				$dt['pinjaman']= $this->M_pinjaman->pinjaman_non_anggota();
				$this->load->view('external/add', $dt);
			}
		}
	}
	

	public function save_image($jaminan=0)
	{
		
		$fileName = $_FILES['file_jaminan']['name']; 
		$fileSize = $_FILES['file_jaminan']['size'];  
		$fileError = $_FILES['file_jaminan']['error'];  
		
		if($fileSize > 0 || $fileError == 0 ){  
			$move = move_uploaded_file($_FILES['file_jaminan']['tmp_name'], 'assets/upload/'.$jaminan);  

		//$response->success = 'General Data Has Been Saved';		
		//echo json_encode($response);
		//$this->index_general(); 
		}
	}
	
	public function save_image2($perjanjian=0)
	{
		$fileName = $_FILES['file_perjanjian']['name']; 
		$fileSize = $_FILES['file_perjanjian']['size'];  
		$fileError = $_FILES['file_perjanjian']['error'];  
		
		if($fileSize > 0 || $fileError == 0){  
			$move = move_uploaded_file($_FILES['file_perjanjian']['tmp_name'], 'assets/upload/'.$perjanjian);  

		//$response->success = 'General Data Has Been Saved';		
		//echo json_encode($response);
		//$this->index_general(); 
		}
	}
	
	
	public function ajax_klien()
	{
		if($this->input->is_ajax_request())
		{
			$id_klien = $this->input->post('id_klien');
			$this->load->model('M_klien');

			$data = $this->M_klien->get_baris($id_klien)->row();
			$json['telp']			= ( ! empty($data->telp)) ? $data->telp : "<small><i>Peminjam belum di pilih</i></small>";
			$json['alamat']			= ( ! empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat) : "<small><i>Peminjam belum di pilih</i></small>";
			$json['type']	= ( ! empty($data->type)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->type) : "<small><i>Peminjam belum di pilih</i></small>";
			echo json_encode($json);
		}
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//ANGSURANNNNN

public function angsur($kode_pinjam = NULL)
	{
		if( ! empty($kode_pinjam))
		{
		    $level = $this->session->userdata('ap_level');
		    $this->load->model('M_Anggota');
			$this->load->model('M_pinjaman');
			$this->load->model('M_angsuran');
			$this->load->model('m_user');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('besar_angsuran','Angsuran','trim|required|callback_cek_minus[besar_angsuran]');
				//$this->form_validation->set_rules('kode_anggota','Kode','trim|required');
				$this->form_validation->set_message('required','%s Data Kosong !');
                $this->form_validation->set_message('cek_minus', '%s tidak boleh kurang');
				if($this->form_validation->run() == TRUE)
				{
					
					$besar_pinjam 	    = $this->input->post('besar_pinjam');
					$besarangsu 	    = $this->input->post('besar_angsuran');
					$angsuran_ke 	    = $this->input->post('angsuran_ke');
					$denda 	            = $this->input->post('denda');
					$kode_pinjam 	    = $this->input->post('kode');
					$ke 	            = $this->input->post('ke');
					$user 	            = $this->input->post('user');
					$lama_angsuran 	    = $this->input->post('lama_angsuran');
					$tempo 	            = $this->input->post('tempo_pinjaman');
					$id_klien 	       = $this->input->post('id_klien');
					$bunga 	            = $this->input->post('bunga');
					$sisa_angsur 	    = $this->M_pinjaman->get_baris_pinjaman_external($kode_pinjam)->row()->sisa_angsuran;
			       	$sisa_pinjaman 	    = $this->M_pinjaman->get_baris_pinjaman_external($kode_pinjam)->row()->sisa_pinjaman;
					$besar_angsuran     = $this->M_pinjaman->get_baris_pinjaman_external($kode_pinjam)->row()->besar_angsuran;
$kk = $this->db->query("SELECT * from eks_pinjaman where kode_pinjam='$kode_pinjam' and id_klien='$id_klien'")->row_array();
                    //$tempo=$kk['tgl_tempo'];
					$sisa=$sisa_pinjaman-$besarangsu;
					$hasilangsur=$lama_angsuran-$angsuran_ke;
					$tgl_entri=date('Y-m-d');
					$kode_anggota='0';
					//$tempo=date('Y-m-d');
					
 if($lama_angsuran==$angsuran_ke){ $this->M_angsuran->eks_update_angsuran_lunas($kode_pinjam,$sisa,$angsuran_ke);}
				   	else { $this->M_angsuran->eks_update_angsuran_ke($kode_pinjam,$hasilangsur,$sisa,$tempo);}
							
$insert = $this->M_angsuran->tambah_angsur($kode_pinjam,$angsuran_ke,$besarangsu,$denda,$sisa,$kode_anggota,$id_klien,$user,$tgl_entri);
	
$sisa_pinjaman = $this->M_pinjaman->get_baris_pinjaman_external($kode_pinjam)->row()->sisa_pinjaman;
if($sisa_pinjaman==0)
{ $this->M_angsuran->eks_angsuran_lunas($kode_pinjam);}
				if($insert)
					{
						$nama = $this->M_Anggota->get_nama_klien($id_klien)->row()->nama;
						//Bunga Pinjaman dimasukan ke Pendapatan
					    $this->M_angsuran->transaksi_eks($tgl_entri,$id_klien,$bunga,$nama,$user);
					   
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Angsuran  <b>".$nama."</b> berhasil disimpan.</div>",				
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
						$dt['detail'] = $this->M_angsuran->detail_angsuran_na($kode_pinjam);
						$dt['master'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
						$this->load->view('external/angsur', $dt);
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





public function detail($id_klien = NULL)
	{
		                $this->load->model('M_simpanan');
						$dat = $this->db->query("SELECT * FROM klien where id_klien='".$this->db->escape_str($id_klien)."'");
			            $row = $dat->row();
						$dt['id'] = $row->id_klien;
						$dt['kode'] = $row->id_klien;
						$dt['nama'] = $row->nama;
						$dt['jenis']= $this->M_simpanan->jenis();
						$dt['simpanan'] = $this->M_simpanan->get_baris_klien($id_klien)->result();
						$this->load->view('external/tambah', $dt);
				
	}




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
	

	
	
	
	
	
	public function cek_kode_pinjam($kode)
	{
		$this->load->model('M_pinjaman');
		$cek = $this->M_pinjaman->cek_kode_validasi($kode);
		if($cek->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}
	public function hapus_pengajuan($kode_pengajuan)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pinjaman');
				$hapus = $this->M_pinjaman->hapus_pengajuan($kode_pengajuan);
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
	
	
	
	
	
	
	public function cetak()
	{
		$kode_pinjam 	= $this->input->get('kode_pinjam');
		
		// if($this->input->is_ajax_request())
		// {
			 $this->load->helper('dompdf');
        	 $time = time();
		     $tgl2 = "%Y-%m-%d";
			 $this->load->model('M_pinjaman');
			 $dt['data'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
			//$this->load->view('external/cetak', $dt);
	    $html = $this->load->view('external/cetak',$dt,true);
        $filename = $tgl2;
        $paper = 'A4';
        $orientation = 'potrait';
        pdf_create($html, $filename, $paper, $orientation);
		// }
	   
	}
	
	public function msword()
	{
		$kode_pinjam 	= $this->input->get('kode_pinjam');
		$nama 	= $this->input->get('nama');
		$tanggal 	= $this->input->get('tanggal');
	    $time = time();
		$tgl2 = "%Y-%m-%d";
	    $this->load->model('M_pinjaman');
	    $dt['data'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
        $document = file_get_contents("dok.rtf");
        $document = str_replace("#NAMA", $nama, $document);
        $document = str_replace("#KODE", $kode_pinjam, $document);
        $document = str_replace("#TANGGAL", $tanggal, $document);
		$filename = 'Laporan_Pinjaman_'.$kode_pinjam.'_'.$nama;
        header("Content-type: application/msword");
        header("Content-disposition: inline; filename=".$filename.".doc");
        header("Content-length: ".strlen($document));
        echo $document;
	   
	}
	

public function cetak_nota()
	{
		$this->load->model('M_pinjaman');
		$this->load->model('M_Anggota');
		$kode_pinjam 	= $this->input->get('kode_pinjam');
		$nama 	= $this->input->get('nama');
		$tanggal 	= tanggal($this->input->get('tanggal'));
		$besar_pinjaman 	= rp2($this->input->get('besar_pinjaman'));
		$duit	= terbilang($this->input->get('besar_pinjaman'))." Rupiah".'';
		$id_klien 	= $this->input->get('id_klien');
		$nama = $this->M_Anggota->get_nama_klien($id_klien)->row()->nama;
	    $time = time();
		$tgl2 = "%Y-%m-%d";
	    
	    $dt['data'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
        $document = file_get_contents("template.rtf");
        $document = str_replace("#KODE", $kode_pinjam, $document);
        $document = str_replace("#TANGGAL", $tanggal, $document);
        $document = str_replace("%%DUIT%%", $duit, $document);
        $document = str_replace("@@JUMLAH@@", $besar_pinjaman, $document);
       
        $document = str_replace("#KLIEN#", $nama, $document);
		$filename = 'Laporan_Pinjaman_'.$kode_pinjam;
        header("Content-type: application/msword");
        header("Content-disposition: inline; filename=".$filename.".doc");
        header("Content-length: ".strlen($document));
        echo $document;
	   
	}
	

	
	public function cetak_surat_perintah()
	{
		$this->load->model('M_pinjaman');
		$this->load->model('M_Anggota');
		$kode_pinjam 	= $this->input->get('kode_pinjam');
		$nama 	= $this->input->get('nama');
		//$tanggal 	= tanggal($this->input->get('tanggal'));
		$tanggal 	= $this->input->get('tanggal');
		$besar_pinjaman 	= rp2($this->input->get('besar_pinjaman'));
		$duit	= terbilang($this->input->get('besar_pinjaman'))." Rupiah".'';
		$id_klien 	= $this->input->get('id_klien');
		//$nama = $this->M_Anggota->get_nama_klien($id_klien)->row()->nama;
	    $time = time();
		$tgl2 = "%Y-%m-%d";
	    
	    $dt['data'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
        $document = file_get_contents("template.rtf");
        $document = str_replace("#KODE", $kode_pinjam, $document);
        $document = str_replace("#TANGGAL", $tanggal, $document);
        $document = str_replace("%%DUIT%%", $duit, $document);
        $document = str_replace("@@JUMLAH@@", $besar_pinjaman, $document);
       
        $document = str_replace("#KLIEN#", $nama, $document);
		$filename = 'Surat_Perintah_Pengeluaran_'.$kode_pinjam.'_'.$nama;
        header("Content-type: application/msword");
        header("Content-disposition: inline; filename=".$filename.".doc");
        header("Content-length: ".strlen($document));
        echo $document;
	   
	}
	
	public function cetak_perjanjian()
	{
		$kode_pinjam 	= $this->input->get('kode_pinjam');
		$nama 	= $this->input->get('nama');
		$tanggal 	= $this->input->get('tanggal');
	    $time = time();
		$tgl2 = "%Y-%m-%d";
	    $this->load->model('M_pinjaman');
	    $dt['data'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
        $document = file_get_contents("dok.rtf");
        $document = str_replace("#NAMA", $nama, $document);
        $document = str_replace("#KODE", $kode_pinjam, $document);
        $document = str_replace("#TANGGAL", $tanggal, $document);
		$filename = 'Surat_Perjanjian_Pinjaman_'.$kode_pinjam.'_'.$nama;
        header("Content-type: application/msword");
        header("Content-disposition: inline; filename=".$filename.".doc");
        header("Content-length: ".strlen($document));
        echo $document;
	   
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
	
	
	
	public function view_pinjaman($kode_pinjam)
	{
		// if($this->input->is_ajax_request())
		// {
			$this->load->model('M_pinjaman');
			$this->load->model('M_simpanan');
			$dt['master'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
			$this->load->view('external/view', $dt);
		// }
	}

	
	
	
	
	
	
	
	public function acc($kode_pinjam = NULL)
	{
		if( ! empty($kode_pinjam))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory')
			{
				// if($this->input->is_ajax_request())
				// {
					
					$this->load->model('M_pinjaman');
					$this->load->model('M_simpanan');
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('status','Status','trim|required');
                       	$besar_pinjaman 	= $this->input->post('besar_pinjaman');
                       	$kode_anggota 	= $this->input->post('kode_anggota');
						$jenis 	= $this->input->post('kode_jenis_pinjam');
						$lama_angsuran 	= $this->input->post('lama_angsuran');
						$tempo 	= $this->input->post('tempo');
					    $id_user 	= $this->input->post('id_user');						
					    $status 	= $this->input->post('status');
					    $total 	= $this->input->post('total');
					    $total_pinjam 	= $this->input->post('total_pinjam');
						$date=date("Y-m-d");
						if($this->form_validation->run() == TRUE)
						{
		     
			 		
	         $insert = $this->M_pinjaman->terima($kode_anggota);
			 $this->M_pinjaman->insert_pinjaman($kode_anggota,$jenis,$besar_pinjaman,$total_pinjam,$total,$lama_angsuran, $date, $tempo, $id_user);
			 
							if($insert)
							{
								
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Status Pinjaman Berhasil diupdate.</div>"
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
						$dt['master'] = $this->M_pinjaman->get_detail_external($kode_pinjam)->row();
						
						$this->load->view('external/detail', $dt);
					}
				}
			// }
		}
	}
}