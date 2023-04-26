<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
define( "URL_HEADER", DOC_ROOT."workspace/src/trip_header.php" );
define( "URL_FOOTER", DOC_ROOT."workspace/src/trip_footer.php" );
include_once( URL_DB );
// 상수를 정의하고 만들어준 상수를 include한다.

$arr_get = $_GET; 
$result = select_trip_info_no($arr_get["trip_no"]); 
// get의 통해 받은 여행번호를 파라미터로 함수에 넘겨서 담긴 정보를 result 변수에 담아둔다.

$front_page =  $result["trip_no"]-1;
$back_page =  $result["trip_no"]+1;
// 앞번호로 이동하기위한 여행번호에서 하나씩 숫자를 빼고 뒷번호로 이동하기위한 여행번호에서 하나씩 숫자를 더한다.

$result_max = trip_info_no_max();  // 최대값을 저장한다.
$max_trip_no = ceil( (int)$result_max[0]["max"]); 
// 배열형태로 저장된 변수의 값을 int형태로 바꾼뒤 올림하여 값을 가져옵니다.

$result_com = $result["trip_com"];
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
                    if ($result_com == 2) { ?>
                        <h2><?php echo $result["trip_title"]?></h2>
                        <div class="trip_com"> 미완료 </div>
                    <?php } else if ($result_com == 1) { ?>
                        <h2 class="complete"><?php echo $result["trip_title"]?></h2>
                        <div class="trip_com"> 완료 </div>
                    <?php }
                } ?>
        </div>
        <!-- 먼저 $result_com에 값이 있는지 확인하고 2이면 미완료 1이면 완료가 뜨게 하는 코드 -->

        <div class ="main_group">
            <?php if($result["trip_no"]>1) { ?>
            <a href="trip_detail.php?trip_no=<?php echo $front_page ?>"> <span class ="front_b">◀</span> </a>
            <?php } ?>
            <!-- $result["trip_no"] 값이 1보다 클때만 앞페이지로 이동하게하게 해준다. -->
            <article>
                <!-- $result 로 부터 정보를 가져온다. -->
                <p class="city"> 도시 <span> <?php echo $result["trip_city"]?> </span></p>
                <p> 비용 <span> <?php echo $result["trip_price"]?> </span></p>
                <p> 날짜 <span> <?php echo $result["trip_date"]?> </span></p>
                <p> 내용 <div class="contents"> <div><?php echo $result["trip_contents"]?> </div></div></p>
            </article>
            <?php if($result["trip_no"]<$max_trip_no) { ?>
            <a href="trip_detail.php?trip_no=<?php echo $back_page ?>"> <span class ="back_b">▶</span> </a>
            <?php } ?>
        </div>
        <!-- $result["trip_no"] 값이 $max_trip_no보다 작을때만 뒷페이지로 이동하게하게 해주는 함수 -->
        <div class ="button_group">
            <button type="button"><a href="trip_list.php#tag">리스트</a></button>
            <button type="button" class="button_up"><a href="trip_update.php?trip_no=<?php echo $result["trip_no"] ?>"> 수정</a></button>
            <?php if($result_com==0 || $result_com==2){ ?>
                <button type="button" class="button_comp"><a href="trip_complete.php?trip_no=<?php echo $result["trip_no"] ?>">완료</a></button>
            <?php } 
            else if($result_com==1){?>
            <button type="button" class="button_comp"><a href="trip_complete.php?trip_no=<?php echo $result["trip_no"] ?>">미완료</a></button>
            <?php }?>
        </div>
        <!-- 리스트부분으로 이동하게 해주는 리스트 버튼
        $result["trip_no"]에서 여행번호를 받아와 해당하는 수정페이지로 이동하게 해주는 수정버튼
        $result["trip_no"]에서 여행번호를 받아와 해당하는 complete.php를 통해 리스트로 이동하는 완료버튼 -->
    </main>
    
    <?php include_once( URL_FOOTER );?>

</body>
</html>
