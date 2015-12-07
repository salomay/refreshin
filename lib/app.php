<?php
class app {

	/***************************************************************************
	* Description : load lib
	***************************************************************************/
	function load_lib()
	{
		global $app;
		$numargs = func_num_args();
		$args = func_get_args();
		for ($i = 0; $i < $numargs; $i++) {
			$libfile = "$args[$i].php";
			include_once "$app[path]/lib/$libfile";
		}
	} 

	/***************************************************************************
	* Description : strtoupper
	***************************************************************************/
	function strtoupper($param)
	{
		$param = @explode(',', $param);
		while (list(, $var) = @each($param)){
			$cmd = "global \$$var;";
			eval($cmd);
			$cmd = "\$$var = trim(strtoupper(\$$var));";
			eval($cmd);
		}
	}

	/***************************************************************************
	* Description : set null value
	***************************************************************************/
	function set_null($param){
		$param = @explode(',', $param);
		while (list(, $var) = @each($param)){
			$cmd = "global \$$var;";
			eval($cmd);
			$cmd = "\$testvar = trim(\$$var);";
			eval($cmd);
			if (strlen($testvar) == 0){
				$cmd = "\$$var = 'NULL';";
				eval($cmd);
			}
		}
	}

	/***************************************************************************
	* Description : serialize64
	***************************************************************************/
	function serialize64($var) 
	{
		return base64_encode(serialize($var));
	}

	/***************************************************************************
	* Description : unserialize64
	***************************************************************************/
	function unserialize64($var) 
	{
		return unserialize(base64_decode($var));
	}

	/***************************************************************************
	* Description : generate uid
	***************************************************************************/
	function generate_unique_id($table_name, $field_name, $length) 
	{
        $dbu = new db();
		$str = " ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$lstr = 36;
		$luid = $length;
		while (TRUE){
			$id = "";
			for ($i = 0; $i < $luid; $i++){
				srand((double)microtime()*100000);
				$index = rand(1,$lstr);      
				$id .= $str[$index];
			}
			if (!$dbu->lookup($field_name, $table_name, $field_name, $id)){
				break;
			}
		}
		return $id;
	}

	/***************************************************************************
	* Description : mysql date convert
	***************************************************************************/
	function to_mysql_date($date) 
	{
		$d = explode('-', $date);
		return "$d[2]-$d[1]-$d[0]";
	}

	/***************************************************************************
	* Description : string helpers
	***************************************************************************/
	function set_default(&$var, $default = '')
	{
		if (!isset($var) || $var == ''){
			$var = $default;
		}
		//echo $var;
	}
	
	function nvl(&$var, $default = '')
	{
		return isset($var) ? $var : $default;
	}

	function ov(&$var) {
		return isset($var) ? htmlspecialchars(stripslashes($var)) : "";
	}

	function pv(&$var) {
		echo isset($var) ? htmlspecialchars(stripslashes($var)) : "";
	}

	function o($var) {
		return empty($var) ? "" : htmlspecialchars(stripslashes($var));
	}

	function p($var) {
		echo empty($var) ? "" : htmlspecialchars(stripslashes($var));
	}

	/***************************************************************************
	* Description : for debugging
	***************************************************************************/
	function debug($var, $exit = 0)
	{
		global $app;
		if ($app[debug]){
			echo "<pre>";
			print_r($var);
			echo "</pre>";
		}
		if ($exit){
			exit;
		}
	}

	/***************************************************************************
	* Description : set navigation bar
	***************************************************************************/
	function set_navigator(&$sql, &$nav, $pagesize, $param, $attr='', $attrPls='')
	{
	   $dbu = new db();
		if ($_GET['page_offset']){
			$pageoffset = $_GET['page_offset'];
		}else{
			$pageoffset = 0;
		}
        
		if ($_GET[page_total]){
			$pagetotal = $_GET['page_total'];
		}else{
			$dbu -> query($sql, $rs, $nr);
			$pagetotal = $nr;
		}
		$cari_limit = preg_match_all('|limit (.*)|sm',$sql,$hasil);
		if ($hasil[1][0]){
			$sql = str_replace("".$hasil[0][0]."","",$sql);
		}
		if ($pageoffset+$pagesize>$pagetotal){			
            $nilai = $pagetotal-$pageoffset;
			$sql = $sql . " limit $pageoffset, $nilai";
		}else{
			$sql = $sql . " limit $pageoffset, $pagesize";
		}
		
		$nav = new nav;
		$nav -> init($pageoffset, $pagetotal, $param, $attr, $attrPls);
		$nav -> param = $param;
		$nav -> build($pagesize);
	}

	/***************************************************************************
	* Description : alphabet bar
	***************************************************************************/
	function alphabar($digit, $url, $key_var)
	{
		global $app;
		$url .= "&page.size=$_GET[page_size]";
		$cmd = "global \$$key_var;";
		eval($cmd);
		$cmd = "\$selkey = \$$key_var;";
		eval($cmd);
		$alpha = ($digit == "yes") ? "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" : "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$l_alpha = strlen($alpha);
		$letter_found = FALSE;
		while($i<$l_alpha){
			if ($selkey == $alpha[$i]){
				$out .=  "<b>$alpha[$i]</b> ";
				$letter_found = TRUE;
			}else{
				$out .=  "<a href='$url&$key_var=$alpha[$i]' class='alphabar'>$alpha[$i]</a> ";
			}
			$i++;
		}
		if ($letter_found){
			$out .=  "<a href='$url&$key_var=' class='alphabar'>".$app['lang']['txt']['all']."</a> ";
		}else{
			$out .=  "<b>".$app['lang']['txt']['all']."</b> ";
		}
		return "<table><tr><td>$out</td></tr></table>";
	}

	/***************************************************************************
	* Description : helper function for delimited data
	* Notes : -
	***************************************************************************/
	function array_delimiter($op, $delimiter, $item, $data = '')
	{
		if ($op == 'add'){
			if (!is_array($item)){
				if (!trim($data)):
					return $delimiter . $item . $delimiter;
				else:
					if (ereg($delimiter . $item . $delimiter, $data)) return $data;
					return $data . $item . $delimiter;
				endif;
			}else{
				return $delimiter . @implode($delimiter, $item) . $delimiter;
			}
		}
		if ($op == 'del'){
			$tmp = str_replace($item.$delimiter, '', $data);
			if (trim($tmp) == $delimiter){
				return '';
			}else{
				return $tmp;
			}
		}
		if ($op == 'get'){
			$tmp1 = explode("$delimiter", $data);
			while (list(, $v) = each($tmp1)){
				if (!empty($v)){
					$tmp2[] = $v;
				}
			}
			return $tmp2;
		}
	}

	/***************************************************************************
	* Description : trim an array (remove empty)
	***************************************************************************/
	function trim_array(&$param)
	{
		while (list($k, $v) = @each($param)){
			if (!trim($v)){
				unset($param[$k]);
			}
		}
		reset($param);
	}

	/***************************************************************************
	* Description : check IE 
	***************************************************************************/
    function is_ie()
    {
		global	$HTTP_USER_AGENT;
    	if (eregi("MSIE", $HTTP_USER_AGENT)){
            return true;
        }else{
        	return false;
        }
    }

	/***************************************************************************
	* Description : date convert
	***************************************************************************/
	function format_date_base($date) 
	{
		$d = explode('-', $date);
		return "$d[2]/$d[1]/$d[0]";
	}
	
		
    /***************************************************************************
    * Description : format date
    * Parameters : $date (YYYY-MM-DD)
	*			   $country : eng, ina
	*			   $format : use built in PHP date format
	*			   $long : Y, N (long format)
    ***************************************************************************/
    function format_date($date, $country, $long = 'N')
    {
        if ($long == 'N'):
			$format = "l, F d Y";
		elseif ($long == 'A'):
			$format = "d/F/Y";
		elseif ($long == 'B'):
			$format = "F, d Y";
		else:
			$format = "l, d F Y";
		endif;
		$out = date($format, strtotime($date));
		if ($country == 'id'){
			$eng = array("/January/", "/February/", "/March/", "/April/", "/May/", "/June/", "/July/", "/August/", "/September/", "/October/", "/November/", "/December/");
        	$ina = array("Januari", "Pebruari", "Maret", "April", "Mei","Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
			$out = preg_replace($eng, $ina, $out);
			if ($long !='A' && $long!='B'){
				$eng = array("/Monday/", "/Tuesday/", "/Wednesday/", "/Thursday/", "/Friday/", "/Saturday/", "/Sunday/");
				$ina = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at","Sabtu", "Minggu");
				$out = preg_replace($eng, $ina, $out);
			}
		}
		return $out;
    }	
    /***************************************************************************
    * Description : format datetime
    * Parameters : $date (YYYY-MM-DD HH:MM:SS)
	*			   $country : eng, ina
	*			   $format : use built in PHP date format
	*			   $long : Y, N (long format)
    ***************************************************************************/
    function format_datetime($date, $country, $long = 'N')
    {
        if ($long == 'N'):
			$format = "F d, Y H:i:s";
		elseif ($long == 'NN'):
			$format = "l, d F Y";
		elseif ($long == 'NN_1'):
			$format = "d/m/Y";
		else:
			$format = "l, d F Y H:i:s";
		endif;
		
		$out = date($format, strtotime($date));
		if ($country == 'id'){
			$eng = array("/January/", "/February/", "/March/", "/April/", "/May/", "/June/", "/July/", "/August/", "/September/", "/October/", "/November/", "/December/");
        	$ina = array("Januari", "Pebruari", "Maret", "April", "Mei","Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
			$out = preg_replace($eng, $ina, $out);
			if ($long !='A' && $long!='B'){
				$eng = array("/Monday/", "/Tuesday/", "/Wednesday/", "/Thursday/", "/Friday/", "/Saturday/", "/Sunday/");
				$ina = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at","Sabtu", "Minggu");
				$out = preg_replace($eng, $ina, $out);
			}
		}
		return $out;
    }

    /***************************************************************************
    * Description : partstr
    * Parameters : $str : string
	*			   $length : length
    ***************************************************************************/
    function partstr($str, $length) 
	{
		return (strlen($str)>$length) ? substr($str, 0, $length)."..." : $str;
	}

    /***************************************************************************
    * Description : mq_encode
    * Parameters : $param : var
    ***************************************************************************/
    function mq_encode($param) 
	{
		if (!get_magic_quotes_gpc()):
			$fields = "\$".str_replace(",", ",\$", $param);
			eval("global $fields;");
			$arr = explode(",", $fields);
            while (list($k, $v) = each($arr)):
                eval("$v = addslashes($v);");
            endwhile;
		endif;
	}
	
	/**
	 * @param int $pass_len The length of the password
	 * @param bool $pass_num Include numeric chars in the password?
	 * @param bool $pass_alpha Include alpha chars in the password?
	 * @param bool $pass_mc Include mixed case chars in the password?
	 * @param string $pass_exclude Chars to exclude from the password
	 * @return string The password
	 */
	 
	function make_uniqid($pass_len = 16, $pass_num = true, $pass_alpha = true, $pass_mc = true, $pass_exclude = '')
	{
	    // Create the salt used to generate the password
	    $salt = '';
	    if ($pass_alpha) { // a-z
	        $salt .= 'abcdefghijklmnopqrstuvwxyz';
	        if ($pass_mc) { // A-Z
	            $salt .= strtoupper($salt);
	        }
	    }
	
	    if ($pass_num) { // 0-9
	        $salt .= '0123456789';
	    }
	
	    // Remove any excluded chars from salt
	    if ($pass_exclude) {
	        $exclude = array_unique(preg_split('//', $pass_exclude));
	        $salt = str_replace($exclude, '', $salt);
	    }
	    $salt_len = strlen($salt);
	
	    // Seed the random number generator with today's seed & password's unique settings for extra randomness
	    mt_srand ((int) date('y')*date('z')+date('His')*($salt_len+$pass_len));
	
	    // Generate today's random password
	    $pass = '';
	    for ($i=0; $i<$pass_len; $i++) {
	        $pass .= substr($salt, mt_rand() % $salt_len, 1);
	    }
	
	    return $pass;
	}
	
	/***************************************************************************
	* Description : format harga
	***************************************************************************/
	function tulis_harga($harga) 
	{
		global $app;
		$dollar = db::lookup("nilai","preference","nama='dollar'");
		$min = db::lookup("nilai","preference","nama='minimal'");
		if ($harga>$min){
			$hasil = "Rp. ".number_format($harga, 2, ',', '.');
		}else{
			$hasil = "Rp. ".number_format(($harga*$dollar), 2, ',', '.');
		}		
		return $hasil;
	}
	
	/***************************************************************************
	* Description : get_lead
	***************************************************************************/
	function get_leads($no, $kalimat) 
	{
		//$imp_kal = implode(" ", $kalimat);
		$exp_kal = explode(" ", $kalimat);
		$hasil = "";
		for($a=0; $a<$no; $a++){
			$hasil = $hasil.$exp_kal[$a]." ";
		}
		return $hasil;
	}
	
	/***************************************************************************
	* Description : display popup calendar
	***************************************************************************/
	function display_popup_calendar()
	{
	    global $app;
	    $rs['cal'] = db::get_recordset("cost_center","0=0 and region_id = '$user[region_id]'");
	    $quarter = libadm::get_quarter(date("F"));
	    $year = date("Y");
	    $budget_region = db::lookup("id", "budget", "region_id = '$user[region_id]' and quarter = '$quarter' and year = '$year'");
		include "$app[path]/blk_left_budget.php";
	}	
	
	/***************************************************************************
	* Description : generate password
	***************************************************************************/
	function randomNumber ($length){
		$password = "";
  		$possible = "0123456789bcdfghjkmnpqrstvwxyz";     
  		$i = 0;   
  		while ($i < $length) { 
   			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    		if (!strstr($password, $char)) { 
      			$password .= $char;
      			$i++;
    		}
  		}
 		return $password;
	}	
	function content($id, $act, $lang, $pageid){
		global $app;
		stats::log_stats($pageid, $act);
		$app[bahasa] = $lang;
		$halaman = db::get_record("page", "page = '$id' and published_page = 'active'");
		return $halaman;
	}
	function set_lang($model = ''){
		global $app;
	    if (!$model):
			$config = db::get_record("configuration", "id", 1);	    
			$bahasa = $config[default_lang];
		else:
			if ( $model == "eng" ):
				$bahasa = "ina";
			elseif ( $model == "ina" ):
				$bahasa = "eng";
			endif;
			//$app[bahasa] = $model;
		endif;	
		return $bahasa;
	}
	function set_bahasa($bhs) {
		global $app;
		$app[bahasa] = $bhs;	    
	}
	function set_pageid($pageno, $lang) {
		global $app;	    
		if ($lang == "eng"):
			$pageid = "E_".$pageno;
		elseif($lang == "ina"):
			$pageid = "I_".$pageno;
		endif;	
		return $pageid;
	}
	/***************************************************************************
	* Description : pos_char
	***************************************************************************/
	function pos_char($kata, $kalimat){
		$exp_kal = explode(" ", $kalimat);
		$end = count($exp_kal);
		//$imp_kal = implode(" ", $kalimat);
		$hasil[0] = 0;
		$b=0;
		for($a=0; $a<$end; $a++){
			if(eregi($kata,$exp_kal[$a])):
				$hasil[$b] = $a;
				$b++;
			endif;
		};
		return $hasil[0];
	}
	/***************************************************************************
	* Description : get_lead
	***************************************************************************/
	function get_lead($no, $kalimat, $start=0){
		$exp_kal = explode(" ", $kalimat);
		if($start>0):
		$end = $no+$start;
		else:
		$end = $no;
		endif;
		//$imp_kal = implode(" ", $kalimat);
		$hasil = "";
		for($a=$start; $a<$end; $a++){
			$hasil = $hasil.$exp_kal[$a]." ";
		}
		$hasil = strip_tags($hasil);
		return $hasil;
	}
	function xSet_lead($lead,$jml){
		if(preg_match('/\< *[img][^\>]*[src]*[alt]*[title] *= *[\"\']{0,1}([^\"\']*)/i', $lead, $matches)){
			$replace_lead = str_replace($matches[0],"",$lead);
			$lead = ereg_replace("' />","",$replace_lead);
			$lead = ereg_replace('" />',"",$replace_lead);

		}
		$replace_lead=str_replace(" ","^",$lead);
		$exp_lead=explode("^",$replace_lead);
		for($i=0;$i<$jml+1;$i++):
			$read_lead.=$exp_lead[$i]." \n";
		endfor;
		return $read_lead;
	}
	/***************************************************************************
	* Description : replace_char
	***************************************************************************/
	function tag_on_char($kata, $kalimat, $str_tag, $end_tag){
		$kalimat = strip_tags($kalimat);
		$exp_kal = explode(" ", $kalimat);
		$end = count($exp_kal);
		//$imp_kal = implode(" ", $kalimat);
		$hasil = "";
		for($a=0; $a<$end; $a++){
			if(eregi($kata,$exp_kal[$a])):
				$all_big = strtoupper($kata);
				$big_small = ucwords($kata);
				$all_small = strtolower($kata);
				$char = $exp_kal[$a];
				if(ereg($char,$all_big)):
					$replace = $str_tag.$all_big.$end_tag;
					$char = str_replace($all_big,$replace,$char);
						$hasil = $hasil.$char." ";
				elseif(ereg($char,$big_small)):
					$replace = $str_tag.$big_small.$end_tag;
					$char = str_replace($big_small,$replace,$char);
						$hasil = $hasil.$char." ";
				elseif(ereg($char,$all_small)):
					$replace = $str_tag.$all_small.$end_tag;
					$char = str_replace($all_small,$replace,$char);
						$hasil = $hasil.$char." ";
				else:
					$hasil = $hasil.$str_tag.$char.$end_tag." ";
				endif;
			else:
				$hasil = $hasil.$exp_kal[$a]." ";
			endif;
		};
		return $hasil;
	}
	function setPathContent($content){
		global $app;
		$res_konten=str_replace("../../css/data_images/uploaded/",$app['data_www']."/uploaded/",$content);
		return $res_konten;
	}
	/*function setPathContent($content){
		global $app;
		$res_konten = str_replace("../../data/uploaded/",$app[data_www]."/uploaded/",$content);
		return $res_konten;
	}*/
	function prosesKonten($p_key,$content,$clrtext){
		//global $app;
		$start_txt = app::pos_char($p_key,$content)-3;
		$txt_isi = app::get_lead(40,$content,$start_txt);
		$txt_isi = app::tag_on_char($p_key,$txt_isi,"<b style='color:$clrtext'>","</b>");
		$reskonten = app::setPathContent($txt_isi);
		return $reskonten;
	}

	function substr_words($str, $txt_len, $end_txt = '...') {
		$words = explode(' ', $str);
		$count = 0;
		$new_str = '';
		$abbr = '';
		foreach ($words as $val) {
			if ($count < $txt_len) {
				$new_str .= $val.' ';
				$count = $count + strlen($val);		
			}
		}
		$new_str = rtrim($new_str, ' ,.;:');
		if (strlen($str) > $txt_len) $new_str .= $end_txt;
		return $new_str;
	}

	function getIP() {
		$ip;
		if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
		else
		$ip = "UNKNOWN";
		return $ip;
	}
	
	function time_delta($start='now', $target='', $precision=0, $labels=2, $suffix=true)
	{
		date_default_timezone_set('Asia/Bangkok'); // PHP complains if this isn't set, for some reason
		// Define all time units in terms of seconds
		$units = array(
		'y' => array('tahun', 31556926), // Source: Google calculator
		'mo' => array('bulan', 2629744), // Source: Google calculator
		'w' => array('minggu', 604800),
		'd' => array('hari', 86400),
		'h' => array('jam', 3600),
		'm' => array('menit', 60),
		's' => array('detik', 1)
		);
		 
		// Some basic sanity checking
		if (empty($target)) return "No target time specified.\n";
		if ($start < 0) return "Invalid start time.\n";
		if (!array_key_exists($precision, $units) AND $precision > 2) return "Improper value for precision.\n";
		if (!is_int($labels) OR !is_bool($suffix)) return "Improper values for labels and/or suffix.\n";
		if (!is_int($target) AND !strtotime($target)) return "Could not understand your target time.\n";
		if (!is_int($start) AND !strtotime($start)) return "Could not understand your start time.\n";
		 
		// Set some sensible defaults
		$fuzz_factor = 0.8; // How close to the next value will we call it "about" something?
		if ($precision < 0 OR $precision > 2) $precision = 2;
		if ($labels < 0 OR $labels > 2) $labels = 2;
		if (!is_int($start)) $start = strtotime($start);
		if (!is_int($target)) $target = strtotime($target);
		 
		// Are we past or future?
		$ending = ($target > $start) ? " yang lalu" : " yang lalu";
		 
		// Calculate time difference & initialize output string
		$delta = abs($target - $start);
		$out = '';
		 
		// Calculate for single-unit precision
		if (is_string($precision)){
			if ($delta < $units[$precision][1]){
				$out .= "Kurang Dari satu {$units[$precision][0]}";
				return ($suffix === true) ? $out.$ending : $out;
			}
			else{
				$out .= intval(($delta / $units[$precision][1]));
				if ($labels == 0) return $out;
				$out .= ($labels == 1) ? $precision : ' '.$units[$precision][0]
				. (($out > 1 AND $labels >= 2) ? 's' : '');
				return ($suffix === true) ? $out.$ending : $out;
			}
		}
		 
		/* Calculate fuzzy precision
		-------------------------
		Fuzzy precision should output only one unit of precision
		and use the modifier "about" if the remainder is > $fuzz_factor.
		*/
		if ($precision == 0){
			foreach ($units as $unit => $type){
				if ($delta >= $type[1] * $fuzz_factor){
					$fuzzy = (fmod(($delta / $type[1]), 1) > $fuzz_factor) ? true : false;
					if ($labels > 0 AND $labels >= 2) $out .= ($fuzzy === true) ? 'Sekitar ' : '';
					$diff = ($fuzzy === true) ? ceil($delta / $type[1]) : intval($delta / $type[1]);
					if ($diff == 1 AND $fuzzy === true) $out .= ($unit == 'h') ? '1 ' : '1 ';
					else $out .= $diff;
					if ($labels == 0) return $diff;
					$out .= ($labels > 1 OR $fuzzy === false) ? ' ' : '';
					$out .= ($labels == 1) ? $unit : $type[0];
					// $out .= ($diff > 1 AND $labels > 1) ? 's' : '';
					$out .= ($diff > 1 AND $labels > 1) ? '' : '';
					return ($suffix === true) ? $out.$ending : $out;
				}
			}
		/* Calculate approximate and exact precision
		-----------------------------------------
		Approximate precision outputs up to 2 units of measure, exact prints
		as many as we have.
		*/
		}		
		else{
			$max = ($precision == 1) ? 2 : count($units); // Iterate twice if approximate precision
			$i = 0;
			foreach ($units as $unit => $type){
				if ($delta >= $type[1] AND $i < $max){
					$diff = intval($delta / $type[1]);
					// $out .= $diff.(($labels > 1) ? (' '.$type[0]) : (($labels == 0) ? ' ' : $unit)).(($diff > 1 AND $labels > 1) ? ('s') : (''));
					$out .= $diff.(($labels > 1) ? (' '.$type[0]) : (($labels == 0) ? ' ' : $unit)).(($diff > 1 AND $labels > 1) ? ('') : (''));
					$delta -= intval($delta / $type[1]) * $type[1];
					$out .= ($i == 0 AND $precision == 1 AND $labels > 0 AND !empty($diff)) ? ' dan ' : '';
					$next_index = array_search($unit,array_keys($units)) + 1;
					$units_numeric = array_values($units);
					if (array_key_exists($next_index, $units_numeric)) $next = $units_numeric[$next_index][1];
					$and = ($precision == 2 AND $labels > 0 AND ($delta % $next == 0) AND $unit != 's');
					$out .= $and ? ' dan ' : (($labels > 0 AND $unit != 's' AND $precision != 1) ? ', ' : '' );
					$i++;
				}
			}
			return ($suffix === true) ? $out.$ending : $out;
		}
	}

	function number_to_K($input){
	    $input = number_format($input);
	    $input_count = substr_count($input, ',');
	    if($input_count != '0'){
	        if($input_count == '1'){
	            return substr($input, 0, -4).'k';
	        } else if($input_count == '2'){
	            return substr($input, 0, -8).'mil';
	        } else if($input_count == '3'){
	            return substr($input, 0,  -12).'bil';
	        } else {
	            return;
	        }
	    } else {
	        return $input;
	    }
	}


	function star_rate($rate){
		if(strlen($rate)>3){
			$awal = substr($rate,0, 1);
			$dot = substr($rate,1, 1);
			$add = substr($rate,2, 1);
			$koma = substr($rate,3, 1);
			if($koma > 5){									
				if($add==9){ 
					$koma=0; 
					$awal = $awal + 1; 
					if($awal > 5){
						$awal = 5;
					}

				}else{
					$koma=$koma+1;
				}
			}
		$rate = $awal.$dot.$koma;
		}else{
			
			$rate = $rate.".0";
			if($rate<=0){
				$rate = 0;
			}
		}
		return $rate;
	}

	function subWord($text, $count)
	{
	    $words_in_text = str_word_count($text,1);
	    $words_to_return = $count;
	    $result = array_slice($words_in_text,0,$words_to_return);
	    $hasil = implode(" ",$result);
	    return $hasil;
	}

	function cekFile($alamat,$fileCek,$defa="default.jpg"){
		global $app;
		if ($fileCek){ 
			$filename = $app['data_path'].$alamat.$fileCek;
			if (!file_exists($filename)) {
				$fileCek=$defa; 
			}
		}else{
			$fileCek=$defa;
		}
		return $fileCek;
	}

	function badWord($jorok){
		$bw = array('fuck',' cum ','cuming','f u c k','fu c k','fuc k','fu ck','cok','jancok','asu','anjing','taek','keat','ashole','goblok','idiot','copo','cupu','dick','vagina','tempek','kontol','pukimai','memek','perek','buah dada','buahdada','bispak','swine','bedes','manok','tempik','go to hell','motherfucker','fucker','sacilat');
		$jorok = str_replace($bw, "***", $jorok);
		return $jorok;
	}
}
?>
