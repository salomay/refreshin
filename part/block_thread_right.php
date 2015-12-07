<?php 
$dbu = new db();
$appx = new app();
$urlx = new url();
if($id_related!=""){ // AND $dnews[id_reff]!=0
	$sql = "SELECT a.id, a.judul, b.username  FROM ".$app[table][forum]." as a LEFT JOIN ".$app[table][pengguna]." as b ON (a.id_user= b.id) WHERE a.id_destinasi='".$id_related."'  ORDER BY a.tgl_post DESC LIMIT 5 ";
	//echo $sql;exit;
	$dbu->query($sql,$rsnews,$hit_related);
}
if($hit_related > 0){
?>
<div class="thread">
<h1 class="main_title" style="padding: 15px 15px 7px;">THREAD<span class="border"></span></h1>
<?php if($_SESSION[member][id]!=""){ ?>
<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='14' and id_bahasa='".$_SESSION[bhs]."'")."/" ?>" class="shortcut_addthr">+ Add Thread</a>
<?php } ?>
<?php 
	while ($dtnews = $dbu->fetch($rsnews)) {
		$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[username])."/";
	?>
		<li>
			<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='41' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtnews[judul])."/" ?>"><span><?php echo $dtnews[judul]; ?></span></a>
			<p>oleh <a href="<?php echo $linkAva; ?>"><i><?php echo $dtnews[username]; ?></i></p></a>
		</li>
	<?php
	}
?>
</ul>
</div>
<?php } ?>