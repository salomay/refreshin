<?php 
$tampil = new usrlib();
echo $tampil->tampilkan_doctype('main');
echo $tampil->tampilkan_header('main');
echo $tampil->tampilkan_menu('main');
$dbu = new db();
$appx = new app();
$urlx = new url();
 
?>
		<div class="wrapcontent">
			<div class="content add_fix">
				<div class="box-left-right add_fix">
					<div class="content_left thread_section">
						<div class="head_nf">
							<ul>
								<li class="active"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/";?>">ARTICLE</a></li>
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/trip/";?>">TRIP</a></li>
								<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/store/";?>">STORE</a></li>
							</ul>
							<div class="box_ic_nf">
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_srch.png"></a>
								<a class="ic_nf" href="#"><img src="<?php echo $app[css_www];?>/images/ic_agn.png"></a>
							</div>
						</div>
						<div class="breadcrumb"><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='1' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">Home</a> > <a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">Forum</a> > <a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/";?>">Article</a> > <a href="<?php echo $app[www]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/".$urlx->shortLink($dfa[destinasi])."/" ?>"><?php echo $dfa[destinasi] ?></a> > <?php echo $dfa[id]; ?></div>
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
						</div>
						
						<div class="postlist">
							<div class="entry-head">
								<div class="time_post"><?php echo $tglpost; ?></div>
								<div class="shorcut_post">
									<!--<div class="rate_post"><a href="#"><i style="color:#fff;" class="demo-icon icon-star">&#xe804;</i></a></div>-->
									<div class="report"><a href="#"><i style="color:#fff;" class="demo-icon icon-attention">&#xe803;</i></a></div>
								</div>
							</div>
							<div class="author add_fix">
								<div class="circle_pict circle_pict_nf">
									<a href="<?php echo $linkAva;?>">
										<img src="<?php echo $dfa[avatar];?>">
									</a>
								</div>
								<div class="user_details">
									<h1><?php echo $dfa[username]; ?></h1>
									<span><i>Travel Addict</i> - Surabaya</span>
									<p>Join: <?php echo $tgljoin; ?>, Post: <?php echo $hitJml; ?></p>
								</div>
							</div>
							<div class="post_entry">
								<h1 class="title_entry"><?php echo $dfa[judul]; ?></h1>
								<div class="rich_text">
								<?php
								$dfa[isi] = str_replace("[img]",'"<img src="',$dfa[isi]);
								$dfa[isi] = str_replace("[/img]",'" />"',$dfa[isi]);
								$dfa[isi] =str_replace("[quote]",'<span clas="quote_post">',$dfa[isi]);
								$dfa[isi] =str_replace("[/quote]",'</span>',$dfa[isi]);
								echo $dfa[isi];
								?>
								</div>								
							</div>
							<div class="entry_footer">
								<p>Last edited by: <?php echo $dfa[username]; ?> <?php echo $dfa[lastUpdate]; ?></p>
								<div class="user_tools">
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-chat">&#xe802;</i> Multi Quote</a>
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-comment">&#xe801;</i> Quote</a>
								</div>
							</div>
						</div> <!-- postlist -->						
						<?php 
						//$lalala = "aaa[/qreq]";
								//echo strpos($lalala,"[/qreq]");exit;
						if($nkomen>0){
							while($dkomen = $dbu->fetch($rkomen)){
							$tglpos = explode(" ",$dkomen[tgl_post]);
							$tglpost = $appx->format_date($tglpos[0],$_SESSION[bhs],'N')." | ".$tglpos[1];
							$tgljoin = $appx->format_date($dkomen[tgljoin],$_SESSION[bhs],'N');
							$dkomen[avatar] = $appx->cekFile("/pengguna/avatar/",$dkomen[avatar]);
							$dkomen[avatar] = $app[data_www]."/pengguna/avatar/".$dkomen[avatar];
							$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dkomen[username])."/";
							$hitJml = $dbu->count_record("SELECT count(id) as jumlah FROM ".$app[table][forum]." WHERE id_user = '".$dkomen[id]."'");
						?>
						<div class="postlist no-entry add_fix">
							<div class="entry-head">
								<div class="time_post"><?php echo $tglpost; ?></div>
								<div class="shorcut_post">
									<div class="report"><a href="#"><i style="color:#fff;" class="demo-icon icon-attention">&#xe803;</i></a></div>
								</div>
							</div>
							<div class="author add_fix">
								<div class="circle_pict circle_pict_nf"><a href="<?php echo $linkAva;?>"><img src="<?php echo $dfa[avatar];?>"></a></div>
								<div class="user_details">
									<h1><?php echo $dfa[username]; ?></h1>
									<span><i>Travel Addict</i> - Surabaya</span>
									<p>Join: <?php echo $tgljoin; ?>, Post: <?php echo $hitJml; ?></p>
								</div>
							</div>
							<div class="post_entry">
								<?php
								$dkomen[isi] = str_replace("[img]",'"<img src="',$dkomen[isi]);
								$dkomen[isi] = str_replace("[/img]",'" />"',$dkomen[isi]);
								$dkomen[isi] =str_replace("[quote]",'<span clas="quote_post">',$dkomen[isi]);
								$dkomen[isi] =str_replace("[/quote]",'</span>',$dkomen[isi]);
								$dkomen[isi] =str_replace("[/quote]",'</span>',$dkomen[isi]);
								$akhirq = strpos($dkomen[isi],"[/qreq]");
								if($akhirq>0){
									$quotnya = substr($dkomen[isi],0,$akhirq);
									$awalq = strpos($quotnya,"[qreq]") + 6;
									$quotnya = substr($quotnya, $awalq);

									$cekex = strpos($quotnya,"|");
									if($cekex > 0){
										$cekex = explode("|", $quotnya);
									}else{
										$cekex[0] = $quotnya;
									}
									//print_r($cekex);
									$komen ="";
									for ($i=0;$i<=count($cekex)-1;$i++){
										$sql ="SELECT a.isi, a.tgl_post as tgl_komen, b.username FROM ".$app[table][forum_komen]." as a LEFT JOIN ".$app[table][pengguna]." as b ON (a.id_user = b.id) WHERE a.id ='".$cekex[$i]."'";
										//echo $sql;
										$x1 = $dbu->get_recordmix($sql);
										$awal = strpos($x1[isi],"[/qreq]") + 7;
										$panjang = strlen($x1[isi]) - $awal;
											$x1[isi] = substr($x1[isi], $awal,$panjang);
										$komen .='<div class="reply_post"><div class="user_reply">
										<a href="#"><div class="sh"><i class="demo-icon icon-down-circle">&#xe806;</i></div></a>'.$x1[username].' said:
									</div>
									<div class="rich_text">'.$x1[isi];
										;
									}
									for ($i=0;$i<=count($cekex)-1;$i++){
										$komen .="</div>									
								</div>";
									}
								} 
								echo $komen;
								#"[qreq]11111|22222|33333[/qreq]"
								?>
								<div class="rich_text">
								<?php 
								$awal = strpos($dkomen[isi],"[/qreq]") + 7;
								$panjang = strlen($dkomen[isi]) - $awal;
									echo substr($dkomen[isi], $awal,$panjang);
								?>
								</div>
							</div>
							<div class="entry_footer">
								<div class="user_tools">
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-chat">&#xe802;</i> Multi Quote</a>
									<a href="#"><i style="color:#085f7d;font-size:19px;" class="demo-icon icon-comment">&#xe801;</i> Quote</a>
								</div>
							</div>
						</div> <!-- postlist -->
						<?php }
						}
						?>
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
						<?php 
							include "part/block_tombol_thread.php";
							include "part/block_hot_thread.php";
						?>
						</div>
					</div> <!-- content_right -->
				</div> <!-- box-left-right add_fix -->
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>