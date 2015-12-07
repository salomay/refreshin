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
	$admlib->set_aktip("geocms_provinsi");
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
	$total = $dbu->count_record("id", "provinsi", $where);
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
	$sql = "SELECT a.*, b.nama as negara FROM ".$app['table']["provinsi"]." a LEFT JOIN ".$app['table']["negara"]." b ON(a.id_negara=b.id) $where $sort $limit";
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
	$admlib->validate('geol_edit');
	$dbu->set_status("provinsi", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status provinsi berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('geol_view');
	$admlib->set_aktip("geocms_provinsi");
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
	$admlib->set_aktip("geocms_provinsi");
	$admlib->validate('geol_add');
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

		## check duplicate provinsi
		$nama = $dbu->lookup("nama","provinsi", "nama ='".$p_nama."' AND id_negara ='".$p_negara."'");
		if ($nama){
			$_SESSION['msg'] .= "Nama $p_nama sudah terpakai di negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		##cek long lat
		if($p_poslat !="" and $p_poslong !=""){
			$nama = $dbu->lookup("nama","provinsi", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."'");
			if ($nama){
				$_SESSION['msg'] .= "Letak Longitude Dan Latitude provinsi $p_nama = provinsi ".$nama." <br/>";
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
				$imgx->thumbnail(100, 100);
				$imgx->save($app['data_path']."/provinsi/logo/logo_".$id.".jpg");				
				$data['logo'] = "logo_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "logo provinsi $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		$appx->mq_encode('p_nama');
		$sql = "insert into ".$app['table']["provinsi"]." (nama, id_negara, pos_lat, pos_long, logo, tgl_post) values
				('$p_nama', '$p_negara', '$p_poslat', '$p_poslong', '$data[logo]', now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "provinsi $p_nama Berhasil ditambahkan di Negara ".$dbu->lookup("nama","negara","id='".$p_negara."'")."....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("geocms_provinsi");
	$admlib->validate('geol_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("provinsi", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_nama');
		// $formix->validate('email', "p_email");

		## check duplicate provinsi 
		$nama = $dbu->lookup("nama","provinsi", "nama ='".$p_nama."' AND id_negara ='".$p_negara."' and id <>'".$p_id."'");
		if ($nama){
			$_SESSION['msg'] .= "Nama $p_nama sudah terpakai di negara lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		if($p_poslat !="" and $p_poslong !=""){
			##cek long lat
			$nama = $dbu->lookup("nama","provinsi", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."' AND id <>'".$p_id."'");
			if ($nama){
				$_SESSION['msg'] .= "Letak Longitude Dan Latitude provinsi $p_nama = provinsi ".$nama." <br/>";
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
		//print_r ($_FILES);exit;
		$data[logo]= $dbu->lookup("logo","provinsi","id='".$p_id."'");
			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/provinsi/logo/$data[logo]");	
				$data['logo'] = "";
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
					
					$imgx->thumbnail(100, 100);
					$imgx->save($app['data_path']."/provinsi/logo/logo_".$id.".jpg");				
					$data['logo']= "logo_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "logo provinsi $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

		$appx->mq_encode('p_nama');
		$sql = "update ".$app['table']["provinsi"]."
				set nama = '$p_nama', 
				    id_negara = '$p_negara',
				    pos_lat = '$p_poslat',
					pos_long = '$p_poslong',
					logo  = '$data[logo]',
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