<?php
include "../../application.php";
$appx = new app();
$dbu = new db();
$appx->load_lib('url', 'msg', 'form', 'file','nav', 'admlib', 'lang.eng');
$formix = new form();
$admlib = new admlib();
$msgx = new msg();
$urlx = new url();
$filex = new file();

$appx->set_default($act, 'update');
$appx->set_default($step, 1);
$dbu->connect();
$admlib->validate("sett");

/*******************************************************************************
* Action : change
*******************************************************************************/
if ($act == "update"){
	$admlib->validate('sett_edit,sett_add');
	$formix->init();
	if ($step == "1"){
	$admlib->set_aktip("sett_configbhs");
		$config = $dbu->get_record("konfig", "id", 1);
		$form = $config;
		$formix->populate($form);
		include "tmp_config.php";
		exit;
	}
	if ($step == "2"){
		$formix->serialize_form();
		$formix->validate('', 'p_judul,p_judul_cms,p_domain');
		if ($formix->is_error()){
			$msgx->build_msg();
			header("location: index.php?act=update&error=1&referer=".$urlx->get_referer());
			exit;
		}		
		$data = $dbu->get_record("konfig", "id", 1);
		$id = rand(1, 999).date("dmYHis");
		$imgx = new SimpleImage();
		if ($p_logo_cms_size > 0){
								
				@unlink($app['data_path']."/konfig/logo/$data[logo_cms]");	
				$data['logo_cms'] = "";
				
				try{
					$src_img = $_FILES["p_logo_cms"]['tmp_name'];
										
					## THUMB ###############
					$imgx->load($src_img);
					
					$imgx->save($app['data_path']."/konfig/logo/logo_cms_".$id.".png");				
					$data['logo_cms']= "logo_cms_".$id.".png";
					
					
				}catch (Exception $e) {
					echo '<span style="color: red;">'.$e->getMessage().'</span>';
				}
		}			
		if ($p_logo_web_size > 0){
		
			@unlink($app['data_path']."/konfig/logo/$data[logo_web]");	
				$data['logo_web'] = "";
				
				try{
					$src_img = $_FILES["p_logo_web"]['tmp_name'];
					
					## THUMB ###############
					$imgx->load($src_img);
					$imgx->save($app['data_path']."/konfig/logo/logo_web_".$id.".png");				
					$data['logo_web']= "logo_web_".$id.".png";
					
					
				}catch (Exception $e) {
					echo '<span style="color: red;">'.$e->getMessage().'</span>';
				}
			
		}
		if ($p_favico_size > 0){
				@unlink($app['data_path']."/konfig/logo/$data[favico]");	
				$data['favico'] = "";
				
				try{
					$data['favico']=$filex->save_file_orig('p_favico',$app['data_path'].'/konfig/logo');
										
				}catch (Exception $e) {
					echo '<span style="color: red;">'.$e->getMessage().'</span>';
				}
			
		}
		
		$sql = "update ".$app[table][konfig]."
				set judul_website = '".$p_judul."',
					status_web = '".$p_status_web."',
					email = '".$p_email."',
					judul_cms = '".$p_judul_cms."',
					domain_name = '".$p_domain."',
					facebook = '".$p_fb."',					
					twitter = '".$p_twit."',
					google_apis ='".$p_google_api."',
					gapisensor ='".$p_gapi."',
					logo_cms = '".$data[logo_cms]."',
					logo_web = '".$data[logo_web]."',
					favico = '".$data[favico]."',
					status ='".$p_status."',
					tgl_modif = now()
				where id = '1'";
		 //print_r($sql);
		/*fb_admin_id = '".$p_fb_admin_id."',
		fb_app_id = '".$p_fb_app_id."',
		fb_app_secret = '".$p_fb_app_secret."',
		fb_acc_token = '".$p_fb_acc_token."',
		fb_page_id = '".$p_fb_page_id."',
		twi_scr_name = '".$p_twi_scr_name."',
		twi_api_url = '".$p_twi_api_url."',
		twi_acc_token = '".$p_twi_acc_token."',
		twi_acc_token_secret = '".$p_twi_acc_token_secret."',
		twi_csr_key = '".$p_twi_csr_key."',
		twi_csr_secret = '".$p_twi_csr_secret."',
		google_plus = '".$p_gplus."',
		google_apis = '".$p_gooapis."',*/	
		//exit;
		$dbu->qry($sql);
		$_SESSION[msg]="Data Konfigurasi web berhasil di update .....";
		$_SESSION[alt]="success";
		header("location: ".$urlx->get_referer());
		exit;
	}
}

?>