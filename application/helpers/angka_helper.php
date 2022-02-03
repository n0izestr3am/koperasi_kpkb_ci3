<?php
defined('BASEPATH') OR exit('No direct script access allowed');


    function rp2($number)

    {

        return 'Rp '.number_format($number,2,',','.');

    }
function gbr($gambar)
	{
				    $nm=str_replace(" ","_","$gambar");
					$pisah=explode(".",$nm);
					$nama_murni_lama = preg_replace("/^(.+?);.*$/", "\\1",$pisah[0]);
					$nama_murni=strtolower($nama_murni_lama);
					$ekstensi_kotor = $pisah[1];
					$file_type = preg_replace("/^(.+?);.*$/", "\\1", $ekstensi_kotor);
					$file_type_baru = strtolower($file_type);
					$ubah=$acak.'dokumen_'.$nama_murni; //tanpa ekstensi
					$gambar = $ubah.'.'.$file_type_baru;
		return $gambar;
	}
function gender($kelamin)
{
    if ($kelamin == '1') {
        return 'Laki-laki';
    } else {
        return 'Perempuan';
    }
}

function status($status)
{
    if ($status == '11') {
        return 'PNS';
    } else {
        return 'Honerer';
    }
}

function simpn($data)
{
    if ($data == '11') {
        return 'Simpanan Pokok';
    } else if($data == '12') {
        return 'Simpanan Hari Raya';
    } else if($data == '13') {
        return 'Simpanan Sukarela';
    }
}

function simp($data)
{
    if ($data == '11') {
        return 100000;
    } else {
        return 75000;
    }
}

function pinjm($data)
{
    if ($data == '21') {
        return 'Pinjaman Umum';
    } else if($data == '22') {
        return 'Pinjaman Instidental';
    }
}

function tempo($data) {
  if($data<5000000) {
   return 20;
  } else if($data<=10000000) {
  return 30;
  } else if($data>10000000) {
  return 40;
  }
}

function pembulatan($totalharga){
 $totalharga=ceil($totalharga);
                            if (substr($totalharga,-3)>49967){
                                $total_harga=round($totalharga,-5);
                            }
                             						
							 else {
                                $total_harga=round($totalharga,-3)+1000;
                            } 
 return $totalharga;
}
 

function bulat($uang){
 $ratusan = substr($uang, -4);
 $akhir = $uang + (1000-$ratusan);
 return $akhir;
}



function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 

 
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}