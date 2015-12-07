<?php
/*******************************************************************************
* Filename : usrlib.php
* Description : user library
*******************************************************************************/
class usrlib{
	function tampilkan_doctype($model = ''){
		global $app;
		$appx=new app();	
		$dbu = new db();
		$urlx = new url();
		$app['me'] = $appx->unserialize64($_SESSION['adminsession']);
		$app[config] = $dbu->get_record("konfig", "id", 1);
		if (!$model){
			include "$app[path]/part/doctype_part.php";
		}else{
			include "$app[path]/part/doctype_".$model."_part.php";
		}
	}
	function tampilkan_header($model = ''){
		global $app;
		$dbu = new db();
		$header_title = $dbu->get_record("header_title", "published = 'active' and page = '".$cpage."'");
		//$fps=db::get_record("page"," page='E_033'and published='active'");
        if (!$model){
			include "$app[path]/part/header_part.php";
		}else{
			include "$app[path]/part/header_".$model."_part.php";
		}
	}	
	
	function tampilkan_menu($model = ''){
		global $app;
		if (!$model){
			include "$app[path]/part/menu_part.php";
		}else{
			include "$app[path]/part/menu_".$model."_part.php";
		}
	}
	
function display_block_sosmedia($model = ''){
		global $app;
		$dbu = new db();		
		$config = $dbu->get_record("configuration", "id", 1);
		if (!$model):
			include "$app[path]/bagian/bag_sosmedia.php";
		else:
			include "$app[path]/bagian/bag_sosmedia_".$model.".php";
		endif;
	}
	
	function tampilkan_footer($model = ''){
	    global $app;
		if (!$model){
			include "$app[path]/part/footer_part.php";
		}else{
			include "$app[path]/part/footer_".$model."_part.php";
		}
	}	
	/*******************************************************************************
	* Description : validating member
	* Parameters : $application
	* Variables : $_SESSION[membersession] = member session variables
	*******************************************************************************/
	function validate($application = '')
	{
		global $app;
		#print_r($_SESSION[membersession]);
		if (!strlen($_SESSION['membersession'])):			
			usrlib::display_msg($app['lang']['error']['title'], $app['lang']['error']['member_not_login']);
		endif;
		$app[member] = app::unserialize64($_SESSION['membersession']);
	}
	
	/***************************************************************************
    * Description : display msg
    * Parameters : $msg_title, $msg_content
    ***************************************************************************/
    function display_msg($msg_title, $msg_content){
		global $app;
		include "$app[path]/dsp_msg.php";
		exit;
    }
	
}

?>