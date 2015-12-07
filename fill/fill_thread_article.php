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
				<div class="box-left-right add_fix">
					<div class="content_left thread_section">
						<div class="head_nf">
							<ul>
								<li class="active"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/";?>">ARTICLE</a></li>
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/trip/";?>">TRIP</a></li>
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/store/";?>">STORE</a></li>
							</ul>
							<div class="box_ic_nf">
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_srch.png"></a>
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_agn.png"></a>
							</div>
						</div>
						<div class="thread_list">
							<span class="bread">ARTICLE</span>
							<?php
							if($nof <=0){
							?>
								<h1 class="main_title" style="background:none;">TODAY<span class="border"></span></h1>
								<ul>
									<li>NO Article Found</li>
								</ul>
								</div>
							<?php	
							}else{
								$tglnya ="";
								$h1=true;
								while($dforum= $dbu->fetch($rforum)){
								if($h1 == true ){
									$h1 = false;
									$tglnya = $appx->format_date($dforum[tgl_post],'id','N');
									$now = $appx->format_date(date("Y-m-d"),'id','N');
									$xtgl = $tglnya ;
									if($tglnya == $now){
										$xtgl = "TODAY";
									}
								?>
								<h1 class="main_title" style="background:none;"><?php echo $xtgl ?><span class="border"></span></h1>
								<ul>
							<?php 
								$avatar = $appx->cekFile('/pengguna/avatar/',$dforum[avatar],'default.jpg');
								$avatar = $app[data_www].'/pengguna/avatar/'.$avatar;
								$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dforum[username])."/";
									}?>
									<li>
									<div class="circle_pict"><a href="<?php echo $linkAva;?>"><img src="<?php echo $avatar;?>"></a></div>
									<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='41' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dforum[judul])."/" ?>"><span><?php echo $dforum[judul]; ?></span></a>
									<p>oleh <a href="<?php echo $linkAva;?>"><i><?php echo $dforum[username];?></i></a> on <a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dforum[destinasi])."/" ?>"><i style="color:#f38f1d;"><?php echo $dforum[destinasi];?></i></a></p>
									<div class="rating">
										<div style="width:<?php echo rand(100) ?>%" class="bg_rate"></div>
										<div class="rate_new"></div>
									</div>
								</li>
							<?php 
								}
								?>
								</ul>
								</div>
							<?php
							}
							?>										
					</div> <!-- content_left -->	
					<div class="content_right thread_section">
						<?php 
							include "part/block_tombol_thread.php";
							include "part/block_hot_thread.php";
						?>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>