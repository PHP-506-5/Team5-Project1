<?php
    function db_conn( &$param_conn ){
        $host     = "localhost"; //host
        $user     = "root"; //user
        $pass     = "root506"; //password
        $db_name  = "trip"; //db name
        $charset  = "utf8mb4"; //charset
        $dns      = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
        $pdo_option   = array(
            PDO::ATTR_EMULATE_PREPARES    => false //DB의 prepared statement 기능을 사용하도록 설정
            ,PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION //PDO Exception을 Thorws 하도록 설정
            ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // 연상배열로 Fetch를 하도록 설정  
        );

        try{
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
        }catch( PDOException $e){
            $param_conn = null;  
            throw new PDOException( $e->getMessage() );
        }
    }

// ---------------------------------
// 함수명	: insert_trip_info
// 기능		: 작성을 할수 있게 해준다.
// 파라미터	: array   &$param_arr
// 리턴값	: string  $result_cnt
// ---------------------------------
function insert_trip_info(&$param_arr){
    $sql =
    " INSERT INTO trip_info( "
    ." 	trip_title "
    ." 	,trip_contents "
    ." 	,trip_city "
    ." 	,trip_price "
    ." 	,trip_date "
    ." ) "
    ." VALUES ( "
    ." 	:trip_title "
    ." 	,:trip_contents "
    ." 	,:trip_city"
    ." 	,:trip_price"
    ." 	,:trip_date"
    ." ) "
    ;

    $arr_prepare = array(
        ":trip_title" => $param_arr["trip_title"]
        ,":trip_contents" => $param_arr["trip_contents"]
        ,":trip_city" => $param_arr["trip_city"]
        ,":trip_price" => $param_arr["trip_price"]
        ,":trip_date" => $param_arr["trip_date"]);

    $conn = null;

    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowcount();
        $conn->commit();

    } catch ( Exception $e) {
        $conn->rollback();
        return $e->getmessage;
    }
    finally{
        $conn = null;
    }
    return $result_cnt;
}

// ---------------------------------
// 함수명	: detail_trip_info
// 기능		: 상세페이지를 볼 수 있게 해준다.
// 파라미터	: int   &$param_no
// 리턴값	: int   $result
// ---------------------------------

function detail_trip_info(&$param_no){
    $sql = " SELECT "
        ." trip_title"
        ." ,trip_no"
        ." ,trip_city"
        ." ,trip_date"
        ." , trip_contents"
        ." FROM trip_info"
        ." WHERE "
        ." trip_no = :trip_no";

    $arr_prepare = array( ":trip_no" => $param_no);

    $conn=null;
    try {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch ( Exception $e) {
        return $e->getmessage;
    }
    finally{
        $conn = null;
    }
    return $result[0];
}

// ---------------------------------
// 함수명	: detail_complete_trip_info
// 기능		: 상세페이지에서 완료를 할 수 있게해준다
// 파라미터	: int  	&$param_no
// 리턴값	: int   $result_cnt
// ---------------------------------

function detail_complete_trip_info( &$param_no){
    $sql = " UPDATE "
        ." trip_info "
        ." SET "
        ." trip_com = '1'"
        ." WHERE "
        ." trip_no = :trip_no";

    $arr_prepare =array(":trip_no" => $param_no);

    $conn = null;
    try {
        db_conn( $conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } 
    catch ( Exception $e ) {
        $conn->rollback();
		return $e->getMessage();
    }
    finally{
        $conn = null;
    }
    return $result_cnt;
}
?>