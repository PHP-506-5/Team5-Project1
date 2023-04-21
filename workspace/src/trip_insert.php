<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
define( "URL_HEADER", DOC_ROOT."workspace/src/trip_header.php" );
define( "URL_FOOTER", DOC_ROOT."workspace/src/trip_footer.php" );
define( "URL_SLIDE", DOC_ROOT."workspace/src/trip_slide.php" );
include_once( URL_DB );

$http_method = $_SERVER["REQUEST_METHOD"];

if($http_method === "POST"){
    $arr_post=$_POST;
    $result_cnt = insert_trip_info($arr_post);
    $trip_no=trip_info_no_max();
    $max_trip_no = ceil( (int)$trip_no[0]["max"]);
    // $redirect_to = "trip_detail.php?trip_no=" . $trip_no;
    header("Location: trip_detail.php?trip_no=" . $max_trip_no);
    exit();
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/com_footer.css">
    <link rel="stylesheet" href="../css/com_header.css">
    <link rel="stylesheet" href="../css/com_slide.css">
    <link rel="stylesheet" href="../css/insert.css">
    <title> 여행 일정 작성 </title>
</head>
<body>
    <div class="all">
    <?php include_once( URL_HEADER ) ?>
    <?php include_once( URL_SLIDE ) ?>
    <main class="page-main">
            <form method = "post" action="trip_insert.php">
                <div class="main_form">
                    <h2> WRITE </h2>
                    <label for="title"> 제목 </label>
                    <input type="text" name="trip_title" id="title" required>
                    <br>
                    <label for="city"> 도시 </label>
                    <input type="text" name="trip_city" id="city" required autofocus>
                    <label for="price"> 비용 </label>
                    <input type="number" name="trip_price" id="price" required step="100">
                    <br>
                    <label for="data"> 날짜 </label>
                    <input type="datetime-local" name="trip_date" id="date">
                    <br>
                    <label for="contents"> 내용 </label>
                    <textarea rows="10" cols="80" name="trip_contents" id="contents"></textarea>
                </div>
                <div class="button_group">
                    <button type="submit" class = "button_write">작성</button>
                    <button type="submit" class = "button_back"> <a href="trip_list.php">back</a></button>
                </div>
            </form>
        </main>
    </div>
    <?php include_once( URL_FOOTER )?>
</body>
</html>