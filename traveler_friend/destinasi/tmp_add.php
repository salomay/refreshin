<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
      <script type="text/javascript" src="<?php echo $app['lib_www']; ?>/tinymce/tinymce.min.js"></script>
      <script>
tinymce.init({
    selector: "textarea",theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,
   
   external_filemanager_path:"<?php echo $app["lib_http"];?>/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "<?php echo $app["lib_http"];?>/filemanager/plugin.min.js"}
 });
</script>
<div class="content">
<?php if($_SESSION['msg']!=""){ ?>
    <div class="box">
    <div class="box-<?php echo $_SESSION["alt"]; ?>">
    <span class="ion-information-circled">
	</span> information</div>
    <div class="box-content" style="vertical-align:center;">
          <?php echo $_SESSION["msg"]; ?>
    </div>
    </div>
  <?php } 
  $_SESSION['msg']="";
  $_SESSION['alt']="";
  //print_r($app[me]);
  ?>
  <h2>Membuat <span class="label label-primary"> Destinasi</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id , bahasa from ".$app[table][bahasa]." where status = 'aktif' order by bahasa";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>bahasa (masukan semua isian sesuai pilihan bahasa)</div>
	<div>
	<select name="p_bahasa" id="p_bahasa" >
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[bahasa]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<?php 
	$sql= "SELECT id , kategori from ".$app[table][destinasi_kategori]." where status = 'aktif' order by kategori";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>kategori destinasi</div>
	<div>
	<select name="p_kat" id="p_kat" >
		<?php
		while($frsx=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsx[id]; ?>"><?php echo $frsx[kategori]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<?php 
	$sql= "SELECT id , nama from ".$app[table][kota]." where status = 'aktif' order by nama";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>kota</div>
	<div>
	<select name="p_kota" id="p_kota" >
		<?php
		while($frsx=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsx[id]; ?>"><?php echo $frsx[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<?php 
	$sql= "SELECT a.id, b.nama from ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." b ON (a.id_reff=b.id_reff) where a.status = 'aktif' and b.id_bahasa='id'";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>destinasi rujukan</div>
	<div>
	<select name="p_reff" id="p_reff" >
		<option value="">tidak ada rujukan</option>
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<script type="text/javascript">
	$('#p_kota').change(function(){
		$('#p_reff').html('');
		/**/
		var id_kota = $('#p_kota').val();
		$.ajax({
			type:"POST",
			url:"<?php echo $app[lib_www] ?>/xaja/comboreff.php",
			data:'kueri='+id_kota,
			success: function(data){
				$("#p_reff").append(data);
			}
		});
	});
</script>
<div>
	<div>nama tempat wisata *</div>
	<div>
	<input name="p_nama" type="text" id="p_nama" placeholder="city of hero surabaya ...">
	</div>
</div>
<br/>
<!--<div>
	<div>nama spot *</div>
	<div>
	<input name="p_spot" type="text" id="p_spot" placeholder="spot 1 ...">
	</div>
</div>
<br/>-->
<div>
	<div>deskripsi *</div>
	<div>
	<textarea name="p_desk" id="p_desk" placeholder="..."></textarea>
	</div>
</div>
<br/>
<div>
	<div>slogan *</div>
	<div>
	<input type="text" name="p_slogan" id="p_slogan" placeholder="..." size="100" />
	</div>
</div>
<br/>
<div>
	<div>alamat *</div>
	<div>
	<input name="p_alamat" type="text" id="p_alamat"  placeholder = "earth ...." size="100"/>
	</div>
</div>
<br/>
<div>
	<div>geolocation</div>
	<div>
	<input name="p_poslong" type="text" id="p_poslong" placeholder="longitude" />
	<input name="p_poslat" type="text" id="p_poslat" placeholder="latitude" />
	</div>
</div>
<br/>
<div>
	<div>website (tanpa http://)</div>
	<div>
		<input name="p_web" type="text" id="p_web" size="60"  placeholder = "http://refreshin.co.id ..."/>
	</div>
</div>
<br/>
<div>
	<div>email</div>
	<div>
	<input name="p_email" type="text" id="p_email"  placeholder = "example@refreshin.co.id"/>
	</div>
</div>
<br/>
<div>
	<div>htm</div>
	<div>
	<input name="p_htm" type="text" id="p_htm" placeholder="Rp. 500.000 ..." />
	</div>
</div>
<br/>
<div>
	<div>untuk usia</div>
	<div>
	<input name="p_usia" type="text" id="p_usia" placeholder="SEGALA USIA" />
	</div>
</div>
<br/>
<div>
	<div>waktu buka</div>
	<div>
	<input name="p_haribuka" type="text" id="p_haribuka" placeholder="senin - sabtu" />
	<input name="p_jambuka" type="text" id="p_jambuka" placeholder="04:00 - 17:00" />
	</div>
</div>
<br/>
<div>
	<div>waktu terbaik</div>
	<div>
	<input name="p_haribaik" type="text" id="p_haribaik" placeholder="senin - sabtu" />
	<input name="p_jambaik" type="text" id="p_jambaik" placeholder="04:00 - 17:00" />
	</div>
</div>
<br/>
<div>
	<div>libur</div>
	<div>
	<input name="p_harilibur" type="text" id="p_harilibur" placeholder="minggu" />
	</div>
</div>
<br/>
<div>
	<div>logo *</div>
	<div>
	<input name="p_logo" type="file" id="p_logo" size="30" />
	</div>
</div>
<br/>
<div>
	<div>thumb *</div>
	<div>
	<input name="p_thumb" type="file" id="p_thumb" size="30" />
	</div>
</div>
<br/>
<div>
	<div>gambar *</div>
	<div>
	<input name="p_gambar" type="file" id="p_gambar" size="30" />
	</div>
</div>
<br/>
<div>
	<div>icon map *</div>
	<div>
	<input name="p_icon" type="file" id="p_icon" size="30" />
	</div>
</div>
<br/>
	<div >Yang Bertanda * Harus disi</div><br/>
	<div class="footer">
		<input type="button" value="Tambah" onClick="set_action(this, 'add')"> 
		<input type="reset" value="Reset" name="reset">
		<input type="hidden" name="act">
		<input type="button" value="Cancel" id="cancel">
		<input type="hidden" name="step" value="2">
		<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer(); ?>"> 
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>