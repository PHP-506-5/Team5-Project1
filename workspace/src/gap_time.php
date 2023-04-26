<?php
    function gap_time($start_date, $end_date) {
	
        $start_time = strtotime($start_date);
        $end_time = strtotime($end_date);

        $diff = $end_time - $start_time;

        $hours = floor($diff/3600);
        $min = floor($diff/60);
    
        return sprintf("%d%d", $hours, $min); 
    }
    // $a=print gap_time("2023-04-19 12:42","2023-04-19 13:00");"\n";
    // echo "\n";
    // if($a>0100){
    //     echo 1;
    // }else{
    //     echo 2;
    // }
// ?>