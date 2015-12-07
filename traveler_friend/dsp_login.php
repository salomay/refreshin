<?php 
$tampil = new admlib();
$appx = new app();
$msgx = new msg();
echo $tampil->tampilkan_header('','login');
?>  
  <body>
    <div class="splash">
      <div id="form-div">
        <p id="judul-cms">CM. SYSTEM</p>
        <form method="post" enctype="multipart/form-data">
          <input class="itext-username" name="p_uname" type="text" placeholder="USER NAME">
          <input class="itext-password" name="p_pwdx" type="password" placeholder="PASSWORD">
          <input class="ibutt-login" type="button" value="LOGIN" onClick="set_action(this, 'login')">
		  <input type="hidden" name="act">
        </form>
      </div>
    </div>
  </body>
<?php echo $tampil->tampilkan_footer('login'); ?>