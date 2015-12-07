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
  <h2>Membuat <span class="label label-primary"> Biaya Destinasi</span> <?php echo $dbu->lookup("nama",$app[table][komunitas],"id ='".$p_id."'"); ?></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>
	<?php 
	$sql= "SELECT a.id, b.nama from ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]."  as b ON(a.id_reff = b.id_reff) LEFT JOIN ".$app[table][komunitas_destinasi]." as c ON (a.id <> c.id_destinasi) where b.id_bahasa = 'id' AND c.id_komunitas ='".$p_id."' order by b.nama ";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
?>
	<div>destinasi </div>
	<div>
	<?php 
	$lock = false;
	if($nrp<=0){
		$hit = $dbu->count_record("id",$app[table][komunitas_destinasi],"where id_komunitas ='".$p_id."'");
		if($hit <= 0){
		$sql= "SELECT a.id, b.nama from ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]."  as b ON(a.id_reff = b.id_reff) where b.id_bahasa = 'id' order by b.nama ";
		//echo $sql;
		$dbu->query($sql,$rsp,$nrp);	
		}else{
			$lock=true;
		}
		
	}

	if($lock == false){
	?>
	<select name="p_destinasi" id="p_destinasi" >
		<?php
			while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>"><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
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
	<?php 
}else{
	echo "data destinasi tidak ditemukan (atau sudah di refrensikan semua ke komunitas ini)";
}
	?>
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>