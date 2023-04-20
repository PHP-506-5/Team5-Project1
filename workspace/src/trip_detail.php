<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
define( "URL_FOOTER", DOC_ROOT."workspace/src/trip_footer.php" );
define( "URL_SLIDE", DOC_ROOT."workspace/src/trip_slide.php" );
include_once( URL_DB );

$arr_get = $_GET;
$result = select_trip_info_no($arr_get["trip_no"]);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/detail.css">
    <link rel="stylesheet" href="../css/com_footer.css">
    <link rel="stylesheet" href="../css/com_slide.css">
    <title> 여행 상세 일정 </title>
</head>
<body>
    <?php include_once( URL_SLIDE ); ?>
    <main>
        <p class="detail_title"><?php echo $result["trip_title"]?></p>
        <article>
            <p> 도시 <?php echo $result["trip_city"]?></p>
            <p> 비용 <?php echo $result["trip_price"]?></p>
            <p> 날짜 <?php echo $result["trip_date"]?></p>
            <p class="contents"> 내용 <?php echo $result["trip_contents"]?></p>
        </article>
        <button type="button" class="button_list"><a href="trip_list.php">리스트</a></button>
        <button type="button" class="button_up"><a href="trip_update.php?trip_no=<?php echo $result["trip_no"] ?>"> 수정</a></button>
        <button type="button" class="button_comp"><a href="trip_complete.php?trip_no=<?php echo $result["trip_no"] ?>">완료</a></button>
    </main>

    <?php include_once( URL_FOOTER );?>
</body>
</html>
