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
			<div class="content add_fix news">
				<div class="head_nf">
					<ul>
						<li <?php echo ($tabnya ==0)? 'class="active"':"" ; ?>><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='5' and id_bahasa='".$_SESSION[bhs]."'")."/all/";?>">ALL</a></li>
						<?php 
						while($dtab = $dbu->fetch($tabKat)){
							$hitTab = $dbu->count_record("id",$app[table][berita]," where id_kat ='".$dtab[id]."'");
							if($hitTab>0){
								?>
								<li <?php echo ($tabnya ==$dtab[id])? 'class="active"':"" ; ?>><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='5' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dtab[kategori])."/";?>"><?php echo strtoupper($dtab[kategori]); ?></a></li>
								<?php
							}
						}
						?>
					</ul>
					<div class="sort_news">
						<span>SORT BY</span>
						<form action="">
							<label class="custom-select">
								<select>
									<option>Date</option>
								</select>
							</label>
						</form>
					</div>
				</div>
				<div class="latest_update add_fix">
				
				<?php 
					$tglnya ="";
					$h1=true;
					while($dnews=$dbu->fetch($rnews)){
						$dnews[icon] = $appx->cekFile('/berita/icon/',$dnews[icon],'default.png');
						$dnews[icon] = $app[data_www].'/berita/icon/'.$dnews[icon];
						$dnews[thumb] = $appx->cekFile('/berita/thumb/',$dnews[thumb],'default.jpg');
						$dnews[thumb] = $app[data_www].'/berita/thumb/'.$dnews[thumb];
						if($h1 == true ){
							$tglnya = $dnews[tgl_post];
							$h1 = false;
						?>
						<h1><?php echo $appx->format_date($dnews[tgl_post],'id','N') ?><span class="border"></span></h1>
						<ul class="update_list update_list_news add_fix">
					<?php } ?>
					<li>
							<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='51'")."/".$urlx->shortLink($dnews[judul])."_".$dnews[id]."/"?>">
								<div class="img_box">
									<div class="icon"><img src="<?php echo $dnews[icon]; ?>"></div>
									<img src="<?php echo $dnews[thumb]; ?>">
								</div>	
								<div class="text">
									<h1><?php echo $dnews[kategori]; ?></h1>
									<span class="border"></span>
									<h2><?php echo $dnews[judul]; ?></h2>
									<p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
									<div class="post_by">oleh <i><?php echo $dnews[username]; ?></i></div>
									<div class="info">
										<div class="date"><?php echo $appx->format_date($dnews[tgl_post],'id','N') ?></div>
										<div class="view"><?php echo $appx->number_to_K($dnews[hit]); ?></div>
									</div>
								</div>
							</a>
						</li>
					<?php 
					if($tglnya != $dnews[tgl_post]){ 
					$h1=true;
						?>
					</ul>	
					<?php } ?>
				<?php
					}
				?>	</ul>			
					<div class="load_more"><a href="#">View More</a></div>
				</div><!-- /.latest_update -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>