<?php 
	// -----------------------------------------------
	// 관리자 비밀번호 업데이트
	// -----------------------------------------------
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("../common/db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
		
	if(!isset($postdata)){
		echo "undefined data"; exit;
	}else{
		// json 형태로 데이터를 받음
		$data = json_decode($postdata,true);
		$password = $data["password"];
		
		// 기존비밀번호 조회
		$query = "SELECT * FROM admin";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		if($result && $count>=1){
			$row = mysqli_fetch_assoc($result);
			$old = $row["password"];
		}
		
		// 쿼리생성
		$query = "
			UPDATE admin 
			SET password = '{$password}'
		";
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 업데이트 쿼리에 영향을 받은 갯수
		$count = mysqli_num_rows($result);
		// 기존비밀번호와 같다면 업데이트가 된 것으로 처리
		if($old==$password) $count = 1;
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result){
			// 변경된 데이터가 있을 경우
			if($count==1){
				echo "success";
			// 변경된 데이터가 없을 경우
			}else{
				echo "fail";
			}
		// DB 연결에 실패했을 경우
		}else{
			echo "DBCF";
		}
	}
	exit;
?>