<?php
$tampil = new usrlib();
echo $tampil->tampilkan_doctype('main');
echo $tampil->tampilkan_header('main');
echo $tampil->tampilkan_menu('main');
$dbu = new db();
$appx = new app();
$urlx = new url();
?>
<body >
	<div class="wrapall">
<div class="wrapcontent">
			<div class="content add_fix">
				<div class="content_category add_fix">
					<div class="tagline">
						<h1>What will</h1>
						<h2>Refreshin</h2>
						<h3>you</h3>
					</div>
					<ul class="destination_category">
					<?php
						while($deskat=$dbu->fetch($rskat)){
						?>
						<li>
							<a href="<?php
                            $jumlah= $dbu->count_record("id",$app[table][destinasi],"where id_kat in (select id from destinasi_kategori where kategori='".$deskat[kategori]."')");
							
							if($jumlah > 0)
							{
								echo $app["www"]."/".$dbu->lookup('nama','action',"action='22'")."/".$urlx->shortLink($deskat[kategori])."/";
							}else{
								echo "javascript:valid()";
							}
							
							
							?>">
								<div class="title">
									<span class="border"></span>
									<b><?php echo $deskat[kategori]; ?></b>
								</div>
								<div class="ico_cat"><img src="<?php echo $app["data_www"];?>/destinasi_kategori/icon/<?php echo $deskat["icon"] ?>"></div>
								<img src="<?php echo $app["data_www"];?>/destinasi_kategori/thumb/<?php echo $deskat["thumb"] ?>">
							</a>
						</li>
						<?php
						}
					?>
					</ul>
					<img class="bg_destination_category" src="<?php echo $app["css_www"];?>/img/bg-destination-category.jpg">
				</div><!-- /.content_category -->
				<div class="latest_update add_fix">
					<h1>Latest Update<span class="border"></span></h1>
					<ul class="update_list add_fix">
						<?php
							while($rsnew=$dbu->fetch($rstip)){
								$newskat= $dbu->get_record('berita_kategori',"id='".$rsnew[id_kat]."' and id_bahasa='id'");
								$newsbhs= $dbu->get_record('berita_bahasa',"id_berita='".$rsnew[id]."' and id_bahasa='id'");
							?>
							<li>
							<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='51'")."/".$urlx->shortLink($newsbhs[judul])."_".$rsnew[id]."/";?>">

								<div class="img_box">
									<div class="icon"><img src="<?php echo $app["data_www"];?>/berita/icon/<?php echo $newskat[icon]; ?>"></div>
									<img src="<?php echo $app["data_www"];?>/berita/thumb/<?php echo $newsbhs[thumb]; ?>">
								</div>
								<div class="text">
									<h1><?php echo strtoupper($newskat[kategori]); ?></h1>
									<span class="border"></span>
									<h2><?php echo $newsbhs[judul]; ?></h2>
									<p><?php echo $newsbhs[sinopsis]; ?></p>
									<div class="post_by">oleh <i><?php echo $dbu->lookup('nama','pengguna',"id='".$rsnew[id_user]."'");?></i></div>
									<div class="info">
										<div class="date"><?php echo $appx->format_date($rsnew[tgl_post],'id','N'); ?></div>
										<div class="view"><?php echo $appx->number_to_K($rsnew[hit]); ?></div>
									</div>
								</div>
							</a>
						</li>
							<?php
							$hit++;
						}
						?>
						
					</ul>
					<div class="load_more"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='5'")."/";?>">View More</a></div>
				</div><!-- /.latest_update -->
			</div>
		</div><!-- /.wrapcontent -->
<?php
echo $tampil->tampilkan_footer('main');
?>
	</div>	
    
    
     <div class="overlay_activity"  id="viewDialog">
			<div class="pop_error">
			<div class="error_box">
            <div class="title-des">Information<img class="close" src="<?php echo $app[css_www]."/";?>img/close.png"></div>
				<div class="con_login">
					Data Not Found !! Please Select Other Category
				</div>
                </div>
			</div>
		</div> <!-- overlay_activity -->
    <script type="text/javascript">
	function valid()
	{
		 document.getElementById("viewDialog").style.display = "block";;
	}
	</script>

	
</body>
</html>