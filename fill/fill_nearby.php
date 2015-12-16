<?php 
$tampil = new usrlib();
echo $tampil->tampilkan_doctype('main');
echo $tampil->tampilkan_header('main');
echo $tampil->tampilkan_menu('main');
$dbu = new db();
$appx = new app();
$urlx = new url();
?>
<body onload="load_destinasi()" >
	<div class="wrapall">
		<div class="wrapcontent">
			<div class="content add_fix">
				<div class="search_destination">
					<h1>NEARBY<span class="border"></span></h1>
					<div class="my_location">
						<div id="gg_loc"></div>
						<p><a id="mappy" href="#"  >Show Map</a></p>
					</div>
					<div class="boxcon_search_destination add_fix" style="display:none;">
						<div class="map_search" id="google_map" style="width:100%;margin-right:0;height:400px;"></div>
					</div>
				</div> <!-- .search_destination -->
				<div class="location_destination">
					<div class="near-cat add_fix">
						<span>Choose Category :</span>
						<ul>
						<?php 
							while($dkat = $dbu->fetch($rkat)){
								$active = "";
								$dkat[icon] = $appx->cekFile('/destinasi_kategori/icon/',$dkat[icon]);
								
								$pkat = $urlx->shortLink($dkat[kategori]);
								if($p_id == $pkat){
									$active=" active";
								}
								echo '<li>';
								?>
										<a href="#" OnClick="setKategori(<?php echo $dkat[id]; ?>)" >

								<?php 		
								echo '<div id="'.$dkat[id].'" value="'.strtoupper($dkat[kategori]).'" class="bullet-cat-near"><img src="'.$app["data_www"].'/destinasi_kategori/icon/'.$dkat[icon].'"></div></a>
								<span class="tip-content">'.$dkat[kategori].'</span>
									</li>';
							}
						?>
						</ul>
					</div>
					<h1><div id="title_kategori">All Category Destination</div><span class="border"></span></h1>
					<ul class="list_location add_fix" id="result">
											

					</ul>
					<div class="load_more"><a href="#">VIEW MORE</a></div>
				</div> <!-- .location_destination -->
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>
	</div>	
</body>
</html>

<script>

	 var lat ;
  	 var lng ;
  	 var kat ;
  	 var map;

var customIcons = {
       1: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_sejarah.png'
      },
       2: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_anak.png'
      },
       3: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_kuliner.png'
      },
       4: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_belanja.png'
      },
       5: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_petualangan.png'
      },
       6: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_adatbudaya.png'
      },
       7: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_florafauna.png'
      },
       8: {
         icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_urban.png'
      }
    };


		$('li div').click(function(e) {
        e.preventDefault();
        $('div').removeClass('active');
        $(this).addClass('active');
  		  });


		$('#mappy').click(function(e){
			load_destinasi();
		})

		function load_destinasi() {

		navigator.geolocation.getCurrentPosition(callback);
		 
		}

	  function callback(position) {

	  lat= position.coords.latitude;
   	  lng = position.coords.longitude;
	  
       map = new google.maps.Map(document.getElementById("google_map"), {
        center: new google.maps.LatLng(lat,lng),
        zoom: 10,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow({content: '<div">ADD CONTENT</div>'});
 
  		getMarker(lat,lng,kat,map);
    }
 

 function setKategori(kategori) {
		$('#result').empty();
		kat= kategori;
		getMarker(lat,lng,kat,map);
		$('#title_kategori').text($('#'+kategori).attr('value'));
		}

function getMarker(lat,lng,kategori,map){
	var kate=kategori;
	var marker =[];
	var key = 1;

		$.ajax({
			type: 'post',
			url: "<?php echo $app[lib_www] ?>/xaja/nearby.php",
			data: {
			lat : lat,
			lng : lng,
			kate : kate
			},
			success:function(data){
				var daftar,detil,markerContent;
				var div = document.getElementById('result');
				$.each(data,function(i) {
					detil = '<li><div class="img_box"><img src="'+data[i].thumb+'"></div><div class="text"><h1>'+data[i].dest.toUpperCase()+'</h1><p>'+data[i].slogan+'.</p></div><a href="'+data[i].urlc+'"><div class="explore">EXPLORE MORE</div></a></li>';
					markerContent="<div style='overflow:hidden; width:150px; height:150px;'><center><b style='color: #085f7d;font-size: 12px;text-transform: uppercase;  font-family: open_sansbold; word-wrap: break-word; white-space: -moz-pre-wrap; white-space: pre-wrap;'>" + data[i].dest.toUpperCase() + "</b></center><br><a href='"+ data[i].urlc +"'><image width='150px' height='120px' src='"+ data[i].thumb +"'/></a> </div>";
					div.innerHTML = div.innerHTML + detil;
					var kategori = data[i].id_kat;
					var pos = new google.maps.LatLng(data[i].lat, data[i].lng);
		        	  var icon = customIcons[kategori] || {};
		        	marker[i] = new google.maps.Marker({
			            position: pos,
			            map: map,
			            title: data[i].nama,
			            icon: icon.icon
			   		 });
			        var infowindow = new google.maps.InfoWindow({
					    content: markerContent
					  });
		        	google.maps.event.addListener(marker[i],'click', function(e) {
					    infowindow.open(map, marker[i]);});
				});


		        	
			},
			error:function(data){ alert(data)}
		});
	
}
</script>