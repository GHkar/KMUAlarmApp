<?php 
	// -----------------------------------------------
	// 관리자 비밀번호 조회
	// -----------------------------------------------
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata))
	{
		echo "undefined data"; exit;
	}
	else
	{
		// json 형태로 데이터를 받음
		$data = json_decode($postdata,true);
		$password = $data["password"];
	
		// 쿼리생성
		$query = "
			SELECT * 
			FROM tbl_user 
			WHERE password = '{$password}'
		";
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result)
		{			
			if($count==1) // 비밀번호가 일치할 경우			
				echo "success";			
			else // 비밀번호가 일치하지 않음			
				echo "fail";
			
		// DB 연결에 실패했을 경우
		}
		else
		{
			echo "DBCF";
		}
	}
	exit;
?>