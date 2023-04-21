<?php
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_DB", DOC_ROOT . "workspace/common/trip_DB_conn.php");
define("URL_SLIDE", DOC_ROOT . "/workspace/src/trip_slide.php" );
define("URL_HEADER", DOC_ROOT . "/workspace/src/trip_header.php" );
define("URL_FOOTER", DOC_ROOT . "/workspace/src/trip_footer.php" );

include_once(URL_DB);

    $http_method = $_SERVER["REQUEST_METHOD"];

// GET 일때
if( $http_method === "GET" )
{
    $trip_no = 1;
    if( array_key_exists( "trip_no", $_GET ) )
    {
        $trip_no = $_GET["trip_no"];
    }
    $result_info = select_trip_info_no( $trip_no );
}
else{
    $arr_post=$_POST;
    $arr_info = array(
        "trip_no" => $arr_post["trip_no"],
        "trip_title" => $arr_post["trip_title"],
        "trip_city" => $arr_post["trip_city"],
        "trip_date" => $arr_post["trip_date"],
        "trip_price" => $arr_post["trip_price"],
        "trip_contents" => $arr_post["trip_contents"]
    );

    // update
    $result_cnt = update_trip_info_no( $arr_info );

    header("Location: trip_detail.php?trip_no=" . $arr_post["trip_no"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trip_update</title>
    <link rel="stylesheet" href="../css/update.css">
    <link rel="stylesheet" href="../css/com_header.css">
    <link rel="stylesheet" href="../css/com_slide.css">
    <link rel="stylesheet" href="../css/com_footer.css">
</head>
<body>
    <div class="parent">
    <?php include_once( URL_HEADER ) ?>         <!-- 헤 더-->
    <?php include_once( URL_SLIDE ) ?>          <!-- 슬라이드 -->
    <main class="page-main">                    <!-- 게시판 -->
    <form method="post" action="trip_update.php">
        <div class="aaa">
            <label for="title"> 제목 </label>
            <input type="text" name="trip_title" id="title" required value="<?php echo $result_info["trip_title"] ?>">   
            <br>
            <label for="city"> 도시 </label>
            <input type="text" name="trip_city" id="city" required autofocus value="<?php echo $result_info["trip_city"] ?>">
            <br>
            <label for="price"> 비용 </label>
            <input type="text" name="trip_price" id="price" value="<?php echo $result_info["trip_price"] ?>">
            <br>
            <label for="data"> 날짜 </label>
            <input type="datetime-local" name="trip_date" id="date" value="<?php echo $result_info["trip_date"] ?>">
            <br>
            <label for="contents"> 내용 </label>
            <textarea rows="6" cols="40" name="trip_contents" id="contents"><?php echo $result_info["trip_contents"] ?></textarea>
            <input type="hidden" name="trip_no" value="<?php echo $result_info["trip_no"] ?>">
        </div>
        <div class="button">
            <button type="submit" class="">수정</button>
            <button type="button"><a href="trip_detail.php?trip_no=<?php echo $result_info["trip_no"] ?>" class="">취소</a></button>
		</div>
            <input type="hidden" name="trip_no" value="<?php echo $result_info["trip_no"]?>">
    </form>
    </main>
</div>
    <?php include_once( URL_FOOTER ) ?>     <!-- 푸 터 -->
</body>
</html>