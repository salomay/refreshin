<?php

/*******************************************************************************
* Filename : msg.php
* Description : message library
*******************************************************************************/

class msg
{
    /***************************************************************************
    * Description : get message
    ***************************************************************************/
    function get_msg()
    {
		$out = '';
		if(!empty($_SESSION['msg'])):
			$out = $_SESSION['msg'];
		endif;
		$_SESSION['msg'] = '';
		msg::reset();
		return $out;
    }

    /***************************************************************************
    * Description : reset
    ***************************************************************************/
    function reset()
    {
		$_SESSION['error_msg'] = array();
		$_SESSION['msg'] = '';
    }

    /***************************************************************************
    * Description : set msg
    * Parameters : $msg
    ***************************************************************************/
    function set_msg($msg, $succ = 0)
    {
		if ($succ):
			$_SESSION['msg'] = $msg;
		else:
			$_SESSION['error_msg'][] = $app['lang']['error']['element'].$msg;
		endif;
    }

    /***************************************************************************
    * Description : build msg
    * Parameters : -
    ***************************************************************************/
    function build_msg($succ = 0)
    {
        global $app;
		if ($succ):
			$out = "".$app['lang']['info']['header']."$_SESSION[msg]".$app['lang']['info']['footer']."";
		else:
			$out = "".$app['lang']['error']['header']."".$app['lang']['error']['element'].@implode($app['lang']['error']['element'], $_SESSION['error_msg'])."".$app['lang']['error']['footer']."";
		endif;
		$_SESSION['msg'] = $out;
    }
	
	 /***************************************************************************
    * Description : build msg
    * Parameters : -
    ***************************************************************************/
    function build_msgx($succ = "")
    {
        global $app;
		if ($succ != ""){
			$_SESSION['msg'] .= $succ;
		}
		
    }
	
	/***************************************************************************
    * Description : build popup msg
    * Parameters : -
    ***************************************************************************/
    function build_popup_msg($succ = 0)
    {
        global $app;
		if ($succ):
			$out = "".$app['lang']['info']['popup_header']."$_SESSION[msg]".$app['lang']['info']['popup_footer']."";
		else:
			$out = "".$app['lang']['error']['popup_header']."".$app['lang']['error']['element'].@implode($app['lang']['error']['element'], $_SESSION['error_msg'])."".$app['lang']['error']['popup_footer']."";
		endif;
		$_SESSION['msg'] = $out;
    }

	/***************************************************************************
    * Description : display msg
    * Parameters : -
    ***************************************************************************/
    function display_popup_msg($type, $who, $lang = 0)
    {
        global $app;
		if ($type == 0):
			if ($who == 0):
				if ($lang):
					include "$app[path]/ina/dsp_error.php";
				else:
					include "$app[path]/dsp_error.php";
				endif;
				exit;
			endif;
		endif;
    }
}

?>