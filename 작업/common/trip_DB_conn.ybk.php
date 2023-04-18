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
    함수명 : select_trip_info_no
    기능   : com이 0인 정보 모두 가져옴
    리턴값 : int $result
    ----------------------------------*/
    function select_trip_info_paging( &$param_arr ){
        $sql =
        " SELECT "
        ." trip_no "
        ." , trip_city "
        ." , trip_title "
        ." , trip_contents "
        ." , trip_date "
        ." FROM trip_info "
        ." WHERE " 
        ." trip_com='0' "
        ." ORDER  BY " 
        ." trip_no ASC "
        ." LIMIT :limit_num OFFSET :offset "
        ;      
        
    $arr_prepare = array(
                    ":limit_num"  => $param_arr["limit_num"]
                    ,":offset"    => $param_arr["offset"]
                    ,":trip_com"  => $param_arr["trip_com"]
                    );    

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


    function select_trip_info_cnt(){
        $sql =
            " SELECT "
            ."       count(*) cnt "
            ." FROM "
            ."       trip_info "
            ." WHERE "
            ." trip_com='0' "
            ;

            $arr_prepare=array();
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
    ?>