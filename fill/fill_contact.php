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
				<div class="about_content">
					<div class="section-2" style="margin:0;">
						<h2 class="tou-sy">CONTACT US</h2>
						<h1 class="main_title" style="text-align:center;font-size:30px;background:none;">Get in touch with us!</h1>
						<div class="contactus add_fix">
							<div class="con-contactus">
								<span>Tell us what you think about Refreshin, or if you have any questions, feel free to ask us!</span>
								<select>
									<option value = "web user">I am common user</option>
									<?php if($_SESSION[member]) {?>
									<option value = "<?php echo $_SESSION[member][uname] ?>">I am <?php echo $_SESSION[member][uname] ?></option>
									<?php } ?>
									<option value = "donatur">donatur</option>
								</select>
								<input type="text" placeholder="Name">
								<input type="text" placeholder="Email">
								<input type="text" placeholder="Phone">
								<textarea placeholder="Message"></textarea>
								<input type="submit" value="Submit">
							</div>
							<div class="con-maps">
								<span style="margin-bottom:43px;">Another way to reach us:</span>
								<div class="map_contact" id="google_map"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
<script> 

$(window).load(function(){
	initMap();
});

var map;
function initMap() {
    var mapOptions = {
        center: new google.maps.LatLng(-7.430343, 112.725132), //lokasi saat pertama kali load
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

    var mapElement = document.getElementById('google_map');
    var map = new google.maps.Map(mapElement, mapOptions);
    var locations = ['Refreshin Office : Perum Gading Fajar, Blok B1 No 18, Buduran Sidoarjo', -7.430343, 112.725132]

        marker = new google.maps.Marker({
            icon: '',
            position: new google.maps.LatLng(locations[1], locations[2]),
            map: map,
			title: locations[0]
        });
		
	var contentString = 'hahahaha';

	var infowindow = new google.maps.InfoWindow({
		content: locations[0]
	});

	google.maps.event.addListener(marker, 'click', function(a) {
		infowindow.open(map,marker);
	});
}
</script>
</html>