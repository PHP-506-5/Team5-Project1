<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
include_once( URL_DB );

$arr_get = $_GET["trip_no"];

$result = select_trip_info_no($arr_get);

if( $result["trip_com"] == 1 ){
    $new_trip_com = '2';
}
else if( $result["trip_com"] ==2 || $result["trip_com"] ==0 ){
    $new_trip_com = '1';
}

$arr_info = array(
    "trip_com" => $new_trip_com
    ,"trip_no" => $arr_get
);

$result_cnt = detail_complete_trip_info( $arr_info );

header("Location: trip_list.php#tag");
exit();
?>