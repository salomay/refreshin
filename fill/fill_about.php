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
				<div class="content_category add_fix" style="height:530px;">
					<img class="bg_about" src="<?php echo $app[css_www];?>/img/bg-about.jpg">
					<div class="tagline about-tagline">
						<h1>ABOUT US</h1>
						<h2>Lest go outside</h2>
						<h1 style="margin-top:10px;">Find all destination & prosper them</h1>
						<a href="#"><img src="<?php echo $app[css_www];?>/img/gplay.png"></a>
						<a href="#"><img src="<?php echo $app[css_www];?>/img/apstore.png"></a>
					</div>
				</div><!-- /.content_category -->
				<div class="about_content">
					<div class="section-1">
						<h1 class="main_title" style="text-align:center;font-size:30px;">WHAT IS REFRESHIN?</h1>
						<p>are internet based program that give tourism community place to shared their activity and information so they can reach people all around the world. We offered companionship and partnership to them, so we both can help tourism prosperity that mostly abandoned. Refreshin also give optimum information to our tourister(user of this application), so they can have usable information about what thay can do, is there are any tourism nearby ,how much it cost etc. And again its all about tourism prosperity.<p>
						<ul class="add_fix">
							<li>
								<div class="point-about">
									<img src="<?php echo $app[css_www];?>/images/about-point1.jpg">
									<div class="circle">1</div>
								</div>
								<div class="con-point-about">
									<h1>All about tourism</h1>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
							</li>
							<li>
								<div class="point-about">
									<img src="<?php echo $app[css_www];?>/images/about-point2.jpg">
									<div class="circle">2</div>
								</div>
								<div class="con-point-about">
									<h1>Filled by community or trusted people</h1>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
							</li>
							<li>
								<div class="point-about">
									<img src="<?php echo $app[css_www];?>/images/about-point3.jpg">
									<div class="circle">3</div>
								</div>
								<div class="con-point-about">
									<h1>Find Nearby Place</h1>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
							</li>
							<li>
								<div class="point-about">
									<img src="<?php echo $app[css_www];?>/images/about-point4.jpg">
									<div class="circle">4</div>
								</div>
								<div class="con-point-about">
									<h1>Share your travel status</h1>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
							</li>
							<li>
								<div class="point-about">
									<img src="<?php echo $app[css_www];?>/images/about-point5.jpg">
									<div class="circle">5</div>
								</div>
								<div class="con-point-about">
									<h1>Charity program</h1>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								</div>
							</li>
						</ul>
					</div>
					<div class="section-2">
						<div class="box-section-2">
							<h1 class="main_title" style="text-align:center;font-size:30px;background:none;">ALL ABOUT</h1>
							<h2 class="tou-sy">TOURISM</h2>
							<div class="mid-about">
								<div class="box-about add_fix">
									<div class="imleft"><img src="<?php echo $app[css_www];?>/images/img-about.png"></div>
									<div class="imright">
										<div class="boxed">
											<div class="box_title_bout"><span class="title_bout">All About Tourism</span></div>
											<div class="con_bout">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, and scrambled it to make a type specimen book.</div>
										</div>
									</div>
								</div>
								<div class="box-about add_fix">
									<div class="imleft">
										<div class="boxed">
											<div class="box_title_bout"><span class="title_bout">Filled by community or trusted people</span></div>
											<div class="con_bout">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, and scrambled it to make a type specimen book.</div>
										</div>
									</div>
									<div class="imright">
										<img src="<?php echo $app[css_www];?>/images/img-about2.png">
									</div>
								</div>
								<div class="box-about add_fix">
									<div class="imleft">
										<img src="<?php echo $app[css_www];?>/images/img-about3.png">
									</div>
									<div class="imright">
										<div class="boxed">
											<div class="box_title_bout"><span class="title_bout">Find Nearby Place</span></div>
											<div class="con_bout">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, and scrambled it to make a type specimen book.</div>
										</div>
									</div>
								</div>
								<div class="box-about add_fix">
									<div class="imleft">
										<div class="boxed">
											<div class="box_title_bout"><span class="title_bout">Share your travel status</span></div>
											<div class="con_bout">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, and scrambled it to make a type specimen book.</div>
										</div>
									</div>
									<div class="imright">
										<img src="<?php echo $app[css_www];?>/images/img-about4.png">
									</div>
								</div>
							</div>
						</div>
					</div> <!-- section-2 -->
					<div class="section-3">
						<img class="bg-footer-about" src="<?php echo $app[css_www];?>/img/bg-footer-about.jpg">
						<div class="con-section-3">
							<img src="<?php echo $app[css_www];?>/img/img-mid-ft.png">
							<p>Setiap keuntungan transaksi sebagian akan disumbangkan untuk kepentingan kepariwisataan</p>
							<div class="wrap-subscribe">
								<input type="text" placeholder="Enter Your email for subscribe">
								<input type="submit" value="Subscribe">
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>