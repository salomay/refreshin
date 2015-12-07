
<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();

//Get our locations from the database.

$query = "SELECT a.nama, a.pos_lat, a.pos_long , b.deskripsi FROM  ".$app[table][kota]." a left join  ".$app[table][kota_bahasa]." b on a.id=b.id_kota";

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
          echo 'name="' .$row['nama']. '" ';
          echo 'deskripsi="' .$row['deskripsi']. '" ';
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