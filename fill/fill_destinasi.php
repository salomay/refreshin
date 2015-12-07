<?php 
$tampil = new usrlib();
echo $tampil->tampilkan_doctype('main');
echo $tampil->tampilkan_header('main');
echo $tampil->tampilkan_menu('main');
$dbu = new db();
$appx = new app();
$urlx = new url();
$pid = explode("_",$p_id);
					
	if($pid[1] != null){
		echo "<body onload='load_destinasi()'>";	
		if($_POST[p_kota] != null){
			
		}
		$idkota = $dbu->lookup("id","kota","nama LIKE '".str_replace("-", "%", $pid[1])."'");	
	}else{
		echo "<body onload='load_city()'>";
	}

	
	$select_lat= $dbu->lookup("pos_lat","kota","nama LIKE '".str_replace("-", "%", $pid[1])."'");
	$select_long= $dbu->lookup("pos_long","kota","nama LIKE '".str_replace("-", "%", $pid[1])."'");
	
?>


	<div class="wrapall">
		<div class="wrapcontent">
			<div class="content add_fix">
				<div class="search_destination">
				<div id="gg_loc"></div>
					<h1>SEARCH DESTINATION<span class="border"></span></h1>
					<div class="boxcon_search_destination add_fix">
						<div class="map_search" id="google_map"></div>
						<div class="sort_by">
							<span>SORT BY</span>
							<div class="sort_form">
								<form method="post" enctype="multipart/form-data">
									<label class="custom-select">
										<select name ="p_negara" id ="p_negara" style="margin-top:22px;">
											<option value="">country</option>
											<option value="1">Indonesia</option>
											<?php //while($negara = $dbu->fetch($rsnegara)){ ?>
											<!--<option value="<?php echo $negara[id]; ?>"><?php echo $negara[nama]; ?></option>-->
											<?php // } ?>
										</select>
									</label>
									<label class="custom-select">
										
										<select name ="p_provinsi" id ="p_provinsi" >
											<option value="">province</option>
										</select>
									</label>
									<label class="custom-select">
										<select name ="p_kota" id ="p_kota">
											<option value="">city</option>
										</select>
									</label>
									<label class="custom-select">
										<select name ="p_kategori" id ="p_kategori">
											<option value="">category</option>
											<?php 
											$rskat = $dbu->get_recordset($app[table][destinasi_kategori],"status ='aktif'");
											while($kategori = $dbu->fetch($rskat)){ ?>
											<option value="<?php echo $kategori[id]; ?>" ><?php echo $kategori[kategori]; ?></option>
											<?php } ?>
										</select>
									</label>
									<input type="hidden" name="act">
									<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer(); ?>">	
									<input type="button"  class="begin_filter" value="Begin Filter" id="b_filter" onClick="set_valid(this,'desfilter')" />
								</form>
							</div>
						</div>
					</div>
				</div> <!-- .search_destination -->

					<?php

					echo $outnya; 
				
					?>
				<!-- .location_destination -->
				
			</div>
		</div><!-- /.wrapcontent -->
		<?php echo $tampil->tampilkan_footer('main'); ?>

	<script type="text/javascript">
 
    var lat_kota=<?php echo json_encode($select_lat); ?>;
    var long_kota=<?php echo json_encode($select_long); ?>;


var customIcons = {
      sejarah: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_sejarah.png'
      },
      anakanak: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_anak.png'
      },
       kuliner: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_kuliner.png'
      },
      shoprestarea: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_belanja.png'
      },
       petualangan: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_petualangan.png'
      },
       adatbudaya: {
        icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_adatbudaya.png'
      },
       florafauna: {
       icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_florafauna.png'
      },
       UrbanCulture: {
         icon: '<?php echo $app[data_www] ?>/destinasi/icon_map/icon_map_urban.png'
      }
    };

 
function set_valid(param, act){
		
		if($('#p_kota').val()=="")
		{
			alert("Harap Pilih Kota")
			$('#p_kota').focus();
		}else{
			var param = param;
			param.form.act.value = act;
			param.form.target = '_self';
			param.form.submit();	
		}
}
	





    function load_city() {
      var map = new google.maps.Map(document.getElementById("google_map"), {
        center: new google.maps.LatLng(-7.430343, 112.725132),
        zoom: 8,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
 
  
      // Bagian ini digunakan untuk mendapatkan data format XML yang dibentuk dalam dataLokasi.php
      downloadUrl("<?php echo $app[lib_www] ?>/xaja/locationKota.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var deskripsi = markers[i].getAttribute("deskripsi");
          lat_kota=markers[i].getAttribute("lat");
          long_kota=markers[i].getAttribute("lng");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<center><h1>" + name + "</h1></center><p>" + deskripsi;
          //var icon = customIcons[kategori] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point
  			
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }


     function load_destinasi() {


      var map = new google.maps.Map(document.getElementById("google_map"), {
        center: new google.maps.LatLng(lat_kota,long_kota),
        zoom: 10,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
 
  
      // Bagian ini digunakan untuk mendapatkan data format XML yang dibentuk dalam dataLokasi.php
      downloadUrl("<?php echo $app[lib_www] ?>/xaja/locationDestinasi.php?idkota=<?php echo $idkota; ?>", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var gambar = markers[i].getAttribute("gambar");
          var button = markers[i].getAttribute("button");
          var kategori = markers[i].getAttribute("kategori");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<div style='overflow:hidden;'><center><b><h3>" + name + "</h3></b></center><br><image width='200px' height='200px' src='"+ gambar +"'/><a href='"+button+"'><div class='explore'>EXPLORE MORE</div></a> </div>";
          var icon = customIcons[kategori] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
 			icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }
 
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
 
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
 
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
 
      request.open('GET', url, true);
      request.send(null);
    }
 
    function doNothing() {}
 
</script>
<script type="text/javascript">
	$(document).ready(function(){
	$('#p_negara').change(function(){
		$('#p_provinsi').html('');
		$('#p_kota').html('');
		var x = $('#p_negara').val();
		$.ajax({
			type:"post",
			url:"<?php echo $app[lib_www] ?>/xaja/combomix.php",
			data:{
				id_negara : x,
				bahasa : "<?php echo $_SESSION[bhs];?>"
			},
			success: function(data){
				$("#p_provinsi").append(data);
			},
			error: function(data){
				alert(error);
			}
		});
	});
	$('#p_provinsi').change(function(){
		$('#p_kota').html('');
		var x = $('#p_provinsi').val();
		$.ajax({
			type:"post",
			url:"<?php echo $app[lib_www] ?>/xaja/combomix.php",
			data:{
				id_provinsi : x,
				bahasa : "<?php echo $_SESSION[bhs];?>"
			},
			success: function(data){
				$("#p_kota").append(data);
			}
		});
	});
	//initMap();
});
</script>
</body>
<script type="text/javascript">
	  $(".load_more").click(function(){
	  	var tmp = $(this).attr('rel');
	  	var cast = $('#'+tmp).attr('cast');
	  	var hitnya = $('#'+tmp).attr('hitmax');
	  	var limit = $('#'+tmp).attr('limit');
	  	var jml = 8;
	  	var curhit = Number(limit)+jml;
	    $.ajax({
			  type: 'post',
			  url: '<?php echo $app[lib_www] ?>/xaja/moreDes.php',
			  data: {
			    cast : cast,
			    limit: limit,
			    jml : jml
			  },
			  success: function (response) {
			   $('#'+tmp).append(response);
			   $('#'+tmp).attr('limit', curhit);
			  	$("html, body").animate({ scrollTop: $(document).height() }, 500); 
				if(hitnya <= curhit){
					$(".load_more").hide();
				}
			  }
		  });
	});		

</script>
</html>