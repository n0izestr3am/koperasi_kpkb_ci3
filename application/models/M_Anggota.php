<?php
class M_Anggota extends CI_Model
{
	function get_all()
	{
		return $this->db
			->select('id_anggota, nama, alamat, no_telp, nip,kode_anggota')
			->where('dihapus', 'tidak')
			->order_by('nama','asc')
			->get('anggota');
	}
	function pokok()
	{
		return $this->db
			->select('kode_jenis_simpan,besar_simpanan, nama_simpanan')
			->where('kode_jenis_simpan', 'S0001')
			->limit(1)
			->get('jenis_simpanan');
	}
	function wajib()
	{
		return $this->db
			->select('kode_jenis_simpan,besar_simpanan, nama_simpanan')
			->where('kode_jenis_simpan', 'S0002')
			->limit(1)
			->get('jenis_simpanan');
	}
		function sukarela()
	{
		return $this->db
			->select('kode_jenis_simpan,besar_simpanan, nama_simpanan')
			->where('kode_jenis_simpan', 'S0003')
			->limit(1)
			->get('jenis_simpanan');
	}
		function juli()
	{
		return $this->db
			->select('kode_jenis_simpan,besar_simpanan, nama_simpanan')
			->where('kode_jenis_simpan', 'S0004')
			->limit(1)
			->get('jenis_simpanan');
	}
	
	function jenis_simpanan()
	{
		return $this->db
			->select('kode_jenis_simpan,besar_simpanan, nama_simpanan')
			->order_by('kode_jenis_simpan','asc')
			->get('jenis_simpanan');
	}
	
	function unit()
	{
		return $this->db
			->select('id_unit_kerja, unit_kerja')
			->order_by('unit_kerja','asc')
			->get('unit_kerja');
	}
	
//    KODE BARANG
   function getKode(){
        $q = $this->db->query("select MAX(RIGHT(kode_anggota,5)) as kd_max from anggota");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "A-".$kd;
    }
	
	function get_list($kode_anggota)
	{
		return $this->db
			->select('id_anggota, nama, alamat, no_telp, nip,kode_anggota')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('anggota');
	}
function get_kode($kode)
	{
		return $this->db
			->select('id_anggota, nama, alamat, no_telp, nip,kode_anggota')
			->where('kode_anggota', $kode)
			->limit(1)
			->get('anggota');
	}
	

	function get_unit($unit)
	{
		return $this->db
			->select('unit_kerja')
			->where('id_unit_kerja', $unit)
			->limit(1)
			->get('unit_kerja');
	}
	function get_nama($kode_anggota)
	{
		return $this->db
			->select('nama')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('anggota');
	}
	function get_nama_klien($id_klien)
	{
		return $this->db
			->select('nama')
			->where('id_klien', $id_klien)
			->limit(1)
			->get('klien');
	}
	
	function get_dari_kode($kode_unik)
	{
		return $this->db
			->select('id_anggota')
			->where('kode_unik', $kode_unik)
			->limit(1)
			->get('anggota');
	}
	
	function fetch_data_klien($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_klien`, 
				a.`nama`, 
				a.`alamat`,
				a.`telp`,
				a.`type`,
				b.`nama_pinjaman`,
				a.`status`,
			
				DATE_FORMAT(a.`tgl_pendaftaran`, '%d %b %Y') AS tgl_pendaftaran 
			FROM 
				`klien` AS a 
				LEFT JOIN `jenis_pinjam` AS b ON a.`type` = b.`kode_jenis_pinjam` 
				, (SELECT @row := 0) r WHERE 1=1 
				
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`type` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`status` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
				OR DATE_FORMAT(a.`tgl_pendaftaran`, '%d %b %Y ') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`nama`',
			2 => 'a.`alamat`',
			3 => 'a.`telp`',
			4 => 'a.`type`',
			5 => 'a.`tgl_pendaftaran`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	
	
	
	
	
	
	
    function insert_simpan($kode,$jenis_simpan,$besar_simpanan, $user,$tgl)
	{
		$dt = array(
			'jenis_simpan' => $jenis_simpan,
			'besar_simpanan' => $besar_simpanan,
			'kode_anggota' => $kode,
			'tgl_entri' => $tgl,
			'id_user' => $user
		);

		return $this->db->insert('simpanan', $dt);
	}
	function tambah_anggota($nama,$alamat,$kode_anggota,$tempat_lahir,$tanggal_lahir,$golongan,$gaji,$nip,$jenis_kelamin,$no_telp,$unit_kerja,$nama_ahli_waris,$ahli_waris,$user,$tgl)
	{
		date_default_timezone_set("Asia/Jakarta");

		$dt = array(
			        'nama' 	=> $nama,
					'alamat' => $alamat,
				    'kode_anggota' 	=> $kode_anggota,
				    'tempat_lahir' 	=> $tempat_lahir,
				    'tanggal_lahir' 	=> $tanggal_lahir,
				    'golongan' 	=> $golongan,
				    'gaji' 	=> $gaji,
				    'nip' 	=> $nip,
				    'j_kelamin' => $jenis_kelamin,
				    'no_telp' 	=> $no_telp,
				    'id_unit_kerja' 	=> $unit_kerja,
				    'nama_ahli_waris' 	=> $nama_ahli_waris,
				    'ahli_waris' 	=> $ahli_waris,
				   	'status' => 'Baru',
					'tgl_pendaftaran' => $tgl,
					'id_user' 	=> $user,
				    'waktu_input' => $tgl,
				    'dihapus' => 'tidak'
		);

		return $this->db->insert('anggota', $dt);
	}






	function update_debitur($id_klien,$nama,$alamat,$telp_peminjam,$type)
	{
		$dt = array(
			          'nama' => $nama,
			          'alamat' => $alamat,
			          'telp' => $telp_peminjam,
			          'type' => $type
		);

		return $this->db
			->where('id_klien', $id_klien)
			->update('klien', $dt);
	}

	function hapus_klien($id_klien)
	{
		
		return $this->db
			->where('id_klien', $id_klien)
			->delete('klien');
	}
	
	
	function hapus_simp($kode_anggota)
	{
			return $this->db
			->where('kode_anggota', $kode_anggota)
			->delete('simpanan');
	}
	function hapus_jasa($kode_anggota)
	{
			return $this->db
			->where('kode_anggota', $kode_anggota)
			->delete('jasa');
	}
	function hapus_trans($kode_anggota)
	{
			return $this->db
			->where('kode_anggota', $kode_anggota)
			->delete('transaksi');
	}
	function hapus_tab($kode_anggota)
	{
			return $this->db
			->where('kode_anggota', $kode_anggota)
			->delete('tabungan');
	}
	function get_baris($id_klien)
	{
		return $this->db
			->select('id_klien, nama,alamat, telp,type')
			->where('id_klien', $id_klien)
			->limit(1)
			->get('klien');
	}
	function barisvc($kode_anggota)
	{
		return $this->db
			->select('id_anggota, nama,tgl_pendaftaran,status,gaji,
			 tempat_lahir,tanggal_lahir,
			 alamat, no_telp, golongan, nip,kode_anggota')
			->join('m_customer G', 'G.id_customer = O.id_customer', 'LEFT')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('anggota');
	}
	
	function baris($kode_anggota)
	{
		return $this->db
			->select('O.*,J.nama AS staff,J.id_user,H.id_unit_kerja,H.unit_kerja')
			->where('O.kode_anggota',$kode_anggota)
			->join('unit_kerja H', 'H.id_unit_kerja = O.id_unit_kerja', 'LEFT')
			->join('pj_user J', 'J.id_user = O.id_user', 'LEFT')
			->limit(1)
			->get('anggota O');
	}
	
	
	
	function get_detail_simpanan($kode_anggota)
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
				`simpanan` a 
				LEFT JOIN `anggota` AS b ON a.`kode_anggota` = b.`kode_anggota` 
				LEFT JOIN `pj_user` AS e ON a.`id_user` = e.`id_user` 
			WHERE 
				a.`kode_anggota` = '".$kode_anggota."' 
			ORDER BY 
				a.`kode_simpan` ASC 
		";

		return $this->db->query($sql);
	}
	
	
	
	
	

	
}