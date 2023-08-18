<?php 
	// -----------------------------------------------
	// 방제 - 대상목인식
	// -----------------------------------------------
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata)){
		echo "undefined data"; exit;
	}else{
		// json 형태로 데이터를 받음
		$data = json_decode($postdata,true);
		$identify = $data["f_identify"];
		
		// 쿼리생성
		$query = "
			SELECT A.*, B.dbh, B.dbh_detail1, B.dbh_detail2, B.rcc, B.rcc_detail1, B.rcc_detail2 
			FROM control_tree as A
				LEFT JOIN damage_tree as B ON A.f_identify = B.f_identify 
			WHERE A.f_identify = 'A-0738' OR A.f_identify = 'A-0762'
		";
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		//$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result)
		{
			$rows = array();

			while ($row = mysqli_fetch_assoc($result))
			{
				array_push($rows, $row);
			}
		}
		else // DB 연결에 실패했을 경우
		{
			$row = "DBCF";
		}
		echo "NEW : ";
		echo a2json($rows);
	}
	exit;
?>