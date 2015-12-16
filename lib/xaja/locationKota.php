
<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();
$urlx = new url();

//Get our locations from the database.

$query = "SELECT a.nama as kota , c.nama as provinsi, a.pos_lat, a.pos_long , b.deskripsi FROM  ".$app[table][kota]." a left join ".$app[table][kota_bahasa]." b on a.id=b.id_kota join ".$app[table][provinsi]." c on a.id_provinsi=c.id";

$dbu->query($query,$rnear,$hit_near);
$dnear="";
if($hit_near>0){

	 // Header File XML
     header("Content-type: text/xml");
 
     // Parent node XML
     echo '<markers>';
 
	while($row = $dbu->fetch($rnear)){
		   // Menambahkan ke node dokumen XML
          echo '<marker ';
          echo 'name="' .$row['kota']. '" ';
          echo 'deskripsi="' .$row['deskripsi']. '" ';
          echo 'button="'.$app[http]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/id_".$row['kota']."_".$urlx->shortLink($row['provinsi'])."/".'" ';
          echo 'lat="' . $row['pos_lat'] . '" ';
          echo 'lng="' . $row['pos_long'] . '" ';
          echo '/>';
	}

	  echo '</markers>';
}
// Akhir File XML (tag penutup node)
     function parseToXML($htmlStr)
     {
          $xmlStr=htmlentities($xmlStr);
   
          return $xmlStr;
     }
 
?>