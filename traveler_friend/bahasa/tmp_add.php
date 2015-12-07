<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
      <script src="<?php echo $app["lib_cms"]; ?>/js/all_check.js"></script>
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
 <h2>Tambah <span class="label label-primary">Bahasa</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id , nama from ".$app[table][negara]." where status = 'aktif' order by nama";
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>negara *</div>
	<div>
	<select name="p_negara" id="p_negara" >
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" ><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<div>id *</div>
	<div>
	<input name="p_idbhs" type="text" id="p_idbhs" >
	</div>
</div>
<div>
	<div>bahasa *</div>
	<div>
	<input name="p_bahasa" type="text" id="p_bahasa" >
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