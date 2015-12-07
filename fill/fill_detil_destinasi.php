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
						<h1 class="main_title">OVERVIEW<span class="border"></span></h1>
						<div class="sosmed">
							<span>Share this article</span>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/tw.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/fb.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/g+.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/dg.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/sq.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/ic.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/sv.png"></a>
							<a href="#"><img src="<?php echo $app["css_www"];?>/images/em.png"></a>
						</div>
						<div class="box_meta_overview">
							<h1><?php echo ucfirst($desbhs[nama]).", ".ucfirst($desbhs[kota]).", ".ucfirst($desbhs[provinsi]); ?></h1>
							<div class="box_postdate add_fix">
								<div class="det_post_by">by <label><a href="#"><?php echo ucfirst($desbhs[username]); ?></a></label></div>
								<span>|</span>
								<div class="det_date"><?php echo $appx->format_date($desbhs[diposting],$_SESSION[bhs]); ?></div>
							</div>
							<div class="litle_quotes"><img src="<?php echo $app["css_www"];?>/images/ic_q_left.png"><?php echo ucfirst($desbhs[slogan]); ?><img src="<?php echo $app["css_www"];?>/images/ic_q_right.png"></div>
						</div>
						<div class="box_main_info add_fix">
							<a class="main_image fancybox-buttons" data-fancybox-group="button" href="<?php echo $app["data_www"];?>/destinasi/gambar/<?php echo $desbhs[gambar];?>">
								<img src="<?php echo $app["data_www"];?>/destinasi/gambar/<?php echo $desbhs[gambar];?>" alt="">
							</a>
							<?php 
								$sql="SELECT judul, dokumen FROM ".$app[table][destinasi_dok]." WHERE status='aktif', AND tipe_dokumen='gambar' AND id_destinasi ='".$desbhs[iddes]."'";
								$dbu->query($sql,$rsgmb,$rsnum);
								if($rsnum>0){
									while($gmbnya= $dbu->fetch($rsgmb)){ ?>
										<a class="main_image other-img fancybox-buttons" data-fancybox-group="button" href="<?php echo $app["data_www"];?>/destinasi/dokumen/<?php echo $gmbnya[dokumen];?>">
											<img src="<?php echo $app["data_www"];?>/destinasi/dokumen/<?php echo $gmbnya[dokumen];?>" alt="<?php echo $gmbnya[judul];?>">
										</a>
								<?php }
								}
								unset($rsgmb);
							?>	
							
							<div class="box_quick add_fix">
								<div class="quick_info">
									<h1>Kategori Usia</h1>
									<h2><?php echo $desbhs[usia] ?></h2>
									<span>&nbsp;</span>
								</div>
								<div class="quick_info transport">
									<a href="#">
									<?php 
										$sql="SELECT id_from, id_to, akses, harga, tgl_post FROM ".$app[table][transport]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
										//echo $sql; exit;
										$dbu->query($sql,$rsrute,$rshitrute);
									?>
									<h1>Transport</h1>
									<h2><?php echo $rshitrute; ?> Route</h2>
									<span>View Detail</span>
									</a>
								</div>
								<div class="quick_info budget">
									<a href="#">
										<h1>Minimum Budget</h1>
										<h2><?php echo $desbhs[htm]; ?></h2>
										<span>View Detail</span>
									</a>
								</div>
								<div class="quick_info activity">
									<a href="#">
									<?php 
										$sql="SELECT nama, deskripsi FROM ".$app[table][destinasi_keg]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
										//echo $sql; exit;
										$dbu->query($sql,$rsact,$rshit);
									?>
									<h1>Activity</h1>
									<h2><?php echo $rshit; ?> Activity</h2>
									<span>View Detail</span>
									</a>
								</div>
								<div class="box_schedule">
									<h1>Schedule</h1>
									<div class="con_schedule">
										<div class="schedule add_fix">
											<label>OPEN</label>
											<div class="day">
												<span><?php echo ucwords(strtolower($desbhs[hari_buka])); ?></span>
												<p><?php echo $desbhs[jam_buka]; ?></p>
											</div>
										</div>
										<div class="schedule add_fix">
											<label>BEST TIME</label>
											<div class="day">
												<span><?php echo ucwords(strtolower($desbhs[best_day])); ?></span>
												<p><?php echo $desbhs[best_time]; ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						<div class="info_loc">
							<p><b>Location :</b> <?php echo $desbhs[alamat];?></p>
							<a href="#">See Location</a>
						</div>
						<div class="rich_text">
							<?php 
							$deskripsi = str_replace("[quote]", '<div class="big_quotes"><div class="ic_quo_left"><img src="'.$app["css_www"].'/img/big_q_left.png"></div>', $desbhs[deskripsi]);
							$deskripsi = str_replace("[/quote]", '<div class="ic_quo_right"><img src="'.$app["css_www"].'/img/big_q_right.png"></div></div>', $desbhs[deskripsi]);
							echo $deskripsi;
							?>
						</div>
						
						<?php
						$sql ="SELECT a.nama, a.slogan, b.id as idchild FROM ".$app[table][destinasi_bahasa]." as a LEFT JOIN ".$app[table][destinasi]." as b ON(a.id_reff = b.id_reff) WHERE b.id_parent ='".$desbhs[iddes]."' AND a.id_bahasa ='".$_SESSION[bhs]."'";
						$dbu->query($sql,$rsrelated,$rsrelhit);
						if($rsrelhit>0){
						?>
						<div class="rel-spot">
							<h1>RELATED SPOT<span class="border"></span></h1>
							<ul class="list_location add_fix">
							<?php 
								while($rela = $dbu->fetch($rsrelated)){
							?>
								<li>
									<div class="img_box">
										<img src="<?php echo $app["data_www"];?>/destinasi/thumb/<?php echo $dbu->lookup("thumb","destinasi","id='".$rela[idchild]."'"); ?>">
									</div>
									<div class="text">
										<h1><?php echo strtoupper($rela[nama]); ?></h1>
										<p><?php echo $rela[slogan]; ?></p>									
									</div>
									<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($rela[nama])."/" ?>"><div class="explore">DETAILS</div></a>
								</li>
								<?php 	} 	?>
								</ul>
							</div>
							<?php } ?>
							<?php 
						$sql ="SELECT a.nama, a.slogan, b.id as idchild FROM ".$app[table][destinasi_bahasa]." as a LEFT JOIN ".$app[table][destinasi]." as b ON(a.id_reff = b.id_reff) WHERE b.id_kat ='".$desbhs[id_kat]."' AND a.id_bahasa ='".$_SESSION[bhs]."' AND b.id <> '".$desbhs[iddes]."'";
						//echo $sql;exit;
						$dbu->query($sql,$rsrelated,$rsrelhit);
						if($rsrelhit>0){
						?>
						<div class="rel-spot">
							<h1>SIMILAR DESTINATION<span class="border"></span></h1>
							<ul class="list_location add_fix">
							<?php 
							while($rela = $dbu->fetch($rsrelated)){
							?>
								<li>
									<div class="img_box">
										<img src="<?php echo $app["data_www"];?>/destinasi/thumb/<?php echo $dbu->lookup("thumb","destinasi","id='".$rela[idchild]."'"); ?>">
									</div>
									<div class="text">
										<h1><?php echo strtoupper($rela[nama]); ?></h1>
										<p><?php echo $rela[slogan]; ?></p>									
									</div>
									<a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($rela[nama])."/" ?>"><div class="explore">DETAILS</div></a>
								</li>
							<?php 
							}
							?>
							</ul>
						</div>
						<?php 
						} ?>
					</div> <!-- content_left -->	
					<div class="content_right">
						<?php if($_SESSION[member][id]!=""){ ?>
						<a class="gt_prm" href="#">GET PROMO</a>
						<a class="add_plan" href="trip_detail.html">ADD TO PLAN</a>
						<div class="box-ck-ot add_fix">
							<?php 
								$sql = "SELECT * FROM ".$app[table][cekin]." WHERE now() < DATE_ADD(tgl_post, INTERVAL 2 WEEK) ORDER BY tgl_post DESC";
								$cek = $dbu->get_recordmix($sql);
								if($cek[tipe]!="cekin"){
							?>
								<a id="ceki" rel="<?php echo $desbhs[iddes]."-".$_SESSION[member][id]."-cekin"; ?>" style="background:#1b39d1;border-bottom:4px solid #11268e;" class="ck-ot" href="#">CHECK IN</a>
							<?php } 
								if($cek[tipe]!="otw"){
							?>
								<a id="ontw" rel="<?php echo $desbhs[iddes]."-".$_SESSION[member][id]."-otw"; ?>" style="background:#bb2705;border-bottom:4px solid #7f1b03;" class="ck-ot" href="#">OTW</a>
							<?php }?>
						</div>
						<?php } 
						$rate = $dbu->lookup("AVG(bintang)","destinasi_respon","id_destinasi='".$desbhs[iddes]."'");
						$rate = $appx->star_rate($rate);
						$jml = $dbu->lookup("count(id_user)","destinasi_respon","id_destinasi='".$desbhs[iddes]."'");
						$sql = "SELECT a.username, a.avatar, b.komen FROM ".$app[table][pengguna]." as a LEFT JOIN ".$app[table][destinasi_respon]." as b ON(a.id = b.id_user) WHERE b.id_destinasi='".$desbhs[iddes]."' order by b.tgl_post desc limit 3";
						$dbu->query($sql,$rsrate,$nr);
						?>
						<div class="box_rate">
							<div class="rate add_fix">
								<div class="score_rate"><?php echo $rate; ?></div>
								<div class="det_rate">
									<div class="rating">
										<div style="width:<?php echo $rate*20; ?>%" class="bg_rate"></div>
										<div class="rate_new"></div>
									</div>
									<div class="total_user"><?php echo $jml; ?> Total User</div>
								</div>
							</div>
							<div class="box_list_rate">
								<?php 
								while($ratex = $dbu->fetch($rsrate)){
								?>
								<div class="con_text_rate add_fix">
									<div class="circle_pict" style="margin-right:10px;"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($ratex[username])."/";?>"><img src="<?php echo $app["data_www"];?>/pengguna/avatar/<?php echo $ratex[avatar]; ?>"></a></div>
									<div class="rich_text_rate"><a href="#">
										<h1><?php echo $ratex[username]; ?></h1>
										<p><?php echo ($ratex[komen]!="")?$appx->subWord($ratex[komen],2)."...":"no comment"; ?></p></a>
									</div>
								</div>
								<?php } ?>
							</div>
							<a href="#" class="explore<?php echo($_SESSION[member][id]!="")?" add-rate":""?>">ADD REVIEW</a>
						</div>
						<?php 
						$sql = "SELECT a.username, a.avatar FROM ".$app[table][pengguna]." as a LEFT JOIN ".$app[table][cekin]." as b ON(a.id = b.id_user) WHERE b.id_destinasi='".$desbhs[iddes]."' AND b.id_user <> '".$_SESSION[member][id]."' ORDER BY b.tgl_post desc ";
							//mysqli_free_result($rsrate);
							$dbu->query($sql,$rswho,$nrwho);
						if($nrwho>0){
							$hit=1;
							$depan="";
							$belakang="";
							while($ratewho = $dbu->fetch($rswho)){
							$belakang = $belakang . '<div class="circle_pict"><a href="'.$app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($ratewho[username])."/".'"><img src="'.$app["data_www"].'/pengguna/avatar/'.$ratewho[avatar].'"></a></div>';
							if($hit<=10){
								$depan = $belakang;
								}									
							}
						?>
						<div class="check_in">
							<h1 class="main_title" style="padding: 15px 15px 7px;">WHO WAS HERE<span class="border"></span></h1>
							<div class="box_circle_pict add_fix">
								<?php echo $depan;	?>
							</div>
							<a href="#" class="explore who-here">VIEW MORE</a>
						</div>
						<?php } 
						$sql = "SELECT nama, logo FROM ".$app[table][komunitas]." WHERE id_destinasi='".$desbhs[iddes]."' ORDER BY nama asc ";
							//mysqli_free_result($rsrate);
							$dbu->query($sql,$rscomm,$nrcomm);
						if($nrcomm>0){
							$hit=1;
							$front="";
							$back="";
							while($commu = $dbu->fetch($rscomm)){
								$back = $back . '<div class="circle_pict"><a href="'.$app["www"]."/".$dbu->lookup('nama','action',"action='31' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($commu[nama])."/".'"><img src="'.$app["data_www"].'/komunitas/logo/'.$commu[logo].'"></a></div>';
								if($hit<=10){
									$front = $back;
								}									
							}
						?>
						<div class="community">
							<h1 class="main_title" style="padding: 15px 15px 7px;">COMMUNITY<span class="border"></span></h1>
							<div class="box_circle_pict add_fix">
								<?php echo $front; ?>
							</div>
							<a href="#" class="explore more-community">VIEW MORE</a>
						</div>
						<?php } 
							$sql = "SELECT a.id as idtred, a.judul, b.username FROM ".$app[table][thread]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) WHERE a.id_destinasi='".$desbhs[iddes]."' AND a.hot ='ya' ORDER BY a.hit desc LIMIT 5";
							$dbu->query($sql,$rstread,$ntread);
							if($ntread<=0){
								$sql = "SELECT a.id as idtred, a.judul, b.username FROM ".$app[table][thread]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) WHERE a.id_destinasi='".$desbhs[iddes]."' ORDER BY a.hit desc LIMIT 5";
								$dbu->query($sql,$rstread,$ntread);

								if($ntread<=0){
									$sql = "SELECT a.id as idtred, a.judul, b.username FROM ".$app[table][thread]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) ORDER BY a.hit desc LIMIT 5";
									$dbu->query($sql,$rstread,$ntread);
								}
							}
						?>
						<?php 
							$idnya = $desbhs[id];
							include "part/block_thread_right.php";
							include "part/block_nearby_place.php";
						?>
					</div> <!-- content_right -->
				</div> <!-- box-left-right -->
			</div>
		</div><!-- /.wrapcontent -->
<?php echo $tampil->tampilkan_footer('main'); ?><!-- /.wrapfooter -->
		<div class="overlay-body"></div>
		<div class="overlay_activity">
			<div class="box-price-des">
				<div class="title-des">ACTIVITY<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="upd-by-des"><span>UPDATE BY :</span>
					<?php 
					$sql="SELECT distinct(id_user) FROM ".$app[table][destinasi_keg]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
					$dbu->query($sql,$rsuser,$rshituser);
					while($rs_user=$dbu->fetch($rsuser)){
						$sql = "SELECT username, avatar FROM ".$app[table][pengguna]." WHERE id='".$rs_user[id_user]."'";
						$useava = $dbu->get_recordmix($sql);
					?>
						<div class="circle_pict">
							<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa='".$_SESSION[bhs]."'");?>/<?php echo $urlx->shortLink($useava[username]); ?>">
								<img src="<?php echo $app["data_www"];?>/pengguna/avatar/<?php echo $useava[avatar];?>">
							</a>
						</div>
					<?php } ?>
				</div>
				<table>
					<tr>
						<th>Activity</th>
						<th>Description</th>		
					</tr>
					<?php 
						while($activ = $dbu->fetch($rsact)){ 
						?>
						<tr>
							<td style="width:30%;text-align:center;"><span><?php echo $activ[nama]; ?></span></td>
							<td><?php echo $activ[deskripsi]; ?></td>		
						</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div> <!-- overlay_activity -->
		
		<div class="overlay_transport">
			<div class="box-price-des">
				<div class="title-des">TRANSPORT<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="upd-by-des"><span>UPDATE BY :</span>
					<?php 
						$sql="SELECT distinct(id_user) FROM ".$app[table][transport]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
						//echo $sql; exit;
						$dbu->query($sql,$rsuser,$rshituser);
					
						while($rs_user=$dbu->fetch($rsuser)){
							$sql = "SELECT username, avatar FROM ".$app[table][pengguna]." WHERE id='".$rs_user[id_user]."'";
							//echo $sql;exit;
							$useava = $dbu->get_recordmix($sql);
						?>
							<div class="circle_pict">
								<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa='".$_SESSION[bhs]."'");?>/<?php echo $urlx->shortLink($useava[username]); ?>">
									<img src="<?php echo $app["data_www"];?>/pengguna/avatar/<?php echo $useava[avatar];?>">
								</a>
							</div>
						<?php	
						}
					?>
				</div>
				<table>
					<tr>
						<th>DATE</th>
						<th>FROM</th>		
						<th>TO</th>		
						<th>ACCESS</th>		
						<th>PRICE</th>		
					</tr>
					<?php 
						while($rute = $dbu->fetch($rsrute)){ 
						?>
						<tr>
							<td style="width:17%;"><span><?php echo $appx->format_date($rute[tgl_post],$_SESSION[bhs]); ?></span></td>
							<td style="text-align:center;"><p><?php echo strtoupper($dbu->lookup("nama","kota","id ='".$rute[id_from]."'"));?></p></td>		
							<td style="text-align:center;"><p><?php echo strtoupper($dbu->lookup("nama","kota","id ='".$rute[id_to]."'"));?></p></td>		
							<td><p><?php echo $rute[akses];?>.</p></td>
							<td style="width:17%;text-align:center;"><span><?php echo $rute[harga];?></span></td>	
						</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div> <!-- overlay_transport -->
		
		<div class="overlay_budget">
			<div class="box-price-des">
				<div class="title-des">MINIMUM BUDGET<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="upd-by-des"><span>UPDATE BY :</span>
				<?php 
						$sql="SELECT harga, deskripsi, tgl_post FROM ".$app[table][destinasi_biaya]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
											//echo $sql; exit;
						$dbu->query($sql,$rsminim,$rshitmin);

						$sql="SELECT distinct(id_user) FROM ".$app[table][destinasi_biaya]." WHERE status='aktif' AND id_bahasa='".$_SESSION[bhs]."' AND id_destinasi ='".$desbhs[iddes]."' order by tgl_post desc limit 5";
						//echo $sql; exit;
						$dbu->query($sql,$rsuser,$rshituser);
					
						while($rs_user=$dbu->fetch($rsuser)){
							$sql = "SELECT username, avatar FROM ".$app[table][pengguna]." WHERE id='".$rs_user[id_user]."'";
							//echo $sql;exit;
							$useava = $dbu->get_recordmix($sql);
						?>
							<div class="circle_pict">
								<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa='".$_SESSION[bhs]."'");?>/<?php echo $urlx->shortLink($useava[username]); ?>">
									<img src="<?php echo $app["data_www"];?>/pengguna/avatar/<?php echo $useava[avatar];?>">
								</a>
							</div>
						<?php }	?>
				<label>TOTAL : <?php echo  $desbhs[htm] ; ?></label>
				</div>
				<table>
					<tr>
						<th>Date</th>
						<th>Description</th>		
						<th>Price</th>				
					</tr>
					<?php 
						while($minim=$dbu->fetch($rsminim)){?>
						<tr>
							<td style="width:20%;text-align:center;"><span><?php echo $appx->format_date($minim[tgl_post],$_SESSION[bhs]); ?></span></td>	
							<td><?php echo  $minim[deskripsi] ; ?></td>
							<td style="width:20%;text-align:center;"><span><?php echo  $minim[harga] ; ?></span></td>						
						</tr>
						<?php }	?>					
				</table>
			</div>
		</div> <!-- overlay_budget -->
		<?php if($_SESSION[member][id]!=""){  ?>
		<div class="overlay_rating">
			<div class="box-price-des box-join box-rating">
				<div class="title-des">RATING<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="upd-by-des">
					<form action="">
						<textarea id="p_review" placeholder="* Please add rating based the relevance of article and the place you visited"></textarea>
						<div class="input select rating-f">
							<select id="example-1" rel="<?php echo $desbhs[iddes] ?>" name="rating">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
						<input type="submit" rel=<?php echo $_SESSION[member][id]; ?> id="rates" value="SUBMIT">
					</form>
					<?php 
						if($nrrev>0){
					?>
					<div class="another_review">
						<span>REVIEW</span>
						<hr>
						<div class="box_lv_review">
							<?php 
							while($ratex=$dbu->fetch($rsrate)){
						?>
							<div class="box-item-review add_fix">
								<div class="circle_pict"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($ratex[username])."/";?>"><img src="<?php echo $app["data_www"];?>/pengguna/avatar/<?php echo $ratex[avatar]; ?>"></a></div>
								<div class="rating">
									<div style="width:<?php echo $ratex[bintang]*20; ?>%" class="bg_rate"></div>
									<div class="rate_new"></div>
								</div>
								<div class="rich_text_rate">
									<h1><?php echo $ratex[username]; ?></h1>
									<p><?php echo ($ratex[komen]!="")?$ratex[komen]:"no comment"; ?></p>
								</div>
							</div>
						<?php }	?>
					<?php }	?>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- overlay_rating -->
		<?php } 
		if($nrwho > 0){
		?>
		<div class="overlay_who_was_here">
			<div class="box-price-des box-join">
				<div class="title-des">WHO WAS HERE<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="another_p_join">
					<span>ANOTHER PERSON JOINED</span>
					<span style="float:right;">TOTAL : <?php echo $nrwho; ?></span>
					<hr>
					<div class="box-item-person add_fix" style="max-height:300px;">
						<?php echo $belakang; ?>
					</div>
				</div>
			</div>
		</div> <!-- overlay_who_was_here -->
		<?php } 
		if($nrcomm > 0){
		?>
		<div class="overlay_community">
			<div class="box-price-des box-join">
				<div class="title-des">COMMUNITY<img class="close" src="<?php echo $app["css_www"];?>/img/close.png"></div>
				<div class="another_p_join">
					<span>ANOTHER COMMUNITY JOINED</span>
					<span style="float:right;">TOTAL : <?php echo $nrcomm; ?></span>
					<hr>
					<div class="box-item-person add_fix" style="max-height:300px;">
						<?php echo $back; ?>
					</div>
				</div>
			</div>
		</div> <!-- overlay_community -->
		<?php } ?>
	</div>	
<script type="text/javascript">
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

	$("#rates").click(function(e){
		e.preventDefault(); 
	  	var cast = $('#example-1').val();
	  	var iddes = $('#example-1').attr('rel');
	  	var revi = $('#p_review').val();
	  	var idu = $('#rates').attr('rel');

	  	$.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/rateDes.php',
			  data: {
			    castx : cast,
			    iddesx: iddes,
			    revix: revi,
			    idux: idu
			  },
			  success: function (response) {
			   $('#p_review').html("");
			   $('.overlay_rating').fadeOut("fast");
			  },
	          error: function (textStatus, errorThrown) {
	          	alert("ajax error(out of memory)");//doesnt goes here
	          }
		  });
	  	
	});	

	$("#ceki").click(function(e){
		e.preventDefault(); 
	  	var cek = $('#ceki').attr('rel');
	  	$.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/cekotw.php',
			  data: {
			    cast : cek
			  },
			  success: function (response) {
			   $('#ceki').hide();
			  },
	          error: function (textStatus, errorThrown) {
	          	alert("ajax error(out of memory)");//doesnt goes here
	          }
		  });
	  	
	});

	$("#ontw").click(function(e){
		e.preventDefault(); 
	  	var cek = $('#ontw').attr('rel');
	  	$.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/cekotw.php',
			  data: {
			    cast : cek
			  },
			  success: function (response) {
			   $('#ontw').hide();
			  },
	          error: function (textStatus, errorThrown) {
	          	alert("ajax error(out of memory)");//doesnt goes here
	          }
		  });
	  	
	});
</script>
</body>

</html>