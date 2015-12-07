<?php 
$dbu = new db();
$urlx = new url();
?>
<div class="wrapheader">
			<div class="header">
				<div class="search_box">
					<input type="text" id="katakunci" placeholder="Search your destination...">
					<input type="submit" id="cari_search" value="">
					<input type="button" value="Advance Search" class="advance_search">
					<div class="arrow_search">▼</div>
				</div>
				<div class="advanced_search">
					<form action="">
						<div class="add_fix">
							<span>Keyword</span><i>:</i><input type="text">
						</div>
						<div class="add_fix">
							<span>Negara</span><i>:</i>
							<Select>
								<option>Pilih Negara</option>
								<option>Indonesia</option>
							</select>
						</div>
						<div class="add_fix">
							<span>Provinsi</span><i>:</i>
							<Select>
								<option>Pilih Provinsi</option>
								<option>Jawa Timur</option>
							</select>
						</div>
						<div class="add_fix">
							<span>Kota</span><i>:</i>
							<Select>
								<option>Pilih Kota</option>
								<option>Surabaya</option>
							</select>
						</div>
						<div class="add_fix">
							<span>Type</span><i>:</i>
							<input type="radio" name="btnevent"  value="" checked="checked"/>&nbsp;<label id="btnevent">Event</label>
							<input type="radio" name="btndestinasi"  value=""/>&nbsp;<label id="btnevent">Destinasi</label>
						</div>
						<div class="add_fix">
							<span>&nbsp;</span><i>&nbsp;</i>
							<input type="checkbox" name="checkarticle" value="article">&nbsp;<label id="checkarticle">Article</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="checkevent" value="event">&nbsp;<label id="checkevent">Event</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="checknews" value="news">&nbsp;<label id="checknews">News</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="checktrip" value="trip">&nbsp;<label id="checktrip">Trip</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="checkstore" value="store">&nbsp;<label id="checktrip">Store</label>
						</div>
						<div class="add_fix">
							<span>Kategori</span><i>:</i>
							<input style="top:3px;" type="checkbox" name="checksejarah" value="sejarah">&nbsp;<label id="checksejarah" style="top:2px;">Article</label>&nbsp;&nbsp;&nbsp;
							<input style="top:3px;" type="checkbox" name="checkpetualangan" value="petualangan">&nbsp;<label id="checkevent" style="top:2px;">Petualangan</label>&nbsp;&nbsp;&nbsp;
						</div>
						<div class="add_fix advanced_date">
							<span>Date</span><i>:</i>
							<span style="width:auto; margin-left:3px;">Start</span>
							<Select>
								<option>Pilih Kota</option>
								<option>Surabaya</option>
							</select>
							<span style="width:auto; margin-left:10px;">End</span>
							<Select>
								<option>Pilih Kota</option>
								<option>Surabaya</option>
							</select>
							<br />
							<input type="checkbox" name="checkexactdate" value="exactdate" style="top:-5px; margin-left:10px;">&nbsp;<label style="top:-7px;" id="checkexactdate">Exact Date</label>&nbsp;&nbsp;&nbsp;
						</div>
						<div class="add_fix">
							<input type="submit" value="SUBMIT">
							<input type="reset" value="RESET">
						</div>
					</form>
				</div>
				
				<div id="hasilcari"></div>
				<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='23' and id_bahasa='".$_SESSION[bhs]."'")."/";?>" class="nearby_link"><span>Nearby Place</span></a>
				<?php
					if($_SESSION[member]['id']!=""){
				?>
				<div class="circle_pict ava_head">
					<a href="#"><img src="<?php echo $app[data_www]; ?>/pengguna/avatar/<?php echo $_SESSION[member][ava]; ?>"></a>
				</div>
				<div class="box_account">
					<img class="tip" src="<?php echo $app[css_www]; ?>/images/tip.png">
					<div class="wrap_shorcut_user">
						<h1><?php echo $_SESSION[member][uname]; ?></h1>
						<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($_SESSION[member][uname])."/";?>"><span>MY PROFILE</span></a>
					</div>
					<a href="<?php echo $app["www"]."/logout/";?>" class="sign-out" >SIGN OUT</a>
				</div>
				<a href="#" class="notification">
					<span><b>12</b></span>
				</a>
				<?php }else{ ?>
					<a href="#" class="login_link"><span>Login / Register</span></a>
				<?php 
					}
				?>
				<!-- <a href="#" class="login_link"><span>Login / Register</span></a> -->
			</div>
			<a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='1' and id_bahasa='".$_SESSION[bhs]."'")."/";?>" class="logo"><img src="<?php echo $app["css_www"];?>/img/logo.png"/></a>
		</div><!-- /.wrapheader -->
<script type="text/javascript">
	function set_action(param, act)
	{
	var param = param;
	param.form.act.value = act;
	param.form.target = '_self';
	param.form.submit();	
	}
	// AJAX call for autocomplete
var MIN_LENGTH = 2; 
	$("#katakunci").keyup(function(){
		var keyword = $("#katakunci").val();
		if (keyword.length >= MIN_LENGTH) {
			$.ajax({
				type: "POST",
				url: "<?php echo $app[lib_www] ?>/xaja/autocomplete.php",
				data:'keyword='+$(this).val(),
				success: function(data){
					$("#hasilcari").show();
					$("#hasilcari").html(data);
				}
			});
		}else{
			$("#hasilcari").hide();
		}
	});
//To select country name
function pilihDestinasi(val,urlnya) {
	if(val!=""){
		window.location = urlnya;
	}
	$("#katakunci").val(val);
	$("#hasilcari").hide();
};

$('#cari_search').click(function(){
	var cast = $("#katakunci").val();
	var kas = "/all/";
	cast = cast.replace(" ","_");
	
	if(cast != ""){
		kas = kas + cast + "/"
	}
	//alert(cast);
	$.ajax({
		  type: 'post',
		  url: '<?php echo $app[lib_www] ?>/xaja/loadDestinasi.php',
		  data: {
		    cast : kas
		  },
		  success: function (response) {
		  	window.location = response;
		  },
	      error: function (textStatus, errorThrown) {
	      	alert("ajax error(out of memory)");//doesnt goes here
		}
	});
});
</script>
