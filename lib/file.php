<?php

/*******************************************************************************
* Filename : file.php
* Description : file library
*******************************************************************************/

class file
{

	/***************************************************************************
	* Description : save picture to server
	* Notes : $filename = field of file
	*         $folder = folder position where file saved
	*         $prefix = 
	***************************************************************************/
	function save_picture($filename, $folder, $prefix = '')
	{
		global $app;
		$field = substr($filename, 2);
		$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name], -4, 4);
		if (!@copy($_FILES[$filename][tmp_name], $folder.'/'. $new_name)):
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;    
		return $new_name;
	}
	function save_picture_WM($filename, $folder, $prefix = '',$watermark,$opa,$qual)
	{
		global $app;
		$field = substr($filename, 2);
		$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name], -4, 4);
		$uploaded_file_path = $folder.'/'. $_FILES[$filename][name];
		$processed_file_path = $folder.'/'. $new_name;
		
		if (!@move_uploaded_file($_FILES[$filename][tmp_name], $uploaded_file_path)){
			//
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		}else{//echo $watermark;exit;
			$result = create_watermark($uploaded_file_path, $processed_file_path, $watermark, $opa,$qual);
			if($result === false){
			//echo "disini";exit;
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
			}
		}
		return $new_name;
	}
	function save_picture_resize($filename, $folder, $prefix = '', $size)
	{
		global $app;
		$field = substr($filename, 2);
		$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name], -4, 4);
		// ambil identitas asli gambar
		  $im_src = imagecreatefromjpeg($_FILES[$filename][tmp_name]);
		  $src_width = imageSX($im_src);
		  $src_height = imageSY($im_src);

		  //Set ukuran gambar hasil perubahan dengan size yg ditentukan
		  $dst_width = $size;
		  $dst_height = ($dst_width/$src_width)*$src_height;

		  //proses perubahan ukuran
		  $im = imagecreatetruecolor($dst_width,$dst_height);
		  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		  //Simpan gambar
		if (!@imagejpeg($im,$folder."/".$new_name)):
			  imagedestroy($im_src);
			  imagedestroy($im);

			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;    
		  imagedestroy($im_src);
		  imagedestroy($im);
		return $new_name;
	}

	function save_picture_resizeWH($filename, $folder, $prefix = '', $width,  $newName="", $height=0)
	{
		global $app;
		$field = substr($filename, 2);
		if($newName==""){
			$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename]['name'], -4, 4);
		}else{
			$new_name = $prefix . $newName;
		}
		// ambil identitas asli gambar
		  $im_src = imagecreatefromjpeg($_FILES[$filename]['tmp_name']);
		  $src_width = imageSX($im_src);
		  $src_height = imageSY($im_src);

		  //Set ukuran gambar hasil perubahan dengan size yg ditentukan
		  $dst_width = $width;
		  if($height != 0):
		  $dst_height = $height;
		  else:
		  $dst_height = ($dst_width/$src_width)*$src_height;
		  endif;
		  //proses perubahan ukuran
		  $im = imagecreatetruecolor($dst_width,$dst_height);
		  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		  //Simpan gambar
		if (!@imagejpeg($im,$folder."/".$new_name)):
			  imagedestroy($im_src);
			  imagedestroy($im);

			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;    
		  imagedestroy($im_src);
		  imagedestroy($im);
		return $new_name;
	}
	
	function save_picture_resizeWHWM($filename, $folder, $prefix = '', $width,  $newName="", $height=0,$opa,$qual)
	{
		global $app;
		$field = substr($filename, 2);
		if($newName==""){
			$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename]['name'], -4, 4);
		}else{
			$new_name = $prefix . $newName;
		}
		// ambil identitas asli gambar
		  $im_src = imagecreatefromjpeg($_FILES[$filename]['tmp_name']);
		  $src_width = imageSX($im_src);
		  $src_height = imageSY($im_src);

		  //Set ukuran gambar hasil perubahan dengan size yg ditentukan
		  $dst_width = $width;
		  if($height != 0):
		  $dst_height = $height;
		  else:
		  $dst_height = ($dst_width/$src_width)*$src_height;
		  endif;
		  //proses perubahan ukuran
		  $im = imagecreatetruecolor($dst_width,$dst_height);
		  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		  //Simpan gambar
		  $uploaded_file_path = $folder."/".$_FILES[$filename]['name'];
		  $processed_file_path = $folder."/".$new_name;
		if (!@imagejpeg($im,$uploaded_file_path)){
			  imagedestroy($im_src);
			  imagedestroy($im);

			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		}else{   
		  imagedestroy($im_src);
		  imagedestroy($im);
		  $result = create_watermark($uploaded_file_path, $processed_file_path, $watermark, $opa,$qual);
		  if($result === false){
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		  }
		}
		return $new_name;
	}

	/***************************************************************************
	* Description : save file to server
	* Notes : $filename = temporary file on server / file handle
	*         $folder = folder position where file saved
	*         $prefix = 
	***************************************************************************/
	function save_file($filename, $folder, $prefix = '')
	{
		global $app;
		$field = substr($filename, 2);
		$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name], -6, 6);

		if (!@copy($_FILES[$filename][tmp_name], $folder.'/'. $new_name)):
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;
		return $new_name;
	}
	
	function save_file_orig($filename, $folder)
	{
		global $app;
		$admlibx = new admlib();
		$field = substr($filename, 2);
		if (!@copy($_FILES[$filename][tmp_name], $folder.'/'. $_FILES[$filename][name])){
			$admlibx->display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		}
		return $_FILES[$filename][name];
	}
	
	function save_file_orig_multiple($filename, $folder, $ke, $prefix='')
	{
		global $app;
		$field = substr($filename, 2);
		//$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name], -4, 4);

		if (!@copy($_FILES[$filename][tmp_name][$ke], $folder.'/'. $_FILES[$filename][name][$ke])):
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;
		return $_FILES[$filename][name][$ke];
	}
	function save_file_multiple($filename, $folder, $ke, $prefix="")
	{
		global $app;
		$field = substr($filename, 2);
		$new_name = $prefix . strtoupper(md5(uniqid(rand(), true))) . substr($_FILES[$filename][name][$ke], -4, 4);
	
		if (!@copy($_FILES[$filename][tmp_name][$ke], $folder.'/'. $new_name)):
			admlib::display_msg($app[lang][error]['title'], "{$app[lang][field][$field]} {$app[lang][error]['ERR_COPY']}");
		endif;
		return $new_name;
	}

	function format_size($size)
	{		
		if ($size >= 1073741824):
			$size = round($size / 1073741824 * 100) / 100 . " Gb";
		elseif ($size >= 1048576):
			$size = round($size / 1048576 * 100) / 100 . " Mb";
		elseif ($size >= 1024):
			$size = round($size / 1024 * 100) / 100 . " Kb";
		elseif ($size > 0):
			$size = $size . " byte";
		else:
			$size="-";
		endif;
		return $size;
	}

	function format_icon($filename)
	{		
		switch ($temp_type) {
        case IMAGETYPE_GIF:
            $extension = ".gif";
			break;
        case IMAGETYPE_JPEG:
			$extension = ".jpg";
            break;
        case IMAGETYPE_PNG:
            $extension = ".png";
			break;
		case IMAGETYPE_SWF:
            $extension = ".swf";
			break;
        case IMAGETYPE_BMP:
            $extension = ".bmp";
			break;
        case IMAGETYPE_PSD:
            $extension = ".psd";
			break;
        case IMAGETYPE_ICO:
            $extension = ".ico";
			break;
        default:
            return $extension ="na";
		}
		if($extension == "na" OR $extension==""){
			$extension = substr($filename, -3);
			if ($extension == "avi"):
				$extension = ".avi";		
			elseif ($extension == "doc"):
				$extension = ".doc";
			elseif ($extension == "ocx"):
				$extension = ".docx";	
			elseif ($extension == "exe"):
				$extension = ".exe";		
			elseif ($extension == "mov"):
				$extension = ".mov";		
			elseif ($extension == "mp3"):
				$extension = ".mp3";		
			elseif ($extension == "mpg"):
				$extension = ".mpg";		
			elseif ($extension == "pdf"):
				$extension = ".pdf";		
			elseif ($extension == "zip"):
				$extension = ".zip";		
			elseif ($extension == "rar"):
				$extension = ".rar";		
			elseif ($extension == "txt"):
				$extension = ".txt";		
			elseif ($extension == "wav"):
				$extension = ".wav";		
			elseif ($extension == "xls"):
				$extension = ".xls";		
			elseif ($extension == "lsx"):
				$extension = ".xlsx";		
			elseif ($extension == "sql"):
				$extension = ".sql";		
			else:
				$extension = "";
			endif;
		}
		return $extension;
	}
	
	function format_bytes($a_bytes)
	{
		if ($a_bytes < 1024) {
			return $a_bytes .' B';
		} elseif ($a_bytes < 1048576) {
			return round($a_bytes / 1024, 2) .' KiB';
		} elseif ($a_bytes < 1073741824) {
			return round($a_bytes / 1048576, 2) . ' MiB';
		} elseif ($a_bytes < 1099511627776) {
			return round($a_bytes / 1073741824, 2) . ' GiB';
		} elseif ($a_bytes < 1125899906842624) {
			return round($a_bytes / 1099511627776, 2) .' TiB';
		} elseif ($a_bytes < 1152921504606846976) {
			return round($a_bytes / 1125899906842624, 2) .' PiB';
		} elseif ($a_bytes < 1180591620717411303424) {
			return round($a_bytes / 1152921504606846976, 2) .' EiB';
		} elseif ($a_bytes < 1208925819614629174706176) {
			return round($a_bytes / 1180591620717411303424, 2) .' ZiB';
		} else {
			return round($a_bytes / 1208925819614629174706176, 2) .' YiB';
		}
	}
	
	function human_filesize($bytes, $decimals = 2) {
	  $sz = 'BKMGTP';
	  $factor = floor((strlen($bytes) - 1) / 3);
	  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
	
	function formatBytes($bytes, $precision = 2) {
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
	  
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
	  
		$bytes /= pow(1024, $pow);
	  
		return round($bytes, $precision) . ' ' . $units[$pow];
	}  
// WATERMARK

// define('WATERMARK_OVERLAY_IMAGE', $app["data_www"]."/logo/favico.png");
// define('WATERMARK_OVERLAY_OPACITY', 50);
// define('WATERMARK_OUTPUT_QUALITY', 90);

function create_watermark($source_file_path, $output_file_path, $watermark, $wm_opacity,$wm_quality)
{
    list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
    if ($source_type === NULL) {
        return false;
    }
	//print_r($watermark);exit;
    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_file_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_file_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_file_path);
            break;
        default:
            return false;
    }
    $overlay_gd_image = imagecreatefrompng($watermark);
    $overlay_width = imagesx($overlay_gd_image);
    $overlay_height = imagesy($overlay_gd_image);
    imagecopy(
        $source_gd_image,
        $overlay_gd_image,
        $source_width - $overlay_width,
        $source_height - $overlay_height,
        0,
        0,
        $overlay_width,
        $overlay_height,
        $wm_opacity
    );
    imagejpeg($source_gd_image, $output_file_path, $wm_quality);
    imagedestroy($source_gd_image);
    imagedestroy($overlay_gd_image);
}
 function getEkstensi($filename){
	$eks = pathinfo($filename, PATHINFO_EXTENSION);
	return $eks; 
 }
	
	
	}

?>