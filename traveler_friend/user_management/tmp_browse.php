<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');?>
<div class="content">
      <script src="<?php echo $app["lib_cms"]; ?>/js/all_check.js"></script>
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
  ?>
  <h2>Daftar <span class="label label-primary">User</span></h2>
  <br/> 
  <div class="table_filter" style="text-align:center;">
    <?php 
    $array = Array();
    for( $i = 65; $i < 91; $i++){
        $array[] = chr($i);
    }
    echo "<a href='index.php?act=browse'>#</a> &nbsp;";
    foreach( $array as $k => $v){
        echo "<a href='index.php?act=browse&abjad=$v'>$v</a> &nbsp;";
    }

?>
   </div>
<form method="post">
  <div class="table_filter">
    <select class="form-control" name="fcari" >
      <option value="name">Nama</option>
      <option value="username">User Name</option>
      <option value="email">E-Mail</option>
    </select>
    <input type="text" class="form-control"  name="kcari">
    <input type="submit" class="form-control" value="cari">
    <input type="hidden" name="act" value="browse">
  </div>
</form>
<!--ALPHABET-->
    <form method="post">
    <!--HEADER TABLE-->
  <table class="cmstable">
    <thead>
      <tr> 
        <th>
          <div>no</div>
        </th>
        <th>
          <div><span>&nbsp;</span></div>
        </th>
        <th  style="text-align:center">
          <div><input id="pilihsemua" type="checkbox" ></div>
        </th>
        <th>
          <div><span>nama</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=nama&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=nama&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>username</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=username&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=username&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>mod</span></div>
        </th>
        <th>
          <div><span>status</span></div>
        </th>
        <th>
          <div><span>email</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=email&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=email&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>tgl post</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=tgl_post&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=tgl_post&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>tgl update</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=tgl_modif&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=tgl_modif&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>             
      </tr>
    </thead>
    <tbody>
      <?php 
        $nors=1;
        while($rshasil=$dbu->fetch($rsbrowse)){   
      ?>
        <tr <?php echo($nors % 2 == 1)?'class="odd"':'class="even"'; ?>>
          <td style="text-align:center;"><?php echo $nors; ?></td>
          <td style="text-align:center">
            <a href="index.php?act=update&p_id=<?php echo $rshasil[id]; ?>" >
              <span class="ion-compose"></span>
            </a>
          </td>
          <td style="text-align:center">
            <input name="item[]" type="checkbox" value="<?php echo $rshasil[id];?>" class="checkbox1">
          <td>
            <?php echo $rshasil["nama"]; ?></td>
          <td>
             <?php echo $rshasil["username"]; ?>&nbsp;&nbsp;<a href="index.php?act=view&p_id=<?php echo $rshasil[id]; ?>" title="view detail" >
              <span class="ion-toggle-filled"></span></a>     
          </td>
          <td style="text-align:center">
            <?php 
              //echo $rshasil['aplikasi'];
              $hak = '';
              $arr_application = @explode("-", $rshasil['aplikasi']);
              $appnya = "";
              while (list(, $v) = @each($arr_application)){
                //print_r($v);
                list($app_idx, $role_idx) = explode('_', $v);
                //echo $app_idx;
                if ($tampil->has_access($app_idx, $rshasil['aplikasi'])){
                  if($appnya!=$app_idx){
                    if($appnya!=""){
                      $hak .= "]\n";
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
              $hak .="]\n";
              echo '<a alt="'.$hak.'" title="'.$hak.'"><span class="ion-grid"></span></a>';
            ?>      
          </td>
          <td style="text-align:center;">
            <?php 
            $stat = "index.php?act=set_status&p_id=$rshasil[id]&status=$rshasil[status]";
            if($rshasil["status"]=='aktif'){
              echo '<a href="'.$stat.'"  title="'.$rshasil[status].'">
                  <span class="ion-happy-outline"></span>
                  </a>';
            }else{
              echo '<a href="'.$stat.'" title="'.$rshasil[status].'">
                  <span class="ion-sad-outline"></span>
                  </a>';
            }
            ?>
          </td>
          <td>
            <?php echo $rshasil["email"]; ?>
          </td>
          <td style="text-align:center;"><?php 
            if (($rshasil["tgl_post"]!=null)&&($rshasil["tgl_post"]!='0000-00-00')){
                $rshasil["tgl_post"] = $appx->format_date($rshasil["tgl_post"], '');
            }else{
                $rshasil["tgl_post"] = "";
            }
            echo $rshasil["tgl_post"]; ?>
          </td>
          <td style="text-align:center;"><?php 
            if (($rshasil["tgl_modif"]!=null)&&($rshasil["tgl_modif"]!='0000-00-00')){
                $rshasil["tgl_modif"] = $appx->format_date($rshasil["tgl_modif"], '');
            }else{
                $rshasil["tgl_modif"] = "";
            }
            echo $rshasil["tgl_modif"]; ?>
          </td>
        </tr>
      <?php   
        $nors++;
        }
      ?>
    </tbody>
  </table>
  <div class="box">
  <div class="box-top">proses</div>
  <div class="box-content" style="vertical-align:center;">
        <a href="index.php?act=browse" title="Reset">
        <span class="ion-ios-refresh"></span></a>
  <a href="index.php?act=add" title="Tambah"><span class="ion-ios-plus"></span></a>
  <input type="button" onClick="set_action(this, 'delete')" value="hapus seleksi">
  </div>
  </div>
  <?php
  $urlnya='index.php?act=browse';
  if($_SESSION["kcari"]!=""){
    $urlnya .= "&kcari='".$_SESSION["kcari"]."'"; 
    $urlnya .= "&fcari='".$_SESSION["fcari"]."'"; 
  }
  if($_SESSION["abjad"]!=""){
    $urlnya .= "&abjad='".$_SESSION["abjad"]."'"; 
  }
  echo $navi->admPage($total,30,$page,'index.php?act=browse','<ul class="pagination" style="float:right;margin-top:-10px;">'); ?>
  <!-- paging -->
  <input type="hidden" name="act">
  </form>
</div>
<?php echo $tampil->tampilkan_footer(''); ?>