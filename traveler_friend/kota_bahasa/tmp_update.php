<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
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
  <h2>Membuat <span class="label label-primary"> Deskripsi Kota</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>kota</div>
	<div>
		<?php echo $dbu->lookup('nama','kota',"id='".$p_id."'") ?>
	</div>
</div>
<br/>
<div>
	<?php 
	$sql= "SELECT id , bahasa from ".$app[table][bahasa]." where status = 'aktif' order by bahasa";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
	?>
	<div>bahasa *</div>
	<div>
	<select name="p_bahasa" id="p_bahasa" >
		<?php
		while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo($frsp[id]==$form[id_bahasa])?"selected":""; ?>><?php echo $frsp[bahasa]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<div>deskripsi *</div>
	<div>
		<textarea name="p_desk" id="p_desk"><?php echo $form[deskripsi]; ?></textarea>
	</div>
</div>
<br/>
<div>
	<div>Meta *</div>
	<div>
		<textarea name="p_meta" id="p_meta"><?php echo $form[meta]; ?></textarea>
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