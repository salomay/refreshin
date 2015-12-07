<?php 
class mapy{

	function mapMarker(){
		global $app;

		$appx = new app();
		$dbu = new db();
		$urlx = new url();
		$radius = '3963.0';
		$sql = sprintf("SELECT a.id, a.website, b.alamat, a.pos_lat, a.pos_long, ( 3959 * acos( cos( radians('%s') ) * cos( radians( a.pos_lat ) ) * cos( radians( a.pos_long ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( a.pos_lat ) ) ) ) AS distance FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON(a.id_reff = b.id_reff) HAVING distance < '%s' ORDER BY distance ",
  mysqli_real_escape_string($center_lat),
  mysqli_real_escape_string($center_lng),
  mysqli_real_escape_string($center_lat),
  mysqli_real_escape_string($radius));
		return $sql;
	}
}
 ?>
