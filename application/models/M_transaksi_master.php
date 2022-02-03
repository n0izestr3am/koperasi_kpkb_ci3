<?php
class M_transaksi_master extends CI_Model
{
	function insert_master($tgl,$kode_anggota,$all,$user)
	{
		$dt = array(
			'kode_anggota' => $kode_anggota,
			'tanggal' => $tgl,
			'nilai' => $all,
			'keterangan' => 'Pendaftaran Anggota Baru',
			'id_user' => $user
		);

		return $this->db->insert('transaksi', $dt);
	}
	
	
		function fetch_data_pendapatan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_transaksi`, 
				a.`id_klien`, 
				a.`id_user`, 
				a.`tanggal` AS tanggal, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`nilai`, 0),',','.') ) AS nilai,
				a.`keterangan`,
				c.`nama` AS staff,
				b.`nama`,
				b.`alamat`
			FROM 
				`transaksi` AS a 
				LEFT JOIN `klien` AS b ON a.`id_klien` = b.`id_klien` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` ,
			    (SELECT @row := 0) r WHERE 1=1 
				
				
		";
		$data['totalData'] = $this->db->query($sql)->num_rows();
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`id_transaksi` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
				OR a.`id_klien` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`id_transaksi`',
			2 => 'a.`id_klien`',
			3 => 'a.`tanggal`',
			4 => 'b.`nama`',
			5 => 'a.`keterangan`'
		);
		$sql .= " GROUP BY ".$columns_order_by[$column_order]." ".$column_dir.", tanggal ";
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	

function insert_jasa($id_transaksi,$kode_anggota,$tgl,$administrasi,$dana_kecelakaan,$iuran_kematian,$kta,$user)
	{
		$dt = array(
			'id_transaksi' => $id_transaksi,
			'kode_anggota' => $kode_anggota,
			'tanggal' => $tgl,
			'administrasi' => $administrasi,
			'dana_kecelakaan' => $dana_kecelakaan,
			'iuran_kematian' => $iuran_kematian,
			'kta' => $kta,
			'keterangan' => 'Jasa Pendaftaran Anggota Baru '.$kode_anggota.'',
			'id_user' => $user
		);

		return $this->db->insert('jasa', $dt);
	}
	function get_max($kode_anggota)
	{
		return $this->db
			->select('id_transaksi')
			->where('kode_anggota', $kode_anggota)
			->limit(1)
			->get('transaksi');
	}

	



	function edit_status($id_transaksi, $status)
	{
		$dt = array(
			'status' => $status
		);

		return $this->db
			->where('id_transaksi', $id_transaksi)
			->update('transaksi_master', $dt);
	}
	
	function update_status($id_penjualan)
	{
		
$dt = array(
			'status' => 'beres'
			
		);

		return $this->db
			->where('id_transaksi', $id_penjualan)
			->update('transaksi_master', $dt);
		
	}
	
	

	function laporan_pinjaman($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`besar_pinjam`) 
					FROM 
						`pinjaman` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`pinjaman` AS a 
			WHERE 
				SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tgl_entri` ASC
		";

		return $this->db->query($sql);
	}
	
	 function laporan_tabungan($from, $to){
$query = $this->db->query("SELECT agt.nama AS nama,agt.kode_anggota AS kode_anggota, p.tgl_mulai AS tgl_mulai, p.besar_tabungan AS besar_tabungan
                                   FROM anggota agt,  tabungan p
                                   WHERE SUBSTR(p.tgl_mulai, 1, 10) >= '".$from."' 
				                   AND SUBSTR(p.tgl_mulai, 1, 10) <= '".$to."' 
                                   AND p.kode_anggota = agt.kode_anggota
                                   ");
        
        return $query;
    }
	
	
	
	function lapo_tabungan($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_mulai`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`besar_tabungan`) 
					FROM 
						`tabungan` AS b 
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
	
	
	 function ambil_laporan_simpanan($from, $to){
        $query = $this->db->query("SELECT a.nama AS nama,a.kode_anggota AS kode_anggota,
         s.wajib AS wajib,s.sukarela AS sukarela, s.juli AS juli,s.pokok AS pokok,s.tgl_entri AS tgl_entri, s.per_total AS per_total
                                   FROM (
                                        SELECT kode_anggota,tgl_entri,
                                        SUM(IF(jenis_simpan='wajib',besar_simpanan,0)) as wajib,
                                        SUM(IF(jenis_simpan='pokok',besar_simpanan,0)) as pokok,
                                        SUM(IF(jenis_simpan='sukarela',besar_simpanan,0)) as sukarela,
                                        SUM(IF(jenis_simpan='12 juli',besar_simpanan,0)) as juli,
                                        SUM(besar_simpanan) AS per_total
                                        FROM simpanan
                                        GROUP BY kode_anggota
                                    ) as s, anggota as a
								  WHERE SUBSTR(s.`tgl_entri`, 1, 10) >= '".$from."' 
				                  AND SUBSTR(s.`tgl_entri`, 1, 10) <= '".$to."' 
                                  AND s.kode_anggota = a.kode_anggota
                                  ");
        return $query;
    }
	
	
	
	
	 function ambil_laporan_pinjaman($from, $to){
$query = $this->db->query("SELECT agt.nama AS nama,agt.kode_anggota AS kode_anggota, p.tgl_entri AS tgl_entri, a.sisa_pinjam AS saldo
                                   FROM anggota agt, angsuran a, pinjaman p
                                   WHERE SUBSTR(p.tgl_entri, 1, 10) >= '".$from."' 
				                   AND SUBSTR(p.tgl_entri, 1, 10) <= '".$to."' 
                                   AND a.kode_pinjam = p.kode_pinjam
                                   AND p.kode_anggota = agt.kode_anggota
                                   ");
        
        return $query;
    }
	
	 function ambil_laporan_pinjaman_non($from, $to){
$query = $this->db->query("SELECT agt.nama AS nama,agt.id_klien AS id_klien, p.tgl_entri AS tgl_entri, p.besar_pinjam AS besar_pinjam, p.total_pinjam AS total_pinjam, a.sisa_pinjam AS saldo
                                   FROM klien agt, angsuran a, eks_pinjaman p
                                   WHERE SUBSTR(p.tgl_entri, 1, 10) >= '".$from."' 
				                   AND SUBSTR(p.tgl_entri, 1, 10) <= '".$to."' 
                                    AND p.id_klien = agt.id_klien
								   GROUP BY agt.id_klien
                                   ");
        
        return $query;
    }
	
	function laporan_pinjaman_semua_anggota($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tgl_entri,a.id_klien AS id_klien,
				(
					SELECT 
						SUM(b.`besar_pinjam`) 
					FROM 
						`eks_pinjaman` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS angsur ,a.id_klien,a.besar_pinjam,a.total_pinjam AS total_pinjam,c.nama
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS c ON a.`id_klien` = c.`id_klien` 
			WHERE 
				SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`id_klien` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		function laporan_pinjaman_non_anggota($debitur,$from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tgl_entri,a.id_klien AS id_klien,
				(
					SELECT 
						SUM(b.`besar_pinjam`) 
					FROM 
						`eks_pinjaman` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS angsur ,a.id_klien,a.besar_pinjam,a.total_pinjam AS total_pinjam,c.nama
			FROM 
				`eks_pinjaman` AS a 
				LEFT JOIN `klien` AS c ON a.`id_klien` = c.`id_klien` 
			WHERE 
				a.`id_klien` = '".$debitur."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`id_klien` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	
		function ambil_laporan_angsuran_non($debitur,$from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tgl_entri,a.sisa_pinjam AS saldo,
				(
					SELECT 
						a.`besar_angsuran`
					FROM 
						`angsuran` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS angsur ,a.id_klien,a.besar_angsuran,a.angsuran_ke,a.sisa_pinjam AS saldo,c.nama
			FROM 
				`angsuran` AS a 
				LEFT JOIN `klien` AS c ON a.`id_klien` = c.`id_klien` 
				LEFT JOIN `eks_pinjaman` AS d ON a.`id_klien` = d.`id_klien` 
			WHERE 
				a.`id_klien` = '".$debitur."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`id_klien` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	
		function ambil_laporan_angsuran_semua($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tgl_entri,a.sisa_pinjam AS saldo,
				(
					SELECT 
						a.`besar_angsuran`
					FROM 
						`angsuran` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS angsur ,a.id_klien,a.kode_angsur,a.besar_angsuran,a.angsuran_ke,a.sisa_pinjam AS saldo,c.nama
			FROM 
				`angsuran` AS a 
				LEFT JOIN `klien` AS c ON a.`id_klien` = c.`id_klien` 
				LEFT JOIN `eks_pinjaman` AS d ON a.`id_klien` = d.`id_klien` 
			WHERE 
				 SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`id_klien` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	function ambil_laporan_simpanban($bln_simpan,$thn_simpan){
        $query = $this->db->query("SELECT a.nama_anggota AS nama_anggota,
                                   s.wajib AS wajib, s.mdh AS mdh, s.per_total AS per_total
                                   FROM (
                                        SELECT id_anggota,
                                        id_transaksi,
                                        SUM(IF(jenis_simpanan='simpanan wajib',nilai,0)) as wajib,
                                        SUM(IF(jenis_simpanan='simpanan mudharabah',nilai,0)) as mdh,
                                        SUM(nilai) AS per_total
                                        FROM tbl_simpanan_rutin
                                        GROUP BY id_anggota
                                    ) as s, tbl_transaksi as t, tbl_anggota as a
                                    WHERE MONTH(t.tanggal) = $bln_simpan
                                    AND YEAR(t.tanggal) = $thn_simpan
                                    AND s.id_transaksi = t.id_transaksi
                                    AND s.id_anggota = a.id_anggota
                                  ");
        return $query;
    }
	
	function laporan_simpanan($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`besar_simpanan`) 
					FROM 
						`simpanan` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`simpanan` AS a 
			WHERE 
				SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tgl_entri` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	
	
	
	
	function laporan_angsuran_non_anggota($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tgl_entri`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`besar_angsuran`) 
					FROM 
						`angsuran` AS b 
					WHERE 
						SUBSTR(b.`tgl_entri`, 1, 10) = SUBSTR(a.`tgl_entri`, 1, 10) 
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`angsuran` AS a 
			WHERE 
				SUBSTR(a.`tgl_entri`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tgl_entri`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tgl_entri` ASC
		";

		return $this->db->query($sql);
	}
	
	
	
	
	

	function cek_nota_validasi($nota)
	{
		return $this->db->select('nomor_nota')->where('nomor_nota', $nota)->limit(1)->get('transaksi_master');
	}
}