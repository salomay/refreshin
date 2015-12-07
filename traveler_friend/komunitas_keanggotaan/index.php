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
	$admlib->set_aktip("communitycms_member");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1 ";
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
		$where .= " AND b.nama LIKE '".$_REQUEST['abjad']."%'"; 
	}else{
		$_SESSION["abjad"]="";		
	}
	$total = $dbu->count_record("id", $app[table][komunitas_pengguna], $where);
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
	$sql = "SELECT a.id, b.nama as komunitas , a.posisi, c.username FROM ".$app['table'][komunitas_pengguna]." as a LEFT JOIN ".$app['table'][komunitas]." as b ON(a.id_komunitas=b.id) LEFT JOIN ".$app[table][pengguna]." as c ON(a.id_user=c.id) $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table'][komunitas_pengguna]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data anggota komunitas yang terpilih berhasil dihapus ....";
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
	$admlib->set_aktip("communitycms_member");
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
	$admlib->set_aktip("communitycms_member");
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
		#check user apakah sudah ada dalam komunitas
		$idnya = $dbu->get_record($app[table][komunitas_pengguna], "id_user ='".$p_user."' AND id_komunitas ='".$p_komunitas."'");
		if ($idnya){
			$_SESSION['msg'] .= "User ".$dbu->lookup("username",$app[table][pengguna],"id ='".$p_user."'")." Sudah Menjadi ".$idnya[posisi]." di komunitas ".$dbu->lookup("username",$app[table][komunitsd],"id ='".$p_komunitas."'")." dengan status ".$idnya[status];
			$_SESSION['alt'] = "warning";
		}

		if ($_SESSION['msg']!=""){
			header("location: index.php?act=add&referer=".$urlx->get_referer());
			exit;
		}


		$sql = "insert into ".$app['table'][komunitas_pengguna]." (id_user, id_komunitas, tgl_gabung, posisi, keterangan, status) values
				('".$p_user."','".$p_komunitas."',now(),'".$p_posisi."','".$p_ket."','".$p_status."')";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "User ".$dbu->lookup("username",$app[table][pengguna],"id ='".$p_user."'")." Berhasil Menjadi ".$p_posisi." di komunitas ".$dbu->lookup("username",$app[table][komunitsd],"id ='".$p_komunitas."'")." dengan status ".$p_status;
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
		$page = $dbu->get_record("komunitas_pengguna", "id = '".$p_id."'");
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		//$formix->validate('', 'p_');
		
		$sql = "update ".$app['table']["komunitas_pengguna"]."
				set id_komunitas = '".$p_komunitas."',    
				status = '".$p_status."',
				posisi = '".$p_posisi."',
				keterangan = '".$p_ket."',	    
				tgl_gabung = now()    
				where id = '$p_id'";
		// echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg']="Data Keanggotaan Komunitas Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>