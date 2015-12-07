<?php
	include "../../application.php";
	$appx= new app();
	$dbu = new db();
	$dbu->connect();
	if($_POST['kueri']){$kueri = $_POST['kueri'];
	$kueri = "SELECT  a.id, b.nama FROM destinasi as a LEFT JOIN destinasi_bahasa as b ON (a.id_reff=b.id_reff) where a.status = 'aktif' and b.id_bahasa='id' and a.id_kota ='".$kueri."' order by nama";
	$data=$dbu->negprovkot($kueri);
	unset($dbu);
	unset($appx);
	echo $data;
}
?>