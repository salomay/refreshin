<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"  />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<meta name="description" content="This Description for Site">
	<meta name="description" content="<?php if($app['detail_des']){ echo str_replace('"',"'",strip_tags($app['detail_des']));
	}elseif($app['lead']){ echo strip_tags($app['lead']);
	}else{ 
		if($header_title['description_'.$app['bahasa']]){ echo strip_tags($header_title['deskripsi']); 
		}else{ echo strip_tags($config['meta_description']);
		}
	}?>"/>
<meta name="keywords" content="<?php 
echo strip_tags($config['meta_keyword']);
if($app['detail_des']){ echo ", ".str_replace('"',"'",strip_tags($app['detail_des']));
}else{
	if($header_title['keyword_'.$app['bahasa']]){ echo ", ".strip_tags($header_title['keyword_'.$app['bahasa']]);  
	}else{ 
		if($app['lead']){ echo ", ".strip_tags($app['lead']);
		
		}
	}
} ?>" />
<meta property="og:title" content="<?php echo $app[config]["judul_website"]; ?> | <?php echo ($header_title['judul'])? $header_title['judul'] : $app[config]['judul_website'];?><?php if($app['detail']){echo " | ".$app['detail'];}?>"/>
<meta property="og:type" content="store"/>
<meta property="og:url" content="<?php echo $urlx->curPageURL()?>"/>
<?php if($app[data_folder]){ ?><meta property="og:image" content="<?php echo $app['data_folder'];?>?mode=<?php echo date("dmYHis")?>"/><?php }?>
<meta property="og:site_name" content="<?php echo $app[config]["judul_website"]; ?>"/>
<!--<meta property="fb:admins" content="100004973885497" />
<meta property="fb:app_id" content="190597577752885" />-->
	<?php
	$condes=""; 
	if($app['detail_des']){
		$condes = str_replace('"',"'",strip_tags($app['detail_des']));
	}elseif($app['lead']){ 
		$condes = strip_tags($app['lead']);
	}else{ 
		if($header_title['deskripsi']){
			$condes = strip_tags($header_title['deskripsi']); 
		}else{ 
			$condes=strip_tags($dbu->lookup("meta_description","konfig_bahasa","id_konfig ='".$app[config][id]."' id_bahasa ='".$_SESSION[bhs]."'"));
		}
	}?>
<meta property="og:description"  content="<?php echo $condes;?>"/>
<meta name="robots" content="index,follow" />
	<link rel="icon" href="<?php echo $app["data_www"] ?>/konfig/logo/<?php echo $app[config]["favico"]; ?>" /> 
	<title><?php echo $app[config]["judul_website"]; ?></title>
	
	<link href="<?php echo $app[css_www];?>/style.css" rel="stylesheet" />
	<link href="<?php echo $app[css_www];?>/cari_katakunci.css" rel="stylesheet" />
	<script src="<?php echo $app[lib_www];?>/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo $app[lib_www];?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo $app[lib_www];?>/js/modernizr-2.7.1.custom.js"></script>
  	
	
	<?php
	if($app[nopage]==51||$app[nopage]==21){
	?>
		<link href="<?php echo $app[css_www];?>/jquery.fancybox.css" rel="stylesheet" />
		<script src="<?php echo $app[lib_www];?>/js/jquery.fancybox.pack.js?v=2.1.5"></script>
	<?php
	}
	?>	
	<?php 
	if(($app[nopage]==2)||($app[nopage]=='desfilter')||($app[nopage]==22)||($app[nopage]==23)||($app[nopage]==11)){
	?>
		<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_GKN-3DocFHGD3RSaSodH_3WBbbrEWMs&extension=.js&callback=initMap"
        async defer></script> 
      <!--  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	--><?php
	}
	?>
	<?php 
		//echo $app[nopage];
		if($app[nopage]==21){
	?>
	<script src="<?php echo $app[lib_www];?>/js/jquery.barrating.js"></script>
<script type="text/javascript">
    $(function () {
            $('#example-a').barrating();

            $('#example-b').barrating('show', {
                readonly:true
            });

            $('#example-c, #example-d').barrating('show', {
                showValues:true,
                showSelectedRating:false
            });

            $('#example-e').barrating('show', {
                initialRating:'A',
                showValues:true,
                showSelectedRating:false,
                onSelect:function(value, text) {
                    alert('Selected rating: ' + value);
                }
            });

            $('#example-1').barrating({ showSelectedRating:false });
            $('#example-f').barrating({ showSelectedRating:false });

            $('#example-g').barrating('show', {
                showSelectedRating:true,
                reverse:true
            });
    });
</script>	
	<?php 
		} 
	?>
</head>
