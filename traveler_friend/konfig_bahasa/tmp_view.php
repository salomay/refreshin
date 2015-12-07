<?php 
$tampil = new admlib();
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
  <h2>Detil <span class="label label-primary">Provinsi</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>nama</div>
	<div class="viewedx">
		<?php echo $dbu->lookup("nama","negara","id='".$form[id_negara]."'"; ?>
	</div>
</div>
<div>
	<div>nama</div>
	<div class="viewedx">
		<?php echo $form[nama]; ?>
	</div>
</div>
<br/>
<div>
	<div>latitude</div>
	<div class="viewedx">
		<?php echo $form[pos_lat]; ?>
	</div>
</div>
<br/>
<div>
	<div>longitude</div>
	<div class="viewedx">
		<?php echo $form[pos_long]; ?>
	</div>
</div>
<br/>
<div>
	<div>logo *</div>
	<div>
		<?php 
		if ($form['logo']){ 
				$filename = $app['data_path']."/provinsi/logo/".$form['logo'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/provinsi/logo/<?php echo $form[logo];?>" width="50" height="50" /> <br>
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/provinsi/logo/default.png" width="50" height="50" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/provinsi/logo/default.png" width="50" height="50" />
			<br><br>
		<?php } ?>
	</div>
</div>
<br/>
	<div >Yang Bertanda * Harus disi</div><br/>
	<div class="footer">
		<input type="button" value="Update" onClick="set_action(this, 'update')"> 
		<input type="reset" value="Reset" name="reset" />
			<input type="hidden" name="act">
			<input type="button" value="Cancel" id="cancel">
			<input type="hidden" name="step" value="2">
			<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer() ?>">
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>