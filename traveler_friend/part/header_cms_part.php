<html>
  <head>
    <title>refreshin dashboard</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="author" content="widhadi agus wahyu prakoso a.k.a scs[Doctor]"/>
    <link rel="stylesheet" href="<?php echo $app[css_cms]; ?>/cms.css"/>
    <link rel="stylesheet" href="<?php echo $app[css_cms]; ?>/cms_table.css"/>
    <link rel="stylesheet" href="<?php echo $app[css_cms]; ?>/inputku.css"/>
    <!--<link rel="stylesheet" href="<?php echo $app[css_cms]; ?>/checkbox.css"/>-->
    <link rel="stylesheet" href="<?php echo $app[css_cms]; ?>/ionicons/css/ionicons.min.css"/>
    <script src="<?php echo $app[lib_www]; ?>/js/jquery-1.11.0.min.js"></script>
    <!--<script src="<?php echo $app[lib_cms]; ?>/js/tableSorter.js"></script>-->
    <script src="<?php echo $app[lib_cms]; ?>/js/cms_table.js"></script>
    <script src="<?php echo $app[lib_www]; ?>/scriptx.js"></script>
  </head>
</html>
<body>
<?php echo '<script type="text/javascript">
  
$(function() {'."
    $('#cancel').click(function(){
      top.location.href = '". $urlx->get_referer()."';
    });
  });
</script>";
?>
  <div id="header">
    <div class="logo"><a href="#" target="_self">REFRESH<span>in</span></a></div>
  </div>
  <div id="container">