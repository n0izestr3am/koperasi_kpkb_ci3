<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author     Srimonika Br Brahmana <srimonika19.sembiring@gmail.com>
 * @copyright  2017
 * @license    Unikom
 *
 */
class Transaksi extends MY_Controller
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
		$this->load->view('transaksi/data');
	}
    public function external()
	{
		$this->load->view('external/data');
	}
	public function list_anggota_json()
	{
		$this->load->model('M_Anggota');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_Anggota->fetch_data_anggota($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$kode_anggota	= $row['kode_anggota'];
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
			$nestedData[]	= $row['nip'];
			$nestedData[]	= $row['alamat'];
			if($level == 'admin' OR $level == 'inventory')
			{
$nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('simpanan/view/'.$row['kode_anggota'])."'><i class='glyphicon glyphicon-check'></i> Simpan</a>";
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('pinjaman/tambah/'.$row['id_anggota'])."'><i class='glyphicon glyphicon-edit'></i> Pinjam | <i class='glyphicon glyphicon-share'></i> Angsur</a>";
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
			$status	= $row['status'];
            $pengajuan = $this->db->query("SELECT * FROM eks_pinjaman where kode_pinjam='$kode_pinjam' and status='Pending'");
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
			if($status == 'Pending')
			{
$nestedData[]	= "<a class='btn btn-danger btn-xs' href='".site_url('transaksi/pinjam-angsur/'.$row['id_anggota'])."' id='Pending'>
<i class='glyphicon glyphicon-alert'></i> Pending</a>";
			}else{
			$nestedData[]	= "<a class='btn btn-danger btn-xs' href='".site_url('transaksi/pinjam-angsur/'.$row['id_anggota'])."'><i class='glyphicon glyphicon-edit'></i> Pinjam | <i class='glyphicon glyphicon-share'></i> Angsur</a>";	
			}
			if($level == 'admin' OR $level == 'inventory')
			{
$nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('transaksi/view-external/'.$row['kode_pinjam'])."'><i class='glyphicon glyphicon-check'></i> Detail</a>";
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('transaksi/pinjam-angsur/'.$row['id_anggota'])."'><i class='glyphicon glyphicon-edit'></i> Pinjam | <i class='glyphicon glyphicon-share'></i> Angsur</a>";
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
			$angsuran = $this->db->query("SELECT * FROM angsuran where kode_pinjam='$kd_p' and kode_anggota='$kode'");
			$ang = $angsuran->row();
			$nestedData[]	= $row['kode_pinjam'];
			$nestedData[]	= $row['tgl_entri'];
			$nestedData[]	= ucfirst($row['nama_pinjaman']);
			$nestedData[]	= $row['besar_pinjam'];
			$nestedData[]	= $row['besar_angsuran'];
			$nestedData[]	= "<kbd>".$row['sisa_angsuran']."</kbd> Bulan Dari <kbd>".$row['lama_angsuran']."</kbd> Bulan ";
			$nestedData[]	= $row['tgl_tempo'];
			$nestedData[]	= $row['status'];
		    $nestedData[]	= "<a class='btn btn-primary btn-xs' href='".site_url('transaksi/view-angsuran/'.$row['kode_pinjam'])."' id='view'><i class='fa fa-eye'></i> View</a>";
			if($row['status'] == 'lunas')
			{
$nestedData[]	= "<a class='btn btn-warning btn-xs' disabled='disabled'>Angsur</a>";
			}else{
$nestedData[]	= "<a class='btn btn-warning btn-xs' href='".site_url('transaksi/angsuran/'.$row['kode_pinjam'])."' id='angsuran'><i class='fa fa-pencil'></i> Angsur</a>";
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
	
	public function ajax_pinjam()
	{
		if($this->input->is_ajax_request())
		{
			$kode_jenis_pinjam = $this->input->post('kode_jenis_pinjam');
			$this->load->model('M_pinjaman');
			$data = $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row();
			$json['nama_pinjaman']			= ( ! empty($data->nama_pinjaman)) ? $data->nama_pinjaman : "<small><i>Tidak ada</i></small>";
			$json['lama_angsuran']			= ( ! empty($data->lama_angsuran)) ? $data->lama_angsuran : "<small><i>Tidak ada</i></small>";
			$json['maks_pinjam']			= ( ! empty($data->maks_pinjam)) ? Rp($data->maks_pinjam)  : "<small><i>Tidak ada</i></small>";
			$json['bunga']			= ( ! empty($data->bunga)) ? $data->bunga : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		}
	}
	public function ajax_pinjaman()
	{
			$kode_jenis_pinjam = $this->input->post('kode_jenis_pinjam');
			$this->load->model('M_pinjaman');
			$data = $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row();
			$json['nama_pinjaman'] = ( ! empty($data->nama_pinjaman)) ? $data->nama_pinjaman : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
	}
	
	public function input_pinjam($kode = NULL)
	{
		if( ! empty($kode))
		{
		$level = $this->session->userdata('ap_level');
		$this->load->model('M_Anggota');
					$this->load->model('M_simpanan');
					$this->load->model('M_pinjaman');
					$this->load->model('m_user');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('kode_anggota','Kode','trim|required');
				$this->form_validation->set_rules('besar_pinjaman','Pinjaman','trim|required|numeric|max_length[40]');
				$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('required','%s harus diisi !');
                $this->form_validation->set_message('cek_pinjaman', '%s sudah ada');
				if($this->form_validation->run() == TRUE)
				{
					$kode_anggota 	= $this->input->post('kode_anggota');
					$besar_pinjaman 	= $this->input->post('besar_pinjaman');
					$tgl_mulai 	= date('Y-m-d');
					$kode_jenis_pinjam 	= $this->input->post('kode_jenis_pinjam');
					$id_user 	= $this->input->post('id_user');
					$tempo=date('Y-m-d',strtotime('+30 day',strtotime($tgl_mulai)));
					$maks_pinjam 	= $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row()->maks_pinjam;
					$besar_angsuran = $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row()->besar_angsuran;
					$lama_angsuran  = $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row()->lama_angsuran;
					$sisa_angsuran 	= $this->M_pinjaman->get_baris($kode_jenis_pinjam)->row()->sisa_angsuran;
					$bunga = (($besar_pinjaman*1.5)/100);
					if($besar_pinjaman > $maks_pinjam)
							{
						    $this->query_error("Maaf besar pinjaman melebihi maksimal pinjam");
							}
					else{
$insert = $this->M_pinjaman->ajukan_pinjaman($kode_anggota,$kode_jenis_pinjam,$besar_pinjaman,$bunga,$lama_angsuran,$tempo, $id_user);
				if($insert)
					{
						$nama = $this->M_Anggota->get_nama($kode_anggota)->row()->nama;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil disimpan.</div>",
							'tgl_mulai' => $tgl_mulai,
							'besar_pinjaman' => (empty($besar_pinjaman)) ? "<small><i>Tidak ada</i></small>" : preg_replace("/\r\n|\r|\n/",'<br />', $besar_pinjaman)						
						));
					    }
					else
					{
						$this->query_error();
					}
				}
				}
				else
				{ $this->input_error();}
			}
			else
			{
			   $dt['anggota'] = $this->M_Anggota->get_kode($kode)->row();
						$dt['simp'] = $this->M_simpanan->sukarela()->row();
						$dt['kasirnya'] = $this->m_user->list_kasir();
						$dt['pinjaman']= $this->M_pinjaman->get_all();
						$this->load->view('transaksi/pinjam', $dt);
			}
		}
		}
	}
	public function cek_pinjaman($besar_pinjaman)
	{
	 $this->load->model('M_pinjaman');
	 $maks_pinjam = $this->M_pinjaman->maks_pinjam($besar_pinjaman);
		if($besar_pinjaman < $maks_pinjam){
			return FALSE;
		}else{
		return TRUE;
		}
	}
	public function cek_diskon($kode_jenis_pinjam)
	{
		$this->load->model('M_transaksi_master');
		        $maks_pinjam = $this->M_pinjaman->maks_pinjam($kode_jenis_pinjam);
		if($maks_pinjam->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}
		public function sukarela($kode = NULL)
	{
		if( ! empty($kode))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory')
			{
				 // if($this->input->is_ajax_request())
				// { 
					$this->load->model('M_Anggota');
					$this->load->model('M_simpanan');
					$this->load->model('m_user');
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('kode_anggota','Kode','trim|required');
						$this->form_validation->set_message('required','%s harus diisi !');
						/* $this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !'); */
						if($this->form_validation->run() == TRUE)
						{
							$kode_anggota 	= $this->input->post('kode_anggota');
							$besar_simpanan 	= $this->input->post('besar_simpanan');
							$tgl_mulai 	= $this->input->post('tgl_mulai');
							$id_user 	= $this->input->post('id_user');
							$master 	= $this->M_simpanan->insert_sukarela($kode_anggota, $besar_simpanan, $tgl_mulai, $id_user);
							if($master)
								{
								    $this->load->model('M_Anggota');
					                $this->load->model('M_simpanan');
				$tabungan		= $this->M_simpanan->get_tabungan($kode_anggota)->row()->besar_tabungan;
									$anggota		= $this->M_simpanan->get_anggota_tabungan($kode_anggota)->row()->kode_anggota;
									$hasil=$tabungan+$besar_simpanan;
									$inserted	= 0;
									$this->M_simpanan->update_tabungan($kode_anggota,$anggota, $hasil, $tgl_mulai);
									$inserted++;
									}								
							if($inserted > 0)
							{
						echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Simpanan berhasil diupdate.</div>"
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
						$dt['anggota'] = $this->M_Anggota->get_kode($kode)->row();
						$dt['simp'] = $this->M_simpanan->sukarela()->row();
						$dt['kasirnya'] = $this->m_user->list_kasir();
						$this->load->view('transaksi/sukarela', $dt);
					}
				}
			 // } 
		}
	}
	public function wajib($kode = NULL)
	{
		if( ! empty($kode))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory')
			{
				 if($this->input->is_ajax_request())
				{ 
					$this->load->model('M_Anggota');
					$this->load->model('M_simpanan');
					$this->load->model('m_user');
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('kode_anggota','Kode','trim|required');
						$this->form_validation->set_message('required','%s harus diisi !');
						/* $this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !'); */
						if($this->form_validation->run() == TRUE)
						{
							$kode_anggota 	= $this->input->post('kode_anggota');
							$besar_simpanan 	= $this->input->post('besar_simpanan');
							$tgl_mulai 	= $this->input->post('tgl_mulai');
							$id_user 	= $this->input->post('id_user');
							$master 	= $this->M_simpanan->insert_wajib($kode_anggota, $besar_simpanan, $tgl_mulai, $id_user);
							if($master)
								{
								    $this->load->model('M_Anggota');
					                $this->load->model('M_simpanan');
									$tabungan		= $this->M_simpanan->get_tabungan($kode_anggota)->row()->besar_tabungan;
									$anggota		= $this->M_simpanan->get_anggota_tabungan($kode_anggota)->row()->kode_anggota;
									$hasil=$tabungan+$besar_simpanan;
									$inserted	= 0;
									$this->M_simpanan->update_tabungan($kode_anggota,$anggota, $hasil, $tgl_mulai);
									$inserted++;
									}								
							if($inserted > 0)
							{
						echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Simpanan berhasil diupdate.</div>"
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
						$dt['anggota'] = $this->M_Anggota->get_kode($kode)->row();
						$dt['simp'] = $this->M_simpanan->wajib()->row();
							$dt['kasirnya'] = $this->m_user->list_kasir();
						$this->load->view('transaksi/wajib', $dt);
					}
				}
			 } 
		}
	}
	
	public function cek_kode($kode)
	{
		$this->load->model('M_pinjaman');
		$cek = $this->M_pinjaman->cek_kode_validasi($kode);
		if($cek->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}
	public function transaksi_cetak()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');
		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;
		$this->load->model('m_pelanggan');
		$pelanggan = 'umum';
		if( ! empty($id_pelanggan))
		{
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}
		$this->load->library('cfpdf');
		$pdf = new FPDF('P','mm','A5');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(25, 4, 'Nota', 0, 0, 'L');
		$pdf->Cell(85, 4, $nomor_nota, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(85, 4, date('d-M-Y H:i:s', strtotime($tanggal)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Kasir', 0, 0, 'L');
		$pdf->Cell(85, 4, $kasir, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Pelanggan', 0, 0, 'L');
		$pdf->Cell(85, 4, $pelanggan, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 5, 'Kode', 0, 0, 'L');
		$pdf->Cell(40, 5, 'Item', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Harga', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Qty', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Subtotal', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$this->load->model('m_barang');
		$this->load->helper('text');
		$no = 0;
		foreach($_GET['kode_barang'] as $kd)
		{
			if( ! empty($kd))
			{
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$pdf->Cell(25, 5, $kd, 0, 0, 'L');
				$pdf->Cell(40, 5, $nama_barang, 0, 0, 'L');
				$pdf->Cell(25, 5, str_replace(',', '.', number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(15, 5, $_GET['jumlah_beli'][$no], 0, 0, 'L');
				$pdf->Cell(25, 5, str_replace(',', '.', number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();
				$no++;
			}
		}
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(105, 5, 'Total Bayar', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(105, 5, 'Cash', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($cash)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(105, 5, 'Kembali', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format(($cash - $grand_total))), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 5, 'Catatan : ', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 5, (($catatan == '') ? 'Tidak Ada' : $catatan), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(130, 5, "Terimakasih telah berbelanja dengan kami", 0, 0, 'C');
		$pdf->Output();
	}
	
	
	
	public function ajax_pelanggan()
	{
		if($this->input->is_ajax_request())
		{
			$id_pelanggan = $this->input->post('id_pelanggan');
			$this->load->model('m_pelanggan');
			$data = $this->m_pelanggan->get_baris($id_pelanggan)->row();
			$json['telp']			= ( ! empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= ( ! empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= ( ! empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		}
	}
	public function ajax_kode()
	{
		if($this->input->is_ajax_request())
		{
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');
			$this->load->model('m_barang');
			$barang = $this->m_barang->cari_kode($keyword, $registered);
			if($barang->num_rows() > 0)
			{
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach($barang->result() as $b)
				{
					$json['datanya'] .= "
						<li>
							<b>Kode</b> :
							<span id='kodenya'>".$b->kode_barang."</span> <br />
							<span id='barangnya'>".$b->nama_barang."</span>
							<span id='harganya' style='display:none;'>".$b->harga."</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			}
			else
			{
				$json['status'] 	= 0;
			}
			echo json_encode($json);
		}
	}
	public function cek_kode_barang($kode)
	{
		$this->load->model('m_barang');
		$cek_kode = $this->m_barang->cek_kode($kode);
		if($cek_kode->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	public function cek_nol($qty)
	{
		if($qty > 0){
			return TRUE;
		}
		return FALSE;
	}
	public function history()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->view('transaksi/transaksi_history');
		}
	}
	public function history_json()
	{
		$this->load->model('m_transaksi_master');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->m_transaksi_master->fetch_data_penjualan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];
		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();
			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='".site_url('marikena/detail-transaksi/'.$row['id_penjualan_m'])."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$row['nomor_nota']."</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];
			if($level == 'admin' OR $level == 'keuangan')
			{
				$nestedData[]	= "<a href='".site_url('marikena/hapus-transaksi/'.$row['id_penjualan_m'])."' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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
	public function detail_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('transaksi_detail');
			$this->load->model('m_transaksi_master');
			$dt['detail'] = $this->transaksi_detail->get_detail($id_penjualan);
			$dt['master'] = $this->m_transaksi_master->get_baris($id_penjualan)->row();
			$this->load->view('transaksi/transaksi_history_detail', $dt);
		}
	}
	
	
	public function hapus_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			$level 	= $this->session->userdata('ap_level');
			if($level == 'admin')
			{
				$reverse_stok = $this->input->post('reverse_stok');
				$this->load->model('m_transaksi_master');
				$nota 	= $this->m_transaksi_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_transaksi_master->hapus_transaksi($id_penjualan, $reverse_stok);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>".$nota."</b> berhasil dihapus !</font>
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
}