<?php
class nav 
{
/**
 * @link: http://www.Awcore.com/dev
 */
    function pagination($hit, $per_page = 12,$page = 1, $url = '?',$div_awal="<div class='nav_pagination_box'>",$prevx='class="next_prev_pagination"',$nextx='class="next_prev_pagination"',$acti='class="active"'){
    	//$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	//$row = mysql_fetch_array(mysql_query($query));
    	//$total = $row['num'];
    	$total = $hit;
        $adjacents = "2";

    	$page = ($page == 0 ? 1 : $page);
    	$start = ($page - 1) * $per_page;
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
		//echo $pagination;
    	if($lastpage > 1)
    	{
    		$pagination .= $div_awal;
                    //$pagination .= "<li class='details'>Page $page of $lastpage";
			if($prev < 1){
				$pagination.= "<a ".$prevx.">PREV</a>";
			}elseif($prev >=1){
				$pagination.= "<a href='{$url}/page-$prev/' ".$prevx.">PREV</a>";
			}
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
				
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{	
    				if ($counter == $page){
						//echo $page;
    					$pagination.= "<a ".$acti.">$counter</a>";
    				}else{
    					$pagination.= "<a href='{$url}/page-$counter/'>$counter</a>";}					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<a ".$acti.">$counter</a>";
    					else
    						$pagination.= "<a href='{$url}/page-$counter/'>$counter</a>";					
    				}
    				$pagination.= "<a class='dot'>...</a>";
    				$pagination.= "<a href='{$url}/page-$lpm1/'>$lpm1</a>";
    				$pagination.= "<a href='{$url}/page-$lastpage/'>$lastpage</a>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<a href='{$url}/page-1/'>1</a>";
    				$pagination.= "<a href='{$url}/page-2/'>2</a>";
    				$pagination.= "<a >...</a>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<a href='' ".$acti.">$counter</a>";
    					else
    						$pagination.= "<a href='{$url}/page-$counter/'>$counter</a>";					
    				}
    				$pagination.= "<a >..</a>";
    				$pagination.= "<a href='{$url}/page-$lpm1/'>$lpm1</a>";
    				$pagination.= "<a href='{$url}/page-$lastpage/'>$lastpage</a>";		
    			}
    			else
    			{
    				$pagination.= "<a href='{$url}/page-1/'>1</a>";
    				$pagination.= "<a href='{$url}/page-2/'>2</a>";
    				$pagination.= "<a >..</a>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<a ".$acti.">$counter</a>";
    					else
    						$pagination.= "<a href='{$url}/page-$counter/'>$counter</a>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<a $nextx href='{$url}/page-$next/'>NEXT</a>";
                //$pagination.= "<a $nextx href='{$url}/page-$lastpage/'>Last</a>";
    		}else{
    			$pagination.= "<a $nextx >NEXT</a>";
               // $pagination.= "<a $nextx >Last</a>";
            }
    		$pagination.= "</div>";		
    	}
		else{
		$pagination ="";
		}
        return $pagination;
    } 
	
	function admPage($hit, $per_page = 12,$page = 1, $url = '?',$div_awal='<ul class="pagination" style="float:right;margin-top:-10px;">'){
    	//$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	//$row = mysql_fetch_array(mysql_query($query));
    	//$total = $row['num'];
    	$total = $hit;
        $adjacents = "2";

    	$page = ($page == 0 ? 1 : $page);
    	$start = ($page - 1) * $per_page;
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
		//echo $pagination;
    	if($lastpage > 1)
    	{
    		$pagination .= $div_awal;
                    //$pagination .= "<li class='details'>Page $page of $lastpage";
			if($prev < 1){
				$pagination.= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}elseif($prev >=1){
				$pagination.= '<li><a href="'.$url."&page=".$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
				
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{	
    				if ($counter == $page){
						//echo $page;
    					$pagination.= '<li class="active">
      <span>'.$counter.' <span class="sr-only">(current)</span></span>
    </li>';
    				}else{
    					$pagination.= '<li><a href="'.$url.'&page='.$counter.'">'.$counter.'</a></li>';
					}					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= '<li class="active">
      <span>'.$counter.' <span class="sr-only">(current)</span></span>
    </li>';
    					else
    						$pagination.= '<li><a href="'.$url.'&page='.$counter.'">'.$counter.'</a></li>';					
    				}
    				$pagination.= "<li><a>...</a></li>";
    				$pagination.= "<li><a href='{$url}&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}&page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=2'>2</a></li>";
    				$pagination.= "<li><a >...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= '<li class="active">
      <span>'.$counter.' <span class="sr-only">(current)</span></span>
    </li>';
    					else
    						$pagination.= '<li><a href="'.$url.'&page='.$counter.'">'.$counter.'</a></li>';					
    				}
    				$pagination.= "<li><a >...</a></li>";
    				$pagination.= "<li><a href='{$url}&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}&page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}&page=2'>2</a></li>";
    				$pagination.= "<li><a >...</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= '<li class="active">
      <span>'.$counter.' <span class="sr-only">(current)</span></span>
    </li>';
    					else
    						$pagination.= '<li><a href="'.$url.'&page='.$counter.'">'.$counter.'</a></li>';
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= '<li>
      <a href="'.$url.'&page='.$next.'" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>';
    		}else{
    			$pagination.= '<li>
      <a aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>';
               // $pagination.= "<a $nextx >Last</a>";
            }
    		$pagination.= "</ul>";		
    	}
		else{
		$pagination ="";
		}
        return $pagination;
    } 
}
?>