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
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
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
  <h2>Merubah <span class="label label-primary"> Destinasi Bahasa</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<?php 
	$sql= "SELECT id from ".$app[table][bahasa]." where status = 'aktif' order by id";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);

	while($frsp=$dbu->fetch($rsp)){
		$a[$frsp[id]]=$frsp[id];

	}

	$sql= "SELECT distinct(id_bahasa) from ".$app[table][destinasi_bahasa]." where id_reff='".$p_id."' and id <> '".$sub."' order by id";
	//echo $sql;
	$dbu->query($sql,$rsp,$nrp);

	while($frsp=$dbu->fetch($rsp)){
		$b[$frsp[id_bahasa]]=$frsp[id_bahasa];
	}

	if($b){
		$result = array_diff($a, $b);
	}else{
		$result = $a;
	}
	/*print_r($a);
	print_r($b);
	print_r($result);*/
	?>
	<div>bahasa (masukan semua isian sesuai pilihan bahasa)</div>
	<div>
	<select name="p_bahasa" id="p_bahasa" >
		<?php
			foreach ($result as $k=>$v){
		 ?>
			<option value="<?php echo $k; ?>" <?php echo ($k==$form[id_bahasa])?"selected":""; ?>><?php echo $dbu->lookup("bahasa","bahasa","id='".$k."'"); ?></option>
		<?php } ?>
	</select>
	</div>
</div>
<br/>
<div>
	<div>nama tempat wisata *</div>
	<div>
	<input value="<?php echo $form[nama]; ?>" name="p_nama" type="text" id="p_nama" placeholder="city of hero surabaya ...">
	</div>
</div>
<br/>
<div>
	<div>deskripsi *</div>
	<div>
	<textarea name="p_desk" id="p_desk" placeholder="..." ><?php echo $form[deskripsi]; ?></textarea>
	</div>
</div>
<br/>
<div>
	<div>slogan *</div>
	<div>
	<input type="text" name="p_slogan" id="p_slogan" value="<?php echo $form[slogan]; ?>" placeholder="..." size="100" />
	</div>
</div>
<br/>
<div>
	<div>alamat *</div>
	<div>
	<input name="p_alamat" type="text" id="p_alamat"  placeholder = "earth ...." size="100" value="<?php echo $form[alamat]; ?>"/>
	</div>
</div>
<br/>
<div>
	<div>htm</div>
	<div>
	<input name="p_htm" type="text" id="p_htm" placeholder="Rp. 500.000 ..." value="<?php echo $form[htm]; ?>" />
	</div>
</div>
<br/>
<div>
	<div>untuk usia</div>
	<div>
	<input name="p_usia" type="text" id="p_usia" placeholder="SEGALA USIA" value="<?php echo $form[usia]; ?>" />
	</div>
</div>
<br/>
<div>
	<div>waktu buka</div>
	<div>
	<input name="p_haribuka" type="text" id="p_haribuka" placeholder="senin - sabtu" value="<?php echo $form[hari_buka]; ?>" />
	<input name="p_jambuka" type="text" id="p_jambuka" placeholder="04:00 - 17:00" value="<?php echo $form[jam_buka]; ?>" />
	</div>
</div>
<br/>
<div>
	<div>waktu terbaik</div>
	<div>
	<input name="p_haribaik" type="text" id="p_haribaik" placeholder="senin - sabtu" value="<?php echo $form[best_day]; ?>"/>
	<input name="p_jambaik" type="text" id="p_jambaik" placeholder="04:00 - 17:00" value="<?php echo $form[best_time]; ?>" />
	</div>
</div>
<br/>
<div>
	<div>libur</div>
	<div>
	<input name="p_harilibur" type="text" id="p_harilibur" placeholder="minggu" value="<?php echo $form[hari_libur]; ?>" />
	</div>
</div>
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