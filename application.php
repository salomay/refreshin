<?php
session_cache_limiter('private, must revalidate');
session_start();
//ini_set('allow_url_fopen', 'on');
ini_set('memory_limit','8000M');
ini_set('max_execution_time','102400');
ini_set('upload_max_filesize','7500M');
ini_set('file_uploads','1');
ini_set('display_errors', true);
## VAR #########################################################################
//register global
if (!ini_get('register_globals')) {
	while(list($key,$value)=each($_FILES)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_ENV)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_GET)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_POST)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_COOKIE)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_SERVER)) $GLOBALS[$key]=$value;
	while(list($key,$value)=@each($_SESSION)) $GLOBALS[$key]=$value;
	foreach($_FILES as $key => $value){
		$GLOBALS[$key]=$_FILES[$key]['tmp_name'];
		foreach($value as $ext => $value2){
			$key2 = $key . '_' . $ext;
			$GLOBALS[$key2] = $value2;
		}
	}
}
## PATH ##
$app['www'] = "";
$app['path'] = $_SERVER["DOCUMENT_ROOT"].$app['www'];
$app['http'] = "http://".$_SERVER["HTTP_HOST"].$app['www'];
$app['http_base'] = 'http:://localhost';
$app['webmin'] = $app['www']."/traveler_friend";
$app['lib_cms'] = $app['webmin']."/lib";
$app['pwebmin'] = $app['path']."/traveler_friend";
$app['lib_path'] = $app['path']."/lib";
$app['lib_www'] = $app['www']."/lib";
$app['lib_http'] = $app['http']."/lib";
$app['data_www'] = $app['www']."/point_of_view";
$app['data_path'] = $app['path']."/point_of_view";
$app['data_http'] = $app['http']."/point_of_view";
$app['css_www'] = $app['www']."/css";
$app['css_cms'] = $app['webmin']."/css";

$pathfiles = $app['www']."/css/images/";
$path_files = $app['path']."/css/images/";
$url_files = $app['http']."/css/images/";
//echo "$act";

## DATABASE ##
$app['db']['server'] = "localhost";
$app['db']['name'] = "refresh2_x3m";
$app['db']['username'] = "root";
$app['db']['password'] = "";
$app['db']['connection'] = 0;


## TABLES & PRIVILEGE ##########################################################
include $app['path']."/tables.php";
include $app['path']."/privilege.php";

## CORE LIBRARY ################################################################
include $app['path']."/lib/config.php";
include $app['path']."/lib/url.php";
/*include $app['path']."/lib/stats.php";*/
include $app['path']."/lib/db.php";
include $app['path']."/lib/app.php";
include $app['path']."/lib/simpleimage.php";

## ERROR SET ###############
$app["devmode"]=true;
if ($app["devmode"]==true) {
     ini_set('display_errors', true); /*change to false in production mode */
     /* error_reporting(E_ALL); */
     error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
 } else { 
     error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
 }
include $app['path']."/lib/securimg/securimage.php";
//include $app['path']."/lib/twiit/TweetPHP.php";
$imgSec = new Securimage();
//$TweetPHP = new TweetPHP();
?>