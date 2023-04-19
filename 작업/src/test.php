<?php
    function gap_time($start_date, $end_date) {
	
        $start_time = strtotime($start_date);
        $end_time = strtotime($end_date);
    
        $diff = $end_time - $start_time;
    
        $hours = floor($diff/3600);
    
        $diff = $diff-($hours*3600);
    
        $min = floor($diff/60);
    
        return sprintf("%d%d", $hours, $min); 
    
    }
?>