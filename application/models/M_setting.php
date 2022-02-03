<?php
class M_setting extends CI_Model
{
	function get_all()
	{
		return $this->db
			->select('id_satuan, nama')
			->where('dihapus', 'tidak')
			->order_by('id_satuan', 'asc')
			->get('satuan');
	}
	function fetch_data_pinjaman($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT
				(@row:=@row+1) AS nomor,
				kode_jenis_pinjam,
				lama_angsuran,
				CONCAT('Rp. ', REPLACE(FORMAT(`maks_pinjam`, 0),',','.') ) AS maks_pinjam,
				bunga,
				nama_pinjaman
			FROM
				`jenis_pinjam`, (SELECT @row := 0) r WHERE 1=1
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";
			$sql .= "
				nama_pinjaman LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'nama_pinjaman'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	function fetch_data_kas($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_kas`, 
				a.`u_entry`, 
				a.`tgl_entri`, 
				a.`keterangan`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`jumlah`, 0),',','.') ) AS jumlah,
				b.`nama`
			FROM 
				`kas` AS a 
				LEFT JOIN `pj_user` AS b ON a.`u_entry` = b.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 ";
		
		
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";
			$sql .= "
				keterangan LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'jumlah',
			2 => 'u_entry'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	 function getKodePinjaman(){
        $q = $this->db->query("select MAX(RIGHT(kode_jenis_pinjam,3)) as kd_max from jenis_pinjam");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return "P".$kd;
    }
	
	
	
	
	 function getKodeSimpanan(){
        $q = $this->db->query("select MAX(RIGHT(kode_jenis_simpan,4)) as kd_max from jenis_simpanan");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return "S".$kd;
    }
function tambah_pinjaman($kode_jenis_pinjam,$nama_pinjaman,$lama_angsuran,$maks_pinjam,$bunga, $user, $tgl)
	{
		$dt = array(
			'kode_jenis_pinjam' => $kode_jenis_pinjam,
			'nama_pinjaman' => $nama_pinjaman,
			'lama_angsuran' => $lama_angsuran,
			'maks_pinjam' => $maks_pinjam,
			'bunga' => $bunga,
			'u_entry' => $user,
			'tgl_entri' => $tgl
		);
		return $this->db->insert('jenis_pinjam', $dt);
	}
	function tambah_kas($keterangan,$jumlah, $user, $tgl)
	{
		$dt = array(
			'keterangan' => $keterangan,
			'jumlah' => $jumlah,
			'u_entry' => $user,
			'tgl_entri' => $tgl
		);
		return $this->db->insert('kas', $dt);
	}
	function kas_update($jumlah)
	{
		 $this->db->query("
			UPDATE `shu` SET `nilai` = `nilai` + ".$jumlah." WHERE `id_shu` = '1'
		");	 
			
	}
	
	
	
	
	
	
	function update_pinjaman($kode_jenis_pinjam,$nama_pinjaman,$lama_angsuran,$maks_pinjam,$bunga,$user)
	{
		$dt = array(
			'kode_jenis_pinjam' => $kode_jenis_pinjam,
			'nama_pinjaman' => $nama_pinjaman,
			'lama_angsuran' => $lama_angsuran,
			'maks_pinjam' => $maks_pinjam,
			'bunga' => $bunga,
			'u_entry' => $user
		);
		return $this->db
			->where('kode_jenis_pinjam', $kode_jenis_pinjam)
			->update('jenis_pinjam', $dt);
	}
	function hapus_kas($id_kas)
	{
			return $this->db
			->where('id_kas', $id_kas)
			->delete('kas');
	}
	
	
	
	
	
	
	function hapus_pinjaman($kode_jenis_pinjam)
	{
			return $this->db
			->where('kode_jenis_pinjam', $kode_jenis_pinjam)
			->delete('jenis_pinjam');
	}
	function get_baris_pinjaman($kode_jenis_pinjam)
	{
		return $this->db
			->select('kode_jenis_pinjam,nama_pinjaman,lama_angsuran,maks_pinjam,bunga')
			->where('kode_jenis_pinjam', $kode_jenis_pinjam)
			->limit(1)
			->get('jenis_pinjam');
	}
	
	// JENIS SIMPAANAN
	function tambah_simpanan($kode_jenis_simpan,$nama_simpanan,$besar_simpanan, $user, $tgl)
	{
		$dt = array(
			'kode_jenis_simpan' => $kode_jenis_simpan,
			'nama_simpanan' => $nama_simpanan,
			'besar_simpanan' => $besar_simpanan,
			'id_user' => $user,
			'tgl_entri' => $tgl
		);
		return $this->db->insert('jenis_simpanan', $dt);
	}
	function hapus_simpanan($kode_jenis_simpan)
	{
			return $this->db
			->where('kode_jenis_simpan', $kode_jenis_simpan)
			->delete('jenis_simpanan');
	}
	function get_baris_simpanan($kode_jenis_simpan)
	{
		return $this->db
			->select('kode_jenis_simpan,nama_simpanan,besar_simpanan,id_user,tgl_entri')
			->where('kode_jenis_simpan', $kode_jenis_simpan)
			->limit(1)
			->get('jenis_simpanan');
	}
	function update_simpanan($kode_jenis_simpan,$nama_simpanan,$besar_simpanan)
	{
		$dt = array(
			'nama_simpanan' => $nama_simpanan,
			'besar_simpanan' => $besar_simpanan
		);
		return $this->db
			->where('kode_jenis_simpan', $kode_jenis_simpan)
			->update('jenis_simpanan', $dt);
	}
	function fetch_data_simpanan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT
				(@row:=@row+1) AS nomor,
				kode_jenis_simpan,
                CONCAT('Rp. ', REPLACE(FORMAT(`besar_simpanan`, 0),',','.') ) AS besar_simpanan,
				nama_simpanan
			FROM
				`jenis_simpanan`, (SELECT @row := 0) r WHERE 1=1
		";
		
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";
			$sql .= "
				nama_simpanan LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'nama_simpanan',
			2 => 'besar_simpanan'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	// SIMPANAN
	// UNIT KERJA
	function fetch_data_unit($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT
				(@row:=@row+1) AS nomor,
				id_unit_kerja,
				unit_kerja
			FROM
				`unit_kerja`, (SELECT @row := 0) r WHERE 1=1
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";
			$sql .= "
				unit_kerja LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array(
			0 => 'nomor',
			1 => 'unit_kerja'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function tambah_unit($unit_kerja, $user, $tgl)
	{
		$dt = array(
			'unit_kerja' => $unit_kerja,
			'u_entry' => $user,
			'tgl_entri' => $tgl
		);
		return $this->db->insert('unit_kerja', $dt);
	}
	function hapus_unit($id_unit_kerja)
	{
			return $this->db
			->where('id_unit_kerja', $id_unit_kerja)
			->delete('unit_kerja');
	}
	function get_baris_unit($id_unit_kerja)
	{
		return $this->db
			->select('id_unit_kerja, unit_kerja')
			->where('id_unit_kerja', $id_unit_kerja)
			->limit(1)
			->get('unit_kerja');
	}
	function update_unit($id_unit_kerja, $unit_kerja)
	{
		$dt = array(
			'unit_kerja' => $unit_kerja
		);
		return $this->db
			->where('id_unit_kerja', $id_unit_kerja)
			->update('unit_kerja', $dt);
	}
	// UNIT KERJA
	function tambah_nama($nama)
	{
		$dt = array(
			'nama' => $nama,
			'dihapus' => 'tidak'
		);
		return $this->db->insert('satuan', $dt);
	}
	function hapus_nama($id_satuan)
	{
		$dt = array(
			'dihapus' => 'ya'
		);
		return $this->db
			->where('id_satuan', $id_satuan)
			->update('satuan', $dt);
	}
	function get_baris($id_satuan)
	{
		return $this->db
			->select('id_satuan, nama')
			->where('id_satuan', $id_satuan)
			->limit(1)
			->get('satuan');
	}
	function update_nama($id_satuan, $nama)
	{
		$dt = array(
			'nama' => $nama
		);
		return $this->db
			->where('id_satuan', $id_satuan)
			->update('satuan', $dt);
	}
}