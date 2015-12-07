<?php 
$dbu = new db();
$appx = new app();
$urlx = new url();
if($id_related!=""){ // AND $dnews[id_reff]!=0

		$sql = "SELECT a.id, b.username , c.judul, c.thumb  FROM ".$app[table][berita]." as a LEFT JOIN ".$app[table][pengguna]." as b ON (a.id_user = b.id) LEFT JOIN ".$app[table][berita_bahasa]." as c ON (c.id_berita = a.id) WHERE a.id_reff='".$id_related."' AND a.ket_id ='".$tabel."' AND a.id <> '".$idnya."' ORDER BY a.tgl_post DESC LIMIT 5 ";
		//echo $sql;exit;
		$dbu->query($sql,$rsnews,$hit_related);

}
if($hit_related > 0){
?>

<div class="thread related_news">
<h1 class="main_title" style="padding: 15px 15px 7px;">RELATED NEWS<span class="border"></span></h1>
<ul>
<?php 
	while ($dtnews = $dbu->fetch($rsnews)) {
		$dtnews[thumb] = $appx->cekFile('/berita/thumb/',$dtnews[thumb],'default.jpg');
		$dtnews[thumb] = $app[data_www]."/berita/thumb/".$dtnews[thumb];
		$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[username])."/";
	?>
		<li>
			<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='51'")."/".$urlx->shortLink($dtnews[judul])."_".$dtnews[id]."/";?>">
				<div class="thumb_img"><img src="<?php echo $dtnews[thumb]; ?>" width="97" height="84"></div>
				<span><?php echo $dtnews[judul]; ?></span>
			</a>
			<p>oleh <a href="<?php echo $linkAva; ?>"><i><?php echo $dtnews[username]; ?></i></p></a>
		</li>
	<?php
	}
?>
</ul>
</div>
<?php } ?>