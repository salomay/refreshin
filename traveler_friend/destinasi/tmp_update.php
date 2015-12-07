<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
      <script type="text/javascript" src="<?php echo $app['lib_www']; ?>/tinymce/tinymce.min.js"></script>
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
    <div class="box-<?php echo $_SESSION["alt"]; ?>"><span class="ion-information-circled"></span> information</div>
    <div class="box-content" style="vertical-align:center;">
          <?php echo $_SESSION["msg"]; ?>
    </div>
    </div>
  <?php } 
  $_SESSION['msg']="";
  $_SESSION['alt']="";
  //print_r($app[me]);
  ?>
  <h2>Merubah Data <span class="label label-primary">Destinasi</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
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
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_kat]==$frsp[id])?"selected":""; ?>><?php echo $frsp[kategori]; ?></option>
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
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_kota]==$frsp[id])?"selected":""; ?>><?php echo $frsp[nama]; ?></option>
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
		<option value="">-----</option>
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_parent]==$frsp[id])?"selected":""; ?>><?php echo $frsp[nama]; ?></option>
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
	 <?php echo $form[wisata]; ?>
	</div>
</div>
<br/>
<div>
	<div>geolocation</div>
	<div>
	<input name="p_poslong" type="text" id="p_poslong" value="<?php echo $form[pos_long]; ?>" placeholder="longitude" />
	<input name="p_poslat" type="text" id="p_poslat" value="<?php echo $form[pos_lat]; ?>" placeholder="latitude" />
	</div>
</div>
<br/>
<div>
	<div>website (tanpa http://)</div>
	<div>
		<input name="p_web" type="text" id="p_web" size="60" value="<?php echo $form[website]; ?>"  placeholder = "http://refreshin.co.id ..."/>
	</div>
</div>
<br/>
<div>
	<div>email</div>
	<div>
	<input name="p_email" type="text" id="p_email"  value="<?php echo $form[email]; ?>" placeholder = "example@refreshin.co.id"/>
	</div>
</div>
<br/>
<div>
	<div>logo destinasi *</div>
	<div>
		<?php 
		if ($form['logo']){ 
				$filename = $app['data_path']."/destinasi/logo/".$form['logo'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi/logo/<?php echo $form[logo];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_logo_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi/logo/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi/logo/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_logo" type="file" id="p_logo" />&nbsp;
	</div>
</div>
<br/>
<div>
	<div>icon destinasi *</div>
	<div>
		<?php 
		if ($form['icon_map']){ 
				$filename = $app['data_path']."/destinasi/icon_map/".$form['icon_map'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi/icon_map/<?php echo $form[icon_map];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_icon_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi/icon_map/default.jpg" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi/icon_map/default.jpg" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_icon" type="file" id="p_icon" />&nbsp;
	</div>
</div>
<br/>
<div>
	<div>thumb destinasi *</div>
	<div>
		<?php 
		if ($form['thumb']){ 
				$filename = $app['data_path']."/destinasi/thumb/".$form['thumb'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi/thumb/<?php echo $form[thumb];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_gambar_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi/thumb/default.jpg" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi/thumb/default.jpg" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_thumb" type="file" id="p_thumb" />&nbsp;
	</div>
</div>
<br/>
<div>
	<div>gambar destinasi *</div>
	<div>
		<?php 
		if ($form['gambar']){ 
				$filename = $app['data_path']."/destinasi/gambar/".$form['gambar'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi/gambar/<?php echo $form[gambar];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_gambar_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi/gambar/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi/gambar/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_gambar" type="file" id="p_gambar" />&nbsp;
	</div>
</div>
<br/>
	<div >Yang Bertanda * Harus disi</div><br/>
	<div class="footer">
		<input type="button" value="Update" onClick="set_action(this, 'update')"> 
		<input type="reset" value="Reset" name="reset" class="btn btn-warning">
			<input type="hidden" name="act">
			<input type="button" value="Cancel" id="cancel">
			<input type="hidden" name="step" value="2">
			<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer() ?>">
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>