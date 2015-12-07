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
	$admlib->set_aktip("tourcms_kategori");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1";
	$tab_bahasa="";
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
		$where .= " AND a.kategori LIKE '".$_REQUEST['abjad']."%'"; 
	}else{
		$_SESSION["abjad"]="";		
	}
	$total = $dbu->count_record("id", "destinasi_kategori", $where);
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
	$sql = "SELECT a.*, b.bahasa as bahasa FROM ".$app['table']["destinasi_kategori"]." a LEFT JOIN ".$app['table']["bahasa"]." b ON(a.id_bahasa=b.id) $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table']["destinasi_kategori"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data kategori destinasi yang terpilih berhasil dihapus ....";
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
		$sql = "DELETE FROM ".$app['table']["destinasi_kategori"]." WHERE id = '".$p_id."'";
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
	$admlib->validate('tour_edit');
	$dbu->set_status("destinasi_kategori", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status destinasi_kategori berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('tour_view');
	$admlib->set_aktip("tourcms_kategori");
	$formix->init();
	$page = $dbu->get_record("destinasi_kategori", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
}


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("tourcms_kategori");
	$admlib->validate('tour_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_kategori');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi_kategori
		$nama = $dbu->lookup("kategori","destinasi_kategori", "kategori ='".$p_kategori."' AND id_bahasa ='".$p_bahasa."'");
		if ($nama){
			$_SESSION['msg'] .= "Kategori $p_kategori sudah terpakai di bahasa lain <br/>";
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

		#icon--------------------------------------
		if ($p_icon_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_icon"]['tmp_name'];
				
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
				$imgx->thumbnail(55, 55);
				$imgx->save($app['data_path']."/destinasi_kategori/icon/icon_".$id.".png");				
				$data['icon'] = "icon_".$id.".png";
			}catch (Exception $e) {
				$_SESSION['msg'] = "icon kategori $p_kategori gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		/*
		#icon--------------------------------------
		if ($p_nicon_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_nicon"]['tmp_name'];
				
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
				$imgx->thumbnail(55, 55);
				$imgx->save($app['data_path']."/destinasi_kategori/icon/nicon_".$id.".png");				
				$data['nicon'] = "nicon_".$id.".png";
			}catch (Exception $e) {
				$_SESSION['msg'] = "icon kategori $p_kategori gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
*/
		#thumb--------------------------------------
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
				$imgx->thumbnail(364, 206);
				$imgx->save($app['data_path']."/destinasi_kategori/thumb/thumb_".$id.".jpg");				
				$data['thumb'] = "thumb_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "thumb kategori $p_kategori gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		$appx->mq_encode('p_kategori');
		$sql = "insert into ".$app['table']["destinasi_kategori"]." (kategori, id_bahasa, icon,thumb) values
				('$p_kategori', '$p_bahasa', '$data[icon]','$data[thumb]')";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "kategori $p_kategori Berhasil ditambahkan di bahasa ".$dbu->lookup("bahasa","bahasa","id='".$p_bahasa."'")."....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("tourcms_kategori");
	$admlib->validate('tour_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("destinasi_kategori", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		//$formix->validate('', 'p_kategori');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi_kategori 
		$nama = $dbu->lookup("kategori","destinasi_kategori", "kategori ='".$p_kategori."' AND id_bahasa ='".$p_bahasa."' and id <>'".$p_id."'");
		if ($nama){
			$_SESSION['msg'] .= "Kategori $p_nama sudah terpakai di bahasa lain <br/>";
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
		//----thumb
		$data[thumb]= $dbu->lookup("thumb","destinasi_kategori","id='".$p_id."'");
			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi_kategori/thumb/$data[thumb]");	
				$data['thumb'] = "";
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
					
					$imgx->thumbnail(364, 206);
					$imgx->save($app['data_path']."/destinasi_kategori/thumb/thumb_".$id.".jpg");				
					$data['thumb']= "thumb_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "thumb kategori $p_kategori gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			//----icon
		$data[icon]= $dbu->lookup("icon","destinasi_kategori","id='".$p_id."'");
			if ($p_icon_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi_kategori/icon/$data[icon]");	
				$data['icon'] = "";
				//echo "masuk";exit;
				try{
					$src_img = $_FILES["p_icon"]['tmp_name'];
					
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
					
					$imgx->thumbnail(55, 55);
					$imgx->save($app['data_path']."/destinasi_kategori/icon/icon_".$id.".png");				
					$data['icon']= "icon_".$id.".png";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "icon kategori $p_kategori gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}
/*
		//---- nearby icon
		$data[nicon]= $dbu->lookup("nicon","destinasi_kategori","id='".$p_id."'");
			if ($p_nicon_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi_kategori/icon/$data[nicon]");	
				$data['nicon'] = "";
				//echo "masuk";exit;
				try{
					$src_img = $_FILES["p_nicon"]['tmp_name'];
					
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
					
					$imgx->thumbnail(55, 55);
					$imgx->save($app['data_path']."/destinasi_kategori/icon/nicon_".$id.".png");				
					$data['nicon']= "nicon_".$id.".png";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "icon kategori $p_kategori gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}
*/
		$appx->mq_encode('p_kategori');
		$sql = "update ".$app['table']["destinasi_kategori"]."
				set kategori = '$p_kategori', 
				    id_bahasa = '$p_bahasa',
					icon  = '$data[icon]',
					thumb = '$data[thumb]'
				where id = '$p_id'";
		 // echo $sql;exit;
		$dbu->qry($sql);

		
		$_SESSION['msg']="Data kategori $p_nama Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>