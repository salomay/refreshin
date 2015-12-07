<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
<script type="text/javascript" src="<?php echo $app['lib_www']; ?>/tinymce/tinymce.min.js"></script>
      <script>
tinymce.init({
    selector: "textarea",theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality code smileys paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | smileys | print preview code ",
   image_advtab: true ,
   
   external_filemanager_path:"<?php echo $app["lib_http"];?>/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "<?php echo $app["lib_http"];?>/filemanager/plugin.min.js"}
 });
</script>
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
  <h2>Merubah <span class="label label-primary">Data Komunitas </span> "<?php echo $dbu->lookup("nama","komunitas","id ='".$form[id]."'"); ?>"</h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id, nama from ".$app[table][kota]." where status = 'aktif' ORDER BY nama asc";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
?>
	<div>pilih destinasi</div>
	<div>
	<select name="p_destinasi" id="p_destinasi" >
		<?php
			while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>" <?php echo($frsp[id]==$form[id_kota])?"selected":""; ?>><?php echo $frsp[nama]; ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<div>nama komunitas *</div>
	<div>
	<input type="text" name="p_nama" id="p_nama" value="<?php echo $form[nama]; ?>" placeholder="x3m gank" size="50" />
	</div>
</div>
<br/>
<div>
	<div>lokasi *</div>
	<div>
	<input type="text" name="p_lokasi" id="p_lokasi" value="<?php echo $form[lokasi]; ?>" placeholder="X Spot ...." size="100" />
	</div>
</div>
<br/>
<div>
	<div>logo komunitas *</div>
	<div>
		<?php 
		if ($form['logo']){ 
				$filename = $app['data_path']."/komunitas/logo/".$form['logo'];
			if (file_exists($filename)) {
			 ?>
			 	<img src="<?php echo  $app['data_www'];?>/komunitas/logo/<?php echo $form[logo];?>" width="150" height="150" /> <br> 
				<input type="checkbox" class="checkbox" name="p_logo_del" value="1">check to remove <br />
			 <?php
			} else {
			 ?>
			 	<img src="<?php echo  $app['data_www']?>/komunitas/logo/default.png" width="150" height="150" />
				<br><br>
			 <?php }
			} else { ?>
			<img src="<?php echo  $app['data_www']?>/komunitas/logo/default.png" width="150" height="150" />
			<br><br>
		<?php } ?>
		<input name="p_logo" type="file" id="p_logo" />&nbsp;
	</div>
</div>
<br/>
<div>
	<div>tanggal terbentuk *</div>
	<div>
	<?php 
		$start = explode("-",$form[tgl_terbentuk]);
		$start_date = $start[2]."/".$start[1]."/".$start[0];
	?>
		<input name="p_start" type="text" id="p_start" value="<?php echo $start_date; ?>" />
        (31/12/1981)
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