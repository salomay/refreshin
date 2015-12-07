<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
      <script src="<?php echo $app["lib_cms"]; ?>/js/all_check.js"></script>
      <script type="text/javascript" src="<?php echo $app['lib_www']; ?>/tinymce/tinymce.min.js"></script>
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
  <h2>Merubah Data <span class="label label-primary">Kota</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id , nama from ".$app[table][provinsi]." where status = 'aktif' order by nama";
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>negara *</div>
	<div>
	<select name="p_provinsi" id="p_provinsi" >
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_provinsi]==$frsp[id])?"selected":""; ?>><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<div>nama kota *</div>
	<div>
	<input name="p_nama" type="text" id="p_nama" value="<?php echo $form[nama]; ?>">
	</div>
</div>
<br/>
<div>
	<div>latitude *</div>
	<div>
	<input name="p_poslat" type="text" id="p_poslat" value="<?php echo $form[pos_lat]; ?>" />
	</div>
</div>
<br/>
<div>
	<div>longitude *</div>
	<div>
	<input name="p_poslong" type="text" id="p_poslong" value="<?php echo $form[pos_long]; ?>"/>
	</div>
</div>
<br/>
<div>
	<div>thumb kota*</div>
	<div>
		<?php 
		if ($form['thumb']){ 
				$filename = $app['data_path']."/kota/thumb/".$form['thumb'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/kota/thumb/<?php echo $form[thumb];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_pict_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/kota/thumb/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/kota/thumb/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_pict" type="file" id="p_pict" />&nbsp;
	</div>
</div>
<br/>
<div>
	<div>logo kota*</div>
	<div>
		<?php 
		if ($form['logo']){ 
				$filename = $app['data_path']."/kota/logo/".$form['logo'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/kota/logo/<?php echo $form[logo];?>" width="50" height="50" /> <br> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/kota/logo/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/kota/logo/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_thumb" type="file" id="p_thumb" />&nbsp;
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