<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."작업/common/trip_DB_conn_jin.php" );
include_once( URL_DB );

$arr_get = $_GET;
$result = detail_trip_info( $arr_get["trip_no"]);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 여행 상세 일정 </title>
</head>
<body>
    <div>
    <p><?php echo $result["trip_title"]?></p>
    <p> 도시 <?php echo $result["trip_city"]?></p>
    <p> 날짜 <?php echo $result["trip_date"]?></p>
    <p> 내용 <?php echo $result["trip_contents"]?></p>

    <button type="button"><a href="trip_list.php">리스트</a></button>
    <button type="button"><a href="trip_update.php?trip_no=<?php echo $result["trip_no"] ?>"> 수정</a></button>
    <button type="button"><a href="trip_complete.php?trip_no=<?php echo $result["trip_no"] ?>">완료</a></button>

    </div>
</body>
</html>
