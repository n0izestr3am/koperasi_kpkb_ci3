<?php
class M_pinjaman extends CI_Model 
{
function pilih_last_id(){
        $query = $this->db->query("SELECT LAST_INSERT_ID() AS id");
        return $query->row();
     }	
	
	
	
	function max_eks_pinjaman(){
        $q = $this->db->query("select max(kode_pinjam) as kode_pinjam from eks_pinjaman");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $kd = ((int)$k->kode_pinjam)+1;
               }
        }else{
            $kd = "";
        }
        return $kd;
    }
function getKodeAng(){
        $q = $this->db->query("select MAX(RIGHT(kode_pinjam,3)) as kd_max from pinjaman");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return "PA".$kd;
    }
	
	
function getKodeEks(){
        $q = $this->db->query("select MAX(RIGHT(kode_pinjam,3)) as kd_max from eks_pinjaman");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return "PNA".$kd;
    }
function get_all()
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman, lama_angsuran, maks_pinjam, bunga')
			->order_by('kode_jenis_pinjam','asc')
			->get('jenis_pinjam');
	}
	function pinjaman_anggota()
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman,lama_angsuran,maks_pinjam, bunga')
			->where_not_in('kode_jenis_pinjam', 'P0005')
			->get('jenis_pinjam');
	}
	function pinjaman_non_anggota()
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman,lama_angsuran,maks_pinjam, bunga')
			->where_in('kode_jenis_pinjam', 'P0006')
			->or_where_in('kode_jenis_pinjam', 'P0005')
			->get('jenis_pinjam');
	}
	function get_type($ajax_type)
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman,lama_angsuran,maks_pinjam, bunga')
			->where('kode_jenis_pinjam', $ajax_type)
			->limit(1)
			->get('jenis_pinjam');
	}
	function get_baris($kode_jenis_pinjam)
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman,lama_angsuran,maks_pinjam, bunga')
			->where('kode_jenis_pinjam', $kode_jenis_pinjam)
			->limit(1)
			->get('jenis_pinjam');
	}
	function total_kas(){
			$this->db->select('sum(nilai) as nilai');
			$this->db->from('shu');
			return $this->db->get();
		}	
	function nilai_kas()
	{
		return $this->db
			->select('nilai')
			->where('id_shu',1)
			->limit(1)
			->get('shu');
	}
	function cek_kas($idkas)
	{
		return $this->db
			->select('id_shu, nilai')
			->where('id_shu', $idkas)
			->limit(1)
			->get('shu');
	}	
function maks_pinjam($kode_jenis_pinjam)
	{
		return $this->db
			->select('maks_pinjam')
			->where('kode_jenis_pinjam', $kode_jenis_pinjam)
			->limit(1)
			->get('jenis_pinjam');
	}
	function get_kode_pengajuan($status)
	{
		return $this->db
			->select('kode_anggota')
			->where('status', $status)
			->limit(1)
			->get('pengajuan');
	}
function get_id($kode)
	{
		return $this->db
			->select('kode_anggota')
			->where('kode_anggota', $kode)
			->limit(1)
			->get('anggota');
	}

	
	function max_klien(){
        $query = $this->db->query("SELECT max(id_klien) as id_klien FROM klien");
        return $query->row();
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
	
	
	
	
	
	function ajuan_external($kode_pinjam,$id_klien,$kode_jenis_pinjam,$type,$totalasli,$angsuran_plus_bunga,$besar_pinjaman,
	$lama_angsuran,$date,$tempo,$nama_jaminan,$id_user,$jaminan,$perjanjian)
	{
	         date_default_timezone_set("Asia/Jakarta");
		     $dt = array(
		   	'kode_pinjam' => $kode_pinjam,
			'id_klien' => $id_klien,
			'kode_jenis_pinjam' => $kode_jenis_pinjam,
			'type' => $type,
			'besar_pinjam' => $besar_pinjaman,
			'total_pinjam' => $totalasli,
			'besar_angsuran' => $angsuran_plus_bunga,
			'lama_angsuran' => $lama_angsuran,
			'sisa_angsuran' => $lama_angsuran,
			'sisa_pinjaman' => $totalasli,
			'id_user' => $id_user,
			'tgl_entri' => $date,
			'tgl_tempo' => $tempo,
			'jaminan' => $nama_jaminan,
			'file_jaminan' => $jaminan,
			'file_perjanjian' => $perjanjian,
			'acc' => 'Belum',
			'status' => 'Belum di acc'
		);
		return $this->db->insert('eks_pinjaman', $dt);
	}
	
	
	function terima_eks($kode_pinjam,$id_klien,$besar_angsuran,$id_user,$acc)
	{
		$dt = array(
			'id_klien' => $id_klien,
			'besar_angsuran' => $besar_angsuran,
			'id_user' => $id_user,
			'acc' => $acc,
			'status' => 'belum lunas'
		);

		return $this->db
			->where('kode_pinjam', $kode_pinjam)
			->update('eks_pinjaman', $dt);
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
	
	
	function ambil_pinjaman_bulanan_eksternal($bulanan){
        $query = $this->db->query("SELECT id_klien,tgl_entri,kode_jenis_pinjam,
                                        SUM(IF(kode_jenis_pinjam='P0005',besar_pinjam,0)) as external,
                                        SUM(besar_pinjam) AS per_total
                                        FROM eks_pinjaman
                        				WHERE MONTH(tgl_entri) = '".$bulanan."' 
				                       
                                  
                                  ");
        return $query;
    }
	function ambil_pinjaman_bulanan_orang($bulanan){
        $query = $this->db->query("SELECT count(id_klien) as total_anggota from eks_pinjaman
                        				WHERE MONTH(tgl_entri) = '".$bulanan."' 
				                       
                                  
                                  ");
        return $query;
    }


	
	function get_baris_pinjaman_external($kode_pinjam)
	{
		return $this->db
			->select('kode_pinjam, id_klien, kode_jenis_pinjam, besar_pinjam, besar_angsuran, lama_angsuran, sisa_angsuran, sisa_pinjaman, id_user, tgl_entri, tgl_tempo, status')
			->where('kode_pinjam', $kode_pinjam)
			->limit(1)
			->get('eks_pinjaman');
	}
	function get_detail_external($kode_pinjam)
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
				a.`file_jaminan`, 
				a.`file_perjanjian`, 
				a.`jaminan`, 
				a.`tgl_tempo`, 
				a.`tgl_entri`, 
				c.`nama_pinjaman`, 
				c.`bunga`, 
				a.`status`,
				a.`acc`,
				b.`nama`,
				b.`type`,
				b.`alamat`,
				d.`nama` AS admin,
				b.`tgl_pendaftaran`,
				b.`telp`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `pj_user` AS d ON a.`id_user` = d.`id_user` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
			WHERE 
				a.`kode_pinjam` = '".$kode_pinjam."' 
			LIMIT 1
		";
		return $this->db->query($sql);
	}
	
	
	
	
	
	
	
	
	function fetch_data_pengajuan_na($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_pengajuan`, 
				a.`id_klien`, 
				a.`tgl_pengajuan`, 
				a.`tgl_acc`, 
				c.`nama_pinjaman`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`besar_pinjam`, 0),',','.') ) AS besar_pinjam,
				a.`status`,
				b.`nama`
			FROM 
				`pengajuan` AS a 
				LEFT JOIN `klien` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_pengajuan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`kode_anggota` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`tgl_pengajuan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
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
			1 => 'a.`kode_pengajuan`',
			2 => 'a.`kode_anggota`',
			3 => 'a.`tgl_pengajuan`',
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
	
	
	
	
	function fetch_data_external($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`kode_pinjam`, 
				a.`id_klien`, 
				a.`tgl_entri`, 
				a.`tgl_tempo`, 
				c.`nama_pinjaman`, 
				a.`besar_pinjam`, 
				a.`status`,
				a.`acc`,
				b.`nama`,
				b.`alamat`
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `jenis_pinjam` AS c ON a.`kode_jenis_pinjam` = c.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`acc` = 'ACC'
				AND a.`status` = 'belum lunas'
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_pinjam` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function get_external()
	{
		return $this->db
			->select('kode_jenis_pinjam, nama_pinjaman,lama_angsuran,maks_pinjam, bunga')
			->where('kode_jenis_pinjam', 'P0005')
			->limit(1)
			->get('jenis_pinjam');
	}
	
	
	function cek_kode_validasi($kode)
	{
		return $this->db->select('kode_pinjam')->where('kode_pinjam', $kode)->limit(1)->get('eks_pinjaman');
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
}