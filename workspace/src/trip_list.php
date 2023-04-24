<?php
	define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
	define( "URL_DB", DOC_ROOT."workspace/common/trip_DB_conn.php" );
	define( "URL_FOOTER" , DOC_ROOT."workspace/src/trip_footer.php");
	include_once( URL_DB );
	$http_method=$_SERVER["REQUEST_METHOD"];

	if( array_key_exists( "page_num", $_GET ) )
	{
		$page_num = $_GET["page_num"];
	}
	else
	{
		$page_num = 1;
	}

	$limit_num = 5;

	$offset = ( $page_num * $limit_num ) - $limit_num;

	$post=isset($_POST["current"])?$_POST["current"] : false;
		if($post=='0'){
			$arr_prepare = array(
				"limit_num" => $limit_num
				,"offset" => $offset
			);
			$result_cnt = select_trip_info_cnt($arr_prepare);
			$max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );

		}else if($post=='1'){
			$arr_prepare = array(
				"limit_num" => $limit_num
				,"offset" => $offset
				,"trip_com" => 1
			);
			$result_cnt = select_trip_info_cnt($arr_prepare);
			$max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );	
			
		}else{
			$arr_prepare = array(
				"limit_num" => $limit_num
				,"offset" => $offset
				,"trip_com" => 2
			);
			$result_cnt = select_trip_info_cnt($arr_prepare);
			$max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );
		}

	$result_paging = select_trip_info_paging_all( $arr_prepare );

	$prev_page_num = $page_num - 1 > 0 ? $page_num - 1 : 1;
	$next_page_num = $page_num + 1 > $max_page_num ? $max_page_num : $page_num + 1;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<title>Trip List</title>
	<link rel="stylesheet" href="../css/list.css">
	<link rel="stylesheet" href="../css/font.css">
	<link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../css/com_footer.css">
	
</head>
<body>
	<div id=first>
		<div id=img></div>
		<div id=mainname>
			To day Trip
			<br>
			<div class="container">
			<a href="trip_insert.php" id="go">작성 시작하기</a>
		</div>
			<br>
			<div id=img2><a href="#tag"><img src="비행기.png" alt=""></a></div>
		</div>
			
		</div>
	
<div id="listpage">
    <form method="POST" action="">
        <select name="current" class="form-select">
            <option value="0">전체</option>
            <option value="1">완료</option>
            <option value="2">미완료</option>
        </select>
        <input type="submit" value="선택" id="select" class="btn btn-dark">
    </form>

			<table>
		<thead>
			<tr>
			<th id="th1">번호</th>
			<th id="th2">도시 이름</th>
			<th>제목</th>
			<th>할 시간</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($result_paging as $recode) { ?>
			
			<tr>
				<td id="td1"><?php echo $recode["trip_no"] ?></td>
				<td id="td2"><?php echo $recode["trip_city"] ?></td>
				
				<td id="td3">
					<a href="trip_detail.php?trip_no=<?php echo $recode["trip_no"] ?>&page_num=<?php echo $page_num ?>">
					<?php if($recode["trip_com"]==1){ ?>
						<div id="div1"><span><?php echo $recode["trip_title"]?></span></div>
						<?php }else{ ?>
						<div id="div2"><?php echo $recode["trip_title"];
					}?></div>
					</a>
					<a id="tag"></a>
				</td>
				<?php
				include_once("gap_time.php");
				if (gap_time(date("Y-m-d H:i:s"), $recode["trip_date"]) <= 0100 && gap_time(date("Y-m-d H:i:s"), $recode["trip_date"]) >= 0000) {
				?>
					<td style="color:blue;"><?php echo $recode["trip_date"]; ?></td>
				<?php } else { ?>
					<td id="td4"><div id="div4"><?php echo $recode["trip_date"] ?></div></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
		</table>


		<div id="choosebut">
			<a href="trip_list.php?page_num=<?php echo $prev_page_num ?>#tag"class="btn btn-outline-secondary">◀</a>
		<?php
			for( $i = 1; $i <= $max_page_num; $i++ )
			{
		?>
				<a href="trip_list.php?page_num=<?php echo $i ?>#tag" class="btn btn-outline-secondary"><?php echo $i ?></a>
		<?php
			}
		?>
			<a href="trip_list.php?page_num=<?php echo $next_page_num ?>#tag"class="btn btn-outline-secondary">▶</a>
		</div>
	</div>
		<?php include_once( URL_FOOTER ) ?>
	</div>
</body>
</html>