<?php 
$dbu = new db();
$appx = new app();
$urlx = new url();
if($id_related!=""){ // AND $dnews[id_reff]!=0
	$sql = "SELECT a.id, a.thumb , b.nama, e.nama as negara  FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff) LEFT JOIN ".$app[table][kota]." as c ON (a.id_kota = c.id) LEFT JOIN ".$app[table][provinsi]." as d ON (c.id_provinsi = d.id) LEFT JOIN ".$app[table][negara]." as e ON (d.id_negara = e.id) WHERE a.id='".$id_related."' OR a.id_parent ='".$id_related."' ORDER BY a.tgl_post DESC LIMIT 5 ";
	//echo $sql;exit;
	$dbu->query($sql,$rsnews,$hit_related);
}
if($hit_related > 0){
?>
<div class="near_place">
<h1 class="main_title" style="padding: 15px 15px 7px;">NEARBY PLACE<span class="border"></span></h1>
<ul>
<?php 
	while ($dtnews = $dbu->fetch($rsnews)) {
		$dtnews[thumb] = $appx->cekFile('/destinasi/thumb/',$dtnews[thumb],'default.jpg');
		$dtnews[thumb] = $app[data_www]."/destinasi/thumb/".$dtnews[thumb];
		$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[username])."/";
	?>
		<li class="add_fix">
			<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[nama])."/" ?>">
				<div class="thumb_img"><img src="<?php echo $dtnews[thumb]; ?>"></div>
				<div class="con_near_place">
					<span><?php echo $dtnews[nama]; ?></span>
			</a>
				<?php if($_SESSION[member]!=""){ ?>
				<a href="#"><p><i>179 Friends </i></a>has been here</p>
				<?php } ?>
			</div>
			<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[nama])."/" ?>" class="explore" style="float:left;padding: 0 10px;">EXPLORE MORE</a>
		</li>

	<?php
	}
?>
</ul>
</div>
<?php } ?>