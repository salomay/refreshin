<?php
/*******************************************************************************
* Filename : db.php
* Description : db library (mysql)
*******************************************************************************/
class db
{
	
    /***************************************************************************
    * Description : DB Connect
    ***************************************************************************/
    function connect()
    {	
		global $app;
		$app['db']['connection']= mysqli_connect($app['db']['server'], $app['db']['username'], $app['db']['password'], $app['db']['name']);
	//echo mysqli_connect_errno($app['db']['connection']);exit;
		if (mysqli_connect_errno()) {
		 echo "Koneksi Gagal: ".mysqli_connect_errno()." : ". mysqli_connect_error();    
		}
	//exit();
    }
	
	
	/***************************************************************************
    * Description : perform default query
    ***************************************************************************/
    function query($sql, &$result, &$nr)
    {
		//echo $sql;exit;
        global $app;
        if (!stristr($sql,"union")){
			if(!$result = mysqli_query($app['db']['connection'],$sql )){
				/*printf("Pesan Error: %s\n", mysqli_error($app['db']['connection']));
				exit;*/
			}
	    	if (preg_match("/select/i",$sql)){
	    	    $nr = mysqli_num_rows($result);
				// echo $nr;exit;
	    	}
			if (mysqli_error($app['db']['connection'])){
				if ($app['debug']){
					$err[] = "SQL : ".$sql;
					$err[] = "ERROR : " . mysqli_error($app['db']['connection']);
					$appx = new app();
					$appx->debug($err);
					exit;
				}
			}
		}
    }
	
	/***************************************************************************
    * Description : fetching query result to array + move pointer 1 level
    ***************************************************************************/
	function fetch($result)
    {
        global $app;
        return mysqli_fetch_assoc($result);
    }
	
    /***************************************************************************
    * Description : fetching query result to array + move pointer 1 level
    ***************************************************************************/
	function fetch_all($result)
    {
        global $app;
        return mysqli_fetch_all($result);
    }

	/***************************************************************************
    * Description : GET Record
    ***************************************************************************/
	function get_record()
	{
		global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()):
			case 2:
				$sql = "select * from ".$app['table'][$args[0]]." where $args[1] limit 1";
				break;
			case 3:
				$sql = "select * from ".$app['table'][$args[0]]." where $args[1] = '$args[2]' limit 1";
				break;
		endswitch;
		if (!stristr($sql,"union")){			
			$db->query($sql, $rs, $nr);
		}
    	if ($nr){
    	    $record = $db->fetch($rs);
    	}else{
    	    $record[0] = "";
    	}
		//print_r($rs);exit;
		mysqli_free_result($rs);
    	return $record;
	}

	/***************************************************************************
    * Description : GET Record
    ***************************************************************************/
	function get_recordmix()
	{
		global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()):
			case 1:
				$sql = $args[0]." limit 1";
				break;
			case 2:
				$sql = "select ".$args[0]." from ".$args[1]." limit 1";
				break;
			case 3:
				$sql = "select ".$args[0]." from ".$args[1]." where ".$args[2]." limit 1";
				break;
			case 4:
				$sql = "select ".$args[0]." from ".$args[1]." where ".$args[2]."= '".$args[3]."' limit 1";
				break;
		endswitch;
		if (!stristr($sql,"union")){			
			$db->query($sql, $rs, $nr);
		}
    	if ($nr){
    	    $record = $db->fetch($rs);
    	}else{
    	    $record[0] = "";
    	}
		//print_r($rs);exit;
		mysqli_free_result($rs);
    	return $record;
	}

	/***************************************************************************
    * Description : fetching recorset from database
    ***************************************************************************/
    function get_recordset()
    {
        global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()):
			case 1:
				$sql = "select * from ".$app['table'][$args[0]]."";
				break;
			case 2:
				$sql = "select * from ".$app['table'][$args[0]]." where $args[1]";
				break;
			case 3:
				$sql = "select * from ".$app['table'][$args[0]]." where $args[1] = '$args[2]'";
				break;
		endswitch;
		//echo $sql;
		if (!stristr($sql,"union")){
    		$db->query($sql, $rs, $nr);
		}
		
    	return $rs;
    }
	
	/***************************************************************************
    * Description : fetching recorset from database
    ***************************************************************************/
    function get_recordsetmix()
    {
        global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()):
			case 1:
				$sql = $args[0];
				break;
			case 2:
				$sql = "select ".$args[0]." from ".$app['table'][$args[0]]."";
				break;
			case 3:
				$sql = "select ".$args[0]." from ".$app['table'][$args[0]]." where $args[1]";
				break;
			case 4:
				$sql = "select ".$args[0]." from ".$app['table'][$args[0]]." where $args[1] = '$args[2]'";
				break;
		endswitch;
		//echo $sql;

    	$db->query($sql, $rs, $nr);

		
    	return $rs;
    }

	/***************************************************************************
    * Description : fetching recorset specified field from database
    ***************************************************************************/
    function get_recordspec()
    {
        global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()):
			case 2:
				$sql = "select $args[0] from ".$app['table'][$args[1]]."";
				break;
			case 3:
				$sql = "select $args[0] from ".$app['table'][$args[1]]." where $args[2]";
				break;
			case 4:
				$sql = "select $args[0] from ".$app['table'][$args[1]]." where $args[2] = '$args[3]'";
				break;
		endswitch;
		//echo $sql;
		if (!stristr($sql,"union")){
    		$db->query($sql, $rs, $nr);
		}
    	
    	return $rs;
    }
	/***************************************************************************
    * Description : anti sql injection
    ***************************************************************************/
	function anti_sql_injection($input) {
	    // daftarkan perintah-perintah SQL yang tidak boleh ada
	    // dalam query dimana SQL Injection mungkin dilakukan
		$dbu = new db();
	    $aforbidden = array ("insert", "select", "update", "delete", "truncate",
	    					 "replace", "drop", " or ", ";", "#", "--", "=" );

	    // lakukan cek, input tidak mengandung perintah yang tidak boleh
	    $breturn=true;
	    foreach($aforbidden as $cforbidden) {
	        if($dbu->stripos($input, $cforbidden)) {
	            $breturn=false;
	            break;
	        }
	    }
	    return $breturn;
	}
	
	/***************************************************************************
    * Description : stripos
    ***************************************************************************/
	function stripos($haystack, $needle, $offset = 0) {
	   // first we need also the php4 compatible function for stripos()
	   return strpos(strtolower($haystack), strtolower($needle),$offset);
	}
	
	/***************************************************************************
    * Description : perform only simple query (delete/update)
    ***************************************************************************/
    function qry($sql)
    {
        global $app;
        if (!stristr($sql,"union")){
			if(!mysqli_query($app['db']['connection'],$sql)){
				printf("Pesan Error: %s\n", mysqli_error($app['db']['connection']));
				exit;
			}
		}
		//unset($rs);
    }
    /***************************************************************************
    * Description : perform multi query
    ***************************************************************************/
    function multi_qry($sql)
    {
        global $app;
        if (!stristr($sql,"union")){
			if(!mysqli_multi_query($app['db']['connection'],$sql)){
				printf("Pesan Error: %s\n", mysqli_error($app['db']['connection']));
				exit;
			}	
				//echo "masuk";		
		}
		//unset($rs);
    }
	/***************************************************************************
    * Description : count record from table
    ***************************************************************************/
    function count_record() {
    	global $app;
		$db = new db();
		$args = func_get_args();
		switch (func_num_args()){
			case 1:
				$sql = $args[0];
				break;
			case 2:
				$sql = "select count($args[0]) as jumlah from ".$app['table'][$args[1]];
				break;
			case 3:
				$sql = "select count($args[0]) as jumlah from ".$app['table'][$args[1]]." $args[2]";
				break;
		}
		$db->query($sql, $rs, $nr);
    	if ($nr){
    		$row = $db->fetch($rs);
   	    	$record = $row['jumlah'];
    	}
		//echo $sql;
		mysqli_free_result($rs);
    	return $record;
    }
	
	/***************************************************************************
    * Description : set status
    * Parameters : id & status
    ***************************************************************************/
	function set_status($tabel, $field, $p_id, $status, $fieldstat) {
		global $app;
		/*$get = db::get_record($tabel, $field, $id);*/
		$db = new db();
		if ( $status == "aktif" ){
			$statusnya = "nonaktif";
		}elseif ( $status == "nonaktif" ){
			$statusnya = "aktif";
		}

		$sql = "update ".$app['table'][$tabel]."
				set $fieldstat = '$statusnya'
				where $field = '$p_id'";
				//echo $sql;exit();
		$db->qry($sql);
	}
	
	/***************************************************************************
    * Description : set hotline
    * Parameters : id & hot
    ***************************************************************************/
	function set_hot($tabel, $field, $p_id, $status, $fieldstat) {
		global $app;
		/*$get = db::get_record($tabel, $field, $id);*/
		$db = new db();
		if ( $status == "ya" ):
			$statusnya = "tidak";
		elseif ( $status == "tidak" ):
			$statusnya = "ya";
		endif;

		$sql = "update ".$app['table'][$tabel]."
				set $fieldstat = '$statusnya'
				where $field = '$p_id'";
				//echo $sql;exit;
		$db->qry($sql);
	}
	
	/***************************************************************************
    * Description : lookup
	* Param : field, table, field_key, $field_value
	*         field, table, condition
    ***************************************************************************/
    function lookup()
    {
		$db = new db();
        global $app;
		$args = func_get_args();
		switch (func_num_args()):
			case 3:
				$sql = "select $args[0] from ".$app['table'][$args[1]]." where $args[2] limit 1";
				break;
			case 4:
				$sql = "select $args[0] from ".$app['table'][$args[1]]." where $args[2] = '$args[3]' limit 1";
				break;
		endswitch;
		//echo $sql;
    	$db->query($sql, $rs, $nr);
    	if ($nr):
    	    $record = $db->fetch($rs);
    	endif;
    	mysqli_free_result($rs);
    	return $record[$args[0]];
    }

    function searchForKeyword($keyword,$table='destinasi_bahasa',$idbhs='id') {
    $dbu = new db();
    $boldy = $keyword;
    $keyword = "'%". $keyword . "%'";
    $sql = "SELECT nama FROM $table WHERE nama LIKE $keyword and id_bahasa='".$idbhs."'ORDER BY nama";
    //echo $sql;
    
    $dbu->query($sql,$rs,$nr);
    //echo $nr;
    if ($nr){
    		$hasil='<ul id="daftar_destinasi">';
      while($results = $dbu->fetch($rs)){
      	$bold = str_replace($_POST['keyword'], '<span style="font-weight:bold;color:#6475F5;">'.$boldy."</span>", $results[nama]);
      	$hasil.='<li onclick="pilihDestinasi(\''.$results[nama].'\')">'.$bold.'</li>';
      }
      	$hasil .="</ul>";
      	return $hasil;
    } 


    unset($dbu); 
   
	}

	function negprovkot($kueri) {
    $db = new db();
    
    $db->query($kueri,$rs,$nr);
    //echo $nr;
    if ($nr){
    		$hasil = '<option value="">all</option>';
      while($results = $db->fetch($rs)){

      	$hasil.='<option  value="'.$results[id].'">'.$results[nama].'</option>';
      }
      	return $hasil;
    } 

    $db = null; 
   
	}
}
?>