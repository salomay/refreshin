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
  //print_r($app[me]);
  ?>
  <h2>Detil <span class="label label-primary">User</span></h2>
  <br/> 
<form method="post" enctype="multipart/form-data">
<div>
	<div>username :</div>
	<div class="viewedx">
	<?php echo $appx->ov($form['username']) ?>
	</div>
</div>
<br/>
<div>
	<div>nama :</div>
	<div class="viewedx">
	<?php echo $form['nama']; ?>
	</div>
</div>
<br/>
<div>
	<div>tipe :</div>
	<div class="viewedx">
		<?php 
		if($appx->ov($form['tipe'])=='1'){
			echo "Administrator";
		}else if($appx->ov($form['tipe'])=='2'){
			echo "Operator";
		}else if($appx->ov($form['tipe'])=='3'){
			echo "Pengguna";
		}else if($appx->ov($form['tipe'])=='4'){
			echo "Community Leader";
		}else if($appx->ov($form['tipe'])=='5'){
			echo "Sponsor";
		}else if($appx->ov($form['tipe'])=='9'){
			echo "Owner";
		}
		?>
	</div>
</div>
<br/>
<div>
	<div>email :</div>
	<div class="viewedx">
		<?php echo $appx->ov($form['email']) ?>
	</div>
</div>
<br/>
<div>
	<div>avatar :</div>
	<div class="viewedx">
		<?php if ($form['avatar']){ 
				$filename = $app['data_path']."/pengguna/avatar/".$form['avatar'];
			if(file_exists($filename)){
		  ?>
				<img src="<?php echo  $app['data_www']?>/pengguna/avatar/<?php echo  $form['avatar'];?>" width="78" height="78" /> <br> 
				<input type="checkbox" class="checkbox" name="p_thumb_del" value="1">check to remove <br />
		<?php }else{ ?>
				<img src="<?php echo  $app['data_www']?>/pengguna/avatar/default.png; ?>" width="78" height="78" />
				<br><br> 
			<?php }
			}else{ ?>
			<img src="<?php echo  $app['data_www']?>/pengguna/avatar/default.png; ?>" width="78" height="78" />
			<br><br>
		<?php } ?>
	</div>
</div>
<br/>
<div>
<div>hak / privileges</div>
<div class="viewedx">
	<?php 
      //echo $form['aplikasi'];
      $hak = '';
      $arr_application = @explode("-", $form['aplikasi']);
      $appnya = "";
      while (list(, $v) = @each($arr_application)){
        //print_r($v);
        list($app_idx, $role_idx) = explode('_', $v);
        //echo $app_idx;
        if ($tampil->has_access($app_idx, $form['aplikasi'])){
          if($appnya!=$app_idx){
            if($appnya!=""){
              $hak .= "]<br/>";
            }
          }
          if($appnya!=$app_idx){
            $hak .= $app['cms']['nama'][$app_idx]." [";
          }
          if($appnya!=$app_idx){
            $hak .= "".$app['cms']['hak'][$app_idx][$role_idx]."";
          }else{
            $hak .= ", ".$app['cms']['hak'][$app_idx][$role_idx]."";
          }
          $appnya = $app_idx;
        }
      $hitapp++;
      }
      $hak .="]<br/>";
      echo $hak;
    ?> 
</div>
</div>
	<br/>
	<div class="footer">
		<!--<input type="button" value="Update" onClick="set_action(this, 'update')"> 
		<input type="reset" value="Reset" name="reset">-->
			<input type="hidden" name="act">
			<input type="button" value="Back" id="cancel">
			<input type="hidden" name="step" value="2">
			<input type="hidden" name="referer" value="<?php echo  $urlx->get_referer() ?>"> 
	</div>	
</form>
</div><br/>
<?php echo $tampil->tampilkan_footer(''); ?>