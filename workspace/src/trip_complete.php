<?php
define( "DOC_ROOT",$_SERVER["DOCUMENT_ROOT"]."/" );
define( "URL_DB",DOC_ROOT."workspace/common/trip_DB_conn.php" );
include_once( URL_DB );

$arr_get = $_GET;
$result_cnt = detail_complete_trip_info( $arr_get["trip_no"]);

header("Location: trip_list.php");
exit();
?>