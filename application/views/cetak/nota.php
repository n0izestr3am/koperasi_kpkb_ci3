<?php

?>
<title>Nota</title>
<link href="<?php echo config_item('css'); ?>print.css" rel="stylesheet">
<script type="text/javascript">
//window.onunload = refreshParent;
//function refreshParent() {
//    window.opener.location.reload();
//}
function cetak() {  		
    window.print();
    setTimeout(function(){ window.close();},300);
}
</script>
<body onload="cetak();">
<div class="layout-print-struk">
    <table style="border-bottom: 1px solid #000;" width="100%">
        <tr><td align="center" style="text-transform: uppercase; font-size: 12px;"><?php echo "".$master->nama."";?></td> </tr>
        <tr><td align="center" style="font-size: 12px;">alamat</td> </tr>
        <tr><td align="center" style="font-size: 12px;">Telp. </td> </tr>
    </table>
    <table width="100%" style="border-bottom: 1px solid #000;">
        <tr><td width="40%">Nomor:0000</td></tr>
      
        <tr><td>No. Resep:</td><td>sx</td></tr>
      
        <tr><td>Tanggal:</td><td>3434</td></tr>
        <tr><td>Pelanggan:</td><td style="white-space: nowrap">sdsds</td></tr>
    </table>
    <table width="100%" style="border-bottom: 1px solid #000;">
        <tr>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php 
       
            ?>
        <tr>
            <td>1</td>
            <td align="center">sds</td>
            <td align="right">sdsd</td>
            <td align="right">dsd</td>
        </tr>
        <?php  ?>
    </table>
    <?php
    
    ?>
    <table width="100%">
        <tr><td>Subtotal:</td><td align="right">wewe</td></tr>
        <tr><td>Diskon:</td><td align="right">ewewe</td></tr>
        <tr><td>PPN <?= $rows->ppn ?> %:</td><td align="right">ewewe</td></tr>
               <tr><td>Pembayaran:</td><td align="right">ewewew</td></tr>
        <tr><td>Kembalian:</td><td align="right">ewewe</td></tr>
    </table>
    <br/>
    <center style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
        TERIMA KASIH, SEMOGA LEKAS SEMBUH
    </center>
</div>
</body>