<?php 
$dbu = new db();
$appx = new app();
$urlx = new url();
$sql = "SELECT a.id, a.judul, a.tgl_post, b.username, FROM ".$app[table][forum]." as a LEFT JOIN ".$app[table][pengguna ]." as b ON (a.id_user = b.id) WHERE a.tipe LIKE '$p_id' AND a.hot ='ya' ORDER BY a.tgl_post DESC LIMIT 5 ";
	//echo $sql;exit;
	 $dbu->query($sql,$rforum,$nof);
?>
<div class="thread">
	<h1 class="main_title" style="padding: 15px 15px 7px;">HOT THREAD<span class="border"></span></h1>
	<?php 
		if($_SESSION[member]!=""){
	?>
	<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/articles/" ?>" class="shortcut_addthr">+ Add Thread</a>
	<?php } ?>
	<ul>
		<?php 
		if($nof <= 0){
		?>
			<li>
				<span>No HOT Thread Found</span>
			</li>
		<?php
		}else{
			while ($dforum=$dbu->fetch($rforum)) {
				$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$sBahasa."'")."/".$urlx->shortLink($dforum[username])."/";
			?>
				<li>
					<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='41' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dforum[judul])."/" ?>"><span><?php echo $dforum[judul]; ?></span></a>
					<p>oleh <a href="<?php echo $linkAva; ?>"><i><?php echo $dforum[username]; ?></i></p></a>
				</li>	
			<?php
			}
		}
		$pid = substr($p_id, 0,strlen($p_id)-1);
		?>
	</ul>
	<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/".$pid."/";?>" class="explore">VIEW MORE</a>
</div>