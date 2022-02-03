<?php
// membaca data dari form
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
// memanggil dan membaca template dokumen yang telah kita buat
$document = file_get_contents("laporan.rtf");
// isi dokumen dinyatakan dalam bentuk string
$document = str_replace("#NAMA", $nama, $document);
$document = str_replace("#KELAS", $kelas, $document);
// header untuk membuka file output RTF dengan MS. Word
header("Content-type: application/msword");
header("Content-disposition: inline; filename=laporan.doc");
header("Content-length: ".strlen($document));
echo $document;
?>