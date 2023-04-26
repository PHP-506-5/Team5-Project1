<?php
    function gap_time($start_date, $end_date) {
	
        $start_time = strtotime($start_date); // 문자형 날짜를 초로 바꾸어 계산 해주는 함수
        $end_time = strtotime($end_date);

        $diff = $end_time - $start_time;

        $hours = floor($diff/3600); // 몫을 시간으로 가져옴
        $min = floor($diff/60); // 몫을 분으로 가져옴
    
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