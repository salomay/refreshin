<?php
$stats = new stats();
$appx = new app();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
$outnya ="";
$awal = 0; $jml = 8 ; $limit = 8; $lm = true;

function tujuanDes($destkota,$stat='provinsi',$tambah){
	global $app;
	$dbu = new db();
	$appx = new app();
	$urlx = new url();
	if($stat == "destinasi"){
		while($desty = $dbu->fetch($destkota)){ 
		$destinasi = $desty[nama];
		$desty[thumb] = $appx->cekFile("/destinasi/thumb/",$desty[thumb],'default.jpg');
		$desty[thumb] = $app[data_www]."/destinasi/thumb/".$desty[thumb];
			$outnya .= '<li>
							<div class="img_box">

								<img src="'.$desty[thumb].'">
							</div>
							<div class="text">
								<h1>'.$destinasi.'</h1>
								<p>'.$dbu->lookup('deskripsi',$app[table][destinasi_bahasa],"id_reff ='".$desty[id_reff]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
							</div>
							<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($destinasi)."/".'"><div class="explore">EXPLORE MORE</div></a>
						</li>';
		}
	}elseif($stat == "provinsi"){
		while($desty = $dbu->fetch($destkota)){ 
		$destinasi = $desty[nama];
		$desty[thumb] = $appx->cekFile("/destinasi/thumb/",$desty[thumb],'default.jpg');
		$desty[thumb] = $app[data_www]."/destinasi/thumb/".$desty[thumb];
			$outnya .= '<li>
							<div class="img_box">

								<img src="'.$desty[thumb].'">
							</div>
							<div class="text">
								<h1>'.$destinasi.'</h1>
								<p>'.$dbu->lookup('deskripsi',$app[table][destinasi_bahasa],"id_reff ='".$desty[id_reff]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
							</div>
							<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($destinasi)."/".'"><div class="explore">EXPLORE MORE</div></a>
						</li>';
		}
	}else{
		//echo "sedel";exit;
		while($dkota=$dbu->fetch($destkota)){
			
			$dkota[thumb] = $appx->cekFile("/kota/thumb/",$dkota[thumb],'default.jpg');
			$dkota[thumb] = $app[data_www]."/kota/thumb/".$dkota[thumb];
			//echo "asdasdas".$dkota[thumb];
			$outnya .= '<li>
							<div class="img_box">
								<img src="'.$dkota[thumb].'">
							</div>
							<div class="text">
								<h1>'.$dkota[nama].'</h1>
								<p>'.$dbu->lookup('deskripsi',$app[table][kota_bahasa],"id_kota ='".$dkota[id]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
							</div>
							<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/id_".$urlx->shortLink($dkota[nama])."_".$urlx->shortLink($tambah)."/".'"><div class="explore">EXPLORE MORE</div></a>
						</li>';
		}
	}
	return $outnya;
}


if($rs_act["action"] == 'desfilter'){
	//print_r($_POST);exit;
	$p_negara = $_POST[p_negara];
	$p_provinsi = $_POST[p_provinsi];
	$p_kota = $_POST[p_kota];
	$p_kate = $_POST[p_kategori];
	//echo $p_negara;exit;
	$tambah ="";
	if($p_negara !=""){
		if($p_provinsi !=""){
				if($p_kota!=""){
					if($p_kate !=""){
						$p_kate = "AND a.id_kat ='".$p_kate."'";
					}
					$sql = "SELECT a.id ,a.id_reff, a.thumb , b.nama FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff )WHERE  a.id_kota ='".$p_kota."' AND status='aktif' ".$p_kate." ORDER BY b.nama asc LIMIT ".$awal.",".$limit;
					//print_r($sql);exit;
					$destkota = $dbu->get_recordsetmix($sql);
					$hitrs = $dbu->count_record("id","destinasi","where id_kota ='".$p_kota."'");
					if($hitrs and $hitrs > 0){ 
							if($hitrs < $jml){
								$limit = $hitrs;
								$lm = false;
							}

						if($sub){
							$kirim="_".$urlx->shortLink($sub);
						}

						$outnya .='<div class="location_destination"><h1>'.$dbu->lookup("nama","provinsi","id='".$p_provinsi."'").", ".$dbu->lookup("nama","kota","id='".$p_kota."'").'<span class="border"></span></h1>
									<ul class="list_location" id="'.$urlx->friendlyURL($dbu->lookup("nama","kota","id='".$p_kota."'")).'" hitmax="'.$hitrs.'" cast="kota_'.$p_kota.$kirim.'" limit="'.$jml.'">';
						$outnya .= tujuanDes($destkota,'provinsi');
						$outnya .='</ul>';
							if($lm=true and ($hitrs>$limit)){
								$outnya .='<div class="load_more" rel="kota_'.$urlx->friendlyURL($dbu->lookup("nama","kota","id='".$p_kota."'")).'"><a  href="#" id="vm" >View More</a></div>';									
							}
						$outnya .='</div>';
						}
				}else{
					//echo "sdfsdf";exit;
					$sql ="SELECT a.id, a.nama, a.thumb FROM ".$app[table][kota]." as a  WHERE a.id_provinsi='".$p_provinsi."' ORDER BY a.nama LIMIT ".$awal.",".$limit;
					$dbu->query($sql,$rskota,$nrkota);
					$hitrs = $dbu->count_record("id","kota","where id_provinsi ='".$p_provinsi."'");
					if($hitrs and $hitrs > 0){ 
		
						if($hitrs < $jml){
							$limit = $hitrs;
							$lm = false;
						}
						$dprov = $dbu->lookup('nama',$app[table][provinsi],"id ='".$p_provinsi."'");
					$outnya .='<div class="location_destination"><h1>'.$dprov.'<span class="border"></span></h1>
					<ul class="list_location" id="'.$urlx->friendlyURL($dprov).'" hitmax="'.$hitrs.'" cast="prov_'.$p_provinsi.'" limit="'.$jml.'">';
					$outnya .= tujuanDes($rskota,'kota');
					unset($rskota);
					$outnya .='</ul>';
						if($lm=true and ($hitrs>$limit)){
							$outnya .='<div class="load_more" rel="'.$urlx->friendlyURL($dprov).'"><a href="#" id="vm" >View More</a></div>';									
						}
					}
				}
			
		}else{
			$tujuan=$app["www"]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/";
			header("location:".$tujuan);	
		}
	}else{
		$tujuan=$app["www"]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/";
		header("location:".$tujuan);
	}
}elseif(!$p_id){
	$sql = "SELECT id, nama FROM ".$app[table][provinsi]." WHERE id_negara ='1' ORDER BY nama LIMIT ".$awal.",".$limit;
	//echo $sql;
	$dbu->query($sql,$rsprov,$nrprov);
	while($dprov = $dbu->fetch($rsprov)){
		
		$hitrs = $dbu->count_record("id","kota","where id_provinsi ='".$dprov[id]."'");
		if($hitrs and $hitrs > 0){ 
		
			if($hitrs < $jml){
				$limit = $hitrs;
				$lm = false;
			}
		$sql = "SELECT a.id, a.nama, a.thumb FROM ".$app[table][kota]." as a  WHERE a.id_provinsi='".$dprov[id]."' ORDER BY a.nama LIMIT ".$awal.",".$limit;
		
		$dbu->query($sql,$rskota,$nrkota);
		$outnya .='<div class="location_destination"><h1>'.$dprov[nama].'<span class="border"></span></h1>
					<ul class="list_location" id="'.$urlx->friendlyURL($dprov[nama]).'" hitmax="'.$hitrs.'" cast="prov_'.$dprov[id].'" limit="'.$jml.'">';
		$outnya .= tujuanDes($rskota,'kota',$dprov[nama]);
		unset($rskota);
		unset($dkota);
		$outnya .='</ul>';
			if($lm=true and ($hitrs>$limit)){
				$outnya .='<div class="load_more" rel="'.$urlx->friendlyURL($dprov[nama]).'"><a href="#" id="vm" >View More</a></div>';									
			}
		}
		$outnya .='</div>';
	} 	
}else{

	if($p_id=="all"){
		if($sub){
			$ides = str_replace("_", " ", $sub);
			$ides = " AND b.nama LIKE '%".$ides."%'";
		}
		$sql = "SELECT a.id ,a.id_reff, a.thumb , b.nama FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff )WHERE status='aktif' $ides ORDER BY b.nama asc LIMIT ".$awal.",".$limit;
		$destkota = $dbu->get_recordsetmix($sql);
		$hitrs = $dbu->count_record("id","destinasi","where status='aktif'");
		if($hitrs and $hitrs > 0){ 
	
				if($hitrs < $jml){
					$limit = $hitrs;
					$lm = false;
				}

			if($sub){
				$kirim="_".$urlx->shortLink($sub);
			}
			
			$outnya .='<div class="location_destination"><h1>ALL DESTINATION<span class="border"></span></h1>
						<ul class="list_location" id="all" hitmax="'.$hitrs.'" cast="all'.$kirim.'" limit="'.$jml.'">';
			$outnya .= tujuanDes($destkota,'provinsi');
			$outnya .='</ul>';
				if($lm=true and ($hitrs>$limit)){
					$outnya .='<div class="load_more" rel="all"><a  href="#" id="vm" >View More</a></div>';									
				}
			$outnya .='</div>';
			}
	}else{
		$pid = explode("_",$p_id);
		//print_r($pid);exit;
		$ikota = $dbu->lookup("id","kota","nama LIKE '".str_replace("-", "%", $pid[1])."'");
		$iprov = $dbu->lookup("id","provinsi"," nama LIKE '".str_replace("-", "%", $pid[2])."'");
		//echo $iprov;exit;
		if($sub){
			$ides = str_replace("_", " ", $sub);
			$ides = " AND b.nama LIKE '%".$ides."%'";
		}
		$sql = "SELECT a.id ,a.id_reff, a.thumb , b.nama FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff )WHERE  a.id_kota ='".$ikota."' AND status='aktif' $ides ORDER BY b.nama asc LIMIT ".$awal.",".$limit;
		//print_r($sql);exit;
		$destkota = $dbu->get_recordsetmix($sql);
		$hitrs = $dbu->count_record("id","destinasi","where id_kota ='".$ikota."'");
		if($hitrs and $hitrs > 0){ 
				if($hitrs < $jml){
					$limit = $hitrs;
					$lm = false;
				}

			if($sub){
				$kirim="_".$urlx->shortLink($sub);
			}

			$outnya .='<div class="location_destination"><h1>'.$dbu->lookup("nama","provinsi","id='".$iprov."'").", ".$dbu->lookup("nama","kota","id='".$ikota."'").'<span class="border"></span></h1>
						<ul class="list_location" id="'.$urlx->friendlyURL($dbu->lookup("nama","kota","id='".$ikota."'")).'" hitmax="'.$hitrs.'" cast="kota_'.$ikota.$kirim.'" limit="'.$jml.'">';
			$outnya .= tujuanDes($destkota,'provinsi');
			$outnya .='</ul>';
				if($lm=true and ($hitrs>$limit)){
					$outnya .='<div class="load_more" rel="kota_'.$urlx->friendlyURL($dbu->lookup("nama","kota","id='".$ikota."'")).'"><a  href="#" id="vm" >View More</a></div>';									
				}
			$outnya .='</div>';
			}
		}
	unset($deskota);
}
unset($dbu);
unset($sql);
unset($appx);


include "fill/fill_destinasi.php";
?>