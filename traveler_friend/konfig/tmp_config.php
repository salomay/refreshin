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
  <h2>Merubah <span class="label label-primary">Master Konfigurasi</span></h2>
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
      <option value="<?php echo $frsp[id]; ?>" <?php echo ($form[id_bahasa]==$frsp[id])?"selected":""; ?>><?php echo $frsp[bahasa]; ?></option>
    <?php } ?>
  </select>
  </div>
</div>
<br/>
<div>
  <div>judul website *</div>
  <div>
    <input name="p_judul" type="text" id="p_judul" value="<?php echo $form[judul_website]; ?>">
  </div>
</div>
<br/>
<div>
  <div>judul cms *</div>
  <div>
    <input name="p_judul_cms" type="text" id="p_judul_cms" value="<?php echo $form[judul_cms]; ?>">
  </div>
</div>
<br/>
<div>
  <div>nama domain *</div>
  <div>
    <input name="p_domain" type="text" id="p_domain" value="<?php echo $form[domain_name]; ?>">
  </div>
</div>
<br/>
<div>
  <div>email *</div>
  <div>
    <input name="p_email" type="text" id="p_email" value="<?php echo $form[email]; ?>">
  </div>
</div>
<br/>
<div>
  <div>facebook *</div>
  <div>
    <input name="p_fb" type="text" id="p_fb" value="<?php echo $form[facebook]; ?>">
  </div>
</div>
<br/>
<div>
  <div>twitter *</div>
  <div>
    <input name="p_twit" type="text" id="p_twit" value="<?php echo $form[twitter]; ?>">
  </div>
</div>
<br/>
<div>
  <div>google api </div>
  <div>
    <input name="p_google_api" type="text" id="p_google_api" value="<?php echo $form[google_apis]; ?>">
  </div>
</div>
<br/>
<div>
  <div>google api sensor </div>
  <div>
    <input name="p_gapi" type="text" id="p_gapi" value="<?php echo $form[gapisensor]; ?>">
  </div>
</div>
<br/>
<div>
  <div>status website*</div>
  <div>
    <select name="p_status_web" id="p_status_web">
      <option value ="aktif" <?php echo($form[status_web]=='aktif')?"selected":""; ?>>aktif</option>      
      <option value ="perbaikan" <?php echo($form[status_web]=='perbaikan')?"selected":""; ?>>perbaikan</option>      
      <option value ="pengembangan" <?php echo($form[status_web]=='pengembangan')?"selected":""; ?>>pengembangan</option>      
    </select>
  </div>
</div>
<br/>
<div>
  <div>status online*</div>
  <div>
    <select name="p_status" id="p_status">
      <option value ="aktif" <?php echo($form[status_web]=='aktif')?"selected":""; ?>>aktif</option>      
      <option value ="nonaktif" <?php echo($form[status_web]=='nonaktif')?"selected":""; ?>>nonaktif</option> 
    </select>
  </div>
</div>
<br/>
<div>
  <div>logo website *</div>
  <div>
    <?php 
    if ($form['logo_web']){ 
        $filename = $app['data_path']."/konfig/logo/".$form['logo_web'];
      if (file_exists($filename)) {
       ?>
        <img src="<?php echo  $app['data_www'];?>/konfig/logo/<?php echo $form[logo_web];?>"  /> <br> 
        <input type="checkbox" class="checkbox" name="p_logo_web_del" value="1">check to remove <br />
       <?php
        }  
      } ?>
    <input name="p_logo_web" type="file" id="p_logo_web" />&nbsp;
  </div>
</div>
<br/>
<div>
  <div>logo cms *</div>
  <div>
    <?php 
    if ($form['logo_cms']){ 
        $filename = $app['data_path']."/konfig/logo/".$form['logo_cms'];
      if (file_exists($filename)) {
       ?>
        <img src="<?php echo  $app['data_www'];?>/konfig/logo/<?php echo $form[logo_cms];?>" /> <br> 
        <input type="checkbox" class="checkbox" name="p_logo_cms_del" value="1">check to remove <br />
       <?php
        }  
      } ?>
    <input name="p_logo_cms" type="file" id="p_logo_cms" />&nbsp;
  </div>
</div>
<br/>
<div>
  <div>fav icon *</div>
  <div>
    <?php 
    if ($form['favico']){ 
        $filename = $app['data_path']."/konfig/logo/".$form['favico'];
      if (file_exists($filename)) {
       ?>
        <img src="<?php echo  $app['data_www'];?>/konfig/logo/<?php echo $form[favico];?>"  /> <br> 
        <input type="checkbox" class="checkbox" name="p_favico_del" value="1">check to remove <br />
       <?php
        }  
      } ?>
    <input name="p_favico" type="file" id="p_favico" />&nbsp;
  </div>
</div>
<br/>
<div>
  <div>tanggal update terakhir 
    <?php 
        if (($form["tgl_modif"]!=null)&&($form["tgl_modif"]!='0000-00-00')){
            $form["tgl_modif"] = $appx->format_date($form["tgl_modif"], 'id');
        }else{
            $form["tgl_modif"] = "";
        }
        echo $form["tgl_modif"]; ?>
</div>
<br/>
<hr/>
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