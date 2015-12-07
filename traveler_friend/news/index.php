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
	$total = $dbu->count_record("id", "berita", $where);
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
	$sql = "SELECT a.id as id, c.kategori as kategori, b.status as status, b.hit as hit, a.judul as judul, d.username as uname, c.id_bahasa as idbahasa FROM ".$app['table']["berita_bahasa"]." a join ".$app['table']["berita"]." b on a.id_berita=b.id join ".$app['table']["berita_kategori"]." c on c.id=b.id_kat JOIN ".$app['table']["pengguna"]." as d ON (d.id = b.id_user)  $where $sort $limit";
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
		$sql = "DELETE a,b FROM ".$app['table']["berita"]." a join ".$app['table']["berita_bahasa"]." b on a.id=b.id_berita WHERE a.id =".$admlib->item_delete($_REQUEST[item])."";
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
		$sql = "DELETE FROM ".$app['table']["berita"]." WHERE id = '".$p_id."'";
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
	$dbu->set_status("berita", "id", $p_id, $status, "status");
	$akt=$status;
	if($akt == "aktif"){
		$akt = "nonaktif";
	}else{
		$akt="aktif";
	}
	$sql="UPDATE ".$app[table][berita]." SET id_user = '".$app[me][id]."' WHERE id ='".$p_id."'";
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
	$dbu->set_hot("berita", "id", $p_id, $hot, "hit");
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
		$formix->validate('', 'p_judul,p_desk,p_sinopsis');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi
		$nama = $dbu->lookup("judul","berita_bahasa", "nama ='".$p_judul."'");
		if ($nama){
			$_SESSION['msg'] .= "Judul $p_judul sudah terpakai di Berita lain <br/>";
			$_SESSION['alt'] = "warning";
		}
		

		if($p_desk==""){
			$_SESSION['msg'] .= "Masukan Deskripsi untuk destinasi $p_nama ....";
			$_SESSION['alt'] = "warning";
		}

		if($p_sinopsis==""){
			$_SESSION['msg'] .= "Masukan Sinopsis untuk destinasi $p_sinopsis ....";
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

		
		


		#thumb berita--------------------------------------
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
				$imgx->save($app['data_path']."/berita/thumb/thumb_".$id.".jpg");				
				$data['thumb'] = "thumb_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "thumbnail berita $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}

		#gambar dberita--------------------------------------
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
				$imgx->save($app['data_path']."/berita/gambar/pict_".$id.".jpg");				
				$data['gambar'] = "pict_".$id.".jpg";
			}catch (Exception $e) {
				$_SESSION['msg'] = "gambar berita $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}

		$appx->mq_encode('p_judul,p_desk,p_sinopsis');
		$id = rand(1, 100).date("dmYHis");
		$sql = "insert into ".$app['table']["berita"]." (id_kat,id_reff,id_user,status,ket_id,hit, tgl_post) values
				('".$p_kat."','0','".$app[me][id]."','nonaktif','destinasi','0', now())";
		//echo $sql."<br/>";
		$dbu->qry($sql);
		
		$sql = "insert into ".$app['table']["berita_bahasa"]." (id_berita, id_bahasa, judul, sinopsis, isi, thumb,gambar,status) values
				(LAST_INSERT_ID(), '".$p_bahasa."','".$p_judul."', '".$p_sinopsis."', '".$p_desk."', '".$data[thumb]."' , '".$data[gambar]."','aktif')";
		//echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg'] = "Berita $p_judul Berhasil ditambahkan ....";
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
		$sql = "SELECT a.id as id , c.id as id_kat, a.sinopsis, a.judul as judul, a.isi, a.thumb,a.gambar FROM ".$app['table']["berita_bahasa"]." a join ".$app['table']["berita"]." b on a.id_berita=b.id join ".$app['table']["berita_kategori"]." c on c.id=b.id_kat JOIN ".$app['table']["pengguna"]." as d ON (d.id = b.id_user)  WHERE a.id ='".$p_id."'";
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
		$formix->validate('', 'p_judul,p_desk,p_sinopsis');
		// $formix->validate('email', "p_email");

		## check duplicate destinasi 
		$judul = $dbu->lookup("judul","berita_bahasa", "judul ='".$p_judul."' and id_berita <>'".$p_id."'");
		if ($judul){
			$_SESSION['msg'] .= "Judul $p_judul sudah terpakai di ".$dbu->lookup("judul","berita_bahasa","id_berita = $judul")." <br/>";
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
	

			$data[thumb]= $dbu->lookup("thumb","berita_bahasa","id_berita='".$p_id."'");
			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/berita/thumb/$data[thumb]");	
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
					$imgx->save($app['data_path']."/berita/thumb/thumb_".$id.".jpg");				
					$data['thumb']= "thumb_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "thumbnail berita $p_judul gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			$data[gambar]= $dbu->lookup("gambar","berita_bahasa","id_berita='".$p_id."'");
			if ($p_gambar_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/berita/gambar/$data[gambar]");	
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
					$imgx->save($app['data_path']."/berita/gambar/gambar_".$id.".jpg");				
					$data['gambar']= "gambar_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "gambar berita $p_judul gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

			

		$appx->mq_encode('p_judul,p_desk,p_sinopsis');
		$sql = "update ".$app[table][berita_bahasa]." a join ".$app[table][berita]." b on a.id_berita=b.id
				set b.id_kat = '".$p_kat."',
				    a.judul = '".$p_judul."',
				    a.sinopsis = '".$p_sinopsis."',
					a.isi = '".$p_desk."',
					thumb  = '".$data[thumb]."',
					gambar  = '".$data[gambar]."',
					b.tgl_modif = now()
				where a.id_berita = '".$p_id."'";
		 // echo $sql;exit;
		$dbu->qry($sql);

		
		$_SESSION['msg']="Data destinasi $p_judul Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>