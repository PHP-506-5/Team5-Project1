<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
define( "URL_HEADER", DOC_ROOT."workspace/src/trip_header.php" );
define( "URL_FOOTER", DOC_ROOT."workspace/src/trip_footer.php" );
include_once( URL_DB );

$arr_get = $_GET;
$result = select_trip_info_no($arr_get["trip_no"]); 

$front_page =  $result["trip_no"]-1;
$back_page =  $result["trip_no"]+1;
$result_max = trip_info_no_max();
$max_trip_no = ceil( (int)$result_max[0]["max"]);

$trip_com = select_trip_info_com($arr_get["trip_no"]);
$result_com = $trip_com[0]["trip_com"]
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/com_header.css">
    <link rel="stylesheet" href="../css/com_footer.css">
    <link rel="stylesheet" href="../css/detail.css">
    <link rel="stylesheet" href="../css/font.css">
    <title> 여행 상세 일정 </title>
</head>
<body>
    <?php include_once( URL_HEADER ); ?>

    <main>
        <br>
        <div class="title_group">
            <?php if (isset($result_com)) {
                    if ($result_com == 0 || $result_com == 2) { ?>
                        <h2><?php echo $result["trip_title"]?></h2>
                        <div class="trip_com"> 미완료 </div>
                    <?php } else if ($result_com == 1) { ?>
                        <h2 class="complete"><?php echo $result["trip_title"]?></h2>
                        <div class="trip_com"> 완료 </div>
                    <?php }
                } ?>
        </div>
        
        <div class ="main_group">
            <?php if($result["trip_no"]>1) { ?>
            <a href="trip_detail.php?trip_no=<?php echo $front_page ?>"> <span class ="front_b">◀</span> </a>
            <?php } ?>
            <article>
                <p class="city"> 도시 <span> <?php echo $result["trip_city"]?> </span></p>
                <p> 비용 <span> <?php echo $result["trip_price"]?> </span></p>
                <p> 날짜 <span> <?php echo $result["trip_date"]?> </span></p>
                <p> 내용 <div class="contents"> <div><?php echo $result["trip_contents"]?> </div></div></p>
            </article>
            <?php if($result["trip_no"]<$max_trip_no) { ?>
            <a href="trip_detail.php?trip_no=<?php echo $back_page ?>"> <span class ="back_b">▶</span> </a>
            <?php } ?>
        </div>
        
        <div class ="button_group">
            <button type="button"><a href="trip_list.php#tag">리스트</a></button>
            <button type="button" class="button_up"><a href="trip_update.php?trip_no=<?php echo $result["trip_no"] ?>"> 수정</a></button>
            <button type="button" class="button_comp"><a href="trip_complete.php?trip_no=<?php echo $result["trip_no"] ?>">완료</a></button>
        </div>
    </main>
    
    <?php include_once( URL_FOOTER );?>

</body>
</html>
