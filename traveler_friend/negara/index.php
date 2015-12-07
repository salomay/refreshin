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
	$admlib->set_aktip("geocms_negara");
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
	$total = $dbu->count_record("id", "negara", $where);
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
	$sql = "SELECT * FROM ".$app['table']["negara"]." a $where $sort $limit";
	//echo $sql;exit;
	$dbu->query($sql,$rsbrowse,$nr_browse);
	include "tmp_browse.php";
    exit;
}

/*******************************************************************************
* Action : del
*******************************************************************************/
if ($act == "delete"){
	$admlib->validate('geol_del');
	if (!empty($_REQUEST[item])){
		$sql = "DELETE FROM ".$app['table']["negara"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
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
	$admlib->validate('geol_del');
	if (!empty($p_id)){
		$sql = "DELETE FROM ".$app['table']["negara"]." WHERE id = '".$p_id."'";
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
	$dbu->set_status("negara", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status negara berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('geol_edit');
	$admlib->set_aktip("geocms_negara");
	$formix->init();
	$page = $dbu->get_record("negara", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
}


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->validate('geol_add');
	$admlib->set_aktip("geocms_negara");
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

		## check duplicate username 
		$nama = $dbu->lookup("nama", 'negara', "nama ='".$p_nama."'");
		if ($nama){
			$_SESSION['msg'] = "Nama Negara Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		##cek long lat
		if($p_poslat !="" and $p_poslong !=""){
			$nama = $dbu->lookup("nama","negara", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."'");
			if ($nama){
				$_SESSION['msg'] = "Letak Longitude Dan Latitude negara $p_nama = negara ".$nama." <br/>";
				$_SESSION['alt'] = "warning";
			}
		}else{
			$p_poslat = 0;
			$p_poslong = 0;
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
		if ($p_thumb_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_thumb"]['tmp_name'];
				
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
				$imgx->thumbnail(150, 100);
				$imgx->save($app['data_path']."/bendera/bendera_".$id.".jpg");				
				$file = "bendera_".$id.".jpg";
				$data['bendera'] = $file;
			}catch (Exception $e) {
				$_SESSION['msg'] = "Bendera Gagal di Upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		$appx->mq_encode('p_nama');
		$sql = "insert into ".$app['table']["negara"]."	(nama, pos_lat, pos_long, bendera, tgl_post) values
				('$p_nama', '$p_poslat', '$p_poslong', '$data[bendera]', now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "Negara $p_nama Berhasil Di Ditambahkan ....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("geocms_negara");
	$admlib->validate('geol_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("negara", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_nama');
		// $formix->validate('email', "p_email");

		## check duplicate country 
		$nama=$dbu->lookup("nama","negara", "nama ='".$p_nama."' AND id <>'".$p_id."'");
		$_SESSION['msg']="";

		if ($nama){
			$_SESSION['msg'] = "Nama Negara Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		if($p_poslat !="" and $p_poslong !=""){
		$row = $dbu->lookup("nama","negara", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."' AND id <>'".$p_id."'");
			if ($nama){
				$_SESSION['msg'] = "Letak Longitude Dan Latitude negara $p_nama = negara ".$nama." <br/>";
				$_SESSION['alt'] = "warning";
			}
		}else{
			$p_poslat = 0;
			$p_poslong = 0;
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
		$data[bendera]= $dbu->lookup("bendera","negara","id='".$p_id."'");

			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/bendera/$data[bendera]");	
				$data['bendera'] = "";
				//echo "masuk";exit;

				try{
					$src_img = $_FILES["p_thumb"]['tmp_name'];
					
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
					
					$imgx->thumbnail(150, 100);
					$imgx->save($app['data_path']."/bendera/bendera_".$id.".jpg");				
					$data['bendera']= "bendera_".$id.".jpg";
				}catch (Exception $e) {
					$_SESSION['msg'] = "bendara negara $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}
		

		$appx->mq_encode('p_nama');
		$sql .= "update ".$app['table']["negara"]."
				set nama = '$p_nama', 
				    pos_lat = '$p_poslat',
				    pos_long = '$p_poslong',
					bendera  = '$data[bendera]',
					tgl_modif = now()
				where id = '$p_id'";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		$_SESSION['msg']="Data Negara $p_nama Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>