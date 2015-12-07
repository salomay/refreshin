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
	$admlib->set_aktip("communitycms_master");
    $page = $_REQUEST['page']; // get the requested page
	$paging = 50; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction
	$where = "WHERE 1=1";
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
	$total = $dbu->count_record("id", "komunitas", $where);
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
	$sql = "SELECT a.*, b.username FROM ".$app['table']["komunitas"]." a LEFT JOIN ".$app['table']["pengguna"]." b ON(a.id_user=b.id) $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table']["komunitas"]." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data komunitas yang terpilih berhasil dihapus ....";
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
		$sql = "DELETE FROM ".$app['table']["komunitas"]." WHERE id = '".$p_id."'";
		//echo $sql;exit;
		$dbu->qry($sql);
		$_SESSION['msg']="data komunitas berhasil dihapus ....";
		$_SESSION['alt']="warning";
		header("location: index.php?act=browse");
	}
	exit;
}

/*******************************************************************************
* Action : set_status
*******************************************************************************/
if ($act == "set_status"){
	$admlib->validate('community_edit');
	$dbu->set_status("komunitas", "id", $p_id, $status, "status");
	$_SESSION['msg'] = "status komunitas \"".$dbu->lookup("nama","komunitas","id='".$p_id."'")."\" berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
}

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"){
	$admlib->validate('community_view');
	$admlib->set_aktip("communitycms_master");
	$formix->init();
	$page = $dbu->get_record("komunitas", "id", $p_id);
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
		$formix->validate('', 'p_nama,p_lokasi');

		if($p_nama == ""){
			$_SESSION['msg'] .= "Masukan Nama Komunitas <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_lokasi == ""){
			$_SESSION['msg'] .= "Masukan Lokasi Komunitas didalam destinasi terpilih <br/>";
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

		$start = explode("/",$p_start);
		$start_date = $start[2]."-".$start[1]."-".$start[0];

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
				$imgx->save($app['data_path']."/komunitas/logo/logo_".$id.".png");				
				$data['logo'] = "logo_".$id.".png";
			}catch (Exception $e) {
				$_SESSION['msg'] = "logo komunitas $p_nama gagal di unggah/upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}

		$appx->mq_encode('p_akseskses,p_harga');
		$sql = "insert into ".$app['table']["komunitas"]." (id_user, id_kota, nama, logo, lokasi,tgl_terbentuk, tgl_post) values ('".$app[me][id]."','$p_destinasi','$p_nama','".$data['logo']."','$p_lokasi','".$start_date."',now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "Komunitas $p_nama Berhasil ditambahkan ";
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
	$admlib->validate('community_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("komunitas", "id = '".$p_id."'");
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_nama,p_lokasi');
		
		if($p_nama == ""){
			$_SESSION['msg'] .= "Masukan Nama Komunitas <br/>";
			$_SESSION['alt'] = "warning";
		}

		if ($p_lokasi == ""){
			$_SESSION['msg'] .= "Masukan Lokasi Komunitas didalam destinasi terpilih <br/>";
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

		$start = explode("/",$p_start);
		$start_date = $start[2]."-".$start[1]."-".$start[0];

		$data[logo]= $dbu->lookup("logo","komunitas","id='".$p_id."'");
			if ($p_logo_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/komunitas/logo/$data[logo]");	
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
					
					$imgx->thumbnail(320, 320);
					$imgx->save($app['data_path']."/komunitas/logo/logo_".$id.".png");				
					$data['logo']= "logo_".$id.".png";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "logo komunitas $p_nama gagal di unggah/upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}

		$appx->mq_encode('p_nama,p_lokasi');
		$sql = "update ".$app['table']["komunitas"]."
				set id_kota = '$p_destinasi', 
				    id_user = '".$app[me][id]."',
				    nama = '".$p_nama."',
				    lokasi = '".$p_lokasi."',
				    logo ='".$data[logo]."',
				    tgl_modif =now()    
				where id = '$p_id'";
		// echo $sql;exit;
		$dbu->qry($sql);

		$_SESSION['msg']="Data omunitas Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>