<?php

/*******************************************************************************
* Filename : url.php
* Description : url libary
*******************************************************************************/

class url
{
    function get_referer()
    {
        global $referer;
        if ($referer){
            $referer = preg_replace ("/&referer(.*)/", "", $referer);
			//echo $referer;exit;
            if (!preg_match("/\?/", $referer)){
                $referer .= "?";
			}
            return $referer;
        }else{
            return $_SERVER['HTTP_REFERER'];
        }

    }
	
	function strip_querystring($url) 
	{
		if ($commapos = strpos($url, '?')):
			return substr($url, 0, $commapos);
		else:
			return $url;
		endif;
	}

	function get_short_referer() 
	{
		return url::strip_querystring($_SERVER['HTTP_REFERER']);
	}

	function me() 
	{
		if (getenv("REQUEST_URI")): 
			$me = getenv("REQUEST_URI");
		elseif (getenv("PATH_INFO")):
			$me = getenv("PATH_INFO");

		elseif ($GLOBALS["PHP_SELF"]):
			$me = $GLOBALS["PHP_SELF"];
		endif;
		return url::strip_querystring($me);
	}
	
	function complete_me() {
		if (getenv("REQUEST_URI")) {
			$me = getenv("REQUEST_URI");

		} elseif (getenv("PATH_INFO")) {
			$me = getenv("PATH_INFO");

		} elseif ($GLOBALS["PHP_SELF"]) {
			$me = $GLOBALS["PHP_SELF"];
		}
		return $me;
	}

	function navigator_url($field, $title, $color = "white") 
	{
		global $app;
		$url = url::complete_me();
		if (ereg('webadmin', $url)):
			$path_ext = "webadmin/";
		endif;
		if (!ereg('\?', $url)):
			$url .= "?";
		endif;
		
		$url = preg_replace("|offset=.*?&|", "offset=0&", $url);
		$url = str_replace('&sort=asc', '', $url);
		$url = str_replace('&sort=desc', '', $url);
		$url = str_replace("&order=$field", '', $url);
		$var = $_GET;
		if ($var['order'] == $field):
			if ($var['sort'] == 'asc'):
			$out = "<a href='$url&order=$field&sort=desc'><font color=$color>$title</font></a> <img src='$app[www]/{$path_ext}img/arrow-asc.gif'>";
			else:
				$out = "<a href='$url&order=$field&sort=asc'><font color=$color>$title</font></a> <img src='$app[www]/{$path_ext}img/arrow-desc.gif'>";
			endif;
		else:
			$out = "<a href='$url&order=$field&sort=asc'><font color=$color>$title</font></a>";
		endif;
		return $out;
	}
	function curPageURL() {
		$pageURL = 'http';
		if ((!empty($_SERVER['HTTPS'])) AND ($_SERVER['HTTPS'] == "on")) {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	function friendlyURL($string){
		$string = preg_replace("`\[.*\]`U","",$string);
		$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
		$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
		return strtolower(trim($string, '-'));
		//return (trim($string, '-'));
	}	

	function shortLink($string){
		$hapus = array('&amp;','/','\\','&',',','#','$','%','@','!','&','(',')','=','+','|','^','~','?','<','>',';','"',"'",'`','-amp-','&lt;','&gt;');
		$string = str_replace($hapus,"",$string);
		$string = str_replace(" ","-",strtolower($string));
		$string = str_replace("--","-",$string);
		return $string;
		//return (trim($string, '-'));
	}

	function build_twitter_feed($var){
	  	//print_r($xml->status);
		//$output = '<ul class="twitter-feed">';
		foreach($var as $tweet){
		  //print_r($tweet);
		  $text = url::make_urls_links($tweet->text);
		  $date = app::format_date($tweet->created_at, $app["bahasa"],"A");
		  $output .='<div class="tweet">
						<div class="title"><a class="title" target="blank" href="http://twitter.com/'.$tweet->user->screen_name.'">@'.$tweet->user->screen_name.'</a></div>
						<p>'.$text.'</p>
						<div class="hour">'.$date.'</div>
						<div class="clear"></div>
						</div>';
		  //$output .= '<li>'.$text.'</li>';
		}
		//$output .= '</ul>';

	  return $output;
	}
	 
	function make_urls_links($text){
		$ret = ' ' . $text;
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a target=\"_blank\" href=\"\\2\" >\\2</a>'", $ret);
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a target=\"_blank\" href=\"http://\\2\" >\\2</a>'", $ret);
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
		$ret = substr($ret, 1);
		return($ret);
	}
	
	function buildBaseString($baseURI, $method, $params)
	{
		$r = array(); 
		ksort($params); 
		foreach($params as $key=>$value){
			$r[] = "$key=" . rawurlencode($value); 
		}            

		return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r)); //return complete base string
	}

	function buildAuthorizationHeader($oauth)
	{
		$r = 'Authorization: OAuth ';
		$values = array();
		foreach($oauth as $key=>$value)
			$values[] = "$key=\"" . rawurlencode($value) . "\""; 

		$r .= implode(', ', $values); 
		return $r; 
	}



    /**
     * Get Twitter Results
     * @param string $u optional name of user to search from
     * @param integer $n number of tweets to return
     * @param string $q optional query string
     * @param string $t type of results mixed|recent|popular
     */
    function getTweets($u = "", $n = 1, $q = "", $t = "recent") {
        //public $queryString;
        //public $json;
        //public $results;
        if($u=="" && $q==""){
            $u='twitterapi';
        }
        if($u!=""){
            $q.="+from:".$u;
        }
        $q = urlencode($q);
        $q.="&result_type=".$t;
        $q.="&rpp=".$n;

        $j = file_get_contents('http://search.twitter.com/search.json?q=' . $q);
        $r = json_decode($j, true);
	echo $j;
        $queryString = $q;
        $json = $j;
        $results = $r;

        $output = '<div id="latest_tweet">';
        /**
         * Loop through and echo each result from the jason data to the page.
         */
        foreach ($results as $tweet) {
            $output .= '<div class="tweet"><div class="profile_image">
                <a href="https://twitter.com/' . $tweet['from_user'] . '"><img src="' . $tweet['profile_image_url'] . '" /></a>
                </div>
                <a class="user_name" href="https://twitter.com/' . $tweet['from_user'] . '">' . $tweet['from_user_name'] . '</a>
                <a class="user" href="https://twitter.com/' . $tweet['from_user'] . '">@' . $tweet['from_user'] . '</a><span class="created_at">' . $tweet['created_at'] .'</span>
                <p class="tweet_text">'. $tweet['text'] . '</p></div>';
        }
         $output .= '</div>';
         return  $output;
    }


}