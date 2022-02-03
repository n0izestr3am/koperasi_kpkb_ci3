<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('M_pinjaman');
		$this->load->database();
	}
	function index()
	{
	   
	   $this->load->view('monika/home');
	}
	
	
function jenis_pinjaman()
	{
     $this->load->model('M_pinjaman');
     $kode_jenis_pinjam = $this->input->post('kode_jenis_pinjam');
     $data  =$this ->M_pinjaman->get_baris($kode_jenis_pinjam)->row();
	 $json['kode_jenis_pinjam']=( ! empty($data->kode_jenis_pinjam)) ? $data->kode_jenis_pinjam : "";
	 $json['lama_angsuran']=( ! empty($data->lama_angsuran)) ? $data->lama_angsuran : "";
	 $json['maks_pinjam']=( ! empty($data->maks_pinjam)) ? $data->maks_pinjam : "";
	 $json['nama_pinjaman']=( ! empty($data->maks_pinjam)) ? $data->nama_pinjaman : "";
	
	 echo json_encode($json);
		
	}
public function ajax_pelanggan()
	{
			$id_member = $this->input->post('id_member');
			$this->load->model('M_member');

			$data = $this->M_member->get_baris($id_member)->row();
			$json['telp']			= ( ! empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['status']			= ( ! empty($data->status)) ? $data->status : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= ( ! empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= ( ! empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		
	}
	
function ambil_konsumen() {
$kode_pinjam = $this->input->post('kode_jenis_pinjam',TRUE);
if($kode_pinjam!=""){
$row1 = $this->db->query("SELECT * FROM pinjaman WHERE kode_pinjam='$kode_pinjam'")->row_array();
			$arr = array("TGL_PINJAM"=>$d->tgl_entri,
			"BESAR_PINJAM"=>$d->besar_pinjam,
			"LAMA_ANGSURAN"=>$d->lama_angsuran,
			"BESAR_ANGSURAN"=>$d->besar_angsuran,
			"SISA_ANGSURAN"=>$d->sisa_angsuran+1
			);
	
	$arr = json_encode($arr);
	exit($arr);
}
}

public function simpanan()
	{
 //$tahun = $this->input->GET('tahun');
 $query = $this->db->query("SELECT kode_simpan,tgl_entri, YEAR(tgl_entri) AS TAHUN, MONTH(tgl_entri) AS BULAN, COUNT( * ) AS JUMLAH FROM simpanan WHERE YEAR(tgl_entri)=2019 GROUP BY MONTH(tgl_entri) ORDER BY kode_simpan");
 
 
        $bln = array();
        $bln['name'] = 'Bulan';
        $rows['name'] = 'Jumlah';
		foreach($query->result_array() as $row)
		{ 
			
			$bln['data'][]	= $row['BULAN'];
			$rows['data'][] = $row['JUMLAH'];
			
		}
$rslt = array();
array_push($rslt, $bln);
array_push($rslt, $rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);
		
	}


public function anggota()
	{
 //$tahun = $this->input->GET('tahun');
 $query = $this->db->query("SELECT kode_anggota,tgl_pendaftaran, YEAR(tgl_pendaftaran) AS TAHUN, MONTH(tgl_pendaftaran) AS BULAN, COUNT( * ) AS JUMLAH FROM anggota WHERE YEAR(tgl_pendaftaran)=2018 
 GROUP BY MONTH(tgl_pendaftaran) ORDER BY MONTH(tgl_pendaftaran) ASC");
 
 
        $bln = array();
        $bln['name'] = 'Bulan';
        $rows['name'] = 'Jumlah';
		foreach($query->result_array() as $row)
		{ 
			
			$bln['data'][]	= sbulan($row['BULAN']);
			$rows['data'][] = $row['JUMLAH'];
			
		}
$rslt = array();
array_push($rslt, $bln);
array_push($rslt, $rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);
		
	}



public function peminjam()
	{
 //$tahun = $this->input->GET('tahun');
 $query = $this->db->query("SELECT id_klien,tgl_pendaftaran, YEAR(tgl_pendaftaran) AS TAHUN, MONTH(tgl_pendaftaran) AS BULAN, COUNT( * ) AS JUMLAH FROM klien WHERE YEAR(tgl_pendaftaran)=2019 
 GROUP BY MONTH(tgl_pendaftaran) ORDER BY MONTH(tgl_pendaftaran) ASC");
 
 
        $bln = array();
        $bln['name'] = 'Bulan';
        $rows['name'] = 'Jumlah';
		foreach($query->result_array() as $row)
		{ 
			
			$bln['data'][]	= sbulan($row['BULAN']);
			$rows['data'][] = $row['JUMLAH'];
			
		}
$rslt = array();
array_push($rslt, $bln);
array_push($rslt, $rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);
		
	}





	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
