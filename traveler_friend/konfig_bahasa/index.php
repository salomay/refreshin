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
	$admlib->set_aktip("sett_conbhs");
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
		$where .= " AND a.headline LIKE '".$_REQUEST['abjad']."%'"; 
	}else{
		$_SESSION["abjad"]="";		
	}
	$total = $dbu->count_record("id", "konfig_bahasa", $where);
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
	$sql = "SELECT a.*, b.bahasa as bahasa FROM ".$app['table']["konfig_bahasa"]." a LEFT JOIN ".$app['table']["bahasa"]." b ON(a.id_bahasa=b.id) $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table']["provinsi"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
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
		$sql = "DELETE FROM ".$app['table']["provinsi"]." WHERE id = '".$p_id."'";
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
	$admlib->validate('sett_edit');
	$dbu->set_status("konfig_bahasa", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status konfig bahasa berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('geol_view');
	$admlib->set_aktip("sett_conbhs");
	$formix->init();
	$page = $dbu->get_record("provinsi", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
}


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("sett_conbhs");
	$admlib->validate('sett_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_headline');
		// $formix->validate('email', "p_email");

		## check duplicate provinsi
		$nama = $dbu->lookup("headline","konfig_bahasa", "headline ='".$p_headline."' AND id_bahasa ='".$p_bahasa."'");
		if ($nama){
			$_SESSION['msg'] .= "headline $p_headline sudah terpakai dengan bahasa yang sama <br/>";
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

		
		#foto user--------------------------------------
		if ($p_gmb_header_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_gmb_header"]['tmp_name'];
				
				$exif = exif_read_data($src_img);
				$imgx = new SimpleImage();
								
				## MAIN ###############
				$imgx->load($src_img);
				
				#-- check orientation ------------
				if(!empty($exif['Orientation'])) {
					switch($exif['Orientation']) {							
						case 3:
							$imgx->rotate(180);
							break;
						case 6:
							$imgx->rotate(90);
							break;
						case 8:
							$imgx->rotate(-90);
							break;
					}
				}
				$imgx->thumbnail(100, 100);
				$imgx->save($app['data_path']."/konfig/gmb_header_".$id.".jpg");				
				$data['gmb_header'] = "gmb_header_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "gambar header gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		$appx->mq_encode('p_headline');
		$sql = "insert into ".$app['table']["konfig_bahasa"]." (id_konfig, id_bahasa, headline, slogan, meta_description, meta_keyword, gmb_header,tgl_post) values
				('1','$p_bahasa','$p_headline', '$p_slogan', '$p_metades', '$p_metakey', '$data[gmb_header]', now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "konfig bahasa $p_bahasa berhasil ditambahkan....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("sett_conbhs");
	$admlib->validate('sett_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("konfig_bahasa", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_headline,p_slogan');
		// $formix->validate('email', "p_email");

		## check duplicate provinsi 
		$nama = $dbu->lookup("headline","konfig_bahasa", "headline ='".$p_headline."' AND id_bahasa ='".$p_bahasa."' and id <>'".$p_id."'");
		if ($nama){
			$_SESSION['msg'] .= "headline $p_headline sudah terpakai untuk bahasa yang sama <br/>";
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
		//print_r ($_FILES);exit;
		$data[gmb_header]= $dbu->lookup("gmb_header","konfig_bahasa","id='".$p_id."'");
			if ($p_gmb_header_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/konfig/$data[gmb_header]");	
				$data['gmb_header'] = "";
				//echo "masuk";exit;
				try{
					$src_img = $_FILES["p_gmb_header"]['tmp_name'];
					
					$exif = exif_read_data($src_img);
					//list($width, $height, $type, $attr) = getimagesize($src_img);
					$imgx = new SimpleImage();
					
					## THUMB ###############
					$imgx->load($src_img);
					
					#-- check orientation ------------
					if(!empty($exif['Orientation'])) {
						switch($exif['Orientation']) {							
							case 3:
								$imgx->rotate(180);
								break;
							case 6:
								$imgx->rotate(90);
								break;
							case 8:
								$imgx->rotate(-90);
								break;
						}
					}
					
					$imgx->thumbnail(500, 300);
					$imgx->save($app['data_path']."/konfig/gmb_header_".$id.".jpg");				
					$data['gmb_header']= "gmb_header_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "gambar header gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

		$appx->mq_encode('p_headline,p_slogan');
		$sql = "update ".$app['table']["konfig_bahasa"]."
				set headline = '$p_headline', 
				    id_bahasa = '$p_bahasa',
				    slogan = '$p_slogan',
					meta_description = '$p_metades',
					meta_keyword = '$p_metakey',
					gmb_header  = '$data[gmb_header]',
					tgl_modif = now()
				where id = '$p_id'";
		 // echo $sql;exit;
		$dbu->qry($sql);

		
		$_SESSION['msg']="Data Provinsi $p_nama Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>