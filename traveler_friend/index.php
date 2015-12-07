<?php
include "../application.php";
$appx= new app();
$appx->load_lib('stats', 'url', 'msg', 'form', 'nav', 'file', 'admlib', 'usrlib');
## START #######################################################################
$appx->set_default($act, '');
$appx->set_default($step, 1);
$admlibx = new admlib();
$dbu = new db();
$formix = new form();
$msgx = new msg();
$dbu->connect();

if ($act == "" || $act =='traveler_friend'){
	$formix->populate($form);
	$pgconfig = $dbu->get_record("konfig", "id", 1);	    
	if($_SESSION['adminsession']){
		header("location: $app[webmin]/index.php?act=home");
	}elseif($_SESSION['membersession']){
		header("location: $app[webmin]/index.php?act=member");
	}else{
		include "dsp_login.php";
	}
	exit;
}

/*******************************************************************************
* login
* gambaran : validasi login
*******************************************************************************/
if ($act == "login"){
	$formix->init();
	$formix->serialize_form();
	$formix->validate('', 'p_uname,p_pwdx');
	if ($formix->is_error()){		
		$msgx->build_msg();
		header("location: index.php");
		exit;
	}
	if( $dbu->anti_sql_injection($_POST['p_uname']) and $dbu->anti_sql_injection($_POST['p_uname'])){
		// lakukan proses login
		$passwordhash = md5(serialize($p_pwdx));
		$sql = "select *
				from ".$app['table']['pengguna']."
				where username = '$p_uname'
					  and password = '$passwordhash' and status = 'aktif'
				limit 1";
		$dbu->query($sql, $rs['login'], $nr['login']);
		
		//echo $nr['login'];exit;
		if($nr['login']){
			$formix->reset();
			// $_SESSION['inline_edit'] = "on";
			$_SESSION['adminsession'] = $appx->serialize64($dbu->fetch($rs['login']));

			header("location: ".$app['webmin']."/index.php?act=home");
			exit;
		}else{
			//echo "masuk jeh nang kene";exit;
			$msgx->set_msg($app[lang][error]['invalid_login']);
			$msgx->build_msg();
			header("location: index.php");
			exit;
		}
	}else{
		$msgx->set_msg($app[lang][error]['invalid_login']);
		$msgx->build_msg();
		header("location: index.php");
		exit;
	}
}

/*******************************************************************************
* aksi : logout
* deskripsi : clear all cookies redirect to admin to login form
*******************************************************************************/
if ($act == "logout"){
	if(!empty($_SESSION['adminsession'])){
		$_SESSION['adminsession'] = array();
		session_unset($_SESSION['adminsession']);
		//session_unset($_SESSION['inline_edit']);
		//session_destroy();
		$msgx->set_msg($app[lang][info]['adm_logout'], 1);
		$msgx->build_msg(1);
	}else{
		session_unset($_SESSION['membersession']);
		$msgx->set_msg($app[lang][info]['member_logout'], 1);
		$msgx->build_msg(1);
	}
    header("location: $app[webmin]/index.php");
	exit;
}

/*******************************************************************************
* aksi : dashboard
* deskripsi : cms front screen
*******************************************************************************/
if ($act == "home"){
	$admlibx->validate();
	$admlibx->set_aktip("cmshome");
	$config = $dbu->get_record("konfig", "id", 1);
    include "home/tmp_home.php";
}
?>