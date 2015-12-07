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
  <h2>Membuat <span class="label label-primary"> keanggotaan Komunitas</span><br/> 
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
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<div>pengguna </div>
	<div>
	<?php 
		$sql= "SELECT id, username, nama from ".$app[table][pengguna]." where status='aktif'";
		//echo $sql;
		$dbu->query($sql,$rsp,$nrp);	
	?>
	<select name="p_user" id="p_user" >
		<?php
			while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[username]; ?> | <?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<div>
	<div>posisi </div>
	<div>
		<select name="p_posisi" id="p_posisi" >
			<option value="member">member</option>
			<option value="leader">leader</option>
			<option value="owner">owner</option>
		</select>
	</div>
</div>
<div>
	<div>status </div>
	<div>
		<select name="p_status" id="p_status" >
			<option value="aktif">aktif</option>
			<option value="pasif">pasif</option>
			<option value="banned">banned</option>
		</select>
		<input type="text" placeholder="keterangan status" name="p_ket" id="p_ket">
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
		<input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
		<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer(); ?>"> 
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>