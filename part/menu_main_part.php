<?php 
$dbu=new db();
?>
		<button class="burger-menu burger-menu-x">
			<span>toggle menu</span>
		</button>
		<div class="wrapmenu">
			<ul class="mainmenu">
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='1' and id_bahasa ='".$_SESSION[bhs]."'")."/";?>" class="active">
						<img src="<?php echo $app["css_www"];?>/img/ic-home.png"/>
						<span>Home</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic-wisata.png"/>
						<span>Destination</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='3' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic-komunitas.png"/>
						<span>Community</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='4' and id_bahasa='".$_SESSION[bhs]."'")."/article/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_thread.png"/>
						<span>Store</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='5' and id_bahasa='".$_SESSION[bhs]."'")."/all/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_news.png"/>
						<span>News</span>
					</a>
				</li>
				<?php if($_SESSION[member][id]!=""){ ?>
				<li>
					<label>PERSONAL</label>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='6' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_newsfeed.png"/>
						<span>Newsfeed</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='7' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_mytrip.png"/>
						<span>My Trip</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_friends.png"/>
						<span>Friends</span>
					</a>
				</li>
				<li>
					<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='9' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">
						<img src="<?php echo $app["css_www"];?>/img/ic_photos.png"/>
						<span>Photos</span>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div><!-- /.wrapmenu -->