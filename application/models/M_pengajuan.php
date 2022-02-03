<?php
class M_pengajuan extends CI_Model 
{

	function fetch_data_pengajuan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`tgl_entri`, 
				a.`tgl_acc`, 
				c.`nama_pinjaman`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) AS besar_pinjam,
				a.`status`,
				b.`nama`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`id_klien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`tgl_entri` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`status` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama_pinjaman` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`id_klien`',
			3 => 'a.`tgl_entri`',
			4 => 'b.`nama`',
			5 => 'c.`nama_pinjaman`',
			6 => 'a.`besar_pinjam`',
     		7 => 'a.`status`'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	function fetch_data_external_baru($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`tgl_entri`, 
				a.`tgl_tempo`, 
				c.`nama_pinjaman`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) AS besar_pinjam,
				a.`status`,
				a.`acc`,
				b.`nama`,
				b.`alamat`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`acc` = 'Belum'
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`kode_anggota` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`tgl_entri` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`status` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama_pinjaman` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`kode_anggota`',
			3 => 'a.`tgl_entri`',
			4 => 'b.`nama`',
			5 => 'c.`nama_pinjaman`',
			6 => 'a.`besar_pinjam`',
     		7 => 'a.`status`',
     		8 => 'a.`acc`',
     		9 => 'b.`alamat`'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function fetch_data_pengajuan_na($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`tgl_entri`, 
				a.`tgl_acc`, 
				c.`nama_pinjaman`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) AS besar_pinjam,
				a.`status`,
				b.`nama`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`id_klien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`tgl_entri` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`status` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama_pinjaman` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`id_klien`',
			3 => 'a.`tgl_entri`',
			4 => 'b.`nama`',
			5 => 'c.`nama_pinjaman`',
			6 => 'a.`besar_pinjam`',
     		7 => 'a.`status`'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}

}