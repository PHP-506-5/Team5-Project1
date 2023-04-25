<?php
    function db_conn( &$param_conn ){
        $host     = "localhost";
        $user     = "root";
        $pass     = "root506";
        $db_name  = "trip";
        $charset  = "utf8mb4";
        $dns      = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
        $pdo_option   = array(
            PDO::ATTR_EMULATE_PREPARES    => false
            ,PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
        );

        try{
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
        }catch( PDOException $e){
            $param_conn = null;  
            throw new PDOException( $e->getMessage() );
        }
    }


    /*-------------------------------
    페이징 넘버 가져오는 함수 작성
    함수명 : select_trip_info_paging_all
    기능   : 정보 모두 가져오면서 com여부 확인
    리턴값 : int $result
    제작자 : 김영범
    ----------------------------------*/
    function select_trip_info_paging_all( &$param_arr ){
        $sql =
        " SELECT "
        ." trip_no "
        ." , trip_city "
        ." , trip_title "
        ." , trip_contents "
        ." , trip_date "
        ." , trip_com "
        ." FROM trip_info ";
        
        if(isset($param_arr["trip_com"]) && $param_arr["trip_com"] !== ""){
            $sql .= " WHERE trip_com=:trip_com ";
        }
        
        $sql .= " ORDER  BY " 
        ." trip_no ASC "
        ." LIMIT :limit_num OFFSET :offset "
        ;      
        
        $arr_prepare = array(
            ":limit_num"  => $param_arr["limit_num"]
            ,":offset"    => $param_arr["offset"]
        );    
        if(isset($param_arr["trip_com"]) && $param_arr["trip_com"] !== ""){
            $arr_prepare[":trip_com"] = $param_arr["trip_com"];
        }
    
        $conn = null;
        try{
            db_conn( $conn );
            $stmt = $conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result = $stmt->fetchAll();
        }catch( Exception $e ){
            return $e->getMessage();
        }
        finally{
            $conn=null;
        }
        return $result;
    }
    
    /*-------------------------------
    특정 변수가 들어오면 그 변수 전체값 가져오는 함수
    함수명 : select_trip_info_paging_cnt
    기능   : 정보 모두 가져오면서 com여부 확인
    리턴값 : int $result
    제작자 : 김영범
    ----------------------------------*/
    function select_trip_info_cnt(&$param_arr){
        $sql =
            " SELECT "
            ."       count(*) cnt "
            ." FROM "
            ."       trip_info "
            ;
    
            if(isset($param_arr["trip_com"]) && $param_arr["trip_com"] !== ""){
                $sql .= " WHERE trip_com=:trip_com ";
            }
            $arr_prepare=array();
            if(isset($param_arr["trip_com"]) && $param_arr["trip_com"] !== ""){
                $arr_prepare[":trip_com"] = $param_arr["trip_com"];
            }
    
            
            $conn=null;
    
            try{
                db_conn( $conn );
                $stmt = $conn->prepare( $sql );
                $stmt->execute( $arr_prepare );
                $result = $stmt->fetchAll();
            }catch( Exception $e ){
                return $e->getMessage();
            }
            finally{
                $conn=null;
            }
            return $result;
    }

// ---------------------------------
// 함수명	: select_trip_info_no
// 기능		: 특정 정보 확인
// 파라미터	: INT		&$param_no
// 리턴값	: Array		$result
// 작성자   : 박진영
// ---------------------------------
function select_trip_info_no(&$param_no)
{
    $sql =
        "SELECT "
        . " trip_no "
        . " ,trip_city "
        . " ,trip_title "
        . " ,trip_date "
        . " ,trip_price "
        . " ,trip_contents "
        . " ,trip_com"
        . " FROM "
        . " trip_info "
        . " WHERE "
        . " trip_no = :trip_no "
    ;

    $arr_prepare = array(
        ":trip_no" => $param_no
    );

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
    return $result[0];
}
//------------------------------------------------
// 함수명    : update_trip_info_no
// 기능      : 게시판 특정 게시글 정보 수정
// 파라미터  : Array             &$param_arr
// 리턴값    : INT/STRING        $result_cnt/ERRMSG
// 작성자    : 박진영
//------------------------------------------------
function update_trip_info_no( &$param_arr )
{   
    $sql=
        " UPDATE "
        ." trip_info "
        ." SET "
        ." trip_city = :trip_city "
        ." ,trip_title = :trip_title "
        ." ,trip_date = :trip_date "
        ." ,trip_price = :trip_price "
        ." ,trip_contents = :trip_contents "
        ." WHERE "
        ." trip_no =:trip_no "
        ;
        $arr_prepare = 
            array(  
                ":trip_city"=>$param_arr["trip_city"]
                ,":trip_title"=>$param_arr["trip_title"]
                ,":trip_date"=>$param_arr["trip_date"]
                ,":trip_price"=>$param_arr["trip_price"]
                ,":trip_contents"=>$param_arr["trip_contents"]
                ,":trip_no" => $param_arr["trip_no"]   

            );
        $conn = null;
        try{
            db_conn( $conn );
            $conn->beginTransaction();
            $stmt = $conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result_cnt = $stmt->rowCount();
            $conn->commit();
        }
        catch( Exception $e)
        {
            $conn-> rollback();
            return $e->getMessage();
        }
        finally
        {
            $conn=null;
        }
        return $result_cnt;    
}

// ---------------------------------
// 새로운 일정을 생성하는 함수 작성
// 함수명	 : insert_trip_info
// 기능		 : 일정을 db에 넣어준다.
// 파라미터	 : array   &$param_arr
// 리턴값	 : string  $result_cnt
// 제작자    : 김진아
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

// ---------------------------------------------
// 상세페이지에서 완료를 할 수 있게해주는 함수 작성
// 함수명	  :  detail_complete_trip_info
// 기능		  :  trip_com을 0에서 1로 변경한다.
// 파라미터   :  int  	&$param_no
// 리턴값	  :  int   $result_cnt
// 제작자     :  김진아
// ---------------------------------------------
function detail_complete_trip_info( &$param_arr){
    $sql = " UPDATE "
        ." trip_info "
        ." SET "
        ." trip_com = :trip_com"
        ." WHERE "
        ." trip_no = :trip_no";

    $arr_prepare =array(":trip_com"=>$param_arr["trip_com"],":trip_no" => $param_arr["trip_no"]);

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

// --------------------------------------------------
// 작성페이지에서 작성을 누르면 상세로 가는 함수 작성
// 함수명    : trip_info_no_max
// 기능      : trip_no의 최댓값을 구한다.
// 파라미터  : 없음
// 리턴값    : array   $result
// 제작자     : 김진아
// --------------------------------------------------
function trip_info_no_max(){
    $sql = " SELECT "
        ." max(trip_no) max "
        ." FROM "
        ." trip_info ";

    $arr_prepare = array();

    $conn = null;

    try {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchall();
    }
    catch ( Exception $e) {
        return $e->getMessage();
    }
    finally{
        $conn = null;
    }
    return $result;
}

?>