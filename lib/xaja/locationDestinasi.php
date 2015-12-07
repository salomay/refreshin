
<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();
$urlx = new url();

//Get our locations from the database.
$idkota=$_GET['idkota'];

$query = "SELECT b.nama, a.gambar ,c.kategori,pos_lat, pos_long FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff ) JOIN ".$app[table][destinasi_kategori]." as c ON (a.id_kat=c.id) WHERE  a.id_kota ='".$idkota."' AND a.status='aktif' ";
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
          echo 'gambar="' . $app[data_www]."/destinasi/gambar/".$row['gambar'] . '" ';
          echo 'kategori="' .parseToXML($row['kategori']). '" ';
          echo 'button="'.$app[http]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($row['nama'])."/".'" ';
          echo 'lat="' . $row['pos_lat'] . '" ';
          echo 'lng="' . $row['pos_long'] . '" ';
          echo '/>';
	}

	  echo '</markers>';
}

      function parseToXML($htmlStr)
     {
          $xmlStr=str_replace('<','<',$htmlStr);
          $xmlStr=str_replace('>','>',$xmlStr);
          $xmlStr=str_replace('"','"',$xmlStr);
          $xmlStr=str_replace("'","'",$xmlStr);
          $xmlStr=str_replace('&', '', $xmlStr);
          $xmlStr=str_replace(" ","",$xmlStr);
          $xmlStr=str_replace("-","",$xmlStr);
          return $xmlStr;
     }

 
?>