<?php 
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("../common/db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata))
	{
		echo "undefined data"; exit;
	}
	else
	{
		// 쿼리생성
		$query = "SELECT id, name, organ, create_date FROM tbl_project";
		//echo $query;
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		//$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result)
		{
			//echo "</br>aaa";
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
		//echo "NEW : ";
		echo a2json($rows);
	}
	exit;
?>