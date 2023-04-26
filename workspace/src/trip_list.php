<?php
	define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
	define( "URL_DB", DOC_ROOT."workspace/common/trip_DB_conn.php" );
	define( "URL_FOOTER" , DOC_ROOT."workspace/src/trip_footer.php");
	include_once( URL_DB );

	if( array_key_exists( "page_num", $_GET ) )// get 방식으로 넘버를 받아와서 $_GET에 page_num할당 없을 시 1 할당
	{
		$page_num = $_GET["page_num"];
	}
	else
	{
		$page_num = 1;
	}


	$limit_num = 5; // 한 페이지에 보여줄 리스트 값

	$offset = ( $page_num * $limit_num ) - $limit_num; // offset으로 몇번부터 몇번까지 보여줄지 지정

	$post=isset($_POST["current"])?$_POST["current"] : false; // post로 받아온 값에 따른 trip_com 지정 0일 경우 전체를 받아옴
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

	$result_paging = select_trip_info_paging_all( $arr_prepare ); //각 각 array를 받은 함수에 전체 값에 따른 result_paging지정

	$prev_page_num = $page_num - 1 > 0 ? $page_num - 1 : 1; // 이전, 다음페이지 번호 연산
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
			<!-- 비행기 클릭 시 하단 부로 내려감 -->
			<div id=img2><a href="#tag"><img src="비행기.png" alt=""></a></div> 
		</div>
			
		</div>
	
<div id="listpage">
	<!-- 셀릭트 박스 버튼을 누르면 post로 값 넘겨줌 -->
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
				// 값이 1시간 이하로 남으면 색을 바꿔줌
				include_once("gap_time.php");
				if (gap_time(date("Y-m-d H:i:s"), $recode["trip_date"]) <= 0100 && gap_time(date("Y-m-d H:i:s"), $recode["trip_date"]) >= 0000) {
				?>
					<td id="h1"><div id="div3"><?php echo $recode["trip_date"] ?></div></td>
				<?php } else { ?>
					<td id="td4"><div id="div4"><?php echo $recode["trip_date"] ?></div></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
		</table>


		<div id="choosebut">
			<!-- 버튼을 눌러도 하단에 고정해 주게 만들어주고 다음페이지로 넘어가는 버튼구현 -->
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