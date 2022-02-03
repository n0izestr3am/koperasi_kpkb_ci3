<?php
class M_tabungan extends CI_Model
{
	

	function get_id($nomor_nota)
	{
		return $this->db
			->select('id_penjualan_m')
			->where('nomor_nota', $nomor_nota)
			->limit(1)
			->get('pj_penjualan_master');
	}


	function fetch_data_pengambilan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_ambil`, 
				a.`kode_anggota`, 
				a.`kode_tabungan`, 
				a.`tgl_ambil`, 
				b.`nip`, 
				b.`nama`, 
				DATE_FORMAT(a.`tgl_ambil`, '%d %b %Y') AS tgl_ambil,
		
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_ambil`, 0),',','.') ) AS besar_ambil,
				IF(c.`nama` IS NULL, 'Umum', c.`nama`) AS nama_admin
			FROM 
				`pengambilan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				
				, (SELECT @row := 0) r WHERE 1=1 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_ambil` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`tgl_ambil`, '%d %b %Y') LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_ambil`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(b.`nama` IS NULL, 'Umum', b.`nama`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_ambil`',
			2 => 'a.`tgl_ambil`',
			3 => 'a.`besar_ambil`',
			4 => 'a.`kode_anggota`',
			5 => 'b.nama',
			6 => 'nama_admin',
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}







	function fetch_data_tabungan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_tabungan`, 
				a.`kode_anggota`, 
				b.`nip`, 
				DATE_FORMAT(a.`tgl_mulai`, '%d %b %Y') AS tanggal,
		
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_tabungan`, 0),',','.') ) AS besar_tabungan,
				IF(b.`nama` IS NULL, 'Umum', b.`nama`) AS nama_anggota
			FROM 
				`tabungan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				
				, (SELECT @row := 0) r WHERE 1=1 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_tabungan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`tgl_mulai`, '%d %b %Y') LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_tabungan`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(b.`nama` IS NULL, 'Umum', b.`nama`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_tabungan`',
			2 => 'a.`tanggal`',
			3 => 'a.`besar_tabungan`',
			4 => 'kode_tabungan',
			5 => 'b.nip',
			6 => 'nama_anggota'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	function update_tabungan($sisa,$kode_tabungan,$kode_anggota){
        $query = $this->db->query("UPDATE tabungan SET besar_tabungan=$sisa		   
                                   WHERE kode_tabungan='$kode_tabungan'
                                   AND kode_anggota='$kode_anggota'
                                  ");
        return $query;
		
    }
	function ambil_tabungan2($kode_anggota,$kode_tabungan,$besar_ambil,$tgl_ambil,$id_user){
        $query = $this->db->query("INSERT into pengambilan(kode_anggota,kode_tabungan,besar_ambil,tgl_ambil,id_user)
		values('$kode_anggota,$kode_tabungan,$besar_ambil,$tgl_ambil,$id_user')");
        return $query;
    }
	function ambil_tabungan($kode_anggota,$kode_tabungan,$besar_ambil,$tgl_ambil,$id_user)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		   	'kode_anggota' => $kode_anggota,
			'kode_tabungan' => $kode_tabungan,
			'besar_ambil' => $besar_ambil,
			'tgl_ambil' => $tgl_ambil,
			'id_user' => $id_user
		);

		return $this->db->insert('pengambilan', $dt);
	}
	function ambil_kas_koperasi($nilai)
	{
		 $this->db->query("
			UPDATE `shu` SET `nilai` = `nilai` - ".$nilai." WHERE `id_shu` = '1'
		");	 
			
	}
	
function get_simpanan($kode_anggota)
	{
		$sql = "
			SELECT sum(besar_simpanan) as total_asli from simpanan where kode_anggota='".$kode_anggota."'
		";
		return $this->db->query($sql);
	}
	
	
	
	function get_pengambilan($kode_tabungan)
	{
		$sql = "
			SELECT 
				a.`kode_tabungan`, 
				a.`kode_anggota`, 
				a.`kode_ambil`, 
				a.`besar_ambil`, 
				a.`tgl_ambil`, 
				b.`nip`,  
				b.`id_unit_kerja`,  
				d.`unit_kerja`,  
				b.`nama`,  
				e.`besar_tabungan`,  
				c.`nama` AS staff,  
				b.`alamat` 
				FROM 
				`pengambilan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `unit_kerja` AS d ON b.`id_unit_kerja` = d.`id_unit_kerja` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				LEFT JOIN `tabungan` AS e ON a.`kode_anggota` = e.`kode_anggota` 
			WHERE 
				a.`kode_tabungan` = '".$kode_tabungan."' 
			LIMIT 1
		";
		return $this->db->query($sql);
	}
	
	
	function get_baris($kode_tabungan)
	{
		$sql = "
			SELECT 
				a.`kode_tabungan`, 
				a.`kode_anggota`, 
				a.`tgl_mulai`, 
				a.`besar_tabungan`, 
				b.`nip`,  
				b.`nama`,  
				b.`alamat` 
				FROM 
				`tabungan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
			WHERE 
				a.`kode_tabungan` = '".$kode_tabungan."' 
			LIMIT 1
		";
		return $this->db->query($sql);
	}

	function cek_anggota($kode_anggota)
	{
		return $this->db->select('kode_anggota')->where('kode_anggota', $kode_anggota)->limit(1)->get('tabungan');
	}
	function laporan_tabungan($from, $to)
	{
		$sql = "
			SELECT 
				
				DISTINCT(SUBSTR(a.`tgl_mulai`, 1, 10)) AS tgl_mulai,
				(
					SELECT c.nama,
				    a.kode_anggota,
						SUM(b.`besar_tabungan`) 
					FROM 
						`tabungan` AS b 
					LEFT JOIN `anggota` AS c ON a.`kode_anggota` = c.`kode_anggota` 	
					WHERE 
						SUBSTR(b.`tgl_mulai`, 1, 10) = SUBSTR(a.`tgl_mulai`, 1, 10) 
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`tabungan` AS a 
			WHERE 
				SUBSTR(a.`tgl_mulai`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_mulai`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tgl_mulai` ASC
		";

		return $this->db->query($sql);
	}

function lap_tabungan()
	{
		$sql = "
			SELECT 
				
				DISTINCT(SUBSTR(a.`tgl_mulai`, 1, 10)) AS tgl_mulai,
				(
					SELECT c.nama,
				    a.kode_anggota,
						SUM(b.`besar_tabungan`) 
					FROM 
						`tabungan` AS b 
					LEFT JOIN `anggota` AS c ON a.`kode_anggota` = c.`kode_anggota` 	
					WHERE 
						SUBSTR(a.`tgl_mulai`, 1, 10)
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`tabungan` AS a 
				WHERE 
				SUBSTR(a.`tgl_mulai`, 1, 10)
				a.`tgl_mulai` ASC
		";

		return $this->db->query($sql);
	}



	
}