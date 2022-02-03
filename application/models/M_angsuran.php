<?php
class M_angsuran extends CI_Model 
{
function get_all()
	{
		return $this->db
			->select('kode_angsur, kode_pinjam, angsuran_ke, sisa_pinjam,denda,besar_angsuran,kode_anggota, sisa_pinjam')
			->order_by('kode_jenis_pinjam','asc')
			->get('angsuran');
	}
	
	function transaksi($tgl_entri,$kode_anggota,$bunga,$user)
	{
		$dt = array(
			'kode_anggota' => $kode_anggota,
			'tanggal' => $tgl_entri,
			'nilai' => $bunga,
			'keterangan' => 'Angsuran Anggota : '.$kode_anggota.'',
			'id_user' => $user
		);

		return $this->db->insert('transaksi', $dt);
	}
	
	function transaksi_eks($tgl_entri,$id_klien,$bunga,$nama,$user)
	{
		$dt = array(
			'id_klien' => $id_klien,
			'kode_anggota' => '0',
			'tanggal' => $tgl_entri,
			'nilai' => $bunga,
			'keterangan' => 'Angsuran Anggota : '.$nama.'',
			'id_user' => $user
		);

		return $this->db->insert('transaksi', $dt);
	}
	
	
	
	function sisa_angsuran($kode_pinjam)
	{
		return $this->db
			->select('sisa_angsuran')
			->where('kode_pinjam', $kode_pinjam)
			->limit(1)
			->get('pinjaman');
	}
	
	function max_angsuran_ke($kode_anggota)
	{
		return $this->db
			->select('angsuran_ke')
			->where('kode_anggota', $kode_anggota)
			->order_by('angsuran_ke','desc')
			->get('angsuran');
	}
	function max_angsuran_eks_ke($id_klien)
	{
		return $this->db
			->select('angsuran_ke')
			->where('id_klien', $id_klien)
			->order_by('angsuran_ke','desc')
			->get('angsuran');
	}
	function get_baris($kode_pinjam)
	{
		return $this->db
			->select('kode_angsur, kode_pinjam, angsuran_ke, sisa_pinjam,denda,besar_angsuran,kode_anggota, sisa_pinjam')
			->where('kode_pinjam', $kode_pinjam)
			->limit(1)
			->get('angsuran');
	}
	function sisa_angsur($kode_pinjam, $sisa_angsuran)
	{
		$sql = "
			UPDATE `pinjaman` SET `sisa_angsuran` = `sisa_angsuran` - ".$sisa_angsuran." WHERE `kode_pinjam` = '".$kode_pinjam."'
		";

		return $this->db->query($sql);
	}
	
	function tambah_angsur_bk($kode_pinjam,$angsuran_ke,$besarangsu,$denda,$sisa,$kode_anggota,$id_klien,$id_user,$tgl_entri){
        $query = $this->db->query("INSERT into angsuran(kode_pinjam, angsuran_ke, besar_angsuran, denda, sisa_pinjam, kode_anggota, id_klien,id_user, tgl_entri) values('$kode_pinjam','$angsuran_ke','$besarangsu','$denda','$sisa','$kode_anggota','$id_klien','$id_user','$tgl_entri')");
        return $query;
    }
	
	function tambah_angsur($kode_pinjam,$angsuran_ke,$besarangsu,$denda,$sisa,$kode_anggota,$id_klien,$user,$tgl_entri)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		   	'kode_pinjam' => $kode_pinjam,
			'angsuran_ke' => $angsuran_ke,
			'besar_angsuran' => $besarangsu,
			'denda' => $denda,
			'sisa_pinjam' => $sisa,
			'kode_anggota' => $kode_anggota,
			'id_klien' => $id_klien,
			'id_user' => $user,
			'tgl_entri' =>  $tgl_entri
		);

		return $this->db->insert('angsuran', $dt);
	}
	
	
	
	
	
	function get_detail_eksternal($kode_pinjam)
	{
		$sql = "
			SELECT 
				a.`id_klien`,  
				a.`kode_angsur`,  
				a.`kode_pinjam`,  
				a.`tgl_entri`,  
				a.`sisa_pinjam`,  
				a.`angsuran_ke`,  
				a.`besar_angsuran`,  
				b.`nama`,  
				c.`kode_jenis_pinjam`,
				d.`nama_pinjaman`,
				c.`besar_pinjam`,
				c.`sisa_pinjaman`,
				c.`sisa_angsuran`,
				b.`type` 
			FROM 
				`angsuran` a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `pinjaman` AS c ON a.`kode_pinjam` = c.`kode_pinjam` 
				LEFT JOIN `jenis_pinjam` AS d ON c.`kode_jenis_pinjam` = d.`kode_jenis_pinjam` 
			WHERE 
				a.`kode_pinjam` = '".$kode_pinjam."' 
			ORDER BY 
				a.`kode_angsur` ASC 
		";

		return $this->db->query($sql);
	}
	
	
	
	function detail_pinjaman_eksternal($kode_pinjam)
	{
		$sql = "
			SELECT 
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`kode_jenis_pinjam`, 
				a.`besar_pinjam`, 
				a.`total_pinjam`, 
				a.`lama_angsuran`, 
				a.`besar_angsuran`, 
				a.`sisa_angsuran`, 
				a.`sisa_pinjaman`, 
				a.`tgl_tempo`, 
				a.`tgl_entri`, 
				c.`nama_pinjaman`,
                c.`lama_angsuran`, 
				c.`bunga`,				
				e.`nama` AS staff, 
				a.`status`,
				b.`nama`,
				
				b.`type`,
				b.`alamat`,
			
				b.`telp`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 
			WHERE 
				a.`kode_pinjam` = '".$kode_pinjam."' 
			LIMIT 1
		";

		return $this->db->query($sql);
	}
	
	
	
	
	
	function detail_angsuran_na($kode_pinjam)
	{
		$sql = "
			SELECT 
				a.`id_klien`,  
				a.`kode_angsur`,  
				a.`kode_pinjam`,  
				a.`tgl_entri`,  
				a.`sisa_pinjam`,  
				a.`angsuran_ke`,  
				a.`besar_angsuran`,  
				b.`nama`,  
				c.`kode_jenis_pinjam`,
				d.`nama_pinjaman`,
				c.`besar_pinjam`,
				c.`sisa_pinjaman`,
				c.`sisa_angsuran`,
				d.`lama_angsuran`, 
				d.`bunga`,
				b.`telp`,
				e.`nama` AS staff, 
				b.`type` 
			FROM 
				`angsuran` a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `eks_pinjaman` AS c ON a.`kode_pinjam` = c.`kode_pinjam` 
				LEFT JOIN `jenis_pinjam` AS d ON c.`kode_jenis_pinjam` = d.`kode_jenis_pinjam`
               LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 				
			WHERE 
				a.`kode_pinjam` = '".$kode_pinjam."' 
			ORDER BY 
				a.`kode_angsur` ASC 
		";

		return $this->db->query($sql);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function update_angsuran_ke($kode_pinjam,$hasilangsur,$sisa,$tempo){
        $query = $this->db->query("UPDATE pinjaman SET sisa_angsuran=$hasilangsur,
                                   sisa_pinjaman='$sisa',
                                   tgl_tempo='$tempo'								   
                                   WHERE kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }
	
	
	
	function update_angsuran_lunas($kode_pinjam,$sisa,$angsuran_ke){
        $query = $this->db->query("UPDATE pinjaman set sisa_angsuran='$angsuran_ke',
		sisa_pinjaman='$sisa',
		status='lunas' 
		where kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }
	function angsuran_lunas($kode_pinjam){
        $query = $this->db->query("UPDATE pinjaman set 
		status='lunas' 
		where kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }

	//ekseternal
	
	function eks_update_angsuran_ke($kode_pinjam,$hasilangsur,$sisa,$tempo){
        $query = $this->db->query("UPDATE eks_pinjaman SET sisa_angsuran=$hasilangsur,
                                   sisa_pinjaman='$sisa',
                                   tgl_tempo='$tempo'								   
                                   WHERE kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }
	
	
	
	function eks_update_angsuran_lunas($kode_pinjam,$sisa,$angsuran_ke){
        $query = $this->db->query("UPDATE eks_pinjaman set sisa_angsuran='$angsuran_ke',
		sisa_pinjaman='0',
		status='lunas' 
		where kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }
	
	function eks_angsuran_lunas($kode_pinjam){
        $query = $this->db->query("UPDATE eks_pinjaman set 
		sisa_pinjaman='0',
		status='lunas' 
		where kode_pinjam='$kode_pinjam'
                                  ");
        return $query;
		
    }
	
	
	
	//ekseternal
	
	
	
	
	
	
	
	
function get_id($kode)
	{
		return $this->db
			->select('kode_angsur')
			->where('kode_angsur', $kode)
			->limit(1)
			->get('angsuran');
	}
	
	function insert_angsuran($kode_anggota,$kode_jenis_pinjam,$besar_pinjaman,$bunga,$lama_angsuran, $tempo, $id_user)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		   	'kode_anggota' => $kode_anggota,
			'kode_jenis_pinjam' => $kode_jenis_pinjam,
			'besar_pinjam' => $besar_pinjaman,
			'besar_angsuran' => $bunga,
			'lama_angsuran' => $lama_angsuran,
			'sisa_angsuran' => $lama_angsuran,
			'sisa_pinjaman' => $besar_pinjaman,
			'id_user' => $id_user,
			'tgl_entri' => date('Y-m-d'),
			'tgl_tempo' => $tempo,
			'status' => 'belum lunas'
		);

		return $this->db->insert('pinjaman', $dt);
	}
	

		
	
	
	function jenis()
	{
		$q = $this->db->query("SELECT * from jenis_simpanan");
		return $q;
	}
function get_jenis_all()
	{
		return $this->db
			->select('kode_jenis_simpan, besar_simpanan, tgl_entri, nama_simpanan, besar_simpanan')
			->order_by('kode_jenis_simpan','asc')
			->get('jenis_simpanan');
	}
	
	
	
	
	
	
	
	
		
	function fetch_data_angsuran_lunas($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_klien`,  
				a.`kode_angsur`,  
				a.`kode_pinjam`,  
				a.`tgl_entri`,  
				a.`sisa_pinjam`,  
				a.`angsuran_ke`,  
				a.`besar_angsuran`,  
				b.`nama`,  
				b.`alamat`,  
				c.`kode_jenis_pinjam`,
				c.`status`,
				d.`nama_pinjaman`,
				c.`besar_pinjam`,
				CONCAT('Rp. ', REPLACE(FORMAT(c.`sisa_pinjaman`, 0),',','.') ) AS sisa_pinjaman,
				c.`sisa_angsuran`,
				c.`lama_angsuran`,
				c.`status`,
				b.`type` 
			FROM 
				`angsuran` a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `eks_pinjaman` AS c ON a.`kode_pinjam` = c.`kode_pinjam` 
				LEFT JOIN `jenis_pinjam` AS d ON c.`kode_jenis_pinjam` = d.`kode_jenis_pinjam`
				, (SELECT @row := 0) r WHERE 1=1 
				AND 
				c.`kode_jenis_pinjam` = 'P0005' 
				AND 
				c.`status` = 'lunas'
					GROUP BY a.`id_klien`
				
				
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`id_klien` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_pinjaman` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`nama_pinjaman`',
			3 => 'a.`lama_angsuran`',
			4 => 'a.`besar_angsuran`',
			5 => 'a.`sisa_angsuran`',
			6 => 'a.`sisa_pinjaman`',
			7 => 'a.`besar_pinjam`',
			8 => 'b.`nama`',
			9 => 'b.`alamat`',
			10 => 'c.`nama_pinjaman`',
			11 => 'c.`status`',
			12 => 'c.`lama_angsuran`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function fetch_data_angsuran_external($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_klien`,  
				a.`kode_angsur`,  
				a.`kode_pinjam`,  
				a.`tgl_entri`,  
				a.`sisa_pinjam`,  
				a.`angsuran_ke`,  
				a.`besar_angsuran`,  
				b.`nama`,  
				b.`alamat`,  
				c.`kode_jenis_pinjam`,
				c.`status`,
				d.`nama_pinjaman`,
				c.`besar_pinjam`,
				
				CONCAT('Rp. ', REPLACE(FORMAT(c.`sisa_pinjaman`, 0),',','.') ) AS sisa_pinjaman,
				c.`sisa_angsuran`,
				c.`lama_angsuran`,
				c.`status`,
				b.`type` 
			FROM 
				`angsuran` a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `eks_pinjaman` AS c ON a.`kode_pinjam` = c.`kode_pinjam` 
				LEFT JOIN `jenis_pinjam` AS d ON c.`kode_jenis_pinjam` = d.`kode_jenis_pinjam`
				, (SELECT @row := 0) r WHERE 1=1 
				
				AND 
				c.`status` = 'belum lunas'
					GROUP BY a.`id_klien`
				
				
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_angsur` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
				
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`nama_pinjaman`',
			3 => 'a.`lama_angsuran`',
			4 => 'a.`besar_angsuran`',
			5 => 'a.`sisa_angsuran`',
			6 => 'a.`sisa_pinjaman`',
			7 => 'a.`besar_pinjam`',
			8 => 'b.`nama`',
			9 => 'b.`alamat`',
			10 => 'c.`nama_pinjaman`',
			11 => 'c.`status`',
			12 => 'c.`lama_angsuran`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	
	function fetch_data_angsuran_eks($id_klien = NULL,$like_value = NULL, $column_order = NULL, $column_dir = NULL)
	{
		$sql = "
			SELECT 
			     
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`kode_jenis_pinjam`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) AS besar_pinjam,
				a.`lama_angsuran`, 
				a.`sisa_angsuran`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_angsuran`, 0),',','.') ) AS besar_angsuran,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`sisa_pinjaman`, 0),',','.') ) AS sisa_pinjaman,
				a.`tgl_tempo`, 
				a.`tgl_entri`, 
				c.`nama_pinjaman`, 
				a.`status`,
				b.`nama`,
				b.`type`,
				b.`alamat`,
				b.`telp`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
			   WHERE 
				a.`id_klien` = '".$id_klien."' 
			    ORDER BY 
				a.`kode_pinjam` DESC
			
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_jenis_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_pinjaman` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_pinjam`',
			2 => 'a.`nama_pinjaman`',
			3 => 'a.`lama_angsuran`',
			4 => 'a.`besar_angsuran`',
			5 => 'a.`sisa_angsuran`',
			6 => 'a.`sisa_pinjaman`',
			7 => 'a.`besar_pinjam`',
			8 => 'b.`nama`',
			9 => 'b.`alamat`',
			10 => 'c.`nama_pinjaman`'
		);
		
		//$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		//$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	

	
	
}