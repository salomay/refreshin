<?php
/******************************************************************************** Filename : admlib.php
* Description : admin library
*******************************************************************************/

class admlib
{	
    function tampilkan_header($title , $model = '')
	{
		global $app;
		
	    $appx = new app();
		$dbu = new db();
		$config = $dbu->get_record("kofig", "id", 1);
		$urlx = new url();
		
		if(!empty($_SESSION['adminsession'])){
			$user = $appx->unserialize64($_SESSION['adminsession']);
		}elseif(!empty($_SESSION['membersession'])){
			$user = $appx->unserialize64($_SESSION['membersession']);
		}
		if (!$model){
			include "$app[pwebmin]/part/header_part.php";
		}else{
			include "$app[pwebmin]/part/header_".$model."_part.php";
		}
	}

	function tampilkan_footer($model = ''){
		global $app;
	    if (!$model){
			include "$app[pwebmin]/part/footer_part.php";
		}else{
			include "$app[pwebmin]/part/footer_".$model."_part.php";
		}
	}

	function display_dashboard($model = '',$lokasi='')
	{
	    global $app, $nav;
		if ($model):
			include "$app[pwebmin]/modul/".$lokasi."/index_".$model.".php";
		/*else:
			include "$app[pwebmin]/modul/".$lokasi."/index.php";*/
		endif;
	}
	
	function tampilkan_menu($model='')
	{
		global $app;
		$appx = new app();
		$user = $appx->unserialize64($_SESSION['adminsession']);
		if (!$model){
			include "$app[pwebmin]/part/menu_part.php";
		}else{
			include "$app[pwebmin]/part/menu_".$model."_part.php";
		}
	}

	function set_aktip($page_id)
	{
	    global $app;
		$app['aktip'] = $page_id;
	}

	function display_block_news()
	{
	    global $app;
	}

    /***************************************************************************
    * Description : display msg
    * Parameters : $msg_title, $msg_content
    ***************************************************************************/
    function display_msg($msg_title, $msg_content)
    {
		global $app;
		include "$app[pwebmin]/dsp_msg.php";
		exit;
    }

    /***************************************************************************
    * Description : display stat
    * Parameters : $msg_title, $msg_content
    ***************************************************************************/
    function display_stat($msg_title, $msg_content)
    {
		global $app;
		include "$app[pwebmin]/web_statistic/dsp_reset.php";
		exit;
    }

	/*******************************************************************************
	* Description : validating admin
	* Parameters : $application
	* Variables : $_SESSION[adminsession] = admin session variables
	*******************************************************************************/
	function validate($application = '')
	{
		global $app;
		$adminlib = new admlib();
		$appx = new app();
		if (!strlen($_SESSION['adminsession'])):
			$adminlib->display_msg($app['lang']['error']['title'], $app['lang']['error']['adm_not_login']);
		endif;
		$app['me'] = $appx->unserialize64($_SESSION['adminsession']);
		//print_r($app["me"]);exit;
		if ($application):
			$applications = explode(',', $application);
			$admin = $app['me'];
			$ok = FALSE;
			while (list(, $v) = @each($applications)):
				if (stristr($admin['aplikasi'],$v) && !stristr($admin['aplikasi'],$v.'_0')):
					$ok = TRUE;
				endif;
			endwhile;
			if (!$ok):
				$adminlib->display_msg($app['lang']['error']['title'], $app['lang']['error']['adm_no_permission']);
			endif;
		endif;
	}
	
	function validate_member()
	{
		global $app;
		$appx = new app();
		// $dbu = new db();
		$adminlib = new admlib();
		if (!strlen($_SESSION['membersession'])):
			$adminlib->display_msg($app['lang']['error']['title'], $app['lang']['error']['adm_not_login']);
		endif;
		$app['member'] = $appx->unserialize64($_SESSION['membersession']);
		
	}

	/*******************************************************************************
	* Description : check admin previlages
	* Parameters : $application
	*******************************************************************************/
	function has_access($application = '', $userapp)
	{
		global $app;
		
		if ($application):
			$applications = explode('-', $application);
			$retval = FALSE;
			while (list(, $v) = @each($applications)):
				if (stristr($userapp, $v) && !stristr($userapp, $v.'_0')):
					$retval = TRUE;
				endif;
			endwhile;
			return $retval;
		endif;
		return FALSE;
	}

	/***************************************************************************
	* Description : create a button for messages
	***************************************************************************/
	function create_button($button)
	{
		$ret = "<br><br><div align='center'><form>";
		while (list($name, $jurl) = each($button)):
			$ret .= "<input type='button' value='$name' class='btn' onclick=\"$jurl\"> ";
		endwhile;
		$ret .= "</form></div><br>";
		return $ret;
	}

	/***************************************************************************
	* Description : create role colspan
	***************************************************************************/
	function  get_role_colspan() {
		global $app;
		$args = func_get_args();
		$default = $args[count($args) - 1];
		unset($args[count($args) - 1]);
		while (list($k, $v) = @each($args)):
			$part = explode(',', $v);
			if (stristr($app['me']['application'],$part[0])):
				$colspan = $part[1];
				break;
			endif;
		endwhile;
		if (!$colspan):
			$colspan = $default;
		endif;
		return $colspan;
	}

	/***************************************************************************
    * Description : get parent in product
    * Parameters : id
    ***************************************************************************/
	function get_top_parent($id, &$parent)
	{
		global $app;
		// $appx = new app();
		$dbu = new db();
		$adminlib = new admlib();
		$data = $dbu->get_record('product_parent', 'id', $id);
		$parent[] = $data['name'];
		if ($data['parent_id']!=0):
			 $admlib->get_top_parent($data['parent_id'],$parent);
		else:
			$parent = array_reverse($parent);
			$parent = implode(" => ", $parent);
		endif;
		return $parent;
	}

	function get_bottom_parent($id, &$child)
	{
		global $app;
		// $appx = new app();
		$dbu = new db();
		$adminlib = new admlib();
		$dat = $dbu->get_recordset('product_parent', 'parent_id', $id);
		while ($record = $dbu->fetch($dat)):
			$child[] = $record['id'];
		endwhile;
		while (list($k, $v) = @each($child)):
			$admlib->get_bottom_parent($v, $child);
		endwhile;
		return $child;
	}
	
	
    /***************************************************************************
    * Description : display budget on left pane
    * Parameters : -
    ***************************************************************************/
	function display_block_shadow()
	{
	    global $app;
	    //$user = $appx->unserialize64($_SESSION[adminsession]);	    
	    $rs['product'] =  $dbu->get_recordset("product", "0=0 and cat_id = '$p_id' and published = 'active' order by sub_cat");
		include "$app[path]/product/blk_shadow.php";
	}

	
	
	function array_is_associative ($array)
	{
		if ( is_array($array) && ! empty($array) )
		{
			for ( $iterator = count($array) - 1; $iterator; $iterator-- )
			{
				if ( ! array_key_exists($iterator, $array) ) { return true; }
			}
			return ! array_key_exists(0, $array);
		}
		return false;
	}
	function Strip($value)
	{
		if(get_magic_quotes_gpc() != 0)
		{
			if(is_array($value))  
				if ( admlib::array_is_associative($value) )
				{
					foreach( $value as $k=>$v)
						$tmp_val[$k] = stripslashes($v);
					$value = $tmp_val; 
				}				
				else  
					for($j = 0; $j < sizeof($value); $j++)
						$value[$j] = stripslashes($value[$j]);
			else
				$value = stripslashes($value);
		}
		return $value;
	}
	function search_grid($foper,$fldatas){
				$fldata = admlib::Strip($fldatas);
				$exp_items = explode(",", $fldata);
				$i=1; while (list(, $v) = each($exp_items)):
					if($i != count($exp_items))$c=",";
					if($i == count($exp_items))$c="";
					$xfield .="'".$v."'".$c;
				$i++; endwhile;
				switch (admlib::Strip($foper)) {
					case "bw":
						//$fldata .= "%";
						$where .= " LIKE '".$fldata."%'";
						break;
					case "bn":
						//$fldata .= "%";
						$where .= " NOT LIKE '".$fldata."%'";
						break;
					case "eq":
						if(is_numeric($fldata)) {
							$where .= " = ".$fldata;
						} else {
							$where .= " = '".$fldata."'";
						}
						break;
					case "ne":
						if(is_numeric($fldata)) {
							$where .= " <> ".$fldata;
						} else {
							$where .= " <> '".$fldata."'";
						}
						break;
					case "lt":
						if(is_numeric($fldata)) {
							$where .= " < ".$fldata;
						} else {
							$where .= " < '".$fldata."'";
						}
						break;
					case "le":
						if(is_numeric($fldata)) {
							$where .= " <= ".$fldata;
						} else {
							$where .= " <= '".$fldata."'";
						}
						break;
					case "gt":
						if(is_numeric($fldata)) {
							$where .= " > ".$fldata;
						} else {
							$where .= " > '".$fldata."'";
						}
						break;
					case "ge":
						if(is_numeric($fldata)) {
							$where .= " >= ".$fldata;
						} else {
							$where .= " >= '".$fldata."'";
						}
						break;
					case "ew":
						$where .= " LIKE '%".$fldata."'";
						break;
					case "en":
						$where .= " NOT LIKE '%".$fldata."'";
						break;
					case "cn":
						$where .= " LIKE '%".$fldata."%'";
						break;
					case "nc":
						$where .= " NOT LIKE '%".$fldata."%'";
						break;
					case "in":
						$where .= " IN (".$xfield.")";
						break;
					case "ni":
						$where .= " NOT IN (".$xfield.")";
						break;
					default :
						$where = "WHERE 1=1";
				}
				return $where;
	}
	
	/***************************************************************************
	* Description : create blk dashboard
	***************************************************************************/
	function create_index_dashboard($p_modul,$p_table,$p_column,$p_view,$p_id){
		$folder = str_replace("sam2_","",$p_table);
		$a= "$";
		$b = '"';
		//print_r($folder);exit;
		if($p_view == "text"):
			
$isi_index = "<?
	".$a."p_id = '$p_id';
	".$a."p_column[0] = '".$p_column[0]."';
	".$a."p_column[1] = '".$p_column[1]."';
	".$a."folder = '$folder';
	".$a."p_modul = '$p_modul';
	".$a."sql = ".$b."select * from ".$p_table." order by (post_date or modify_date) desc limit 4".$b.";
	$dbu->query(".$a."sql,".$a."rs['data'],".$a."nr['data']);	
	".$a."thumbnail = $dbu->lookup(".$b."thumbnail".$b.",".$b."dashboard".$b.",".$b."table_name = '".$p_table."'".$b.");
	include 'template_text.php';
	?>";
				
		elseif($p_view == "image"):
$isi_index = "<?
	".$a."p_id = '$p_id';
	".$a."p_column[0] = '".$p_column[1]."';
	".$a."p_column[1] = '".$p_column[0]."';
	".$a."folder = '$folder';
	".$a."p_modul = '$p_modul';
	".$a."sql = ".$b."select * from ".$p_table." order by (post_date or modify_date) desc limit 4".$b.";
	$dbu->query(".$a."sql,".$a."rs['gallery'],".$a."nr['gallery']);	
	".$a."thumbnail = $dbu->lookup(".$b."thumbnail".$b.",".$b."dashboard".$b.",".$b."table_name = '".$p_table."'".$b.");
	include 'template_image.php';
	?>";
	
		elseif($p_view == "grid"):
$isi_index = "<?
	".$a."p_id = '$p_id';
	".$a."title = '".$p_column[0]."';
	".$a."post_date = '".$p_column[1]."';
	".$a."modif = '".$p_column[2]."';
	".$a."folder = '$folder';
	".$a."p_modul = '$p_modul';
	".$a."sql = ".$b."select * from ".$p_table." order by post_date desc , modify_date desc limit 4".$b.";
	$dbu->query(".$a."sql,".$a."rs['data'],".$a."nr['data']);	
	".$a."thumbnail = $dbu->lookup(".$b."thumbnail".$b.",".$b."dashboard".$b.",".$b."table_name = '".$p_table."'".$b.");
	include 'template_grid.php';
	?>";
	
	elseif($p_view == "chart"):
$isi_index = "<?
	".$a."axis = ".$b."".$b.";
	".$a."data = ".$b."".$b.";
	".$a."p_id = '$p_id';
	".$a."folder = '$folder';
	".$a."p_modul = '$p_modul';
	".$a."tot = $dbu->lookup('sum(hit)', '$folder', 0, 0);
	".$a."where = 'and 1=1';
	".$a."field='sum(hit)';
	".$a."rs['data'] = $dbu->get_recordset('$folder',".$b."published = 'active'".$b.");
	while(".$a."chart = $dbu->fetch(".$a."rs['data'])):
		".$a."axis .= ".$b."'".$b.".".$a."chart['".$p_column[0]."'].".$b."', ".$b.";
		".$a."x['counter']= ($dbu->lookup(".$b."".$a."field".$b.", '$folder', ".$b.$p_column[0]."='".$b.".".$a."chart['".$p_column[0]."'].".$b."' ".$a."where".$b."));
		if(".$a."x['counter']==NULL){".$a."x['counter']=0;}
		".$a."data .=sprintf(".$b."%.2f".$b.", ".$a."x['counter']/".$a."tot * 100).".$b.",".$b.";
	endwhile;	
	".$a."thumbnail = $dbu->lookup(".$b."thumbnail".$b.",".$b."dashboard".$b.",".$b."table_name = '".$p_table."'".$b.");
	include 'template_chart.php';
	?>";
		endif;
		$filename = "../$app[pwebmin]/modul/$p_view/index_".$folder.".php";
		admlib::create_file($filename,$isi_index);	
	}
	
	function create_file($filename,$content){
		$fh = fopen($filename , "w+");
		if($fh==false)
			die("unable to create file");
		
		if (is_writable($filename)) {
			 if (!$handle = fopen($filename, 'a')) {
				echo "Cannot open file ($filename)";
				exit;
			}
		if (fwrite($handle, $content) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
		} else {
			 echo "The file $filename is not writable";
		}
	}
	function item_delete($var_item){
		$i=1; while (list(, $v) = each($var_item)){
			if($i != count($var_item))$items .="'".$v."',";
			if($i == count($var_item))$items .="'".$v."'";
		$i++;
		}
		// print_r($items);exit;
		return $items;
	}
}

?>