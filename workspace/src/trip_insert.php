<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."작업/common/trip_DB_conn_jin.php" );
include_once( URL_DB );

$http_method = $_SERVER["REQUEST_METHOD"];
if($http_method === "POST"){
    $arr_post=$_POST;
    $result_cnt = insert_trip_info($arr_post);
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/insert.css">
    <title> 여행 일정 작성 </title>
</head>
<body>
    <form method = "post" action="trip_insert.php">
        <label for="city"> 도시 </label>
        <input type="text" name="trip_city" id="city" required autofocus>
        <br>
        <label for="title"> 제목 </label>
        <input type="text" name="trip_title" id="title" required>
        <br>
        <label for="contents"> 내용 </label>
        <input type="text" name="trip_contents" id="contents" required>
        <br>
        <label for="price"> 비용 </label>
        <input type="text" name="trip_price" id="price">
        <br>
        <label for="data"> 날짜 </label>
        <input type="datetime-local" name="trip_date" id="date">

        <button type="submit">작성</button>
        <button type="submit"> <a href="trip_list.php">back</a></button>
    </form>
</body>
</html>