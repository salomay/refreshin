<?php if(!empty($_SESSION['adminsession'])){ 
$appx = new app();
$admlibx= new admlib();
?>
<div class="sidebar">
      <div id="nav">
        <ul>
          <li><a href="<?php echo $app['webmin']; ?>/home/" <?php echo ((preg_match("/cmshome/i", $app['aktip'])))? "class='active'" : ""?>>DASHBOARD</a>
            <ul>
              <li><a href="#" <?php echo (preg_match("/cms_cpass/i", $app['aktip']))? "class='active'" : ""?>>rubah password</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/index.php?act=logout" <?php echo (preg_match("/cms_logout/i", $app['aktip']))? "class='active'" : ""?>>logout</a></li>
            </ul>
          </li>
          <?php if ($admlibx->has_access("pgn", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/usercms/i", $app['aktip']))? "class='active'" : ""?>>PENGGUNA</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/user_management/index.php" <?php echo (preg_match("/usercms_mana/i", $app['aktip']))? "class='active'" : ""?>>Manajemen</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/user_achievement/index.php" <?php echo (preg_match("/usercms_achi/i", $app['aktip']))? "class='active'" : ""?>>Capaian</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if ($admlibx->has_access("geol", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/geocms/i", $app['aktip']))? "class='active'" : ""?>>GEOGRAFI</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/negara/index.php" <?php echo (preg_match("/geocms_negara/i", $app['aktip']))? "class='active'" : ""?>>negara</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/provinsi/index.php" <?php echo (preg_match("/geocms_prov/i", $app['aktip']))? "class='active'" : ""?>>provinsi</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/kota/index.php" <?php echo (preg_match("/geocms_kota/i", $app['aktip']))? "class='active'" : ""?>>kota</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/bahasa/index.php" <?php echo (preg_match("/geocms_bhs/i", $app['aktip']))? "class='active'" : ""?>>bahasa</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if ($admlibx->has_access("tours", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/tourcms/i", $app['aktip']))? "class='active'" : ""?>>PARIWISATA</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/destinasi_kategori/index.php" <?php echo (preg_match("/tourcms_kategori/i", $app['aktip']))? "class='active'" : ""?>>kategori destinasi</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/destinasi/index.php" <?php echo (preg_match("/tourcms_destinasi/i", $app['aktip']))? "class='active'" : ""?>>destinasi</a></li>
            </ul>
          </li>
          <?php } ?>
           <?php if ($admlibx->has_access("tours", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/tourcms/i", $app['aktip']))? "class='active'" : ""?>>NEWS</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/news_kategori/index.php" <?php echo (preg_match("/tourcms_kategori/i", $app['aktip']))? "class='active'" : ""?>>kategori berita</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/news/index.php" <?php echo (preg_match("/tourcms_destinasi/i", $app['aktip']))? "class='active'" : ""?>>berita</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if ($admlibx->has_access("community", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/communitycms/i", $app['aktip']))? "class='active'" : ""?>>KOMUNITAS</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/komunitas/index.php" <?php echo (preg_match("/communitycms_master/i", $app['aktip']))? "class='active'" : ""?>>master komunitas</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/komunitas_keanggotaan/index.php" <?php echo (preg_match("/communitycms_member/i", $app['aktip']))? "class='active'" : ""?>>keanggotaan</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if ($admlibx->has_access("sett", $user['aplikasi'])){ ?>
          <li><a <?php echo (preg_match("/sett/i", $app['aktip']))? "class='active'" : ""?>>KONFIGURASI</a>
            <ul>
              <li><a href="<?php echo $app['webmin']; ?>/aksi/index.php" <?php echo (preg_match("/sett_action/i", $app['aktip']))? "class='active'" : ""?>>manajemen aksi</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/konfig/index.php" <?php echo (preg_match("/sett_config/i", $app['aktip']))? "class='active'" : ""?>>web konfig</a></li>
              <li><a href="<?php echo $app['webmin']; ?>/konfig_bahasa/index.php" <?php echo (preg_match("/sett_conbhs/i", $app['aktip']))? "class='active'" : ""?>>web konfig detil</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  <?php
    }
    ?>