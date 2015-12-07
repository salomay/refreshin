<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();
if($_POST['kueri']){$kueri = $_POST['kueri'];
$data=$dbu->negprovkot($kueri);
echo $data;
}
?>