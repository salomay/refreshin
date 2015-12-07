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
				<div style="margin:0;" class="content_left friend_section">
					<ul class="f_comm add_fix">
					<?php while ($komm = $dbu->fetch($rscomm)) {
					?>
						<li class="add_fix">
								<div class="img_box img_fc">
								<?php 
								$komm[logo] = $appx->cekFile('/komunitas/logo/',$komm[logo],'default.jpg');
								$komm[logo] = $app[data_www].'/komunitas/logo/'.$komm[logo];
								?>
									<img src="<?php echo $komm[logo]; ?>" width ="138" height="181">
								</div>
								<div class="tf_comm">
									<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='31' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($komm[nama])."/";?>"><h1><?php echo $komm[nama]; ?></h1></a>
									<h2><?php echo $komm[slogan]; ?></h2>
									<a href="#"><h3><?php 
									$jml_ang = $dbu->count_record("id",$app[table][komunitas_pengguna],"where id_komunitas ='".$komm[id]."'");
									echo  $appx->number_to_K($jml_ang) ?> Member</h3></a>
									<div class="rating">
										<div style="width:90%" class="bg_rate"></div>
										<div class="rate_new"></div>
									</div>
									<?php if($_SESSION[member][id]!=""){
										$cek = $dbu->lookup("id",$app[table][komunitas_pengguna],"id_user='".$_SESSION[member][id]."' AND id_komunitas='".$komm[id]."'");
										if($cek!=""){
										?>
											<a href="#" id="unjoinx" class="explore clr_b join">UNJOIN</a>
										<?php
										}else{ ?>
											<a href="#" id="joinx" class="explore clr_b join">JOIN</a>
										<?php
										}
									}else{ ?>
										<a class="explore clr_b join">NEED LOGIN</a>
									<?php } ?>
									
								</div>
							</li>
					<?php } ?>						
					</ul>
				
				</div> <!-- content_left -->
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>	
</body>
<script src="js/basic.js"></script>
</html>