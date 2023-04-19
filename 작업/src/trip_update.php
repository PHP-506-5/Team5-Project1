<?php
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_DB", DOC_ROOT . "작업/common/trip_DB_conn.ybk.php");
include_once(URL_DB);

$http_method = $_SERVER["REQUEST_METHOD"];

// GET 일 때
if ($http_method === "GET") {
    $trip_no = 1;
    if (array_key_exists("trip_no", $_GET)) {
        $trip_no = $_GET["trip_no"];
    }
    $result_info = select_trip_info_no($trip_no);
} else {
    $arr_post = $_POST;
    $arr_info = array(
        "trip_city" => $arr_post["trip_city"]
        ,"trip_title" => $arr_post["trip_title"]
        ,"trip_date" => $arr_post["trip_date"]
        ,"trip_price" => $arr_post["trip_price"]
        ,"trip_contents" => $arr_post["trip_contents"]
        ,"trip_no" => $arr_post["trip_no"]
    );

    // update
    $result_cnt = update_trip_info_no($arr_info);

    header("Location: trip_detail.php?trip_no=" .$arr_post["trip_no"]);
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
</head>
<body>
    <div class="grid">
    <!-- 헤더     -->
    <header class="page-header">
        <div class="content">
        <!-- <p>헤더</p> -->
        </div>
    </header>
    <!-- 왼쪽이미지 슬라이드 -->
    <aside class="page-leftbar">
        <div class="content">
        <!-- <p>슬라이드</p> -->
        </div>
    </aside>
    <!-- 게시판 -->
    <main class="page-main">
    <form method="post" action="trip_update.php">
        <div class="container">
			<table class='aaa'>
				<tr>
					<th class="">
						<label for="title">제목</label>
					</th>
					<td class="">
						<input type="text" name="trip_title" id="title" value="<?php echo $result_info["trip_title"] ?>">
					</td>
				</tr>
                <tr>
					<th class="">
						<label for="city">도시</label>
					</th>
					<td class="">
						<input type="text" name="trip_city" id="city" value="<?php echo $result_info["trip_city"] ?>">
					</td>
				</tr>
                <tr>
					<th class="">
						<label for="date">날짜</label>
					</th>
					<td class="">
						<input type="date" name="trip_date" id="date" value="<?php echo $result_info["trip_date"] ?>">
					</td>
				</tr>
                <tr>
					<th class="">
						<label for="pirce">비용</label>
					</th>
					<td class="">
						<input type="pirce" name="trip_price" id="pirce" value="<?php echo $result_info["trip_price"] ?>">
					</td>
				</tr>
				<tr>
					<th class="">
						<label  for="trip_contents">내용</label>
					</th>
					<td class="">
					<textarea rows="6" cols="10" name="trip_contents" id="contents"><?php echo $result_info["trip_contents"] ?></textarea>
					</td>
				</tr>
			</table>
        </div>
        <div class="button">
            <button type="submit" class="btn">수정</button>
            <a href="trip_detail.php?trip_no=<?php echo $result_info["trip_no"] ?>" class="">취소</a>
		</div>
            <input type="hidden" name="trip_no" value="<?php echo $result_info["trip_no"]?>">
    </form>
    </main>
    <!-- 푸터 -->
    <footer class="page-footer">
        <div class="content">
        <!-- <p>Footer</p> -->
        </div>
    </footer>
</div>
</body>
</html>