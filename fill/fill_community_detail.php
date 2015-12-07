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
				<div class="banner_community">
					<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $komm[logo] ?>"></a></div>
					<div class="con_banner_community">
						<?php 
						#cek apakah user anggota/ jika iya apa posisinya
						$posisinya ="";
						if($_SESSION[member][id]!=""){
							$posisinya = $dbu->lookup("posisi",$app[table][komunitas_pengguna]," id_user='".$_SESSION[member][id]."' AND id_komunitas='".$komm[id]."'");
							if($posisinya!=""){
								$posisinya = " - [ ".$posisinya." ]";
							}
						}
						?>
						<h1 class="main_title"><?php echo $komm[nama].$posisinya; ?><span class="border"></span></h1>
						<div class="litle_quotes"><img src="<?php echo $app[css_www];?>/images/ic_q_left.png"><?php echo $komm[slogan]; ?><img src="<?php echo $app[css_www];?>/images/ic_q_right.png"></div>
						<div class="statictic_community add_fix">
							<span class="ic_m">Member <b><?php 
									$jml_ang = $dbu->count_record("id",$app[table][komunitas_pengguna],"where id_komunitas ='".$komm[id]."'");
									echo  $appx->number_to_K($jml_ang) ?></b></span>
							<span class="ic_loc">Location <b><?php echo $komm[lokasi]; ?></b></span>
							<span class="ic_link">Website <b><a href="http://<?php echo $komm[website]; ?>"><?php echo $komm[website]; ?></a></b></span>
						</div>
					</div>
					
					<div class="overlay"></div>
					<img class="img_banner" src="<?php echo $app[css_www];?>/images/banner_community.jpg">
				</div>
				<div class="box-left-right add_fix">
					<div class="content_left community_section">
						<div class="head_nf head_nf_community">
							<ul>
								<li class="active"><a href="#">ACTIVITY</a></li>
								<li><a href="#">THREAD</a></li>
								<li><a href="#">GALLERY</a></li>
								<li><a href="#">MEMBER</a></li>
							</ul>
							<?php if($_SESSION[member][id]!=""){
								$cek = $dbu->lookup("id",$app[table][komunitas_pengguna],"id_user='".$_SESSION[member][id]."'");
								if($cek!=""){
								?>
									<a href="#" id="unjoinx" class="join_community">UNJOIN</a>
								<?php
								}else{ ?>
									<a href="#" id="joinx" class="join_community">JOIN</a>
								<?php
								}
							}else{ ?>
								<a class="join_community">NEED LOGIN</a>
							<?php } ?>
						</div>
							<div class="box_itm_newsfeed add_fix">
								<div class="con_newsfeed add_fix">
									<div class="line_newsfeed">
										<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
										<div class="bar"></div>
										<div class="ic_cat"><a href="#"><img src="<?php echo $app[css_www];?>/images/ic_cat_1.png"></a></div>
									</div>
									<div class="box_con_newsfeed">
										<h1>Lorem Ipsum</h1>
										<span>4 Minutes Ago</span>
										<div class="frame_post">
											<div class="img_post"><a href="#"><img src="<?php echo $app[css_www];?>/images/img_post.jpg"></a></div>
											<span>Upcoming a trip <a href="#"><i>Explore East Java.</i></a></span>
											<label>12 Desember 2015</label>
											<div class="box_comment">
												<ul class="add_fix">
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<textarea placeholder="Write your comment..."></textarea>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div> <!-- con_newsfeed -->
								<div class="con_newsfeed add_fix">
									<div class="line_newsfeed">
										<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
										<div class="bar"></div>
										<div class="ic_cat"><a href="#"><img src="<?php echo $app[css_www];?>/images/ic_cat_2.png"></a></div>
									</div>
									<div class="box_con_newsfeed">
										<h1>Lorem Ipsum</h1>
										<span>4 Minutes Ago</span>
										<div class="frame_post">
											<span>Check In to <a href="#"><i>Bromo, East Java, Indonesia</i></a></span>
											<div class="box_comment">
												<ul class="add_fix">
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<textarea placeholder="Write your comment..."></textarea>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div> <!-- con_newsfeed -->
								<div class="con_newsfeed add_fix">
									<div class="line_newsfeed">
										<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
										<div class="bar"></div>
										<div class="ic_cat"><a href="#"><img src="<?php echo $app[css_www];?>/images/ic_cat_3.png"></a></div>
									</div>
									<div class="box_con_newsfeed">
										<h1>Lorem Ipsum</h1>
										<span>4 Minutes Ago</span>
										<div class="frame_post">
											<div class="box_img_post add_fix">
												<div class="img_post img_post_thumb">
													<a href="#"><img src="<?php echo $app[css_www];?>/images/thumb_nf.jpg"></a>
												</div>
												<div class="img_post img_post_thumb">
													<a href="#"><img src="<?php echo $app[css_www];?>/images/thumb_nf_1.jpg"></a>
												</div>
												<div class="img_post img_post_thumb">
													<a href="#"><img src="<?php echo $app[css_www];?>/images/thumb_nf.jpg"></a>
												</div>
											</div>
											<span>Uploaded to <a href="#"><i>Album Vacation</i></a></span>
											<div class="box_comment">
												<ul class="add_fix">
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<textarea placeholder="Write your comment..."></textarea>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<div class="text_box_c">
															<h1>Lorem Ipsum</h1>
															<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
														</div>
														</p>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div> <!-- con_newsfeed -->
								<div class="con_newsfeed add_fix">
									<div class="line_newsfeed">
										<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
										<div class="bar"></div>
										<div class="ic_cat"><a href="#"><img src="<?php echo $app[css_www];?>/images/ic_cat_2.png"></a></div>
									</div>
									<div class="box_con_newsfeed">
										<h1>Lorem Ipsum</h1>
										<span>4 Minutes Ago</span>
										<div class="frame_post">
											<span>Check In to <a href="#"><i>Borobudur, Central Java, Indonesia</i></a></span>
											<div class="box_comment">
												<ul class="add_fix">
													<li>
														<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
														<textarea placeholder="Write your comment..."></textarea>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div> <!-- con_newsfeed -->
							</div>
					</div> <!-- content_left -->
					<div class="content_right community_section_r">
						<div class="friend_activity" style="margin-top:0;">
							<h1 class="main_title" style="padding:15px;">FRIEND ACTIVITY<span class="border"></span></h1>
							<div class="box_list_rate">
								<div class="con_text_act add_fix">
									<div class="circle_pict" style="margin-right:10px;"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
									<div class="rich_text_act">
										<a href="#"><h1>Lorem Ipsum</h1></a>
										<p>Check In at <a href="#"><i>Mount Bromo</i></a>,East Java, Indonesia</p>
									</div>
								</div>
								<div class="con_text_act add_fix">
									<div class="circle_pict" style="margin-right:10px;"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
									<div class="rich_text_act">
										<a href="#"><h1>Lorem Ipsum</h1></a>
										<p>Mengomentari kiriman <a href="#"><i>Dolot sit amet</i></a></p>
									</div>
								</div>
								<div class="con_text_act add_fix">
									<div class="circle_pict" style="margin-right:10px;"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
									<div class="rich_text_act">
										<a href="#"><h1>Lorem Ipsum</h1></a>
										<p>Upload photo at <a href="#"><i>Lorem Ipsum Album</i></a></p>
									</div>
								</div>
							</div>
						</div>
						<div class="near_place">
							<h1 class="main_title" style="padding: 15px 15px 7px;">TOP DESTINATION<span class="border"></span></h1>
							<ul>
								<li class="add_fix">
									<div class="thumb_img"><img src="<?php echo $app[css_www];?>/images/thumb_near.jpg"></div>
									<div class="con_near_place">
										<a href="#"><span>Ijen, Indonesia</span></a>
										<a href="#"><p><i>179 Friends </i></a>has been here</p>
									</div>
									<a href="detail_destination.html" class="explore" style="float:left;padding: 0 10px;">EXPLORE MORE</a>
								</li>
								<li class="add_fix">
									<div class="thumb_img"><img src="<?php echo $app[css_www];?>/images/thumb_near.jpg"></div>
									<div class="con_near_place">
										<a href="#"><span>Ijen, Indonesia</span></a>
										<a href="#"><p><i>179 Friends </i></a>has been here</p>
									</div>
									<a href="detail_destination.html" class="explore" style="float:left;padding: 0 10px;">EXPLORE MORE</a>
								</li>
								<li class="add_fix">
									<div class="thumb_img"><img src="<?php echo $app[css_www];?>/images/thumb_near.jpg"></div>
									<div class="con_near_place">
										<a href="#"><span>Ijen, Indonesia</span></a>
										<a href="#"><p><i>179 Friends </i></a>has been here</p>
									</div>
									<a href="detail_destination.html" class="explore" style="float:left;padding: 0 10px;">EXPLORE MORE</a>
								</li>
								<li class="add_fix">
									<div class="thumb_img"><img src="<?php echo $app[css_www];?>/images/thumb_near.jpg"></div>
									<div class="con_near_place">
										<a href="#"><span>Ijen, Indonesia</span></a>
										<a href="#"><p><i>179 Friends </i></a>has been here</p>
									</div>
									<a href="detail_destination.html" class="explore" style="float:left;padding: 0 10px;">EXPLORE MORE</a>
								</li>
								
							</ul>
						</div>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>