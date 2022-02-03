<?php
class M_simpanan extends CI_Model 
{

function get_id($kode)
	{
		return $this->db
			->select('kode_anggota')
			->where('kode_anggota', $kode)
			->limit(1)
			->get('anggota');
	}
	function get_anggota_tabungan($kode_anggota)
	{
		return $this->db
			->select('kode_anggota')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('tabungan');
	}
	
	 
	
	
	function insertsimpanan($kode_anggota,$jenis_simpan,$besar_simpanan,$tgl_mulai,$id_user)
	{
			$dt = array(
		    'tgl_entri' => date('Y-m-d'),
			'kode_anggota' => $kode_anggota,
			'jenis_simpan' => $jenis_simpan,
			'besar_simpanan' => $besar_simpanan,
			'tgl_mulai' => $tgl_mulai,
			'id_user' => $id_user
		);

		return $this->db->insert('simpanan', $dt);
	}
	
	function insert_simpanan($kode_anggota,$jenis_simpan,$besar_simpanan,$tgl,$id_user){
        $query = $this->db->query("INSERT into simpanan(kode_anggota, jenis_simpan, besar_simpanan, tgl_entri, id_user) values('$kode_anggota','$jenis_simpan','$besar_simpanan','$tgl','$id_user')");
        return $query;
    }
	
	function insert_wajib($kode_anggota, $besar_simpanan, $tgl_mulai, $id_user)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		    'tgl_entri' => date('Y-m-d'),
			'kode_anggota' => $kode_anggota,
			'jenis_simpan' => 'wajib',
			'besar_simpanan' => $besar_simpanan,
			'tgl_mulai' => $tgl_mulai,
			'id_user' => $id_user
		);

		return $this->db->insert('simpanan', $dt);
	}
	function insert_sukarela($kode_anggota, $besar_simpanan, $tgl_mulai, $id_user)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		    'tgl_entri' => date('Y-m-d'),
			'kode_anggota' => $kode_anggota,
			'jenis_simpan' => 'sukarela',
			'besar_simpanan' => $besar_simpanan,
			'tgl_mulai' => $tgl_mulai,
			'id_user' => $id_user
		);

		return $this->db->insert('simpanan', $dt);
	}
	function get_tabungan($kode_anggota)
	{
		return $this->db
			->select('besar_tabungan')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('tabungan');
	}
	function insert_tabung($kode_anggota, $besar_simpanan)
	{
	date_default_timezone_set("Asia/Jakarta");
		$dt = array(
		   'kode_anggota' => $kode_anggota,
			'besar_tabungan' => $besar_simpanan,
			'tgl_mulai' => date("Y-m-d")
		);

		return $this->db->insert('tabungan', $dt);
	}
	
	
	function update_tabdddungan($kode, $besar_simpanan)
	{
		$dt = array(
			'kode_anggota' => $kode,
			'besar_tabungan' => $besar_simpanan,
			'tgl_mulai' => date("Y-m-d")
		);
      if( ! empty($kode)){
            $this->db->insert('tabungan', $dt);
			
        }else{
			$this->db->query("
			UPDATE `tabungan` SET `besar_tabungan` = `besar_tabungan` + ".$besar_simpanan." WHERE `kode_anggota` = '".$kode."'
		");	 
			return $this->db
			->where('kode_anggota', $kode)
			->update('tabungan', $dt);
				
		}
		
	}
	
    
	 
	 function save($kode_anggota, $besar_simpanan)
	{
		$room	= $this->M_simpanan->get_by_kode_anggota($kode_anggota);
			if (!$room)
			{
			$dt = array(
			'kode_anggota' => $kode_anggota,
			'besar_tabungan' => $besar_simpanan,
			'tgl_mulai' => date("Y-m-d")
		     );
		$this->db->insert('tabungan', $dt);
			}
			else
			{ $this->db->query("
			UPDATE `tabungan` SET `besar_tabungan` = `besar_tabungan` + ".$besar_simpanan." WHERE `kode_anggota` = '".$kode_anggota."'
		");	
          
            		
			}
		
	}
	//kas koperasi 
	function input_kas_koperasi($besar_simpanan)
	{
		 $this->db->query("
			UPDATE `shu` SET `nilai` = `nilai` + ".$besar_simpanan." WHERE `id_shu` = '1'
		");	 
			
	}
	
	function kas_koperasi($nilai)
	{
		 $this->db->query("
			UPDATE `shu` SET `nilai` = `nilai` + ".$nilai." WHERE `id_shu` = '1'
		");	 
			
	}
	 
	function ambil_kas_koperasi($nilai)
	{
		 $this->db->query("
			UPDATE `shu` SET `nilai` = `nilai` - ".$nilai." WHERE `id_shu` = '1'
		");	 
			
	}
	 
	 
	 
	 function update_tabungan($kode_anggota, $besar_simpanan)
    {
        if ($kode_anggota)
        {
            $this->db->query("
			UPDATE `tabungan` SET `besar_tabungan` = `besar_tabungan` + ".$besar_simpanan." WHERE `kode_anggota` = '".$kode_anggota."'
		");	 
            return $kode_anggota;
        }
        else
        {
			$dt = array(
			'kode_anggota' => $kode_anggota,
			'besar_tabungan' => $besar_simpanan,
			'tgl_mulai' => date("Y-m-d")
		);
			
            $this->db->insert('tabungan', $dt);
            return $this->db->insert_id();
        }
    }
	
	
	function get_by_kode_anggota($kode_anggota)
    {
		$this->db->where('kode_anggota',$kode_anggota);
		$result = $this->db->get('tabungan');
        return $result->row();
    }
	
	function get_jenis_simpanan($kode_jenis_simpan)
	{
		return $this->db
			->select('kode_jenis_simpan, besar_simpanan, tgl_entri, nama_simpanan, besar_simpanan')
			->where('kode_jenis_simpan', $kode_jenis_simpan)
			
			->limit(1)
			->get('jenis_simpanan');
	}
	
	
	
	
	function get_kode($kode_anggota)
	{
		return $this->db
			->select('kode_anggota')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('anggota');
	}
	
	
	
	
	function max_simpanan()
	{
$q = $this->db->query("SELECT sum(besar_simpanan) as simpan from simpanan");
		return $q;
	}

	function kode_simpan(){
        $query = $this->db->query("SELECT max(kode_simpan) as kode_simpan 
                                   FROM simpanan");
        
        return $query->row();  
    }
	
	

		
	function ambil_detail_simpanan($kode_anggota)
	{
		$sql = "
			SELECT 
				a.`kode_anggota`, 
				a.`tgl_entri`, 
				a.`kode_simpan`, 
				b.`nama` AS nama,
				b.`alamat` AS alamat,
				b.`nip` AS nip,
				b.`id_unit_kerja` AS id_unit_kerja,
				e.`nama` AS staff,
				d.`unit_kerja` AS unit_kerja,
				SUM(IF(jenis_simpan='wajib',besar_simpanan,0)) as wajib,
                SUM(IF(jenis_simpan='pokok',besar_simpanan,0)) as pokok,
                SUM(IF(jenis_simpan='sukarela',besar_simpanan,0)) as sukarela,
                SUM(IF(jenis_simpan='12 juli',besar_simpanan,0)) as juli,
                SUM(besar_simpanan) AS per_total	
			FROM 
				`simpanan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 
				LEFT JOIN `unit_kerja` AS d ON b.`id_unit_kerja` = d.`id_unit_kerja` 
			WHERE 
				a.`kode_anggota` = '".$kode_anggota."' 
			LIMIT 1
		";

		return $this->db->query($sql);
	}
	
	
	
	
	function get_detail_simpanan($kode_simpan)
	{
		$sql = "
			SELECT 
				a.`jenis_simpan`, 
				a.`kode_simpan`, 
				a.`kode_anggota`, 
				a.`id_user`, 
				a.`tgl_entri`, 
				a.`besar_simpanan`, 
				e.`nama`,
				b.`nama`,
				b.`nip`,
				b.`alamat`,
				b.`golongan`,
				b.`no_telp`
			FROM 
				`simpanan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 
			WHERE 
				a.`kode_simpan` = '".$kode_simpan."' 
			LIMIT 1
		";

		return $this->db->query($sql);
	}
	
	
	
	
	
	function fetch_data_simpanan_all($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				a.`kode_anggota`, 
				a.`kode_simpan`, 
				b.`nama` AS nama_anggota,
				SUM(IF(jenis_simpan='wajib',besar_simpanan,0)) as wajib,
                SUM(IF(jenis_simpan='pokok',besar_simpanan,0)) as pokok,
                SUM(IF(jenis_simpan='sukarela',besar_simpanan,0)) as sukarela,
                SUM(IF(jenis_simpan='12 juli',besar_simpanan,0)) as juli,
                SUM(besar_simpanan) AS per_total			
			FROM 
				`simpanan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				 GROUP BY 
				a.`kode_anggota` DESC
				
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_anggota` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				`wajib` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				`pokok` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				`juli` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				`sukarela` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`kode_anggota` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`tgl_entri` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`besar_simpanan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'nama_anggota',
			2 => 'a.`kode_anggota`',
			3 => 'b.`no_telp`',
			4 => 'a.`besar_simpanan`',
			5 => 'pokok',
			6 => 'wajib',
			7 => 'sukarela',
			8 => 'juli',
			9 => 'a.`tgl_entri`'
		);
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function ambil_simpanan_bulanan($bulanan){
        $query = $this->db->query("SELECT kode_anggota,tgl_entri,kode_simpan,
                                        SUM(IF(jenis_simpan='wajib',besar_simpanan,0)) as wajib,
                                        SUM(IF(jenis_simpan='pokok',besar_simpanan,0)) as pokok,
                                        SUM(IF(jenis_simpan='sukarela',besar_simpanan,0)) as sukarela,
                                        SUM(IF(jenis_simpan='12 juli',besar_simpanan,0)) as juli,
                                        SUM(besar_simpanan) AS per_total
                                        FROM simpanan
                        				 WHERE MONTH(tgl_entri) = '".$bulanan."' 
				                       
                                  
                                  ");
        return $query;
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
function ambil_simpanan($kode_anggota){
        $query = $this->db->query("SELECT kode_anggota,tgl_entri,kode_simpan,
                                        SUM(IF(jenis_simpan='wajib',besar_simpanan,0)) as wajib,
                                        SUM(IF(jenis_simpan='pokok',besar_simpanan,0)) as pokok,
                                        SUM(IF(jenis_simpan='sukarela',besar_simpanan,0)) as sukarela,
                                        SUM(IF(jenis_simpan='12 juli',besar_simpanan,0)) as juli,
                                        SUM(besar_simpanan) AS per_total
                                        FROM simpanan
                        				WHERE 
				                        kode_anggota = '".$kode_anggota."' 
                                  
                                  ");
        return $query;
    }
	function fetch_data_simpanan($kode_anggota = NULL,$like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_anggota`, 
				a.`tgl_entri`, 
				a.`kode_simpan`,
				a.`jenis_simpan`,
				a.`besar_simpanan`,
				b.`nama`
			FROM 
				`simpanan` AS a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`kode_anggota` = '".$kode_anggota."'  
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_anggota` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`tgl_entri` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`jenis_simpan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_simpanan`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_anggota`',
			2 => 'a.`tgl_entri`',
			3 => 'a.`jenis_simpan`',
			4 => 'b.`nama`',
			5 => 'a.`besar_simpanan`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function wajib()
	{
		return $this->db
			->select('kode_jenis_simpan, besar_simpanan, tgl_entri, nama_simpanan, besar_simpanan')
			->where('nama_simpanan', 'wajib')
			->order_by('kode_jenis_simpan','asc')
			->get('jenis_simpanan');
	}
function sukarela()
	{
		return $this->db
			->select('kode_jenis_simpan, besar_simpanan, tgl_entri, nama_simpanan, besar_simpanan')
			->where('nama_simpanan', 'sukarela')
			->order_by('kode_jenis_simpan','asc')
			->get('jenis_simpanan');
	}

	function get_baris_klien($id_klien)
	{
		return $this->db
			->select('id_klien, nama, alamat, telp, type')
			->where('id_klien', $id_klien)
			->limit(1)
			->get('klien');
	}
	function get_baris($id_anggota)
	{
		return $this->db
			->select('id_anggota, nama, alamat, no_telp, nip,kode_anggota')
			->where('id_anggota', $id_anggota)
			->limit(1)
			->get('anggota');
	}

	
	
}