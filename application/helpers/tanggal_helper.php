<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tanggal'))
{
function tanggal($var = '')
{
if ($var == '0000-00-00' or $var == '' ) {
return '0';    
 } else {
$tgl = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$tgl2 = array("1","2","3","4","5","6","7","8","9","10","11","12");
$pecah = explode("-", $var);
return $pecah[2]." ".$tgl[$pecah[1] - 1]." ".$pecah[0];
 }	
	

}
}

if ( ! function_exists('event'))
{
function event($var = '')
{
$tgl = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$tgl2 = array("1","2","3","4","5","6","7","8","9","10","11","12");
$pecah = explode("-", $var);
return $pecah[1];
}
}


if ( ! function_exists('sbulan'))
{
	function sbulan($sbulan)
	{
switch($sbulan){
case "01" : $sbulan = "Jan"; break;
case "02" : $sbulan = "Feb"; break;
case "03" : $sbulan = "Mar"; break;
case "04" : $sbulan = "Apr"; break;
case "05" : $sbulan = "Mei"; break;
case "06" : $sbulan = "Jun"; break;
case "07" : $sbulan = "Jul"; break;
case "08" : $sbulan = "Agust"; break;
case "09" : $sbulan = "Sept"; break;
case "10" : $sbulan = "Oktr"; break;
case "11" : $sbulan = "Nov"; break;
case "12" : $sbulan = "Des"; break;
case "" : $sbulan = ""; break;
}
		return $sbulan;
	}
}










if ( ! function_exists('bulanan'))
{
	function bulanan($bulanan)
	{
switch($bulanan){
case "01" : $bulanan = "Januari"; break;
case "02" : $bulanan = "Februari"; break;
case "03" : $bulanan = "Maret"; break;
case "04" : $bulanan = "April"; break;
case "05" : $bulanan = "Mei"; break;
case "06" : $bulanan = "Juni"; break;
case "07" : $bulanan = "Juli"; break;
case "08" : $bulanan = "Agustus"; break;
case "09" : $bulanan = "September"; break;
case "10" : $bulanan = "Oktober"; break;
case "11" : $bulanan = "November"; break;
case "12" : $bulanan = "Desember"; break;
case "" : $bulanan = ""; break;
}
		return $bulanan;
	}
}


if ( ! function_exists('ago'))
{
function ago($time) {
	$diff = time() - (int)$time;

	if ($diff == 0) {
		return 'Just now';
	}

	$intervals = array(
		1 => array('year', 31556926),
		$diff < 31556926 => array('month', 2628000),
		$diff < 2629744 => array('week', 604800),
		$diff < 604800 => array('day', 86400),
		$diff < 86400 => array('hour', 3600),
		$diff < 3600 => array('minute', 60),
		$diff < 60 => array('second', 1)
	);

	$value = floor($diff/$intervals[1][1]);
	$ago = $value.' '.$intervals[1][0].($value > 1 ? 's' : '');

	$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

	$day = $days[date('w', $time)];

	if ($ago == '1 day') {
		return 'Yesterday at '.date('H:i', $time);
	}
	elseif ($ago == '2 days' || $ago == '3 days' || $ago == '4 days' || $ago == '5 days' || $ago == '6 days' || $ago == '7 days') {
		return $day.' at '.date('H:i', $time);
	}
	elseif ($value <= 59 && $intervals[1][0] == 'second' ||  $intervals[1][0] == 'minute' ||  $intervals[1][0] == 'hour') {
		return $ago.' ago';
	}
	else {
		return date('M', $time).' '.date('d', $time).', '.date('Y', $time).' at '.date('H:i', $time);
	}
}

}




if ( ! function_exists('blnevent'))
{
function blnevent($var = '')
{
$tgl = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sept","Okt","Nov","Des");
$tgl2 = array("1","2","3","4","5","6","7","8","9","10","11","12");
$pecah = explode("-", $var);
return $tgl[$pecah[1] - 1];
}
}
if ( ! function_exists('tanggal2'))
{
function tanggal2($var = '')
{

$tgl = array("1","2","3","4","5","6","7","8","9","10","11","12");
$pecah = explode("-", $var);
return $pecah[2]."/".$tgl[$pecah[1] - 1]."/".$pecah[0];
}
}



if ( ! function_exists('tanggal_indo'))
{
function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}


}












if ( ! function_exists('timeAgo'))

{
function xTimeAgo ($oldTime, $newTime, $timeType) {
        $timeCalc = strtotime($newTime) - strtotime($oldTime);        
        if ($timeType == "x") {
            if ($timeCalc = 60) {
                $timeType = "m";
            }
            if ($timeCalc = (60*60)) {
                $timeType = "h";
            }
            if ($timeCalc = (60*60*24)) {
                $timeType = "d";
            }
        }        
        if ($timeType == "s") {
            $timeCalc .= " detik lalu";
        }
        if ($timeType == "m") {
            $timeCalc = round($timeCalc/60) . " menit lalu";
        }   
if ($timeType == "d") {
            $timeCalc = round($timeCalc/60/60/24) . " hari lalu";
        }   		
        if ($timeType == "h") {
            $timeCalc = round($timeCalc/60/60) . " jam lalu";
        }
             
        return $timeCalc;
    }
	
function timeAgo($timestamp){
	date_default_timezone_set('Asia/Jakarta');
	$skrg=date("Y-m-d H:i:s");
	$isi= str_replace("-","",xTimeAgo($skrg,$timestamp,"m"));
	$isi2= str_replace("-","",xTimeAgo($skrg,$timestamp,"h"));
	$isi3= str_replace("-","",xTimeAgo($skrg,$timestamp,"d"));
	$go="";
	if($isi > 60)
	{
		$go=$isi2;
	}
elseif($isi2 > 24)
	{
		$go=$isi3;
	}elseif($isi < 61)
	{
		$go=$isi;
	}
	return $go;
}
}

if ( ! function_exists('time_elapsed_string'))
{
function time_elapsed_string($datetime, $full = false) {
     date_default_timezone_set('Asia/Jakarta');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',       
         'w' => 'minggu',       
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' lalu' : 'just now';

}
}


if ( ! function_exists('jam'))
{
function jam($datetime, $full = false) {
		$today = time();    
                 $createdday= strtotime($datetime); 
                 $datediff = abs($today - $createdday);  
                 $difftext="";  
                 $hours= floor($datediff/3600);  
                 $hari= floor($datediff/24);  
                 $minutes= floor($datediff/60);  
                 $seconds= floor($datediff);  
                 //year checker  
                /*  array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'minute'), */
                 //hour checker  
                 if($difftext=="")  
                 {  
                    if($hari>1)  
                    $difftext=$hari." hari";  
                    elseif($hari==1)  
                    $difftext=$hari." hari"; 
                   				
                 }  
                if($difftext=="")  
                 {  
                    if($hours>1)  
                    $difftext=$hours." Jam";  
                    elseif($hours==1)  
                    $difftext=$hours." Jam"; 
                   				
                 }  
                 //minutes checker  
                 if($difftext=="")  
                 {  
                    if($minutes>1)  
                    $difftext=$minutes." Menit";  
                    elseif($minutes==1)  
                    $difftext=$minutes." Menit";  
                 }  
                 //seconds checker  
                 if($difftext=="")  
                 {  
                    if($seconds>1)  
                    $difftext=$seconds." Detik";  
                    elseif($seconds==1)  
                    $difftext=$seconds." Detik";  
                 }  
                 return $difftext;  
	}
}



if ( ! function_exists('nama_hari'))
{
	function hari($namaHari)
	{
		$ubah = gmdate($namaHari, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$nama = date("l", mktime(0));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}

if(!function_exists('facebook_like')){
 function facebook_like($url){
   $formlink  = '<iframe src="http://www.facebook.com/plugins/like.php?href=';
   $formlink .= urlencode($url);
   $formlink .= ';layout=button_count&show_faces=true&width=450&';
   $formlink .= 'action=like&colorscheme=light&height=21" scrolling="no"';
   $formlink .= 'frameborder="0" style="border:none; overflow:hidden;';
   $formlink .= 'width:450px;height:21px;" allowTransparency="true"></iframe>';               
   return $formlink;
  }



 if(!function_exists('getRelativeTime')){
 function plural($num) {
    if ($num != 1)
        return "";
}

function getRelativeTime($date) {
 date_default_timezone_set('Asia/Jakarta');
    $diff = time() - strtotime($date);
	
    if ($diff<60)
        return $diff . " detik" . plural($diff) . " lalu";
    $diff = round($diff/60);
    if ($diff<60)
        return $diff . " menit" . plural($diff) . " lalu";
    $diff = round($diff/60);
    if ($diff<24)
        return $diff . " jam" . plural($diff) . " lalu";
    $diff = round($diff/24);
    if ($diff<7)
        return $diff . " hari" . plural($diff) . " lalu";
    $diff = round($diff/7);
    if ($diff<4)
        return $diff . " minggu" . plural($diff) . " lalu";
 $tgl = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$tgl2 = array("1","2","3","4","5","6","7","8","9","10","11","12");
$pecah = explode("-", $date);
return $pecah[1]." ".$tgl[$pecah[1] - 1]." ".$pecah[0];
}

  }
  
  
  
  
    
  if ( ! function_exists('date_dropdown'))
{
	function date_dropdown(){
	
       $html_output = '    <p class=inline-small-label>'."\n";
        $html_output .= '       <label for=field4>Tgl</label>'."\n";
       
        /*days*/
        $html_output .= '           <select name="date_day" id="day_select">'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option>' . $day . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";
   	
		
		/*months*/
        /*months*/
        $html_output .= '           <select name="date_month" id="month_select" >'."\n";
		$hari=date("m");
        $months = array("$hari", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
                $html_output .= '               <option value="' . $month . '">' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";
		 
		 
		 /*days*/
        $html_output .= '<select name="year" id="year">'."\n";
           for ($i = $this_year; $i <= $this_year+10; $i++) {
			 $this_year = date("Y");
					 if ($i == $year)   $html_output .= '<option value="'.$i.'">' . $i . '</option>'."\n";
	else   $html_output .= '<option value="'.$i.'">' . $i . '</option>'."\n";
			 
                        }
        $html_output .= ' /select>'."\n";
		 
		 
		 
		 
		/*years*/
        $html_output .= '<select name="jam" id="year_select">'."\n";
	  $t = date("H:i:s");
   $html_output .= ' <option value="'.$t.'">' . $t . '</option>
   <option value="00:00:00">00:00</option>      
        <option value="00:30:00">00:30</option>      
        <option value="01:00:00">01:00</option>     
        <option value="01:30:00">01:30</option>      
        <option value="02:00:00">02:00</option>      
        <option value="02:30:00">02:30</option>      
        <option value="03:00:00">03:00</option>      
        <option value="03:30:00">03:30</option>      
        <option value="04:00:00">04:00</option>      
        <option value="04:30:00">04:30</option>      
        <option value="05:00:00">05:00</option>      
        <option value="05:30:00">05:30</option>      
        <option value="06:00:00">06:00</option>      
        <option value="06:30:00">06:30</option>     
        <option value="07:00:00">07:00</option>      
        <option value="07:30:00">07:30</option>      
        <option value="08:00:00">08:00</option>      
        <option value="08:30:00">08:30</option>      
        <option value="09:00:00">09:00</option>      
        <option value="09:30:00">09:30</option>      
        <option value="10:00:00">10:00</option>      
        <option value="10:30:00">10:30</option>      
        <option value="11:00:00">11:00</option>      
        <option value="11:30:00">11:30</option>      
        <option value="12:00:00">12:00</option>      
        <option value="12:30:00">12:30</option>      
        <option value="13:00:00">13:00</option>      
        <option value="13:30:00">13:30</option>      
        <option value="14:00:00">14:00</option>      
        <option value="14:30:00">14:30</option>      
        <option value="15:00:00">15:00</option>      
        <option value="15:30:00">15:30</option>      
        <option value="16:00:00">16:00</option>      
        <option value="16:30:00">16:30</option>      
        <option value="17:00:00">17:00</option>      
        <option value="17:30:00">17:30</option>      
        <option value="18:00:00">18:00</option>      
        <option value="18:30:00">18:30</option>      
        <option value="19:00:00">19:00</option>      
        <option value="19:30:00">19:30</option>      
        <option value="20:00:00">20:00</option>      
        <option value="20:30:00">20:30</option>      
        <option value="21:00:00">21:00</option>      
        <option value="21:30:00">21:30</option>      
        <option value="22:00:00">22:00</option>      
        <option value="22:30:00">22:30</option>      
        <option value="23:00:00">23:00</option>      
        <option value="23:30:00">23:30</option>
   
   '."\n";
  

 $html_output .= '           </select>'."\n";
 $html_output .= '           </p>'."\n";
		
      
		
		
    return $html_output;
}
}
  
  
 function tanggal_jam($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}
  
  
  
  
  
  
  
  
  
 }