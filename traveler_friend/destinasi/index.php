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
	$total = $dbu->count_record("id", "destinasi", $where);
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
	$sql = "SELECT a.id as id, a.id_reff as id_reff, a.status as status, a.hot as hot, b.nama as kota, c.nama as wisata, d.username as uname FROM ".$app['table']["destinasi"]." as a LEFT JOIN ".$app['table']["kota"]." as b ON(a.id_kota=b.id) LEFT JOIN ".$app[table][destinasi_bahasa]." as c ON(c.id_reff = a.id_reff) LEFT JOIN ".$app[table][pengguna]." as d ON (a.id_aktifator = d.id) $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table']["destinasi"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
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
		$sql = "DELETE FROM ".$app['table']["destinasi"]." WHERE id = '".$p_id."'";
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
	$dbu->set_status("destinasi", "id", $p_id, $status, "status");
	$akt=$status;
	if($akt == "aktif"){
		$akt = "nonaktif";
	}else{
		$akt="aktif";
	}
	$sql="UPDATE ".$app[table][destinasi]." SET id_aktifator = '".$app[me][id]."' WHERE id ='".$p_id."'";
	$dbu->qry($sql);
	$_SESSION['msg'] = "status destinasi berhasil di ".$akt."kan ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : set_hot
*******************************************************************************/
if ($act == "set_hot"){
	$admlib->validate('tour_edit');
	$dbu->set_hot("destinasi", "id", $p_id, $hot, "hot");
	$_SESSION['msg'] = "status hot destinasi berhasil di update ....";
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
	$page = $dbu->get_record("destinasi", "id", $p_id);
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
		//print_r($app[me]);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_nama,p_desk,p_slogan,p_alamat');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi
		$nama = $dbu->lookup("nama","destinasi_bahasa", "nama ='".$p_nama."'");
		if ($nama){
			$_SESSION['msg'] .= "Nama $p_nama sudah terpakai di Destinasi lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		##cek long lat
		if($p_poslat !="" and $p_poslong !=""){
			$nama = $dbu->lookup("id","destinasi", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."'");
			if ($nama){
				$_SESSION['msg'] .= "Letak Longitude Dan Latitude destinasi $p_nama = destinasi ".$dbu->lookup("nama","destinasi_bahasa","id_destinasi = $nama")." <br/>";
				$_SESSION['alt'] = "warning";
			}
		}else{
			$p_poslat = 0;
			$p_poslong = 0;
		}

		if($p_desk==""){
			$_SESSION['msg'] .= "Masukan Deskripsi untuk destinasi $p_nama ....";
			$_SESSION['alt'] = "warning";
		}

		if($p_slogan==""){
			$_SESSION['msg'] .= "Masukan Slogan untuk destinasi $p_nama ....";
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

		
		#logo destinasi--------------------------------------
		if ($p_logo_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_logo"]['tmp_name'];
				
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
				$imgx->thumbnail(320, 320);
				$imgx->save($app['data_path']."/destinasi/logo/logo_".$id.".png");				
				$data['logo'] = "logo_".$id.".png";
			}catch (Exception $e) {
				$_SESSION['msg'] = "logo destinasi $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		#icon destinasi--------------------------------------
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
				$imgx->thumbnail(200, 200);
				$imgx->save($app['data_path']."/destinasi/icon_map/icon_".$id.".png");				
				$data['icon'] = "icon_".$id.".png";
			}catch (Exception $e) {
				$_SESSION['msg'] = "icon destinasi $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}


		#thumb destinasi--------------------------------------
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
				$imgx->thumbnail(131, 93);
				$imgx->save($app['data_path']."/destinasi/thumb/thumb_".$id.".jpg");				
				$data['thumb'] = "thumb_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "thumbnail destinasi $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}

		#gambar destinasi--------------------------------------
		if ($p_gambar_size > 0){
			$id = rand(1, 100).date("dmYHis");
			$file="";
			try{
				$src_img = $_FILES["p_gambar"]['tmp_name'];
				
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
				$imgx->thumbnail(1016, 857);
				$imgx->save($app['data_path']."/destinasi/gambar/pict_".$id.".jpg");				
				$data['gambar'] = "pict_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "gambar destinasi $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}

		$appx->mq_encode('p_nama,p_desk,p_slogan,p_alamat,p_haribuka,p_haribaik,p_harilibur');
		$id = rand(1, 100).date("dmYHis");
		$sql = "insert into ".$app['table']["destinasi"]." (id_reff,id_user, id_kota,id_parent, logo, thumb, gambar, icon_map, website, email,pos_lat, pos_long, id_kat , tgl_post) values
				('".$id."','".$app[me][id]."', '".$p_kota."','".$p_reff."','".$data[logo]."','".$data[thumb]."','".$data[gambar]."','".$data[icon]."', '".$p_web."', '".$p_email."' , '".$p_poslat."','".$p_poslong."','".$p_kat."',  now())";
		//echo $sql."<br/>";
		$dbu->qry($sql);
		
		$sql = "insert into ".$app['table']["destinasi_bahasa"]." (id_user, id_bahasa, id_reff, nama, usia, alamat, htm,hari_buka, jam_buka, hari_libur, best_day, best_time , slogan , deskripsi) values
				('".$app[me][id]."', '".$p_bahasa."','".$id."','".$p_nama."', '".$p_usia."', '".$p_alamat."', '".$p_htm."' , '".$p_haribuka."','".$p_jambuka."','".$p_harilibur."','".$p_haribaik."','".$p_jambaik."', '".$p_slogan."', '".$p_desk."')";
		//echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg'] = "destinasi $p_nama Berhasil ditambahkan di kota ".$dbu->lookup("nama","kota","id='".$p_kota."'")."....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("tourcms_destinasi");
	$admlib->validate('tour_edit');
	$formix->init();
	if ($step == "1"){
		$sql = "SELECT a.id, a.id_kat, a.id_kota,a.id_parent,a.logo,a.thumb,a.gambar,a.icon_map,a.website, a.email, a.pos_lat, a.pos_long, b.nama as wisata FROM ".$app['table']["destinasi"]." as a LEFT JOIN ".$app['table']["destinasi_bahasa"]." as b ON(a.id_reff=b.id_reff) WHERE a.id ='".$p_id."'";
		//echo $sql;exit;
		$page = $dbu->get_recordmix($sql);
		$form = $page;
		//print_r($form);
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_poslat,p_poslong');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi 
		$nama = $dbu->lookup("nama","destinasi", "nama ='".$p_nama."' AND id_negara ='".$p_negara."' and id <>'".$p_id."'");
		if ($nama){
			$_SESSION['msg'] .= "Nama $p_nama sudah terpakai di ".$dbu->lookup("nama","destinasi_bahasa","id_destinasi = $nama")." <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		if($p_poslat !="" and $p_poslong !=""){
			##cek long lat
			$nama = $dbu->lookup("id","destinasi", "pos_lat ='".$p_poslat."' AND pos_long ='".$p_poslong."' AND id <>'".$p_id."'");
			if ($nama){
				$_SESSION['msg'] .= "Letak Longitude Dan Latitude destinasi $p_nama = destinasi ".$nama." <br/>";
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
		$data[logo]= $dbu->lookup("logo","destinasi","id='".$p_id."'");
			if ($p_logo_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi/logo/$data[logo]");	
				$data['logo'] = "";
				//echo "masuk";exit;
				try{
					$src_img = $_FILES["p_logo"]['tmp_name'];
					
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
					$imgx->save($app['data_path']."/destinasi/logo/logo_".$id.".png");				
					$data['logo']= "logo_".$id.".png";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "logo destinasi $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			$data[thumb]= $dbu->lookup("thumb","destinasi","id='".$p_id."'");
			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi/thumb/$data[thumb]");	
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
					
					$imgx->thumbnail(131, 93);
					$imgx->save($app['data_path']."/destinasi/thumb/thumb_".$id.".jpg");				
					$data['thumb']= "thumb_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "thumbnail destinasi $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			$data[gambar]= $dbu->lookup("gambar","destinasi","id='".$p_id."'");
			if ($p_gambar_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi/gambar/$data[gambar]");	
				$data['gambar'] = "";
				//echo "masuk";exit;
				try{
					$src_img = $_FILES["p_gambar"]['tmp_name'];
					
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
					$imgx->save($app['data_path']."/destinasi/gambar/gambar_".$id.".jpg");				
					$data['gambar']= "gambar_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "gambar destinasi $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			$data[icon_map]= $dbu->lookup("icon_map","destinasi","id='".$p_id."'");
			if ($p_gambar_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/destinasi/icon_map/$data[icon_map]");	
				$data['icon_map'] = "";
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
					
					$imgx->thumbnail(100, 100);
					$imgx->save($app['data_path']."/destinasi/icon_map/icon_map_".$id.".png");				
					$data['icon_map']= "icon_map_".$id.".png";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "icon_map destinasi $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

		$appx->mq_encode('p_web,p_poslat,p_poslong');
		$sql = "update ".$app[table][destinasi]."
				set id_kota = '".$p_kota."', 
				    id_kat = '".$p_kat."',
				    id_parent = '".$p_reff."',
				    pos_lat = '".$p_poslat."',
					pos_long = '".$p_poslong."',
					website = '".$p_web."',
					email = '".$p_email."',
					logo  = '".$data[logo]."',
					thumb  = '".$data[thumb]."',
					gambar  = '".$data[gambar]."',
					icon_map  = '".$data[icon_map]."',
					tgl_modif = now()
				where id = '".$p_id."'";
		 // echo $sql;exit;
		$dbu->qry($sql);

		
		$_SESSION['msg']="Data destinasi $p_nama Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>