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
					<h1><?php
					$kat = '%'.str_replace("-","%",$app[p_id])."%";
							echo "KATEGORI ".$app[p_id];
					// echo $dbu->lookup('kategori','destinasi_kategori',"id='".$app[p_id]."'") 
					?>
                    <span class="border"></span></h1>
					
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
										<a href="'.$app["www"]."/".$dbu->lookup('nama','action',"action='22'")."/".$urlx->shortLink($dkat[kategori])."/".'"><div class="bullet-cat-near'.$active.'"><img src="'.$app["data_www"].'/destinasi_kategori/icon/'.$dkat[icon].'"></div></a>
										<span class="tip-content">'.$dkat[kategori].'</span>
									</li>';
								}
						?>
						</ul>
					</div>
					<?php while($prop =$dbu->fetch($rsprop)){ ?>						
						<?php
							#--hitung jumlah kota di propinsi

							$hitrs = $dbu->count_record("id","kota","where id_provinsi ='".$prop[id]."'"); 
							#-- jika $hitrs > 0 (kota ada)
							//echo "$hitrs";
							if($hitrs and $hitrs > 0){ 
								#-- selesksi kota 8 record
								$awal = 0;
								$limit = 8;
								$lm = true;
								if($hitrs < 8){
									$limit = $hitrs;
									$lm = false;
								}
								
								?>
								<!-- <h1><?php // echo $prop[nama]; ?><span class="border"></span></h1> -->
								
                                
                                <?php 
								
								
								$query = "select distinct a.nama from kota a join destinasi b on a.id=id_kota join destinasi_bahasa c on b.id_reff=c.id_reff where a.id_provinsi in (select id from provinsi where nama='".$prop[nama]."') and b.id_kat in (select id from destinasi_kategori where kategori LIKE '%".$kat."%')";
								
					$dbu->query($query,$rnear,$hit_near);

						while($nea = $dbu->fetch($rnear)){ 
								echo  '<br /><h1>'.$nea[nama].', '.$prop[nama].'<span class="border"></span></h1>'; ?>
								
							
						<ul class="list_location add_fix" >

					<?php 
					
					
					$urlnya = $dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'");
					$query = "SELECT a.website, b.nama as dest, b.slogan , b.alamat, a.thumb, a.icon_map ,LTRIM(' url') as urlc FROM destinasi as a LEFT JOIN destinasi_bahasa as b ON(a.id_reff = b.id_reff) where  a.id_kota in (select id from kota where nama='".$nea[nama]."') and a.id_kat in (select id from destinasi_kategori where kategori LIKE '%".$kat."%')";
				
					$dbu->query($query,$data,$hit_data);

						while($row = $dbu->fetch($data)){ 

								$thumb=$app[data_www].'/destinasi/thumb/'.$row[thumb].'';
								$urlc=$app[www]."/".$urlnya."/".$urlx->shortLink($row[dest])."/";
					?>
											
										<li><div class="img_box"><img src="<?php echo $thumb; ?>"></div><div class="text"><h1><?php echo $row[dest]; ?></h1><p><?php echo $row[slogan]; ?></p></div><a href="<?php echo $urlc; ?>"><div class="explore">EXPLORE MORE</div></a></li>

						<?php } ?>

					</ul>
									
								
					<?php	}
								
								 ?>
                              
                                
                              
                                
                                
                                
								<?php 
								if($lm=true and ($hitrs>$limit)){

								?>
									<div class="load_more" rel="<?php echo $urlx->friendlyURL($prop[nama]);?>"><a  href="#" id="vm" >View More</a></div>										
						<?php 		
								}
							}
						} ?>
					
				</div> <!-- .location_destination -->
<script type="text/javascript">
	  $(".load_more").click(function(){
	  	var tmp = $(this).attr('rel');
	  	var cast = $('#'+tmp).attr('rel');
	  	var limit = $('#'+tmp).attr('limit');
	    $.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/moreKota.php',
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