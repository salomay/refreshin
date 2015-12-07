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
					<div class="content_left">
						<h1 class="main_title">NEWS DETAIL<span class="border"></span></h1>
						<!--<div class="sosmed">
							<span>Share this article</span>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/tw.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/fb.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/g+.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/dg.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/sq.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/ic.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/sv.png"></a>
							<a href="#"><img src="<?php echo $app[css_www];?>/images/em.png"></a>
						</div>-->
						<div class="box_meta_overview">
							<h1><?php echo $dnews[judul] ?></h1>
							<div class="box_postdate add_fix">
							<?php 
								$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dnews[username])."/";
							?>
								<div class="det_post_by">by <label><a href="<?php echo $lingAva; ?>"><?php echo $dnews[username] ?></a></label></div>
								<span>|</span>
								<div class="det_date"><?php echo $appx->format_date($dnews[tgl_post],'id','N'); ?></div>
							</div>
							<div class="litle_quotes"><img src="<?php echo $app[css_www];?>/images/ic_q_left.png"><?php echo $dnews[sinopsis] ?><img src="<?php echo $app[css_www];?>/images/ic_q_right.png"></div>
						</div>
						<div class="box_main_info add_fix det_news">
							<?php 
								$dnews[gambar] = $appx->cekFile('/berita/gambar/',$dnews[gambar],'default.jpg');
								$dnews[gambar] = $app[data_www]."/berita/gambar/".$dnews[gambar];
							?>
							<a class="main_image fancybox-buttons" data-fancybox-group="button" href="<?php echo $dnews[gambar]; ?>"><img src="<?php echo $dnews[gambar]; ?>" alt=""></a>
						</div>
						<div class="rich_text">
							<?php echo $dnews[isi]; ?>
						</div>
					</div> <!-- content_left -->	
					<div class="content_right">
						<?php 
							$idnya = $dnews[id];
							$id_related = $dnews[id_reff];
							$tabel = $dnews[ket_id];
							include "part/block_related_news.php";
							include "part/block_thread_right.php";
							include "part/block_nearby_place.php";
						?>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',
				closeBtn  : true,

				helpers : {
					title : {
						type : 'outside'
					},
					buttons	: {}
				},
				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
	}) 
</script>
</html>