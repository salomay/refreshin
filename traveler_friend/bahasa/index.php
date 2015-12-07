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
$admlib->validate("geol");

/*******************************************************************************
* Action : browse
*******************************************************************************/
if ($act == "browse"){
	$admlib->set_aktip("geocms_bhs");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1";
	$tab_negara="";
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
	$total = $dbu->count_record("id", "bahasa", $where);
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
	$sql = "SELECT a.*, b.nama as negara FROM ".$app['table']["bahasa"]." a LEFT JOIN ".$app['table']["negara"]." b ON(a.id_negara=b.id) $where $sort $limit";
	//echo $sql;exit;
	$dbu->query($sql,$rsbrowse,$nr_browse);
	include "tmp_browse.php";
    exit;
}

/*******************************************************************************
* Action : del
*******************************************************************************/
if ($act == "delete"){
	if (!empty($_REQUEST[item])){
		$sql = "DELETE FROM ".$app['table']["bahasa"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
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
		$sql = "DELETE FROM ".$app['table']["bahasa"]." WHERE id = '".$p_id."'";
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
if ($act == "set_status"){
	$admlib->validate('geol_edit');
	$dbu->set_status("bahasa", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status bahasa berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('geol_view');
	$admlib->set_aktip("geocms_bhs");
	$formix->init();
	$page = $dbu->get_record("bahasa", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
}


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("geocms_bhs");
	$admlib->validate('geol_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_bahasa');
		// $formix->validate('email', "p_email");

		## check duplicate ID
		$nama = $dbu->lookup("id","bahasa", "id ='".$p_idbhs."'");
		if ($nama){
			$_SESSION['msg'] .= "ID bahasa $p_bahasa sudah terpakai untuk ID bahasa negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		## check duplicate bahasa
		$nama = $dbu->lookup("bahasa","bahasa", "bahasa ='".$p_bahasa."' AND id_negara ='".$p_negara."'");
		if ($nama){
			$_SESSION['msg'] .= "Nama $p_bahasa sudah terpakai untuk negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}

		## check duplicate negara
		$nama = $dbu->lookup("id_negara","bahasa", "id_negara ='".$p_negara."'");
		if ($nama){
			$_SESSION['msg'] .= "Negara ".$dbu->lookup("nama","negara","id ='".$p_negara."'")." Sudah Memiliki bahasa terdaftar <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($formix->is_error()){
			$_SESSION['msg'] .= "Isi Semua Inputan ....";
			$_SESSION['alt'] = "warning";
		}
		
		if ($_SESSION['msg']!=""){
			header("location: index.php?act=add&referer=".$urlx->get_referer());
			exit;
		}

		$appx->mq_encode('p_nama');
		$sql = "insert into ".$app['table']["bahasa"]." (id, id_negara, bahasa, tgl_post) values
				('$p_idbhs','$p_negara', '$p_bahasa',now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "Bahasa $p_nama Berhasil ditambahkan di Negara ".$dbu->lookup("nama","negara","id='".$p_negara."'")."....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("geocms_bhs");
	$admlib->validate('geol_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("bahasa", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_bahasa');
		// $formix->validate('email', "p_email");

		$recbhs = $dbu->get_record("bahasa","id ='".$p_id."'");
		## check duplicate bahasa 
		$nama = $dbu->lookup("bahasa","bahasa", "bahasa ='".$p_bahasa."' AND id <>'".$p_id."'");
		if ($nama){
			$_SESSION['msg'] .= "Bahasa $p_bahasa sudah terpakai di negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		## check duplicate ID
		$nama = $dbu->lookup("id","bahasa", "id ='".$p_idbhs."' and id <>'".$recbhs["id"]."'");
		if ($nama){
			$_SESSION['msg'] .= "ID bahasa $p_bahasa sudah terpakai untuk ID bahasa negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}

		## check duplicate negara
		$nama = $dbu->lookup("id_negara","bahasa", "id_negara ='".$p_negara."' and id_negara<>'".$recbhs[id_negara]."'");
		if ($nama){
			$_SESSION['msg'] .= "Negara ".$dbu->lookup("nama","negara","id ='".$p_negara."'")." Sudah Memiliki bahasa terdaftar <br/>";
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
		

		$appx->mq_encode('p_bahasa');

		$sql = "update ".$app['table']["action"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["berita_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["berita_kategori"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["destinasi_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["halaman_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["header_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["konfig_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
				$dbu->qry($sql);
		$sql = "update ".$app['table']["bahasa"]." 
				set bahasa = '$p_bahasa', 
				    id_negara = '$p_negara',
				    id = '$p_idbhs',
					tgl_modif = now()
				where id = '$p_id';";
				$dbu->qry($sql);

		/*$sql = "update ".$app['table']["action"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["berita_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["berita_kategori"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["destinasi_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["halaman_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["header_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["konfig_bahasa"]." 
				set id_bahasa = '$p_idbhs'
				where id_bahasa = '$p_id';";
		$sql .= "update ".$app['table']["bahasa"]." 
				set bahasa = '$p_bahasa', 
				    id_negara = '$p_negara',
				    id = '$p_idbhs',
					tgl_modif = now()
				where id = '$p_id';";
		//echo $sql;exit;
		$dbu->multi_qry($sql);*/

		
		$_SESSION['msg']="Data bahasa $p_nama Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>