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
<h2>Maerubah <span class="label label-primary"> keanggotaan Komunitas</span><br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id, nama from ".$app[table][komunitas]." where status ='aktif' ";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
?>
	<div>komunitas </div>
	<div>
	<select name="p_komunitas" id="p_komunitas" >
		<?php
			while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_komunitas]==$frsp[id])?"selected":""; ?>><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<?php 
		$sql= "SELECT id, username, nama from ".$app[table][pengguna]." where id='".$form[id_user]."'";
		//echo $sql;
		$frsp = $dbu->get_recordmix($sql);	
	?>
	<div>pengguna <?php echo $frsp[username]; ?> | <?php echo $frsp[nama]; ?> </div>
	<div>
	</div>
</div>
<div>
	<div>posisi </div>
	<div>
		<select name="p_posisi" id="p_posisi" >
			<option value="member" <?php echo ($form[posisi]=="member")?"selected":""; ?>>member</option>
			<option value="leader" <?php echo ($form[posisi]=="leader")?"selected":""; ?>>leader</option>
			<option value="owner" <?php echo ($form[posisi]=="owner")?"selected":""; ?>>owner</option>
		</select>
	</div>
</div>
<div>
	<div>status </div>
	<div>
		<select name="p_status" id="p_status" >
			<option value="aktif" <?php echo ($form[status]=="aktif")?"selected":""; ?>>aktif</option>
			<option value="pasif" <?php echo ($form[status]=="pasif")?"selected":""; ?>>pasif</option>
			<option value="banned" <?php echo ($form[status]=="banned")?"selected":""; ?>>banned</option>
		</select>
		<input type="text" placeholder="keterangan status" value="<?php echo $form[keterangan]; ?>" name="p_ket" id="p_ket">
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
			<input id="getreff" type="hidden" name="referer" value="<?php echo  $urlx->get_referer() ?>">
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>