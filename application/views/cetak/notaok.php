<?php

        ?>
            
            <div class="print_wrap">
           
            <div class="print_area" style="min-height: 300px;">
                <div id="print_report">
				<?php $this->load->view('cetak/styleprint'); ?>
                  
                     <div class="area" style="overflow: hidden;">
                        <h1><?php echo config_item('web_title'); ?></h1>
                        <h2>Nota Pinjaman</h2>
                        <hr style="margin-top: 10px;" />
                        <div style="margin-top: 30px; border: 1px solid black; padding: 10px;">
                           
                            <table class="tb_view">
                                <tr>
                                    <td style="width: 120px;">Nama Anggota</td>
                                    <td style="width: 10px;">:</td>
                                    <td style="font-weight: bold; width: 250px;"> <?php echo $master->nama; ?></td>
                                    <!-- side row -->
                                   <?php foreach($detail->result() as $d){?>
                                    <td>Bag Keanggotaan</td>
                                    <td>:</td>
                                    <td><label><?php echo $d->staff; ?></label></td>
									<?php } ?>
                                </tr>
                               
                                
                                <tr>
                                    <td>Nip</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;"><?php echo $master->nip; ?></td>
									<?php foreach($detail->result() as $d){?>
                                    <td>Tanggal Pinjaman</td>
                                    <td>:</td>
                                    <td><label><?php echo tanggal($d->tgl_entri); ?></label></td>
									<?php } ?>
                                </tr>
									
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;"><?php echo $master->alamat; ?></td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;"><?php echo $master->unit_kerja; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div style="margin-top: 10px;">
                            <table class="new_grid">
                                <thead>
			  <th style="background:#000000; color:#FFFFFF; width: 25px;">No</th>
              <th style="background:#000000;  color:#FFFFFF;text-align:center; width: 200px;">Besar Pinjaman</th>
              <th style="background:#000000; color:#FFFFFF; text-align:center; width: 100px;">Angsuran / Bulan</th>
              <th style="background:#000000;  color:#FFFFFF;text-align:center; width: 100px;">Bunga / Bulan</th>
              <th style="background:#000000; color:#FFFFFF; text-align:center; width: 150px;">Angsuran Pokok</th>
                                  
                                </thead>
                                <tbody>
                             <?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
	$date=date("Y-m-d");	
	$jenis=$d->kode_jenis_pinjam;
	$besar_pinjam=$d->besar_pinjam;
	$p = $this->db->query("SELECT * FROM jenis_pinjam where kode_jenis_pinjam='$jenis'");
    $d = $p->row();
	$lama_angsuran=$d->lama_angsuran;
	$bunga=$d->bunga;
	$angsuranPokok=$besar_pinjam/$lama_angsuran;
    $bung=$bunga/100;
    $bungaPerBulan=$besar_pinjam*$bung;
    $total=$angsuranPokok+$bungaPerBulan;
    $totalasli=$total*$lama_angsuran;
    $tempo=date('Y-m-d',strtotime('+30 day',strtotime($date)));
		echo "
			<tr >
				
				<td>".$no."</td>
				<td>Rp.".Rp($besar_pinjam)."</td>
				<td>Rp.".Rp($total)." / ".$lama_angsuran." Bulan </td>
				<td>Rp.".Rp($bungaPerBulan)."</td>
				<td>Rp.".Rp($angsuranPokok)." </td>
				
			</tr>";

		$no++;
	}
?>
                                         
                                     
                            </tbody>
                            </table>
                        </div>
                        <div style="width: 400px; margin-top: 10px; float: right;">
                            <table class="new_grid">
                                
                                <tbody>
                                   <tr>
      <td colspan="2" style="background:#000000;  color:#FFFFFF; text-align: center;"><label class="label_summary">Pokok Pinjaman </label></td>
                                        <td style="text-align: right;">
                                            <label class="label_summary"><?php echo "Rp. ".Rp($besar_pinjam)."" ?></label>
                                        </td>
                                    </tr>
                                    <tr>
<td colspan="2" style="background:#000000;  color:#FFFFFF; text-align: center;"><label class="label_summary">Total pinjaman / Bunga</label></td>
                                        <td style="text-align: right;">
                                            <label class="label_summary"><?php echo "Rp. ".Rp($totalasli)."" ?></label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                     <div class="area">
                </div>
            </div>
            </div>
	
        <?php
   
?>
