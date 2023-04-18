<?php
	define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
	define( "URL_DB", SRC_ROOT."작업/common/trip_DB_conn.ybk.php" );
	include_once( URL_DB );
	$http_method=$_SERVER["REQUEST_METHOD"];

	$post=$_POST;
	$trip_com=$post["current"];

	if( array_key_exists( "page_num", $_GET ) )
	{
		$page_num = $_GET["page_num"];
	}
	else
	{
		$page_num = 1;
	}

	$limit_num = 4;
	$result_cnt = select_trip_info_cnt();

	$max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );

	$offset = ( $page_num * $limit_num ) - $limit_num;

	if(isset($_POST["current"])){
        $arr_prepare = array(
                        "limit_num" => $limit_num
                        ,"offset" => $offset
                        ,"trip_com" => $trip_com
        );
    }

	// 페이징용 데이터 검색
	$result_paging = select_trip_info_paging( $arr_prepare );

	$prev_page_num = $page_num - 1 > 0 ? $page_num - 1 : 1;
	$next_page_num = $page_num + 1 > $max_page_num ? $max_page_num : $page_num + 1;

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>여행 정보</title>
</head>
<body>
	<div class="container">
			<a href="trip_insert.php">일정 작성</a>
		</div>

    <form method="POST" action="">
        <select name="current">
            <option value="0">전체</option>
            <option value="1">완료</option>
            <option value="2">미완료</option>
        </select>
        <input type="submit" value="선택">
    </form>

		<table>
			<thead>
				<tr>
					<th>번호</th>
					<th>제목</th>
					<th>할 시간</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach( $result_paging as $recode )
					{
				?>
						<tr>
							<td><?php echo $recode["trip_no"] ?></td>
							<td><a href="trip_detail.php?trip_no=<?php echo $recode["trip_no"] ?>"><?php echo $recode["trip_title"] ?></a></td>
							<td><?php echo $recode["trip_date"] ?></td>
						</tr> 
				<?php
					}
				?>
			</tbody>
		</table>

		<!-- 페이징 번호 -->
		<div>
			<a href="trip_list.php?page_num=<?php echo $prev_page_num ?>" class="button_a">◀</a>
		<?php
			for( $i = 1; $i <= $max_page_num; $i++ )
			{
		?>
				<a href="trip_list.php?page_num=<?php echo $i ?>" class="button_a"><?php echo $i ?></a>
		<?php
			}
		?>
			<a href="trip_list.php?page_num=<?php echo $next_page_num ?>" class="button_a">▶</a>
		</div>
	</div>
</body>
</html>