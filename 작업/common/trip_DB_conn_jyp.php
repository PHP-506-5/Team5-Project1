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

//함수명    : update_trip_info_no
//기능      : 게시판 특정 게시글 정보 수정
//파라미터  : Array             &$param_arr
//리턴값    : INT/STRING        $result_cnt/ERRMSG
function update_trip_info_no( &$param_arr )
{   
    $sql=
        " UPDATE "
        ." trip_info "
        ." SET "
        ." trip_city = :trip_city "
        ." ,trip_title = :trip_title "
        ." ,trip_date = :trip_date "
        ." ,trip_contents = :trip_contents "
        ." WHERE "
        ." trip_no =:trip_no "
        ;
        $arr_prepare = 
            array(
                ":trip_city"=>$param_arr["trip_city"]
                ,":trip_title"=>$param_arr["trip_title"]
                ,":trip_date"=>$param_arr["trip_title"]
                ,":trip_contents"=>$param_arr["trip_contents"]
                ,":t_no" => $param_arr["trip_no"]
            );
        $conn = null;
        try{
            db_conn( $conn ); //db연결
            $conn->beginTransaction(); //transaction 시작
            $stmt = $conn->prepare( $sql );//statement object 셋팅
            $stmt->execute( $arr_prepare );//db request
            $result_cnt = $stmt->rowCount();//query 적용 recode 갯수
            $conn->commit();
        }
        catch( Exception $e)
        {
            return $e->getMessage();
        }
        finally
        {
            $conn=null;
        }
        return $result_cnt;    
}

function select_trip_info_no(&$param_no)
{
    $sql=
    " SELECT "
    ." trip_no "
    ." ,trip_city "
    ." ,trip_title "
    ." ,trip_date "
    ." ,trip_price "
    ." ,trip_contents "
    ." FROM "
    ."  trip_info "
    ." WHERE " 
    ."  trip_no = :trip_no "
    ;

    $arr_prepare = 
    array(
        ":trip_no"    => $param_no
    );

    $conn = null;
    try{
        db_conn( $conn );
        $stmt = $conn-> prepare( $sql );
        $stmt -> execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e)
    {
        return $e->getMessage();
    }
    finally
    {
        $conn=null;
    }
    return $result[0];

}

    ?>