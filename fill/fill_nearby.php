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
				<div class="search_destination">
					<h1>NEARBY<span class="border"></span></h1>
					<div class="my_location">
						<div id="gg_loc"></div>
						<p><a id="mappy" href="#" >Show Map</a></p>
					</div>
					<div class="boxcon_search_destination add_fix" style="display:none;">
						<div class="map_search" id="google_map" style="width:100%;margin-right:0;height:400px;"></div>
					</div>
				</div> <!-- .search_destination -->
				<div class="location_destination">
					<div class="near-cat add_fix">
						<span>Choose Category :</span>
						<ul>
						<?php 
							while($dkat = $dbu->fetch($rkat)){
								$active = "";
								$dkat[icon] = $appx->cekFile('/destinasi_kategori/icon/',$dkat[icon]);
								
								$pkat = $urlx->shortLink($dkat[kategori]);
								if($p_id == $pkat){
									$active=" active";
								}
								echo '<li>
										<a href="'.$app["www"]."/".$dbu->lookup('nama','action',"action='23'")."/".$urlx->shortLink($dkat[kategori])."/".'"><div class="bullet-cat-near'.$active.'"><img src="'.$app["data_www"].'/destinasi_kategori/icon/'.$dkat[icon].'"></div></a>
										<span class="tip-content">'.$dkat[kategori].'</span>
									</li>';
							}
						?>
						</ul>
					</div>
					<h1><?php echo strtoupper($kat);?><span class="border"></span></h1>
					<ul class="list_location add_fix" id="dekat"></ul>
					<div class="load_more"><a href="#">VIEW MORE</a></div>
				</div> <!-- .location_destination -->
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>