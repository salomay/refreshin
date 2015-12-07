<?php
/*******************************************************************************
* Filename : index.php
* Description : index file
*******************************************************************************/
include "application.php";


$appx= new app();
$appx->load_lib('stats', 'msg', 'form', 'nav', 'file', 'admlib', 'usrlib','mapy');
## START #######################################################################
$appx->set_default($act, 'index');
//app::set_default($step, 1);
$dbu = new db();
$dbu->connect();
$urlx = new url;
$pg_config = $dbu->get_record("konfig", "id", 1);
//unset($_SESSION[dummy]);
if($act=="logindulu"){
	if($p_kunci == "tourismprosperity"){
		$_SESSION[dummy] = $p_kunci;
		//print_r($_SESSION[dummy]);exit;
	}else{
		unset($_SESSION[dummy]);
	}
}
if($_SESSION[dummy]!=""){
//echo $act;exit;
//$_SESSION[msg]="";
if(!isset($_SESSION[member][id])||$_SESSION[member][id]==""||$_SESSION[member][id]==null){
	if(isset($_COOKIE[rahasia]) && $_COOKIE[rahasia]!="") {

		$sql ="UPDATE ".$app[table][pengguna]." SET terakhir_login = now() WHERE id='".$_COOKIE[rahasia]."'";
		$dbu->qry($sql);
		$getuser = $dbu->get_record($app[table][pengguna],"ses_id ='".$_COOKIE[rahasia]."'");
		$_SESSION[member][id]=$getuser[id];
		$_SESSION[member][uname]=$getuser[username];
		$_SESSION[member][ava]=$getuser[avatar];
	}
}

if(!$_SESSION[bhs]){
	$_SESSION[bhs]=$pg_config[id_bahasa];
}

$defaultURL = $app["www"]."/".$dbu->lookup('nama','action',"action='1' and id_bahasa ='".$_SESSION[bhs]."'")."/";

if ($act == 'traveler_friend'){ 
	//echo "$app[webmin]";exit;
	header("location:".$app["webmin"]."/index.php");
	exit;
}elseif($act == 'index'){ 

	/*******************************************************************************
	* Action : index
	*******************************************************************************/
	global $app;
	if ( $pg_config['status'] == 1 ){ 		// under construction
		//echo "FAIL";
		header("location:under.html");
	}elseif( $pg_config['status'] == 0 ){ 
		//echo "HOME";
		header("location: $app[www]/".$dbu->lookup('nama','action',"action='1' and id_bahasa='".$_SESSION[bhs]."'")."/");
	}else{// no action
	}	
    exit;
}else{ 
	if($act !=""){
		$sql="select action, nama from ".$app['table']['action']." where nama='".$act."' and id_bahasa ='".$_SESSION[bhs]."'";
		$dbu->query($sql,$rs,$nr);
		if($nr>0){
			$rs_act=$dbu->fetch($rs);
			if($rs_act["action"]==1){
			//home
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_home.php";
			    exit;
			}elseif($rs_act["action"]==2){
				//destinasi
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_destinasi.php";
			    exit;
			}elseif($rs_act["action"]==21){
				//destinasi_detil
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_destinasi_detil.php";
			    exit;
			}elseif($rs_act["action"]==22){
				//kategori destinasi
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_destinasi_kat.php";
			    exit;
			}elseif($rs_act["action"]==23){
				//nearby
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_nearby.php";
			    exit;
			}elseif($rs_act["action"]==3){
				//komunitas
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_community.php";
			    exit;
			}elseif($rs_act["action"]==31){
				//komunitas detil
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_community_detail.php";
			    exit;
			}elseif($rs_act["action"]==4){
				//thread
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_thread.php";
			    exit;
			}elseif($rs_act["action"]==41){
				//thread detail
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_thread_detail.php";
			    exit;
			}elseif($rs_act["action"]==5){
				//berita
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_news.php";
				exit;		
			}elseif($rs_act["action"]==51){
				//berita detil
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_news_detail.php";
				exit;			
			}elseif($rs_act["action"]==8){
				//profile member
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_profil.php";
				exit;			
			}elseif($rs_act["action"]==10){
				//about
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_about.php";
				exit;			
			}elseif($rs_act["action"]==11){
				//contact us
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_contact.php";
				exit;			
			}elseif($rs_act["action"]==13){
				//about
				$pageku=$rs_act["nama"];
				include "grafiti/coretan_faq.php";
				exit;		
			}else{
				header("location:".$defaultURL);
				exit;
				}
		}else{
			if($act=="login"){
			#login
				if( $dbu->anti_sql_injection($_POST['p_uname']) and $dbu->anti_sql_injection($_POST['p_pwd'])){
					$passwordhash = md5(serialize($_POST["p_pwd"]));
					$sql = "SELECT id, username, avatar FROM ".$app[table][pengguna]." WHERE username ='".$_POST[p_uname]."' AND password ='".$passwordhash."'";
					$dbu->query($sql,$rs,$nr);
					if($nr>0){
						$ses_id = session_id($uname[id]);
						$uname=$dbu->fetch($rs);
						if($_POST[p_cek]=="on"){
							$cookie_name = "rahasia";
							$cookie_value = $ses_id;
							setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
						}
						//print_r($_POST);exit;
						
						$sql ="UPDATE ".$app[table][pengguna]." SET terakhir_login = now(), ses_id ='".$ses_id."' WHERE id='".$uname[id]."'";
						//echo $sql;exit;
						$dbu->qry($sql);
						$_SESSION[member][id]=$uname[id];
						$_SESSION[member][uname]=$uname[username];
						$_SESSION[member][ava]=$uname[avatar];
						header("location:".$_POST[referer]);
					}else{
						$_SESSION[msg]="incorrect username or password ....!!";
						header("location:".$_POST[referer]);
					}
				}else{
					$_SESSION[msg]="incorrect username or password ....!!";
					header("location:".$_POST[referer]);
				}
			exit;
			}elseif($act=="logout"){
				//echo $defaultURL;exit;
				//print_r($_COOKIE);exit;
				$sql ="UPDATE ".$app[table][pengguna]." SET terakhir_login = now(), ses_id='' WHERE id='".$_SESSION[member][id]."'";
				$dbu->qry($sql);		
				unset($_SESSION[member]);
				setcookie("rahasia", "", time() - 3600);
				header("location:".$defaultURL);
				exit;
			}elseif($act=="member_register"){
				//echo $email_reg;exit;
				$_SESSION[msg]="";
				$hitErr =1;

				#cek username
				if($nama_reg==""){
					$_SESSION[msg] .= "$hitErr . username can't be empty !<br />";
					 $hitErr++;
				}else{
					$ada = $dbu->lookup("id","pengguna","username ='".$nama_reg."'");
					if($ada!=""){
						$_SESSION[msg] .= "$hitErr . username already used by other !<br />";
					 	$hitErr++;
					}
				}

				#cek password
				if($pwd_reg==""){
					$_SESSION[msg] .= "$hitErr . Insert password !<br />";
					 $hitErr++;
				}elseif(strlen($pwd_reg)<6){
				  $_SESSION[msg] .= "$hitErr . Password minimal 6 alphanumric char !<br />";
					 $hitErr++;
				}elseif($pwd_reg!=$cpwd_reg){
				  $_SESSION[msg] .= "$hitErr . Password Confirmation doesnt Match !<br />";
					 $hitErr++;
				}


				#cek email
				if($email_reg==""){
					$_SESSION[msg] .= "$hitErr . Insert your email address!<br />";
					 $hitErr++;
				}elseif(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email_reg)) {
					$_SESSION[msg] .= "$hitErr . format email tidak valid !<br />";
					$hitErr++;
				}elseif(preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email_reg)) {
					$ada = $dbu->count_record("id","pengguna","WHERE email='".$email_reg."'");
					if($ada>0){
						$_SESSION[msg] .= "$hitErr . email ini sudah terdaftar sebagai member lain !<br />";
						$hitErr++;
					}
				}

				#cek captcha
				//echo $captcha;exit;
				if ($imgSec->check($captcha) == false || $captcha=="") {
			        $_SESSION[msg] .= "$hitErr . Wrong Captcha (Secutiry Text) !<br />";
					 $hitErr++;
				}
				
				if($_SESSION[msg]!=""){
					#gagal regis
					header("location:".$referer);
				}else{
					#proses regis
					$passwordhash = md5(serialize($pwd_reg));
					$sql="INSERT INTO ".$app[table][pengguna]."(username,password,email,tgl_post,terakhir_login) VALUES('".$nama_reg."','".$passwordhash."','".$email_reg."',now(),now())";
					$dbu->qry($sql);
					//echo $sql;

					#verification mail sent
					$subject = 'refreshin.co.id verification email';
					$to = $email_reg;
					$headers = "From: " . strip_tags("webmaster@bisnisokey.com") . "\r\n";
					//$headers .= "Reply-To: ". strip_tags($p_email) . "\r\n";
					//$headers .= "CC: susan@example.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					$message = '<html><body>';
					$message .= '<img src="'.$app["http"]."/".$app["data_www"]."/konfig/logo/".$pg_config[logo].'" alt="refreshin.co.id" title="refreshin.co.id" />';
					$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
					$message .= "<tr style='background: #eee;'><td><strong>username : </strong> </td><td>" . strip_tags($nama_reg) . "</td></tr>";
					$message .= "<tr><td><strong>email : </strong> </td><td>" . strip_tags($email_reg) . "</td></tr>";
					$message .= "<tr><td><strong></strong>Password:</td><td>" . strip_tags($pwd_reg) . "</td></tr>";
					$message .= '<tr><td><strong>click this link to verify:</strong> </td><td><a href="' . $app["http"]."/member_verify/".$urlx->shortLink($nama_reg)."/". '" target="_blank">VERIVY</a></td></tr>';
					$message .= '<tr><td><strong>click this link if you never register to our website</strong> </td><td><a href="' . $app["http"]."/member_unreg/".$urlx->shortLink($nama_reg)."/". '" target="_blank">UNREG</a></td></tr>';
					$message .= "<tr><td><strong>&nbsp;</strong> </td><td>" . htmlentities("one more step to be a family member of refreshin.co.id") . "</td></tr>";
					$message .= "</table>";
					$message .= "</body></html>";
					//echo $message;exit;
					if (mail($to, $subject, $message, $headers)) {
						$_SESSION["MSGX"]="Email Verifikasi telah Dikirim ke Email Yang Anda Daftarkan <br /> silahkan periksa email anda <br /><br /> note: jika tidak ada coba periksa di folder spam";
						echo "<script type='text/javascript'>
						window.location='".$app["www"]."/home/';			
					</script>";
					} else {
						$_SESSION["MSGX"]="maaf email verifikasi gagal terkirim !";
						echo "<script type='text/javascript'>
						window.location='".$app["www"]."/home/';		
						</script>";
					}
				exit;	
				}
			}elseif($act =='desfilter'){
					//echo "masuk sini";exit;
				$rs_act["action"]='desfilter';
				$pageku = $rs_act["action"];
				include "grafiti/coretan_destinasi.php";
			    exit;	
			}elseif($act=="add_thread_article"){
				$_SESSION[msg]="";
				$hit=1;
				$iddest="";
				#-- cek judul--
				if($p_judul !=""){
					$cek = $dbu->lookup("judul",$app[table][forum]," judul ='".$p_judul."'");
					if($cek!=""){
						$_SESSION[msg] = $hit.". The Title That You Used For New Forum thread is already used";
						$hit++;
					}
				}else{
					$_SESSION[msg] = $hit.". Thread Title must be filled ...";
						$hit++;
				}

				#cek destinasi
				if($p_dest !=""){
					$cek = $dbu->lookup("id_reff",$app[table][destinasi_bahasa]," nama ='".$p_dest."'");
					if($cek==""){
						$_SESSION[msg] = $hit.". The Destination Name you enter not yet registered on our database";
						$hit++;
					}else
					{
						$iddest = $dbu->lookup('id',$app[table][destinasi],"id_reff = '".$cek."'");
					}
				}else{
					$_SESSION[msg] = $hit.". You Must pick one of our destination ...";
					$hit++;
				}

				# cek tipe article
				if($p_tipe ==""){
					$_SESSION[msg] = $hit.". You Must pick the type of this article you want to write ...";
					$hit++;
				}

				# cek tipe article
				if(strlen($p_content)<50){
					$_SESSION[msg] = $hit.". You Must wrote more than 50 char for the content";
					$hit++;
				}

				#cek captcha
				//echo $captcha;exit;
				if ($imgSec->check($captchax) == false || $captchax=="") {
			        $_SESSION[msg] .= "$hitErr . Wrong Captcha (Secutiry Text) !<br />";
					 $hitErr++;
				}


				if($_SESSION[msg]==""){
					$id = rand(1, 100).date("dmYHis");
					$sql ="INSERT INTO ".$app[table][forum]." (id,id_destinasi,id_user,judul,isi,tipe,tgl_post) VALUES('".$id."','".$iddest."','".$_SESSION[member][id]."','".$p_judul."','".$p_content."','".$p_tipe."',now())";
					echo $sql;exit;
					$dbu->qry($sql);

				}else{
					header("location:".$referer);
				}

			}else{
				header("location:".$defaultURL);
				exit;
			}
		}
	}

	header("location:".$defaultURL);
	exit;
}
}else{
	include "grafiti/logindulu.php";
}
?>