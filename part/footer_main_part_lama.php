<?php $urlx = new url(); ?>
<script src="<?php echo $app["lib_www"]; ?>/js/basic.js"></script>
<div class="wrapfooter add_fix">
			<p>Copyright © 2015 All Rights Reserved.</p>
			<div class="secondary_menu">
				<ul>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Privacy Policy</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">About Us</a></li>
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
		}
		if(empty($_SESSION[member]) || !isset($_SESSION[member])){ ?>
		<div class="overlay-body"></div>
		<div class="pop_box_login">
			<div class="login_wrap">
				<h1>LOGIN<img src="<?php echo $app[css_www]."/";?>img/close.png" class="close" /></h1>
				<div class="con_login">
					<form method="post" name="frmLogin" enctype="multipart/form-data" action="<?php echo $app[www]."/login/";?>">
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
<?php if(($app[nopage]==2)||($app[nopage]==22)||($app[nopage]==23)){ ?>


<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
  <script type="text/javascript">
  $('#mappy').click(function () {
  	getLocation();
  });

  function getLocation() {
      if (navigator.geolocation) {
      	var timeoutVal = 10 * 1000 * 1000;
          navigator.geolocation.getCurrentPosition(savePosition, positionError, {enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 });
      } else {
          //Geolocation is not supported by this browser
      }
  }

  // handle the error here
  function positionError(error) {
      var errorCode = error.code;
      var message = error.message;

      alert(message);
  }

  function savePosition(position) {
           // $.post("<?php echo $app[lib_www] ?>/xaja/nearby.php", {lat: position.coords.latitude, lng: position.coords.longitude});
           var lat = position.coords.latitude;
           var lng = position.coords.longitude;
           $.ajax({
			  type: 'post',
			  url: "<?php echo $app[lib_www] ?>/xaja/currentLocation.php",
			  data: {
			    lat : lat,
			    lng : lng
			  },
			  success: function (response) {
			   if(response != "gagal"){
			   		if(response.alamat !="" && response.alamat != null){
						var alamat =response.alamat;
			   		}
					if(response.kota !="" && response.kota != null){
						var kota = response.kota;
			   		}
					if(response.provinsi !="" && response.provinsi != null){
						if(response.negara==null){
							response.negara = "";
						}else{
							response.negara = ','+ response.negara;
						}
						var provinsi = response.provinsi+response.negara;
			   		}
					
			   		var lokasi ='<p>You are now in <route id="route">' + alamat + '</route>&nbsp;<kota id="kuto">' + kota + '</kota>, <provinsi id="prop">' + provinsi + '</provinsi></p><p>Latitude Longitude : <i id="lati">' + lat + '</i>, <i id="longi">' + lng + '</i></p>';

					$("#gg_loc").html(lokasi);
					var kat ="<?php echo $app[pid] ?>";
					$.ajax({
			           type: 'post',
						  url: "<?php echo $app[lib_www] ?>/xaja/nearby.php",
						  data: {
						    lat : response.lat,
						    lng : response.lng,
						    kate : kat
						  },
			            success:function(data){
			            	var bounds = new google.maps.LatLngBounds();
			            	var mapOptions = {
							        center: new google.maps.LatLng(lat, lng), //lokasi saat pertama kali load
							        zoom: 18, //level zoom 0-21
							        zoomControl: true, //tampilkan zoom slide
							        zoomControlOptions: {
							            style: google.maps.ZoomControlStyle.DEFAULT, //style slide SMALL, LARGE, DEFAULT(tergantung ukuran div)
							        },
							        disableDoubleClickZoom: true, //aktifkan klik dua kali untuk zoom
									mapTypeControl: true, //tampilakn pilihan tampilan map atau satelit
							        mapTypeControlOptions: {
							            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, //pilih tampilan map atau satelit DROPDOWN_MENU, HORIZONTAL_BAR
							        },
							        scaleControl: true, //tampilkan scala info
							        scrollwheel: true, //aktifkan zoom scroll
							        streetViewControl: true, //tampilkan Street View
							        draggable : true, //aktifkan draggable
							        overviewMapControl: true, //aktifkan overview map
							        overviewMapControlOptions: {
							            opened: false,
							        },
							        mapTypeId: google.maps.MapTypeId.ROADMAP, //pilihan tampilan ROADMAP, SATELLITE, HYBRID, TERRAIN						    
							    }
			            	var map = new google.maps.Map(document.getElementById('google_map'), mapOptions);
			            	var infoWindow = new google.maps.InfoWindow();
			            	var marker, i, daftar;
			            	daftar="";
					        for (i = 0; i < data.length; i++) { 
					        daftar = daftar + '<li><div class="img_box"><img src="'+data[i]['thumb']+'"></div><div class="text"><h1>'+data[i]['dest'].toUpperCase()+'</h1><p>'+data[i]['slogan']+'.</p></div><a href="'+data[i]['urlc']+'"><div class="explore">EXPLORE MORE</div></a></li>';
					          var position = new google.maps.LatLng(data[i]['lat'], data[i]['lng']);
						        bounds.extend(position);
						        marker = new google.maps.Marker({
						            position: position,
						            map: map,
						            title: data[i]['nama']
						        });
						        
						        // Allow each marker to have an info window    
						        google.maps.event.addListener(marker, 'click', (function(marker, i) {
						            return function() {
						            	var detil ='<h3>'+data[i]['dest']+'</h3><p>'+data[i]['alamat']+'</p><hr/><p>'+data[i]['slogan']+'</p>'
						                infoWindow.setContent(detil);
						                infoWindow.open(map, marker);
						            }
						        })(marker, i));

						        // Automatically center the map fitting all markers on the screen
						        map.fitBounds(bounds);
					        }  
					        //alert(daftar);
					        $('#dekat').html(daftar);
			        	}
			 		 });
					//alert(response);
			   }else{
			   		$("#gg_loc").html('YOU MUST ALLOW SHARE LOCATION, TO ABLE TO SEE THE NEARBY DESTINATION');	
			   }			   
			  }
		  });
  }

  </script>

<?php } ?>