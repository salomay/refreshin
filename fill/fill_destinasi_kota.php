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
<script src="http://maps.googleapis.com/maps/api/js"></script> 
<div class="wrapcontent">
			<div class="content add_fix">
				<div class="search_destination">
					<h1><?php echo $dbu->lookup('kategori','destinasi_kategori',"kategori LIKE '".$sqlkey_kat."'") ?><span class="border"></span></h1>
					<div class="my_location">
						<div id="gg_loc">						
						</div>
						<p><a id="mappy" href="#" >Show Map</a></p>
					</div>
					<div class="boxcon_search_destination add_fix" style="display:none;">
						<div class="map_search" id="google_map" style="width:100%;margin-right:0;height:400px;"></div>
					</div>
				</div> <!-- .search_destination -->
				<div class="location_destination">					
						<?php
							#--hitung jumlah destinasi di kota
							$hitrs = $dbu->count_record("id","destinasi","where id_kota ='".$kotax[id]."'"); 
							#-- jika $hitrs > 0 (destinasi ada)
							//echo "$hitrs";
							if($hitrs and $hitrs > 0){ 
								#-- selesksi destinasi 8 record
								$awal = 0;
								$limit = 8;
								$lm = true;
								if($hitrs < 8){
									$limit = $hitrs;
									$lm = false;
								}
								?>
								<h1><?php echo $dbu->lookup("nama","provinsi","id='".$kotax[id_provinsi]."'"); ?>, <?php echo $dbu->lookup("nama","kota","id='".$kotax[id]."'"); ?><span class="border"></span></h1>
								<ul class="list_location add_fix" id="<?php echo $urlx->friendlyURL($kotax[nama]);?>" rel="<?php echo $app[act]."|".$app[p_id]."|".$kotax[id] ?>" limit="8">
								<?php 
								while($desty = $dbu->fetch($destkota)){ 
									$destinasi = $dbu->lookup("nama","destinasi_bahasa","id_reff='".$desty[id_reff]."'");
									?>
									<li>
										<div class="img_box">
											<?php
												if ($desty[thumb]){ 
														$filename = $app['data_path']."/destinasi/thumb/".$desty[thumb];
													if (!file_exists($filename)) {
														$desty[thumb]="default.jpg"; 
													}
												}else{
													$desty[thumb]="default.jpg";
												}
											?>
											<img src="<?php echo $app[data_www]."/destinasi/thumb/".$desty[thumb];?>">
										</div>
										<div class="text">
											<h1><?php echo $destinasi; ?></h1>
											<p><?php echo $dbu->lookup('deskripsi',$app[table][destinasi_bahasa],"id_reff ='".$desty[id_reff]."' AND id_bahasa='".$_SESSION[bhs]."'"); ?></p>									
										</div>
										<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($destinasi)."/" ?>"><div class="explore">DETAILS</div></a>
									</li>
							<?php
								}
							?>
								</ul>
								<?php 
								if($lm=true and ($hitrs>$limit)){

								?>
									<div class="load_more" rel="<?php echo $urlx->friendlyURL($kotax[nama]);?>"><a  href="#" id="vm" >View More</a></div>
									
						<?php 		
								}
							}
						?>
					
				</div> <!-- .location_destination -->
<script type="text/javascript">
	  $(".load_more").click(function(){
	  	var tmp = $(this).attr('rel');
	  	var cast = $('#'+tmp).attr('rel');
	  	var limit = $('#'+tmp).attr('limit');
	    $.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/moreDestinasi.php',
			  data: {
			    tnt : cast,
			    awal: limit
			  },
			  success: function (response) {
			   $('#'+tmp).append(response);
			   $('#'+tmp).attr('limit',Number(limit)+8);
			  	var nDiv = document.getElementById(tmp);
				nDiv.scrollTop = nDiv.scrollHeight;
			  }
		  });
	});				
</script>
			</div>
		</div><!-- /.wrapcontent -->
<?php
echo $tampil->tampilkan_footer('main');
?>
	</div>	
</body>
</html>