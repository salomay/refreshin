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
 //print_r($form);
  ?>
  <h2>Merubah Data <span class="label label-primary">User</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>USERNAME *</div>
	<div>
	<input name="p_username" type="text" id="p_username" value="<?php echo $appx->ov($form['username']) ?>">
	</div>
</div>
<br/>
<div>
	<div>NAMA *</div>
	<div>
	<input name="p_name" id="p_name" type="text" value="<?php echo $form['nama']; ?>"  >
	</div>
</div>
<br/>
<div>
	<div>TIPE *</div>
	<div>
	<select name="p_tipe" id="p_tipe">
		<option value="1" <?php echo ($appx->ov($form['tipe'])=='1')?"selected":""; ?> >Administrator</option>
		<option value="2" <?php echo ($appx->ov($form['tipe'])=='2')?"selected":""; ?>>Operator</option>
		<option value="3" <?php echo ($appx->ov($form['tipe'])=='3')?"selected":""; ?>>User</option>
		<option value="4" <?php echo ($appx->ov($form['tipe'])=='4')?"selected":""; ?>>Community Leader</option>
		<option value="5" <?php echo ($appx->ov($form['tipe'])=='5')?"selected":""; ?>>Sponsor</option>
		<option value="9" <?php echo ($appx->ov($form['tipe'])=='9')?"selected":""; ?>>Owner</option>
	</select>
	</div>
</div>
<br/>
<div>
	<div>EMAIL *</div>
	<div>
	<input name="p_email" type="text"  id="p_email" value="<?php echo $appx->ov($form['email']) ?>">
	</div>
</div>
<br/>
<div>
	<div>AVATAR *</div>
	<div>
		<?php if ($form['avatar']){ 
				$filename = $app['data_path']."/pengguna/avatar/".$form['avatar'];
			//echo $filename;
			if(file_exists($filename)){
		  ?>
				<img src="<?php echo  $app['data_www'];?>/pengguna/avatar/<?php echo $form['avatar'];?>" width="78" height="78" /> <br> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br />
		<?php }else{ ?>
				<img src="<?php echo  $app['data_www']?>/pengguna/avatar/default.png" width="78" height="78" />
				<br><br> 
			<?php }
			}else{ ?>
			<img src="<?php echo  $app['data_www']?>/pengguna/avatar/default.png" width="78" height="78" />
			<br><br>
		<?php } ?>
		<input name="p_thumb" type="file" id="p_thumb" />&nbsp;
	</div>
</div>
<br/>
<div>
<div>HAK / Privileges</div>
</div>
<br/>
<div>
	<table id="previlage">
	<tr>
		<th style="text-align:left;">No</th>
		<th style="text-align:left;">Nama Modul</th>
		<th>Browse</th>
		<th>Menambah</th>
		<th>Merubah</th>
		<th>Menghapus</th>
		<th>Reset</th>
		<th>Semua</th>
	</tr>
<?php

$i = 0;
while (list($k ,$v) = each($app['cms']['nama'])){
$no = $i+1;

if (preg_match("/".$k."_view/i", $form['aplikasi'])){
					$checked[$k.'_view'] = 'checked';
}else{
	$checked[$k.'_view'] = '';
}
if (preg_match("/".$k."_add/i", $form['aplikasi'])){
	$checked[$k.'_add'] = 'checked';
}else{
	$checked[$k.'_add'] = '';
}
if (preg_match("/".$k."_edit/i", $form['aplikasi'])){
	$checked[$k.'_edit'] = 'checked';
}else{
	$checked[$k.'_edit'] = '';
}
if (preg_match("/".$k."_del/i", $form['aplikasi'])){
	$checked[$k.'_del'] = 'checked';
}else{
	$checked[$k.'_del'] = '';
}
if (preg_match("/".$k."_rest/i", $form['aplikasi'])){
	$checked[$k.'_rest'] = 'checked';
}else{
	$checked[$k.'_rest'] = '';
}

?>
<tr>
	<td><?php echo ($no<=9)? "0".$no:$no; ?></td> 
	<td><?php echo $v; ?></td> 
	<?php $i++;	?>
	<td style="<?php echo $background?>">
	<?php
		if($app['cms']['hak'][$k]['view']){ ?>
		<input type="checkbox" name="p_cms[<?php echo $k; ?>][]" class="p_cms_<?php echo $k ?>" id="p_cms_<?php echo $k ;?>_view" value="<?php echo $k.'_view'; ?>" <?php echo $checked[$k.'_view']; ?> /> 
		<?php }else{ ?>
			&nbsp;
		<?php } ?>
	</td>
	<td style="<?php echo $background; ?>">
		<?php
		if($app['cms']['hak'][$k]['add']){
		?>
		<input type="checkbox" name="p_cms[<?php echo $k ?>][]" class="p_cms_<?php echo $k ?>" id="p_cms_<?php echo $k ?>_hak" value="<?php echo $k.'_add' ?>" <?php echo $checked[$k.'_add']; ?> /> 
		<?php }else{ ?>
			&nbsp;
		<?php } ?>
	</td>
	<td style="<?php echo $background?>">
		<?php 
		if($app['cms']['hak'][$k]['edit']){
		?>
		<input type="checkbox" name="p_cms[<?php echo $k ?>][]" class="p_cms_<?php echo $k ?>" id="p_cms_<?php echo $k ?>_hak" value="<?php echo $k.'_edit' ?>" <?php echo $checked[$k.'_edit']; ?> /> 
		<?php }else{ ?>
			&nbsp;
		<?php } ?>
	</td>
	<td style="<?php echo $background?>">
		<?php
		if($app['cms']['hak'][$k]['del']){
		?>
		<input type="checkbox" name="p_cms[<?php echo $k ?>][]" class="p_cms_<?php echo $k ?>" id="p_cms_<?php echo $k ?>_hak" value="<?php echo $k.'_del' ?>" <?php echo $checked[$k.'_del']; ?> /> 
		<?php }else{ ?>
		&nbsp;
		<?php } ?>
	</td>
	<td style="<?php echo $background?>">
		<?php
		if($app['cms']['hak'][$k]['rest']){
		?>
		<input type="checkbox" name="p_cms[<?php echo $k ?>][]" class="p_cms_<?php echo $k ?>" id="p_cms_<?php echo $k ?>_hak" value="<?php echo $k.'_rest' ?>" <?php echo $checked[$k.'_rest']; ?> /> 
		<?php }else{ ?>
		&nbsp;
		<?php } ?>
	</td>
	<td style="<?php echo $background?>">
		<input type="checkbox" class="p_cms_all" rel="p_cms_<?php echo $k ?>" >
	</td>
</tr> 	
	<?php
	}
	?>
<tr class="select_all">
<td>
</td> 
<td style="text-align:left;">
	<font style="color:#000;font-weight:bold;font-size:13px;">Pilih Semua Opsi</font>
</td> 
<td>
	<input type="checkbox" class="p_cms_all_form" rel="p_cms_<?php echo $k; ?>" >
</td>
<td collspan="5">
</td>
</tr>
</table>

<?php
echo "<script>";
echo "$(\"input#p_cms_".$k."_hak\").click(function(){
		var checked_status = this.checked;
		$(\"input#p_cms_".$k."_view\").each(function()
		{
			this.checked = checked_status;
		});
	});

	$(\"input.p_cms_all\").click(function(){
		var checked_status = this.checked;
		id = $(this).attr(\"rel\");
		$(\"input.\"+id).each(function()
		{
			this.checked = checked_status;
		});		
	});

	$(\"input.p_cms_all_form\").click(function(){
		var checked_status = this.checked;
		$(\"input\").each(function()
		{
			this.checked = checked_status;
		});		
	});";
echo "</script>";
?>
	</div><br/>
	<div >Yang Bertanda * Harus disi</div><br/>
	<div class="kontenFooter">
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