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



    function select_trip_info_paging( &$param_arr ){
        $sql =
        " SELECT " 
        ." trip_no "
        ." , trip_title "
        ." , trip_date "
        ." FROM trip_info "
        ." WHERE " 
        ." trip_com= :trip_com "
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
    ?>