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
$admlib->validate("tour");

/*******************************************************************************
* Action : browse
*******************************************************************************/
if ($act == "browse"){
	$admlib->set_aktip("tourcms_destinasi");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1 AND a.id_destinasi ='".$p_id."'";
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
	$total = $dbu->count_record("id", "transport", $where);
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
	$sql = "SELECT a.*, b.username FROM ".$app['table']["transport"]." a LEFT JOIN ".$app['table']["pengguna"]." b ON(a.id_user=b.id) $where $sort $limit";
	//echo $sql;exit;
	$dbu->query($sql,$rsbrowse,$nr_browse);
	include "tmp_browse.php";
    exit;
}

/*******************************************************************************
* Action : del
*******************************************************************************/
if ($act == "delete"){
	$admlib->validate('tour_del');
	if (!empty($_REQUEST[item])){
		$sql = "DELETE FROM ".$app['table']["transport"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data transport yang terpilih berhasil dihapus ....";
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
		$sql = "DELETE FROM ".$app['table']["transport"]." WHERE id = '".$p_id."'";
		//echo $sql;exit;
		$dbu->qry($sql);
		$_SESSION['msg']="data transport berhasil dihapus ....";
		$_SESSION['alt']="warning";
		header("location: index.php?act=browse");
	}
	exit;
}

/*******************************************************************************
* Action : set_status
*******************************************************************************/
if ($act == "set_status"){
	$admlib->validate('tour_edit');
	$dbu->set_status("transport", "id", $sub, $status, "status");
	$_SESSION['msg'] = "status rute berhasil di update ....";
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
	$admlib->set_aktip("tourcms_destinasi");
	$admlib->validate('tour_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_akses,p_harga');

		if($p_kotaf == $p_kotat){
			$_SESSION['msg'] .= "Kota Asal Dan Tujuan Tidak Boleh Sama <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_akses == ""){
			$_SESSION['msg'] .= "Masukan Gambaran Akses Rute <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_harga == ""){
			$_SESSION['msg'] .= "Masukan Biaya Rute <br/>";
			$_SESSION['alt'] = "warning";
		}

/*		if (!preg_match('/^[0-9]{0,15}$/', $p_harga)){
			$_SESSION['msg'] .= "Masukan Angka Untuk Biaya <br/>";
			$_SESSION['alt'] = "warning";
		}
*/
		if ($formix->is_error()){
			$_SESSION['msg'] .= "Isi Semua Inputan ....";
			$_SESSION['alt'] = "warning";
		}
		
		if ($_SESSION['msg']!=""){
			header("location: index.php?act=add&referer=".$urlx->get_referer());
			exit;
		}

		$appx->mq_encode('p_akseskses,p_harga');
		$sql = "insert into ".$app['table']["transport"]." (id_user, id_bahasa, id_destinasi, id_from, id_to, harga, akses, tgl_post) values
				('".$app[me][id]."','$p_bahasa','$p_id','$p_kotaf','$p_kotat','$p_harga','".$p_akses."',now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "Rute Destinasi Berhasil ditambahkan ";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("tourcms_kota");
	$admlib->validate('tour_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("transport", "id = '".$sub."'");
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_akses,p_harga');
		
		if($p_kotaf == $p_kotat){
			$_SESSION['msg'] .= "Kota Asal Dan Tujuan Tidak Boleh Sama <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_akses == ""){
			$_SESSION['msg'] .= "Masukan Gambaran Akses Rute <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_harga == ""){
			$_SESSION['msg'] .= "Masukan Biaya Rute <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($formix->is_error()){
			$_SESSION['msg'] .= "Isi Semua Inputan ....";
			$_SESSION['alt'] = "warning";
		}

		$appx->mq_encode('p_akses,p_harga');
		$sql = "update ".$app['table']["transport"]."
				set id_bahasa = '$p_bahasa', 
				    id_user = '".$app[me][id]."',
				    id_from = '".$p_kotaf."',
				    id_to = '".$p_kotat."',
				    harga ='$p_harga',
				    tgl_modif =now(),
				    akses ='$p_akses'	    
				where id = '$sub'";
		// echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg']="Data Biaya Destinasi Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>