<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
include_once( URL_DB );
// 상수로 db_conn.php의 위치를 지정하고 include해서 사용한다.

$arr_get = $_GET["trip_no"];
// 정보에 대한 주소를 사용하여야 하기때문에 get사용한다.

$result = select_trip_info_no($arr_get);
// get에서 여행 번호를 받아와 함수의 파라미터로 값을 넘겨준다.

if( $result["trip_com"] == 1 ){
    $new_trip_com = '2';
}
else if( $result["trip_com"] ==2){
    $new_trip_com = '1';
}

$arr_info = array(
    "trip_com" => $new_trip_com
    ,"trip_no" => $arr_get
);

$result_cnt = detail_complete_trip_info( $arr_info );

// $result["trip_com"]으로 trip_com값을 받아와 1일때는 2로 2일때는 1로 바꾼다.

header("Location: trip_list.php#tag");
exit();
// 그뒤 헤더를 통해 list 파일로 이동한다.
?>