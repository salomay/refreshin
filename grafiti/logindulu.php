<!DOCTYPE html>
<html>
<head>
	<title>refreshin.co.id</title>
	<script language="JavaScript" src="<?php echo  $app['lib_www'] ?>/scriptx.js"></script>
</head>
<style type="text/css">
body{
	font-family: 'Montserrat', Arial, Helvetica, sans-serif;
}
.splash {
		height: 100vh;
		background-size:cover;
		display : flex;
		flex-direction : column;
		justify-content : center;
		align-items:center;
		background-image:url("<?php echo $app[data_www];?>/cms_bg/bg_1.jpg");
	}

#judul-cms {
  color: #fff;
  font-weight: bold;
  display: block;
  padding: 0 5px;
  text-align: left;
}

#form-div {
  background-color: rgba(3, 135, 126, 0.5);
  border-radius: 4px;
  box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.9);
  padding: 0px 35px 35px 35px;
  text-align: center;
  width: 25%;
}

#form-div form {
  display: block;
}

#form-div input {
  border: none;
  border-radius: 4px;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

#form-div .itext-username {
  margin: 4px auto;
  padding: 8px;
  width: 100%;
}

#form-div .itext-password {
  margin: 4px auto;
  padding: 8px;
  width: 100%;
}

#form-div .ibutt-login {
  cursor: pointer;
  float: right;
  font-weight: bold;
  margin: 4px auto;
  padding: 8px;
}

#form-div .ibutt-login:hover {
  background-color: grey;
  color: black;
}
</style>
<body>
    <div class="splash">
      <div id="form-div">
        <p id="judul-cms">WELCOME</p>
        <form method="post" enctype="multipart/form-data">
          <input class="itext-password" name="p_kunci" type="password" placeholder="insert the key ..."><br/>
          <input class="ibutt-login" type="button" value="JOIN" onClick="set_action(this, 'logindulu')">
		  <input type="hidden" name="act">
        </form>
      </div>
    </div>
  </body>
</html>