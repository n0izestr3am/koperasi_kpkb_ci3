<?php
class M_klien extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_klien, nama,alamat,telp,type')
			->where('status', 'aktif')
			->order_by('nama', 'asc')
			->get('klien');
	}

	function fetch_data_merek($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_merk_barang, 
				merk 
			FROM 
				`pj_merk_barang`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				merk LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'merk'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function save_klien($nama,$alamat,$telp_peminjam,$type)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		   	'nama' => $nama,
			'alamat' => $alamat,
			'telp' => $telp_peminjam,
			'type' => $type,
			'email' => '@',
			'status' => 'Aktif',
			'tgl_pendaftaran' =>date('Y-m-d')
			
		);
		return $this->db->insert('klien', $dt);
	}
	
	
	
	function update_merek($id_klien,$nama,$alamat)
	{
		$dt = array(
			          'nama' => $nama,
			          'alamat' => $alamat
		);

		return $this->db
			->where('id_klien', $id_klien)
			->update('klien', $dt);
	}
	
	
	
	
	
	function update($id_klien,$nama,$alamat_debitur,$telp_peminjam,$typex)
	{
		$dt = array(
			          'nama' => $nama,
			          'alamat' => $alamat_debitur,
			          'telp' => $telp_peminjam,
			          'type' => $typex
		);

		return $this->db
			->where('id_klien', $id_klien)
			->update('klien', $dt);
	}


	function get_baris_laporan($debitur)
	{
		return $this->db
			->select('id_klien, nama,alamat,telp,type')
			->where('id_klien', $debitur)
			->limit(1)
			->get('klien');
	}
	
	
	
	function get_baris($id_klien)
	{
		return $this->db
			->select('id_klien, nama,alamat,telp,type')
			->where('id_klien', $id_klien)
			->limit(1)
			->get('klien');
	}
	
	function hapus_merek($id_merk_barang)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_merk_barang', $id_merk_barang)
			->update('pj_merk_barang', $dt);
	}

	

}