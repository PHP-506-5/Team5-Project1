<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
define( "URL_HEADER", DOC_ROOT."workspace/src/trip_header.php" );
define( "URL_FOOTER", DOC_ROOT."workspace/src/trip_footer.php" );
define( "URL_SLIDE", DOC_ROOT."workspace/src/trip_slide.php" );
include_once( URL_DB );

$http_method = $_SERVER["REQUEST_METHOD"]; // 현재 페이지가 어떤 방식으로 요청되었는지를 확인하는 데 사용

if($http_method === "POST"){ // post일경우
    $arr_post=$_POST; // post를 담아둔다.

    if(empty($_POST['trip_price'])) { // trip_price 필드가 비어있는 경우
        $arr_post['trip_price'] = null; }// 디폴트 값으로 null 할당

    $result_cnt = insert_trip_info($arr_post);  
    // 함수에 파라미터로 값을 넘겨주고 가져온 정보를 담아준다.

    $trip_no=trip_info_no_max(); // 변수에 받아온 여행번호의 최대값을 저장한다.
    $max_trip_no = ceil( (int)$trip_no[0]["max"]); 
    // 배열형태로 저장된 변수의 값을 int형태로 바꾼뒤 올림하여 값을 가져옵니다.
    header("Location: trip_detail.php?trip_no=" . $max_trip_no);
    exit();
    // 최대 여행번호를 가진 디테일페이지로 이동하게 해준다.
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
    <link rel="stylesheet" href="../css/font.css">
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
                    <label for="price" class="lable_price"> 비용 </label>
                    <input type="number" name="trip_price" id="price" step="100">
                    <br>
                    <label for="data"> 날짜 </label>
                    <input type="datetime-local" name="trip_date" id="date" required>
                    <br>
                    <label for="contents"> 내용 </label>
                    <textarea rows="10" cols="80" name="trip_contents" id="contents" required></textarea>
                </div>

                <div class="button_group">
                    <button type="submit" class = "button_write">작성</button>
                    <button type="submit" class = "button_back"> <a href="trip_list.php">back</a></button>
                </div>
                <!-- post 요청방식을 사용하며 submit 하면 insert.php에서 처리한다. -->
            </form>
        </main>
    </div>

    <?php include_once( URL_FOOTER )?>
    
</body>
</html>