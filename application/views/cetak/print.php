<?php

        ?>
            <script>
                function PrintDetailReservasi()
                {
                    $("#print_report").printThis({
                        importCSS: true,
                        pageTitle: "Top 10 Organizer Kunjungan",
                    });
                }
            </script>
            <div class="print_wrap">
            <div style="margin-bottom: 5px; text-align: right;">
                <a href="javascript:void(0)" onclick="PrintDetailReservasi()"><img src="../images/printer.png" /></a>
            </div>
            <div class="print_area" style="min-height: 300px;">
                <div id="print_report">
				<?php $this->load->view('cetak/styleprint'); ?>
                  
                     <div class="area" style="overflow: hidden;">
                        <h1>SOKA INDAH RESTAURANT</h1>
                        <h2>DETAIL RESERVASI</h2>
                        <hr style="margin-top: 10px;" />
                        <div style="margin-top: 30px; border: 1px solid black; padding: 10px;">
                            fhfhfh
                            <table class="tb_view">
                                <tr>
                                    <td style="width: 120px;">Organizer/Travel</td>
                                    <td style="width: 10px;">:</td>
                                    <td style="font-weight: bold; width: 250px;">dddd</td>
                                    <!-- side row -->
                                    <td style="width: 120px;" >Jumlah Peserta</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;">4343</td>
                                </tr>
                               
                                
                                <tr>
                                    <td>Tanggal Reservasi</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;">dfdf</td>
                                    <td>Notes</td>
                                    <td>:</td>
                                    <td><label>fdfdf</label></td>
                                </tr>
                                <tr>
                                    <td>Jam</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;">fdfdfd</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <td style="font-weight: bold;">dfdfd</td>
                                </tr>
                            </table>
                        </div>
                        <div style="margin-top: 10px;">
                            <table class="new_grid">
                                <thead>
                                    <th style="width: 25px;">No</th>
                                    <th style="text-align:center; width: 200px;">Menu Makanan</th>
                                    <th style="text-align:center; width: 100px;">Harga (Rp.)</th>
                                    <th style="text-align:center; width: 80px;">Jml. Item</th>
                                    <th style="text-align:center; width: 100px;">Sub Total (Rp.)</th>
                                    <th style="text-align:center; width: 200px;">Notes</th>
                                </thead>
                                <tbody>
                             
                                            <tr>
                                                <td>1</td>
                                                <td>2</td>
                                                <td style="text-align: right;">43434</td>
                                                <td style="text-align: center;">2</td>
                                                <td style="text-align: right;">242424</td>
                                                <td style="text-align: left;">note</td>
                                            </tr>
                                     
                            </tbody>
                            </table>
                        </div>
                        <div style="width: 400px; margin-top: 10px; float: right;">
                            <table class="new_grid">
                                <thead>
                                    <tr>
                                        <th style="width: 70px; text-align: center;">Total Item</th>
                                        <th style="width: 110px; text-align: center;">Total (gross)</th>
                                        <th style="width: 110px; text-align: center;">Discount</th>
                                        <th style="width: 110px; text-align: center;">Total (net)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; vertical-align: top;"><label class="label_summary"><?php echo $TotalItem; ?></label></td>
                                        <td style="text-align: right; vertical-align: top;"><label class="label_summary">harga</label></td>
                                        <td style="text-align: center; vertical-align: top;"><label class="label_summary">harga2</label></td>
                                        <td style="text-align: right; vertical-align: top;">
                                            <label class="label_summary">
                                           dfdfdf
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: center;"><label class="label_summary">TOTAL</label></td>
                                        <td style="text-align: right;">
                                            <label class="label_summary">dfdfd</label>
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