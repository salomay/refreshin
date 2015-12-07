<?php 
$tampil = new admlib();
$appx = new app();
$dbu = new db();
$navi = new nav();
echo $tampil->tampilkan_header('home','cms');
echo $tampil->tampilkan_menu('cms');
?>
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
  //print_r($rshasil);
  ?>
  <h2>Daftar <span class="label label-primary">Komunitas </span></h2>
  <br/> 
  <div class="table_filter" style="text-align:center;">
    <?php 
    $array = Array();
    for( $i = 65; $i < 91; $i++){
        $array[] = chr($i);
    }
    echo '<a href="index.php?act=browse&p_id='.$p_id.'">#</a> &nbsp;';
    foreach( $array as $k => $v){
        echo '<a href="index.php?act=browse&p_id='.$p_id.'&abjad=$v">'.$v.'</a> &nbsp;';
    }

?>
   </div>
<form method="post">
  <div class="table_filter">
    <select class="form-control" name="fcari" >
      <option value="nama">nama</option>
      <option value="lokasi">lokasi</option>
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
            <a href="index.php?act=browse&p_id=<?php echo $p_id; ?>&sidx=nama&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&p_id=<?php echo $p_id; ?>&sidx=nama&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>lokasi</span>
          </div>
        </th>
        <th>
          <div><span>destinasi</span>
          </div>
        </th>
        <th>
          <div><span>status</span>
          </div>
        </th>
        <th>
          <div><span>aktifator</span>
          </div>
        </th>
        <th>
          <div><span>tgl terbentuk</span>
          <?php 
          if($sord=="desc"){
          ?>
            <a href="index.php?act=browse&sidx=tgl_terbentuk&sord=asc" title="asc">
            <span class="ion-arrow-down-b"></span>
            </a>
          <?php 
          }else{
          ?>
            <a href="index.php?act=browse&sidx=tgl_terbentuk&sord=desc" title="desc">
            <span class="ion-arrow-up-b"></span>
            </a>
          <?php
          }
          ?>
          </div>
        </th>
        <th>
          <div><span>post update </span>
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
          </td>
          <td >
            <?php echo $rshasil["nama"]; ?>
          </td>
          <td style="text-align:center">
            <?php echo $rshasil[lokasi]; ?>
          </td>
          <td style="text-align:center;">
            <a href="../komunitas_destinasi/index.php?act=browse&p_id=<?php echo $rshasil[id]; ?>" title="destinasi yang di naungi" >
              <span class="ion-gear-b"></span></a>
          </td>
          <td style="text-align:center;">
            <?php 
            $stat = "index.php?act=set_status&p_id=".$rshasil[id]."&status=".$rshasil["status"];
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
          <td style="text-align:center">
            <?php echo $rshasil["username"]; ?>
          </td>
          <td style="text-align:center;"><?php 
            if (($rshasil["tgl_terbentuk"]!=null)&&($rshasil["tgl_terbentuk"]!='0000-00-00')){
                $rshasil["tgl_terbentuk"] = $appx->format_date($rshasil["tgl_terbentuk"], '');
            }else{
                $rshasil["tgl_terbentuk"] = "";
            }
            echo $rshasil["tgl_terbentuk"]; ?>
            </td>
          <td style="text-align:center;"><?php 
            if (($rshasil["tgl_post"]!=null)&&($rshasil["tgl_post"]!='0000-00-00')){
                $rshasil["tgl_post"] = $appx->format_date($rshasil["tgl_post"], '');
            }else{
                $rshasil["tgl_post"] = "";
            }
            echo $rshasil["tgl_post"]; ?>
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
        <a href="index.php?act=browse&p_id=<?php echo $p_id;?>" title="Reset">
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