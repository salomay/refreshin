<?php

/*******************************************************************************
* Filename : form.php
* Description : form library
*******************************************************************************/

class form
{
    /***************************************************************************
    * Description : init
    ***************************************************************************/
	function init() 
	{
		$formx = new form();
		global $error;
		$formx->set_error(0);
		if (!$error):
			$formx->reset();
		endif;
	}

    /***************************************************************************
    * Description : is error
    ***************************************************************************/
	function is_error() 
	{
		if ($_SESSION['error_flag']):
			return TRUE;
		endif;
		return FALSE;
	}

    /***************************************************************************
    * Description : set_error
    ***************************************************************************/
	function set_error($flag) 
	{
		$_SESSION['error_flag'] = $flag;
	}

    /***************************************************************************
    * Description : reset
    ***************************************************************************/
	function reset() 
	{
		$_SESSION['error_flag'] = 0;
		$_SESSION['form_value'] = '';
		$_SESSION['error_msg'] = array();
	}

    /***************************************************************************
    * Description : bundle form value
    ***************************************************************************/
    function serialize_form()
    {
		$appx = new app();
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $_SESSION['form_value'] = $appx->serialize64($_GET);
        }else{
            $_SESSION['form_value'] = $appx->serialize64($_POST);
        }
    }

    /***************************************************************************
    * Description : unbundle form value
    ***************************************************************************/
    function unserialize_form()
    {
		$appx = new app();
        $frm = $appx->unserialize64($_SESSION['form_value']);
        return $frm;
    }
	
    /***************************************************************************
    * Description : populate form
    ***************************************************************************/
    function populate(&$form)
    {
		global $error;
		$formx = new form();
		if ($formx->is_error() || $error){
        	$frm = $formx->get_value();
			while (list($k, $v) = @each($frm)){
				if (in_array($k , array('act', 'step', 'referer'))){
					$field = $k;
				}else{
					$field = substr($k, 2);
				}
				$form[$field] = $v;
			}
		}
    }

    /***************************************************************************
    * Description : get value
    ***************************************************************************/
    function get_value()
    {
		$appx = new app();
        return $appx->unserialize64($_SESSION['form_value']);
    }

    /***************************************************************************
    * Description : validate form
    ***************************************************************************/
    function validate($type, $fields, $param = '')
    {
        global $app;
		$msgx = new msg();
        $fields = "\$".str_replace(",", ",\$", $fields);
		//print_r($fields);
        eval("global $fields;");
        $arr = explode(",", $fields);
        if ($type == ''):
            while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
                $cmd = "\$v = $v;";
                eval($cmd);
                if (!trim($v)):
					$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['empty']."");
                    $_SESSION['error_flag'] = 1;
                endif;
            endwhile;
        endif;
        if ($type == 'checkbox'):
            while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
                $cmd = "\$v = $v;";
                eval($cmd);
                if (!@count($v)):
					$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['checkbox']."");
                    $_SESSION['error_flag'] = 1;
                endif;
            endwhile;
		endif;
        if ($type == 'select'):
			while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
				eval("\$v = $v;");
				if (!trim($v)):
					$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['select']."");
                    $_SESSION['error_flag'] = 1;
				endif;
			endwhile;
        endif;
        if ($type == 'email'):
			while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
				eval("\$v = $v;");
				if (!ereg("/^(.+)@(.+)\\.(.+)$/i", $v)):
					$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['email']."");
                    $_SESSION['error_flag'] = 1;
				endif;
			endwhile;
        endif;
        if ($type == 'date'):
			while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
				eval("\$v = $v;");
				list($year, $month, $date) = explode('-', $v);
				if (!checkdate($month, $day, $year)):
					$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['date']."");
                    $_SESSION['error_flag'] = 1;
				endif;
			endwhile;
        endif;
        if ($type == 'image'):
			while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
				$var = substr($v, 1);
				eval("\$v = $v;");
				
				list($file_max_size, $min_width, $max_width, $min_height, $max_height) = explode('|', $param);
								
				$file['tmp_name'] = $_FILES[$var]['tmp_name'];
				$file['name'] = $_FILES[$var]['name'];
				$file['size'] = $_FILES[$var]['size'];
				
				if ($file['size'] > 0):
					$pict = getimagesize($file['tmp_name']);
					//print_r($pict);exit;
					/*if (!(($pict[2] == 1) || ($pict[2] == 2) || ($pict[2] == 13))):
						$error = 'ERR_TYPE';
						if ($error):
							$msgx->set_msg("{$app[lang][field][$field]} {$app[lang][error]['image.'.$error]}");
							$_SESSION[error_flag] = 1;
						endif;
					endif;*/
					if (($pict[0] < $min_width) || ($pict[0] > $max_width) || ($pict[1] < $min_height) || ($pict[1] > $max_height)):
						$error = 'ERR_WIDTH';
						if ($error):
							$msgx->set_msg("".$app['lang']['field'][$field]." ".$app['lang']['error']['image.'.$error]."");
							$_SESSION['error_flag'] = 1; 
						endif;
					endif;
					if ($file[size] > ($file_max_size * 1024)):
						$error = 'ERR_SIZE';
						if ($error):
							$msgx->set_msg("".$app['lang']['field'][$field]." ".$app['lang']['error']['image.'.$error].""); 
							$_SESSION['error_flag'] = 1;
						endif;
					endif;
				endif;				
			endwhile;
        endif;
		if ($type == 'file'):
			while (list($k, $v) = each($arr)):
                $field = substr($v, 3);
				$var = substr($v, 1);
				eval("\$v = $v;");
				
				list($file_max_size) = explode('|', $param);
								
				$file['tmp_name'] = $_FILES[$var]['tmp_name'];
				$file['name'] = $_FILES[$var]['name'];
				$file['size'] = $_FILES[$var]['size'];

				if ($file['size'] > 0):
					$pict = getimagesize($file['tmp_name']);
					if ($file['size'] > ($file_max_size * 1024)):
						$error = 'ERR_SIZE';
						if ($error):
							$msgx->set_msg("".$app['lang']['error']['file'.$error].""); 
							$_SESSION['error_flag'] = 1;
						endif;
					endif;
				endif;				
			endwhile;
        endif;
    }

	function validate_count_char($fields, $length)
    {
        global $app;
        $fields = "\$".str_replace(",", ",\$", $fields);
        eval("global $fields;");
        $arr = explode(",", $fields);
        while (list($k, $v) = each($arr)):
			$field = substr($v, 3);
			$cmd = "\$v = $v;";
			eval($cmd);
			$char = strlen($v);
			//$char = count_chars($v);
			if ($char > $length):
				$msgx->set_msg("".$app['lang']['field'][$field]."".$app['lang']['error']['char']." Your $field : $char characters." );
				$_SESSION['error_flag'] = 1;
			endif;
       endwhile;
	}
}

?>