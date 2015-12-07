<?php
/*******************************************************************************
* Filename : feed.php
* Description : feed library (mysql)
*******************************************************************************/
class feed
{
	function feedCheckIn($dfeed,$sBahasa,$member){
		global $app;
		$appx = new app();
		$dbu = new db();
		$urlx = new url();
		$fcek_in = "";		
		$icon =$app[css_www]."/images/ic_cat_2.png";
		$avatar = $appx->cekFile('/pengguna/avatar/',$member[avatar],'default.jpg');
		$avatar = $app[data_www].'/pengguna/avatar/'.$avatar;
		$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$sBahasa."'")."/".$urlx->shortLink($member[username])."/";
		
		$fcek_in = '<div class="con_newsfeed add_fix">
					<div class="line_newsfeed">
						<div class="circle_pict circle_pict_nf"><a href="'.$linkAva.'"><img src="'.$avatar.'"></a></div>
						<div class="bar"></div>
						<div class="ic_cat"><a href="#"><img src="'.$icon.'"></a></div>
					</div>';
		$dipost = $appx->time_delta('now',$dfeed[tgl_post],0,2,true);
		if($_SESSION[member][id]!=""){
			$bolehKomen= '<li>
							<div class="circle_pict circle_pict_nf"><a href="'.$linkAva.'"><img src="'.$avatar.'"></a></div>
							<textarea id="cekin" placeholder="Write your comment..."></textarea>
						</li>';
		}
		$sql = "SELECT a.nama , b.nama as kota , c.nama as provinsi, d.nama as negara FROM ".$app[table][destinasi_bahasa]." as a LEFT JOIN ".$app[table][destinasi]. " as e ON (a.id_reff = e.id_reff)  LEFT JOIN ".$app[table][kota]." as b ON(e.id_kota = b.id) LEFT JOIN ".$app[table][provinsi]." as c ON(b.id_provinsi = c.id) LEFT JOIN ".$app[table][negara]." as d ON(c.id_negara = d.id) LEFT JOIN ".$app[table][cekin]." as f ON(e.id = f.id_destinasi ) LEFT JOIN ".$app[table][pengguna_feed]." as g ON(f.id = g.id_tabel) WHERE g.id ='".$dfeed[id]."' AND a.id_bahasa ='".$sBahasa."'" ;
		$lokasi = $dbu->get_recordmix($sql);
		$cekin_di = '<span>Check in at <a href="#"><i>'.$lokasi[nama].'('.$lokasi[kota].'), '.$lokasi[provinsi].', '.$lokasi[negara].'</i></a></span>';

		$fcek_in .= '<div class="box_con_newsfeed">
						<h1>'.$member[nama].'</h1>
						<span>'.$dipost.'</span>
						<div class="frame_post">
							'.$cekin_di.'
							<div class="box_comment">
								<ul class="add_fix" id="list_cekin" rel="cekin_'.$dfeed[id_tabel].'">
									'.$bolehKomen;
		#komen cekin---------------------------
		$sql = "SELECT a.nama , a.avatar, a.username, b.id, b.komen, b.tgl_post as tgl_komen FROM ".$app[table][pengguna]." as a LEFT JOIN ".$app[table][cekin_komen]." as b ON(b.id_user = a.id) WHERE b.id_cekin = '".$dfeed[id_tabel]."'";
		$dbu->query($sql,$rkomen,$nkomen);
		if($nkomen>0){
			while($dkomen=$dbu->fetch($rkomen)){
				$dkomen[avatar] = $appx->cekFile("/pengguna/avatar/",$dkomen[avatar]);
				$other_avatar = $app[data_www].'/pengguna/avatar/'.$dkomen[avatar];
				$other_linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$sBahasa."'")."/".$urlx->shortLink($dkomen[username])."/";
				$fcek_in .='<li>		
							<div class="circle_pict circle_pict_nf"><a href="'.$other_linkAva.'"><img src="'.$other_avatar.'"></a></div>
							<div class="text_box_c">
								<h1>'.$dkomen[nama].'</h1>
								<p>'.$dkomen[komen].'</p>
							</div>					
						</li>';
			}
		}
		$fcek_in .='</ul></div></div></div></div>';
		return $fcek_in;
	}
}
?>