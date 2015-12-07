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
  <h2>Membuat <span class="label label-primary"> Kegiatan Destinasi</span> <?php echo $dbu->lookup("nama","destinasi_bahasa","id_reff ='".$dbu->lookup("id_reff","destinasi","id='".$p_id."'")."'"); ?></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>
	<?php 
	$sql= "SELECT id from ".$app[table][bahasa]." where status = 'aktif' order by id";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);
?>
	<div>bahasa (masukan semua isian sesuai pilihan bahasa)</div>
	<div>
	<select name="p_bahasa" id="p_bahasa" >
		<?php
			while($frsp=$dbu->fetch($rsp)){
		 ?>
			<option value="<?php echo $frsp[id]; ?>"><?php echo $dbu->lookup("bahasa","bahasa","id='".$frsp[id]."'"); ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<div>nama *</div>
	<div>
	<input type="text" name="p_nama" id="p_nama" placeholder="Lorem Ipsum" size="100" />
	</div>
</div><div>
	<div>deskripsi *</div>
	<div>
	<textarea name="p_desk" id="p_desk" ></textarea>
	</div>
</div>
<br/>

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