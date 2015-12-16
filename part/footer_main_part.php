<?php $urlx = new url(); 
$dbu = new db()?>
<script src="<?php echo $app["lib_www"]; ?>/js/basic.js"></script>
<div class="wrapfooter add_fix">
			<p>Copyright © 2015 All Rights Reserved.</p>
			<div class="secondary_menu">
				<ul>
					<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='13' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">FAQ</a></li>
					<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='12' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">Privacy Policy</a></li>
					<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='11' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">Contact Us</a></li>
					<li><a href="<?php echo $app["www"]."/".$dbu->lookup('nama','action',"action='10' and id_bahasa='".$_SESSION[bhs]."'")."/";?>">About Us</a></li>
				</ul>
			</div>
		</div><!-- /.wrapfooter -->

		
		
		<?php if($_SESSION[msg]!=""){ ?>
		<div class="overlay-error"></div>
		<div class="pop_error">
			<div class="error_box">
				<h1>Information <img src="<?php echo $app[css_www]."/";?>img/close.png" class="close_error" /></h1>
				<div class="con_login">
					<?php 
						echo $_SESSION[msg];
					?>
				</div>
			</div>
		</div>
		<?php 
			unset($_SESSION[msg]);
		}//print_r($_SESSION);
		if(empty($_SESSION[member][id]) || !isset($_SESSION[member][id])||$_SESSION[member][id]==""||$_SESSION[member][id]==null){ 

			?>
		<div class="overlay-body"></div>
		<div class="pop_box_login">
			<div class="login_wrap">
				<h1>LOGIN<img src="<?php echo $app[css_www]."/";?>img/close.png" class="close" /></h1>
				<div class="con_login">
					<form method="post" name="frmLogin" enctype="multipart/form-data" action="<?php echo $app[http]."/login/";?>">
					<input type="text" name="p_uname" id="p_uname" placeholder="Username">
					<input type="password" name="p_pwd" id="p_pwd" placeholder="Password">
					<input type="checkbox" name="p_cek" id="p_cek"><span>Remember me</span>
					<input type="hidden" name="referer" value="<?php echo $urlx->curPageURL()?>">
					<input class="btn_lg_pop" type="submit" value="LOGIN" >
					</form>
				</div>
				<div class="reg">Not a member yet? <label><a class="reg-a" href="#">Register Now</a></label></div>
			</div>
			<div class="register-boxed">
				<h1>REGISTER<img src="<?php echo $app[css_www]."/";?>img/close.png" class="close_reg" /></h1>
				<div class="con_login">
					<form method="post" name="frmRegis" enctype="multipart/form-data" action="<?php echo $app[www]."/member_register/";?>">
						<input type="text" name="nama_reg" id="nama_reg" placeholder="Username">
						<input type="password" name="pwd_reg" id="pwd_reg"  placeholder="Password">
						<input type="password" name="cpwd_reg" id="cpwd_reg" placeholder="Confirm Password">
						<input type="Email" name="email_reg" id="email_reg" placeholder="Email Address">
						<div class="robot">
							<img id="siimage" src="<?php echo $app["lib_www"]."/securimg/securimage_show.php";?>?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
						</div>
						<input type="text" name="captcha" id="captcha_reg" placeholder="Enter the code shown">
						<p>Can't read this code? <a href="#" onClick="document.getElementById('siimage').src = '<?php echo $app["lib_www"]."/securimg/securimage_show.php";?>?sid=' + Math.random(); this.blur(); return false">Try a different code</a></p>
						<div class="box-submit-reg add_fix">
							<input type="hidden" name="referer" value="<?php echo $urlx->curPageURL()?>">
							<input type="reset" id="b_resetx" value="RESET">
							<input type="submit" value="SUBMIT" id="b_submit" >
						</div>
					</form>
				</div>
			</div>
		</div> <!-- pop_box_login -->
		<!--reset-start -->
		<script type="text/javascript">
			$("#b_resetx").click(function(e){
				e.preventDefault();
				$("#nama_reg").val("");
				$("#pwd_reg").val("");
				$("#cpwd_reg").val("");
				$("#email_reg").val("");
				$("#captcha_reg").val("");
			});
			$('.close_error').click(function(){
				$('.pop_error').hide();
				$('.overlay-error').hide();
			});
			$('.overlay-error').click(function(){
				$('.pop_error').hide();
				$('.overlay-error').hide();
			});
		</script>
		<!--reset-end -->
		<?php } ?>
<?php if(($app[nopage]==2)||($app[nopage]=='desfilter')||($app[nopage]==22)||($app[nopage]==23)){ ?>
<script type="text/javascript">

var xlat,xlng,marker;
var kategori ="<?php echo $app[p_id]; ?>";


function initMap() {
  var map = new google.maps.Map(document.getElementById('google_map'), {
    center: {lat: -7.430343, lng: 112.725132},
    zoom: 8
  });
  //var infoWindow = new google.maps.InfoWindow({map: map});

  // Try HTML5 geolocation.
  var infowindow = new google.maps.InfoWindow({
	    content: "my current position"
	  });
  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(function(position) {
    	xlat = -7.430343;
   		xlng = 112.725132;
	    if(xlat == null || xlat == ""){
	   		xlat = geoplugin_latitude();
	   	}

		if(xlng == null || xlng == ""){
	   		xlng = geoplugin_longitude();
	   	}
	

   	var pos = {
        lat: xlat,
        lng: xlng
      };
	marker = new google.maps.Marker({
	    position: pos,
	    title:"my current position"
	});
	marker.addListener('click', function() {
	    infowindow.open(map, marker);
	  });

	marker.setMap(map);
      map.setCenter(pos);
      codeLatLng(xlat,xlng,'navi');
      genMarker(xlat,xlng,kategori,map,marker,infowindow);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
    
    //alert(xlat);
  } else {
    // Browser doesn't support Geolocation
    xlat = -7.430343;
   	xlng = 112.725132;
    var pos = {
        lat: xlat,
        lng: xlng
      };
   	marker = new google.maps.Marker({
	    position: pos,
	    title:"my current position"
	});
		marker.addListener('click', function() {
	    infowindow.open(map, marker);
	  });

	marker.setMap(map);
	map.setCenter(pos);
	codeLatLng(xlat,xlng,'geo');
	genMarker(xlat,xlng,kategori,map)
  }
  
}


function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}

function codeLatLng(lat, lng, dari) {
	
	var latlng = new google.maps.LatLng(lat, lng);
	var hasil =[];
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
	//console.log(results);
		if(dari=='geo'){
			hasil['nomor'] = '';
			hasil['alamat'] = results[0].address_components[0].long_name;
			hasil['kelurahan']  = results[0].address_components[1].long_name;
			hasil['kecamatan']  = results[0].address_components[2].long_name;
			hasil['kota']  = results[0].address_components[3].long_name;
			hasil['provinsi']  = results[0].address_components[4].long_name;
			hasil['negara']  = results[0].address_components[5].long_name;
			hasil['kodepos']  = results[0].address_components[6].long_name;
			hasil['alamat_lengkap']  = results[0].formated_address;			
		}else{
			hasil['nomor'] = results[0].address_components[0].long_name;
			hasil['alamat'] = results[0].address_components[1].long_name;
			hasil['kelurahan']  = results[0].address_components[4].long_name;
			hasil['kecamatan']  = results[0].address_components[5].long_name;
			hasil['kota']  = results[0].address_components[6].long_name;
			hasil['provinsi']  = results[0].address_components[7].long_name;
			hasil['negara']  = results[0].address_components[8].long_name;
			hasil['kodepos']  = results[0].address_components[9].long_name;
			hasil['alamat_lengkap']  = results[0].formated_address;
				
		}
		
		var lokasi ='<p>You are now in <route id="route">' + hasil['alamat']+" "+hasil['nomor'] + '</route>&nbsp;<kota id="kuto">' + hasil['kota'] + '</kota>, <provinsi id="prop">' + hasil['provinsi'] + '</provinsi></p><p>Latitude Longitude : <i id="lati">' + lat + '</i>, <i id="longi">' + lng + '</i></p>';
			<?php if($app[nopage]!=2 AND $app[nopage]!='desfilter') { ?>
				$("#gg_loc").html(lokasi);
			<?php } ?>
	}else{
			<?php if($app[nopage]!=2 AND $app[nopage]!='desfilter') { ?>
				$("#gg_loc").html("No Information Availabel For Your Current Location: "+status);
			<?php } ?>
	}

});

}

function genMarker(lat,lng,kategori,map){
	var kat = kategori;
	var marker =[];
	var key = 1;
	if(kat!=""){
		$.ajax({
			type: 'post',
			url: "<?php echo $app[lib_www] ?>/xaja/nearby.php",
			data: {
			lat : lat,
			lng : lng,
			kate : kat
			},
			success:function(data){
				var daftar,detil;
				var div = document.getElementById('dekat');
				//var i = 0;
				//var bounds = new google.maps.LatLngBounds();
				$.each(data,function(i) {
					detil = '<li><div class="img_box"><img src="'+data[i].thumb+'"></div><div class="text"><h1>'+data[i].dest.toUpperCase()+'</h1><p>'+data[i].slogan+'.</p></div><a href="'+data[i].urlc+'"><div class="explore">EXPLORE MORE</div></a></li>';
					div.innerHTML = div.innerHTML + detil;
		        	//daftar = daftar + detil;
		        	var pos = new google.maps.LatLng(data[i].lat, data[i].lng);
		        	//bounds.extend(pos);
		        	marker[i] = new google.maps.Marker({
			            position: pos,
			            map: map,
			            title: data[i].nama
			   		 });
			        var infowindow = new google.maps.InfoWindow({
					    content: detil
					  });
		        	google.maps.event.addListener(marker[i],'click', function(e) {
					    infowindow.open(map, marker[i]);});
 
					});

					//marker.setMap(map);
				//map.fitBounds(bounds);
		     //$('#dekat').html(daftar);
			},
			error:function(data){}
		});
	}
}

</script>

<?php } ?>