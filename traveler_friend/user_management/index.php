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
$admlib->validate("pgn");

/*******************************************************************************
* Action : browse
*******************************************************************************/
if ($act == "browse"){
	$admlib->set_aktip("usercms_mana");
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
	$total = $dbu->count_record("id", "pengguna", $where);
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
	$sql = "SELECT * FROM ".$app['table']['pengguna']." a $where $sort $limit";
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
		$sql = "DELETE FROM ".$app['table']['pengguna']." WHERE `id` IN (".$admlib->item_delete($_REQUEST[item]).")";
		$dbu->qry($sql);
		$_SESSION['msg']="data pengguna yang terpilih berhasil dihapus ....";
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
		$sql = "DELETE FROM ".$app['table']['pengguna']." WHERE id = '".$p_id."'";
		//echo $sql;exit;
		$dbu->qry($sql);
		$_SESSION['msg']="data pengguna berhasil dihapus ....";
		$_SESSION['alt']="warning";
		header("location: index.php?act=browse");
	}
	exit;
}

/*******************************************************************************
* Action : set_status
*******************************************************************************/
if ($act == "set_status"):
	$dbu->set_status("pengguna", "id", $p_id, $status, "status", "id");
	$_SESSION['msg'] = "status user berhasil di update ....";
	$_SESSION['alt'] = "info";
	header("location: ".$urlx->get_referer());
endif;

/*******************************************************************************
* Action : view
*******************************************************************************/
if ($act == "view"):
	$admlib->set_aktip("usercms_mana");
	$formix->init();
	$page = $dbu->get_record("pengguna", "id", $p_id);
	$form = $page;
	$formix->populate($form);
	include "tmp_view.php";
	exit;
endif;


/*******************************************************************************
* Action : add
*******************************************************************************/
if ($act == "add"){
	$admlib->set_aktip("usercms_mana");
	$admlib->validate('pgn_del,pgn_add');
	$formix->init();
	if ($step == 1){
		$formix->populate($form);
	    include "tmp_add.php";
	exit;
	}

    if ($step ==2){
		$formix->serialize_form();
		$formix->validate('', 'p_username,p_password,p_name');
		// $formix->validate('email', "p_email");

		## check duplicate username 
		$row = $dbu->get_record('pengguna', 'username', $p_username);
		if ($row[username]){
			$_SESSION['msg'] = "Username Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}
		
		$regex = filter_var($p_email, FILTER_VALIDATE_EMAIL);
		if ($regex == "" ) {  
			$_SESSION['msg'] .= "Email Salah <br/>";
			$_SESSION['alt'] = "warning"; 
		}
		
		if ($p_password != $p_retype_password){
			$_SESSION['msg'] .= "Konfirmasi Password Salah <br/>";
			$_SESSION['alt'] = "warning";
		}

		if (!@count($p_cms)){
			$_SESSION['msg'] .= "Tentukan Hak Akses User <br/>";
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
		
		
		while(list($k, $v) = each($p_cms)):
			//print_r($k); 
			//echo"<br/>";
			//print_r($v);
			//echo"<br/>";
			$cms[] = implode("-",$v);
			//print_r($application);
		endwhile;
		
		
		$application = implode("-", $cms);
		//print_r($application);exit;
		$passwordhash = md5(serialize($p_password));
		$id = rand(1, 100).date("dmYHis");	
		
		#foto user--------------------------------------
		if ($p_thumb_size > 0){
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
				$imgx->thumbnail(80, 80);
				$imgx->save($app['data_path']."/pengguna/avatar/avatar_".$id.".png");				
				$file = "avatar_".$id.".png";
				$data['thumb'] = $file;
			}catch (Exception $e) {
				$_SESSION['msg'] = "Avatar Failed To Upload ....";
				$_SESSION['alt'] = "warning";
				header("location: ".$urlx->get_referer());
				exit;
			}			
		}
		
		$appx->mq_encode('p_name,p_username');
		$sql = "insert into ".$app['table']['pengguna']."
				(id,nama, username, password, aplikasi, email,avatar,tipe,dibuat_oleh, tgl_post) values
				('".$id."','".$p_name."', '".$p_username."', '".$passwordhash."', '".$application."', '".$p_email."','".$data[thumb]."','".$p_tipe."', '".$app['me']['id']."', now())";
		//echo $sql;exit;
		$dbu->qry($sql);
		
		
		$_SESSION['msg'] = "User Baru Berhasil Di Ditambahkan ....";
		$_SESSION['alt'] = "info";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

/*******************************************************************************
* Action : update
*******************************************************************************/
if ($act == "update"){
	$admlib->set_aktip("usercms_mana");
	$admlib->validate('pgn_del,pgn_add,pgn_edit');
	$formix->init();
	if ($step == "1"){
		$page = $dbu->get_record("pengguna", "id", $p_id);
		$form = $page;
		$formix->populate($form);
		include "tmp_update.php";
		exit;
	}

	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_username,p_name');
		// $formix->validate('email', "p_email");

		## check duplicate username 
		$data = $dbu->get_record("pengguna", "id", $p_id);
		$row = $dbu->get_record('pengguna', 'username', $p_username);
		$_SESSION['msg']="";
		if ($row[username]!="" && $row[username]!= $data[username]){
			$_SESSION['msg'] = "Username Sudah Terpakai <br/>";
			$_SESSION['alt'] = "warning";
		}
		$regex = filter_var($p_email, FILTER_VALIDATE_EMAIL);
		if ($regex == "" ) {  
			$_SESSION['msg'] .= "Email Salah <br/>";
			$_SESSION['alt'] = "warning"; 
		}
		
		if (!@count($p_cms)){
			$_SESSION['msg'] .= "Tentukan Hak Akses User <br/>";
			$_SESSION['alt'] = "warning";
		}else{
			while(list($k, $v) = each($p_cms)){
			// print_r($k); print_r($v);
				$applican[] = implode("-",$v);
			// print_r($application);
			}
			$application = implode("-", $applican);	
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
			if ($p_thumb_size){
				$id = rand(1, 100).date("dmYHis");
				
				@unlink($app['data_path']."/pengguna/avatar/$data[avatar]");	
				$data['avatar'] = "";
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
					
					$imgx->thumbnail(80, 80);
					$imgx->save($app['data_path']."/pengguna/avatar/avatar_".$id.".jpg");				
					$data['avatar']= "avatar_".$id.".jpg";
					
				}catch (Exception $e) {
					$_SESSION['msg'] = "Avatar Failed To Upload ....";
					$_SESSION['alt'] = "warning";
					header("location: ".$urlx->get_referer());
					exit;
				}
						
			}
		
		if ($p_id == $app['me']['id']){
			$app['me']['id'] = $p_username;
		}

		$appx->mq_encode('p_username,p_name');
		$sql = "update ".$app['table']['pengguna']."
				set nama = '$p_name', 
				    aplikasi = '$application',
				    username = '$p_username',
					email = '$p_email',
					avatar  = '$data[avatar]',
					dibuat_oleh = '".$app['me']['id']."',
					tgl_modif = now()
				where id = '$p_id'";
		 // echo $sql;exit;
		$dbu->qry($sql);
		## am i updated ? if yes then update the session
		if ($p_id == $app['me']['id']){
			$user = $dbu->get_record("pengguna", "id", $p_id);
			$_SESSION['adminsession'] = $appx->serialize64($user);
		}
		
		$_SESSION['msg']="Data User Berhasil Di Update ....";
		$_SESSION['alt']="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>