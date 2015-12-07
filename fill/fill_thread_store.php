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
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/";?>">ARTICLE</a></li>
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/trip/";?>">TRIP</a></li>
								<li class="active"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/store/";?>">STORE</a></li>
							</ul>
							<div class="box_ic_nf">
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_srch.png"></a>
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_agn.png"></a>
							</div>
						</div>
						<div class="breadcrumb"><a href="#">Home</a> > <a href="#">Forum</a> > <a href="#">Destinasi</a> > <a href="#">Tempat Wisata</a> > <a href="#">Bromo Mount</a></div>
						<div class="paging_thread add_fix">
							<a class="add_f" href="#">Post Reply</a>
							<div class="pull-right">
								<ul class="pagination">
									<li class="page-count">Page 1 of 411</li>
									<li class="active"><a>1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#"><i style="color:#7b7b7b;font-size: 12px;" class="demo-icon icon-right-open">&#xe800;</i></a></li>
									<li><a href="#"><i style="color:#7b7b7b;font-size: 12px;" class="demo-icon icon-fast-fw">&#xe805;</i></a></li>
								</ul>
							</div>
						</div>
						<div class="forum-control add_fix">
							<div class="rating">
								<div style="width:90%" class="bg_rate"></div>
								<div class="rate_new"></div>
							</div>
							<div class="sosmed">
								<span>Share this article</span>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/tw.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/fb.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/g+.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/dg.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/sq.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/ic.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/sv.png"></a>
								<a href="#"><img src="<?php echo $app[css_www];?>/images/em.png"></a>
							</div>
						</div>
						
						<div class="postlist">
							<div class="entry-head">
								<div class="time_post">21 Desember 2015 | 09:00</div>
								<div class="shorcut_post">
									<div class="rate_post"><a href="#"><i style="color:#fff;" class="demo-icon icon-star">&#xe804;</i></a></div>
									<div class="report"><a href="#"><i style="color:#fff;" class="demo-icon icon-attention">&#xe803;</i></a></div>
								</div>
							</div>
							<div class="author add_fix">
								<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
								<div class="user_details">
									<h1>Lorem Ipsum</h1>
									<span><i>Travel Addict</i> - Surabaya</span>
									<p>Join: 30-06-2013, Post: 7,187</p>
								</div>
								<a href="#" class="buy_this">BUY</a>
							</div>
							<div class="post_entry">
								<h1 class="title_entry">Mount Bromo, Indonesia</h1>
								<span class="quote_post">Mount Bromo is still one of the most active volcanoes in the world and there are areas that are blocked off from tourists due to its imminent danger.</span>
								<div class="rich_text">
								<p>It sits inside the massive Tengger caldera (volcanic crater with diameter approximately 10km), surrounded by the Laut Pasir (sea of sand) of fine volcanic sand. This breathtaking and ethereal landscape have been swooned by many travelers alike.<br/><br/>
								Myth has it that Mount Bromo is significant to the Tengger people who believe that the site is where their brave prince sacrificed his life for his family. To appease the Gods, the people will offer food and money by throwing it into the crater of the volcano once a year during annual Kasada (or Kasodo) festival.</p><img src="<?php echo $app[css_www];?>/img/img_des.jpg">
								</div>
								
								<div class="reply_post">
									<div class="user_reply">
										<a href="#"><div class="sh"><i class="demo-icon icon-down-circle">&#xe806;</i></div></a>Lorem ipsum said:
									</div>
									<div class="rich_text">
										<p>Every lodge, guesthouse or hotel normally serves food as well for travelers. There are also few independent eateries around to choose from such as Bromo Corner Café and Waroeng Basuki, or you may just head on to simple roadside warungs and enjoy basic local Indonesian food.<br/><br/>

										You should also try out the hot Javanese coffee (kopi panas). All restaurants will open by 3am as that is when most people start to wake for the hike to catch the sunrise. If you forget to bring food, the restaurants near Mount Bromo open from 3 am. They generally provide various types of Indonesian traditional dishes such as Ketoprak, fried rice, Rujak Cingur, Bandrek, etc.<br/><br/>

										Sun rises at 5.30am, therefore usually you have to plan when to start hiking depending on your fitness level. Maps and information are readily and easily available at one of the many official locations.<br/><br/>

										Extra tip is that you may want to hike earlier to avoid the crowd and get a good spot as you may find a lot of people crowding the vantage point to view the sun rising over Mount Bromo.<br/><br/>
										</p>
									</div>
								</div> <!-- reply post -->
							</div>
							<div class="entry_footer">
								<p>Last edited by: loremipsum 12-08-2015 11:01</p>
								<div class="user_tools">
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-chat">&#xe802;</i> Multi Quote</a>
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-comment">&#xe801;</i> Quote</a>
								</div>
							</div>
						</div> <!-- postlist -->
						
						<div class="postlist no-entry add_fix">
							<div class="entry-head">
								<div class="time_post">21 Desember 2015 | 09:00</div>
								<div class="shorcut_post">
									<div class="report"><a href="#"><i style="color:#fff;" class="demo-icon icon-attention">&#xe803;</i></a></div>
								</div>
							</div>
							<div class="author add_fix">
								<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
								<div class="user_details">
									<h1>Lorem Ipsum</h1>
									<span><i>Travel Addict</i> - Surabaya</span>
									<p>Join: 30-06-2013, Post: 7,187</p>
								</div>
							</div>
							<div class="post_entry">
								<div class="rich_text">
								<p>It sits inside the massive Tengger caldera (volcanic crater with diameter approximately 10km), surrounded by the Laut Pasir (sea of sand) of fine volcanic sand. This breathtaking and ethereal landscape have been swooned by many travelers alike.<br/><br/>
								Myth has it that Mount Bromo is significant to the Tengger people who believe that the site is where their brave prince sacrificed his life for his family. To appease the Gods, the people will offer food and money by throwing it into the crater of the volcano once a year during annual Kasada (or Kasodo) festival.</p></div>
							</div>
							<div class="entry_footer">
								<div class="user_tools">
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-chat">&#xe802;</i> Multi Quote</a>
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-comment">&#xe801;</i> Quote</a>
								</div>
							</div>
						</div> <!-- postlist -->
						
						<div class="postlist no-entry add_fix">
							<div class="entry-head">
								<div class="time_post">21 Desember 2015 | 09:00</div>
								<div class="shorcut_post">
									<div class="report"><a href="#"><i style="color:#fff;" class="demo-icon icon-attention">&#xe803;</i></a></div>
								</div>
							</div>
							<div class="author add_fix">
								<div class="circle_pict circle_pict_nf"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div>
								<div class="user_details">
									<h1>Lorem Ipsum</h1>
									<span><i>Travel Addict</i> - Surabaya</span>
									<p>Join: 30-06-2013, Post: 7,187</p>
								</div>
							</div>
							<div class="post_entry">
								<div class="reply_post">
									<div class="user_reply">
										<a href="#"><div class="sh"><i class="demo-icon icon-down-circle">&#xe806;</i></div></a>Lorem ipsum said:
									</div>
									<div class="rich_text">
										<p>Every lodge, guesthouse or hotel normally serves food as well for travelers. There are also few independent eateries around to choose from such as Bromo Corner Café and Waroeng Basuki, or you may just head on to simple roadside warungs and enjoy basic local Indonesian food.<br/><br/>

										You should also try out the hot Javanese coffee (kopi panas). All restaurants will open by 3am as that is when most people start to wake for the hike to catch the sunrise. If you forget to bring food, the restaurants near Mount Bromo open from 3 am. They generally provide various types of Indonesian traditional dishes such as Ketoprak, fried rice, Rujak Cingur, Bandrek, etc.<br/><br/>

										Sun rises at 5.30am, therefore usually you have to plan when to start hiking depending on your fitness level. Maps and information are readily and easily available at one of the many official locations.<br/><br/>

										Extra tip is that you may want to hike earlier to avoid the crowd and get a good spot as you may find a lot of people crowding the vantage point to view the sun rising over Mount Bromo.<br/><br/>
										</p>
									</div>
								</div> <!-- reply post -->
								<div class="rich_text">
								<p>It sits inside the massive Tengger caldera (volcanic crater with diameter approximately 10km), surrounded by the Laut Pasir (sea of sand) of fine volcanic sand. This breathtaking and ethereal landscape have been swooned by many travelers alike.<br/><br/>
								Myth has it that Mount Bromo is significant to the Tengger people who believe that the site is where their brave prince sacrificed his life for his family. To appease the Gods, the people will offer food and money by throwing it into the crater of the volcano once a year during annual Kasada (or Kasodo) festival.</p></div>
							</div>
							<div class="entry_footer">
								<div class="user_tools">
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-chat">&#xe802;</i> Multi Quote</a>
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-comment">&#xe801;</i> Quote</a>
								</div>
							</div>
						</div> <!-- postlist -->
						<div class="box_nxpr_thread">
							<div class="paging_thread add_fix">
								<a href="#" class="add_f">Post Reply</a>
								<div class="pull-right">
									<ul class="pagination">
										<li class="page-count">Page 1 of 411</li>
										<li class="active"><a>1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#">4</a></li>
										<li><a href="#"><i class="demo-icon icon-right-open" style="color:#7b7b7b;font-size: 12px;"></i></a></li>
										<li><a href="#"><i class="demo-icon icon-fast-fw" style="color:#7b7b7b;font-size: 12px;"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="nxpr add_fix">
								<a href="#">Next Thread ></a>
								<a href="#">< Previous Thread</a>
							</div>
						</div>
						
					</div> <!-- content_left -->	
					<div class="content_right thread_section">
						<?php include "part/block_tombol_thread.php"; ?>
						<div class="thread">
							<h1 class="main_title" style="padding: 15px 15px 7px;">HOT THREAD<span class="border"></span></h1>
							<a href="#" class="shortcut_addthr">+ Add Thread</a>
							<ul>
								<li>
									<a href="detil_thread.html"><span>Lorem Ipsum is a simply dummy text of type</span></a>
									<p>oleh <a href="#"><i>lorem ipsum</i></p></a>
								</li>
								<li>
									<a href="detil_thread.html"><span>Lorem Ipsum is a simply dummy text of type</span></a>
									<p>oleh <a href="#"><i>lorem ipsum</i></p></a>
								</li>
								<li>
									<a href="detil_thread.html"><span>Lorem Ipsum is a simply dummy text of type</span></a>
									<p>oleh <a href="#"><i>lorem ipsum</i></p></a>
								</li>
								<li>
									<a href="detil_thread.html"><span>Lorem Ipsum is a simply dummy text of type</span></a>
									<p>oleh <a href="#"><i>lorem ipsum</i></p></a>
								</li>
							</ul>
							<a href="thread.html" class="explore">VIEW MORE</a>
						</div>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
		<div class="overlay-body"></div>
		<div class="overlay_shopping">
			<div class="box-price-des box-shop">
				<div class="title-des">SHOPPING CART<img class="close" src="<?php echo $app[css_www];?>/img/close.png"></div>
				<div class="upd-by-des"><span>BOOKED BY :</span><div class="circle_pict"><a href="#"><img src="<?php echo $app[css_www];?>/images/ava.jpg"></a></div></div>
				<table>
					<tr>
						<th>Item</th>
						<th>Price</th>		
						<th>Qty</th>				
						<th>Total</th>				
					</tr>
					<tr style="border-bottom:1px solid #dad9d9;">
						<td>1. Lorem Ipsum</td>				
						<td>100.000</td>				
						<td>
							<select>
								<option>1</option>
								<option>2</option>
								<option>3</option>
							</select>
						</td>				
						<td>200.000</td>				
					</tr>
					<tr>
						<td class="add-item-shop" colspan="4"><a href="#"><span>Add Item</span></a></td>			
					</tr>
				</table>
				<div class="subtot add_fix">
					<div class="add_fix">
						<p>Sub Total :</p>
						<span>200.000</span>
					</div>
				</div>
				<div class="subtot add_fix">
					<div class="checkout"><a href="">Check Out</a></div>
					<a href="#" class="donate">Donate</a>
				</div>
			</div>
		</div> <!-- overlay_shopping -->
	</div>	
</body>
</html>