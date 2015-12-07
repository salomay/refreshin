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
$admlib->validate("community");

/*******************************************************************************
* Action : browse
*******************************************************************************/
if ($act == "browse"){
	$admlib->set_aktip("tourcms_destinasi");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1 AND a.id_komunitas ='".$p_id."'";
	$tab_provinsi="";
	if(isset($_REQUEST["kcari"])){
		$_SESSION["kcari"]= $_REQUEST["kcari"];
		$_SESSION["fcari"]= $_REQUEST["fcari"];
		$where .= " AND ".$_REQUEST["fcari"]." LIKE '%".$_REQUEST["kcari"]."%'";	
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
	$total = $dbu->count_record("id", "destinasi_biaya", $where);
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
	//$sql = "SELECT * FROM ".$app['table']['page']." $where $sort $limit";
	$sql = "SELECT a.id, c.nama as destinasi FROM ".$app['table']["komunitas_destinasi"]." as a LEFT JOIN ".$app['table']["destinasi"]." as b ON(a.id_destinasi=b.id) LEFT JOIN ".$app[table][destinasi_bahasa]." as c ON(b.id_reff=c.id_reff) $where $sort $limit";
	//echo $sql;exit;
	$dbu->query($sql,$rsbrowse,$nr_browse);
	include "tmp_browse.php";
    exit;
}

/*******************************************************************************
* Action : del
*******************************************************************************/
if ($act == "delete"){
	$admlib->validate('community_del');
	if (!empty($_REQUEST[item])){
		$sql = "DELETE FROM ".$app['table'][komunitas_destinasi]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data destinasi komunitas ".$dbu->lookup("nama",$app[table][komunitas],"id ='".$p_id."'")." yang terpilih berhasil dihapus ....";
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
		$sql = "DELETE FROM ".$app['table']["komunitas_destinasi"]." WHERE id = '".$p_id."'";
		//echo $sql;exit;
		$dbu->qry($sql);
		$_SESSION['msg']="data destinasi berhasil dihapus ....";
		$_SESSION['alt']="warning";
		header("location: index.php?act=browse");
	}
	exit;
}

/*******************************************************************************
* Action : set_status
*******************************************************************************/
if ($act == "set_status"){
	$admlib->validate('community');
	$dbu->set_status("komunitas_destinasi", "id", $sub, $status, "status");
	$_SESSION['msg'] = "status biaya berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('tour_view');
	$admlib->set_aktip("tourcms_destinasi");
	$formix->init();
	$page = $dbu->get_record("kota", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
}


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("communitycms_master");
	$admlib->validate('community_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_destinasi');

		$sql = "insert into ".$app['table']["komunitas_destinasi"]." (id_komunitas, id_destinasi) values
				('".$p_id."','".$p_destinasi."')";
		echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "Destinasi Berhasil ditambahkan ke komunitas ini";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("communitycms_master");
	$admlib->validate('community_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("komunitas_destinasi", "id = '".$sub."'");
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_destinasi');
		
		$sql = "update ".$app['table']["komunitas_destinasi"]."
				set id_destinasi = '".$p_destinasi."'	    
				where id = '$sub'";
		// echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg']="Data Destinasi Komunitas Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>