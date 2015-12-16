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
					<div class="circle_pict circle_pict_nf">
						<a href="#"><img src="<?php echo $app[data_www];?>/pengguna/avatar/<?php echo $dprof[avatar]; ?>"></a></div>
					<div class="con_banner_community">
						<h1 class="main_title"><?php echo $dprof[nama]; ?><span class="border"></span></h1>
						<div class="litle_quotes"><img src="<?php echo $app[css_www];?>/images/ic_q_left.png">Mount Bromo which stands tall at 2329 m is one of the most iconic mountain in Indonesia.<img src="<?php echo $app[css_www];?>/images/ic_q_right.png"></div>
						<div class="statictic_community add_fix">
							<span class="ic_loc">Location <b>Malang, East Java</b></span>
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
								<li><a href="#">TRIP</a></li>
								<li><a href="#">FRIENDS</a></li>
								<li><a href="#">PHOTO</a></li>
							</ul>
							<?php 
							if($dprof[id]!=$_SESSION[member][id]){ 
								#DEFAULT -> FOLLOW
								$foll = '<a href="#" id="cfollow" rel="follow_'.$dprof[id].'" class="join_community">FOLLOW</a>';
								
								#CEK APPROVED FOLLOW -> UNFOLLOW
								$follx = $dbu->lookup("status",$app[table][daftar_teman],"id_user = '".$_SESSION[member][id]."' AND id_teman ='".$dprof[id]."' AND approved = 'Y'");
								if($follx != ""){
									$foll = '<a href="#" id="cfollow" rel="unfollow_'.$dprof[id].'" class="join_community">UNFOLLOW</a>';
								}
								
								#CEK NOT APPROVED YET 
								$follx = $dbu->lookup("status",$app[table][daftar_teman],"id_user = '".$_SESSION[member][id]."' AND id_teman ='".$dprof[id]."' AND approved = 'N'");
								
								if($follx != ""){
									$foll = '<a class="join_community">WAITING FOR APPROVAL</a>';
								}

							}
								#LINK FOLLOW / UNFOLLOW / WAIT 4 APPROVAL
								echo $foll; ?>
						</div>
							<div class="box_itm_newsfeed add_fix">
								<?php echo $feed; ?>
							</div>
					</div> <!-- content_left -->

					<div class="content_right thread_section" style="padding-top:20px">
						<a class="ad_new_trip" href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/articles/" ?>">Create Destination</a>
						<a class="add_plan" href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/articles/" ?>">Create News</a>
					</div>

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
	<?php
	echo $tampil->tampilkan_footer('main');
	?>
	</div>	
	<script type="text/javascript">
	$('textarea').keyup(function(e) {
    if(e.which == 13) {
    	var idnya = this.id;
    	if(idnya == "cekin"){
    		var idcek = $('#list_'+idnya).attr('rel');
    		var komennya = $('#'+idnya).val();
    		$.ajax({
				  type: 'post',
				  url: '<?php echo $app[lib_www] ?>/xaja/komenCekin.php',
				  data: {
				    komen : komennya,
				    idc: idcek
				  },
				  success: function (response) {
				   $('#'+idnya).val(null);
				   $('#list_'+idnya).append(response);
				  }
			  });    		
    	}
    }
});
	</script>
</body>
</html>