<?php
class M_home extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_halaman, judul')
			->where('dihapus', 'tidak')
			->order_by('judul', 'asc')
			->get('halaman');
	}
function total_transaksi(){
			$this->db->select('sum(nilai) as total_transaksi');
			$this->db->from('transaksi');
			return $this->db->get();
		}
	function total_kas(){
			$this->db->select('sum(nilai) as total_kas');
			$this->db->from('shu');
			return $this->db->get();
		}	
	function ambil_kas_bulanan($bulanan){
        $query = $this->db->query("SELECT SUM(nilai) as nilai from transaksi
                        				WHERE MONTH(tanggal) = '".$bulanan."' 
				                       
                                  
                                  ");
        return $query;
    }
	
	
	
	
	function get_p()
	{
		$sql = "
SELECT eks_pinjaman.kode_pinjam, jenis_pinjam.nama_pinjaman, COUNT(eks_pinjaman.kode_pinjam) AS total
FROM eks_pinjaman
LEFT JOIN jenis_pinjam
ON eks_pinjaman.kode_jenis_pinjam=jenis_pinjam.kode_jenis_pinjam
GROUP BY jenis_pinjam.nama_pinjaman
		";

		return $this->db->query($sql);
	}
	
	
	
	
	function telat()
	{
		return $this->db
			->select('id_klien, tgl_entri,kode_jenis_pinjam, status, tgl_tempo')
			->where('status', 'belum lunas')
			->order_by('kode_pinjam','asc')
			->get('eks_pinjaman');
	}
	function lancar()
	{
		return $this->db
			->select('id_klien, tgl_entri,kode_jenis_pinjam, status, tgl_tempo')
			->where('status', 'lunas')
			->order_by('kode_pinjam','asc')
			->get('eks_pinjaman');
	}
function numRowsPinjaman($status)
	{
		$this->db->select('*');
		$this->db->from('pinjaman');
		$this->db->where('status', $status);
		$data = $this->db->get()->num_rows();
		return $data;
	}
	
	function numRowsPengajuan()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->where('status', 'belum acc');
		$data = $this->db->get()->num_rows();
		return $data;
	}
	
	function get_baris($id_halaman)
	{
		return $this->db
			->select('id_halaman, judul,isi')
			->where('id_halaman', $id_halaman)
			->limit(1)
			->get('halaman');
	}

	
}