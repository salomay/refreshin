<?php
include "../../application.php";
$appx = new app();
$dbu = new db();
$appx->load_lib('url', 'msg', 'form', 'nav', 'admlib', 'lang.eng');
$formix = new form();
$admlib = new admlib();
$msgx = new msg();
$urlx = new url();

$appx->set_default($act, 'browse');
$appx->set_default($step, 1);
$dbu->connect();
$admlib->validate("sett");

/*******************************************************************************
* Action : browse
*******************************************************************************/
if ($act == "browse"){
	$admlib->set_aktip("sett_action");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1";
	if(isset($_REQUEST["kcari"])){
		$_SESSION["kcari"]= $_REQUEST["kcari"];
		$_SESSION["fcari"]= $_REQUEST["fcari"];
		$where .= " AND a.".$_REQUEST["fcari"]." LIKE '%".$_REQUEST["kcari"]."%'";	
	}else{
		$_SESSION["kcari"]= "";
		$_SESSION["fcari"]= "";	
	}
	if(isset($_REQUEST["abjad"])){
		$_SESSION["abjad"]=$_REQUEST["abjad"];
		$where .= " AND a.nama LIKE '".$_REQUEST['abjad']."%'"; 
	}else{
		$_SESSION["abjad"]="";		
	}
	$total = $dbu->count_record("id", "action", $where);
	if( $total >0 ) {
			$total_pages = ceil($total/$paging);
		} else {
			$total_pages = 0;
		}
	if ($page > $total_pages){ $page = $total_pages; }
	
	$start = $paging * $page - $paging; // do not put $limit*($page - 1)
	
	if ($start<0){ $start = 0;}
	
	if($sidx !="" && $sord !=""){
		$sort="ORDER BY $sidx $sord";
	}
	if($paging>0){
	$limit="LIMIT $start , $paging";}
	$sql = "SELECT a.*, b.bahasa as bahasa FROM ".$app['table']["action"]." a LEFT JOIN ".$app['table']["bahasa"]." b ON(a.id_bahasa=b.id) $where $sort $limit";
	//echo $sql;
	$dbu->query($sql,$rsbrowse,$nr_browse);
	include "tmp_browse.php";
    exit;
}

/*******************************************************************************
* Action : del
*******************************************************************************/
if ($act == "delete"){
	$admlib->validate('sett_del');
	if (!empty($_REQUEST[item])){
		$sql = "DELETE FROM ".$app['table']['action']." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data action yang terpilih berhasil dihapus ....";
		$_SESSION['alt']="danger";
		header("location: ".$urlx->get_referer());
	}
	exit;
}

/*******************************************************************************
* Action : single delete
*******************************************************************************/
if ($act == "s_delete"){
	//print_r($_REQUEST);exit;
	if (!empty($p_id)){
		$sql = "DELETE FROM ".$app['table']['action']." WHERE id = '".$p_id."'";
		//echo $sql;exit;
		$dbu->qry($sql);
		$_SESSION['msg']="data action berhasil dihapus ....";
		$_SESSION['alt']="warning";
		header("location: index.php?act=browse");
	}
	exit;
}

/*******************************************************************************
* Action : set_status
*******************************************************************************/
if ($act == "set_status"):
	$dbu->set_status("action", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status user berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
endif;

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"):
	$admlib->set_aktip("sett_action");
	$formix->init();
	$page = $dbu->get_record("action", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
endif;


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("sett_action");
	$admlib->validate('sett_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_nama');
		// $formix->validate('email', "p_email");

		## check duplicate aksi 
		
		$_SESSION['msg']="";
		/*$nama=$dbu->lookup("nama","action","nama='".$p_nama."'");
		if ($nama){
			$_SESSION['msg'] = "Nama Aksi $p_nama Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}*/
		
		if ($formix->is_error()){
			$_SESSION['msg'] .= "Isi Semua Inputan ....";
			$_SESSION['alt'] = "warning";
		}
		// echo $_SESSION['msg']."lala";exit;
		if ($_SESSION['msg']!=""){
			header("location: index.php?act=add&p_id=$p_id&referer=".$urlx->get_referer());
			exit;
		}
		
		$appx->mq_encode('p_nama');
		$sql = "insert into ".$app['table']['action']."
				(action, id_bahasa, nama) values
				('$p_noaksi', '$p_bahasa', '$p_nama')";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "User Baru Berhasil Di Ditambahkan ....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("sett_action");
	$admlib->validate('sett_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("action", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_nama');
		// $formix->validate('email', "p_email");

		## check duplicate aksi 
		
		$_SESSION['msg']="";
		$nama=$dbu->lookup("nama","action","nama='".$p_nama."' and id  <> '".$p_id."'");
		if ($nama){
			$_SESSION['msg'] = "Nama Aksi $p_nama Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		if ($formix->is_error()){
			$_SESSION['msg'] .= "Isi Semua Inputan ....";
			$_SESSION['alt'] = "warning";
		}
		// echo $_SESSION['msg']."lala";exit;
		if ($_SESSION['msg']!=""){
			header("location: index.php?act=update&p_id=$p_id&referer=".$urlx->get_referer());
			exit;
		}
		
		

		$appx->mq_encode('p_nama');
		$sql = "update ".$app['table']['action']."
				set nama = '$p_nama', 
				    action = '$p_noaksi',
				    id_bahasa = '$p_bahasa'					
				where id = '$p_id'";
		 // echo $sql;exit;
		$dbu->qry($sql);
		## am i updated ? if yes then update the session

		
		$_SESSION['msg']="Data Aksi Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>