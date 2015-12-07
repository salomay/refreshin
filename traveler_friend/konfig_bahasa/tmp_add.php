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
  <h2>Merubah Data <span class="label label-primary"> Konfigurasi Bahasa</span></h2>
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
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[bahasa]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<div>headline *</div>
	<div>
	<input name="p_headline" type="text" id="p_headline">
	</div>
</div>
<br/>
<div>
	<div>slogan *</div>
	<div>
	<input name="p_slogan" type="text" id="p_slogan"/>
	</div>
</div>
<br/>
<div>
	<div>meta deskripsi *</div>
	<div>
	<textarea name="p_metades" id="p_metades"></textarea>
	</div>
</div>
<br/>
<div>
	<div>meta keyword *</div>
	<div>
	<textarea name="p_metakey" id="p_metakey"></textarea>
	</div>
</div>
<br/>
<div>
	<div>gambar header</div>
	<div>
		<input name="p_gmb_header" type="file" id="p_gmb_header" />&nbsp;
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