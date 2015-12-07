<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
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
  <h2>Merubah Data <span class="label label-primary">Kategori Destinasi</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id , bahasa from ".$app[table][bahasa]." where status = 'aktif' order by bahasa";
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>bahasa *</div>
	<div>
	<select name="p_bahasa" id="p_bahasa" >
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_bahasa]==$frsp[id])?"selected":""; ?>><?php echo $frsp[bahasa]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<div>kategori *</div>
	<div>
	<input name="p_kategori" type="text" id="p_kategori" value="<?php echo $form[kategori]; ?>">
	</div>
</div>
<br/>
<div>
	<div>home icon *</div>
	<div>
		<?php 
		if ($form['icon']){ 
				$filename = $app['data_path']."/destinasi_kategori/icon/".$form['icon'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi_kategori/icon/<?php echo $form[icon];?>" width="50" height="50" /> <br/><br/> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br /><br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi_kategori/icon/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi_kategori/icon/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_icon" type="file" id="p_icon" />&nbsp;
	</div>
</div>
<br/>
<!--
<div>
	<div>nearby icon *</div>
	<div>
		<?php 
		if ($form['nicon']){ 
				$filename = $app['data_path']."/destinasi_kategori/icon/".$form['nicon'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi_kategori/icon/<?php echo $form[nicon];?>" width="50" height="50" /> <br/><br/> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br /><br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi_kategori/icon/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi_kategori/icon/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
		<input name="p_nicon" type="file" id="p_nicon" />&nbsp;
	</div>
</div>
<br/>
-->
<div>
	<div>thumb *</div>
	<div>
		<?php 
		if ($form['thumb']){ 
				$filename = $app['data_path']."/destinasi_kategori/thumb/".$form['thumb'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/destinasi_kategori/thumb/<?php echo $form[thumb];?>" /> <br> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br /><br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/destinasi_kategori/thumb/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/destinasi_kategori/thumb/default.png" width="50" height="50" />
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