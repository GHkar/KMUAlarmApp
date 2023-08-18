<?php 
	// -----------------------------------------------
	// 훈증무더기 입력
	// -----------------------------------------------
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("db_connection.php");
	
	// 안드로이드 POST
	$postdata = file_get_contents("php://input");
	$arr = explode("\r\n\r\n", $postdata);
	$arr2 = explode("\r\n", $arr[1]);
	$token = $arr2[0];
		
	if(!isset($postdata)){
		echo "undefined data"; exit;
	}else{
		
		// 전달받은 토큰값 세팅
//		$token = isset($postdata["token"])?$postdata["token"]:"";
		
		// 토큰값 확인
		if($token==""){
			echo "undefined token";
		}else{
			// 중복값 체크
			$query = "SELECT * FROM token WHERE token = '{$token}'";
			$result = mysqli_query($conn,$query);
			$count = mysqli_num_rows($result);
			if($result){
				// 이미 값이 있는경우
				if($count>=1){
					echo "overlap";				
				}else{		
					// 쿼리생성
					$query = "
						INSERT INTO 
							token 
						VALUES (
							null,
							'{$token}'
						)
					";
					// 쿼리실행
					$result2 = mysqli_query($conn,$query);
					// 업데이트 쿼리에 영향을 받은 갯수
					$count2 = mysqli_affected_rows($conn);
					
					// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
					if($result2){
						// insert 성공
						if($count2==1){
							echo "success";
						// insert 실패
						}else{
							echo "fail";
						}
					// DB 연결에 실패했을 경우
					}else{
						echo "DBCF";
					}
				}
			// DB 연결에 실패했을 경우
			}else{
				echo "DBCF";
			}
		}
	}
	exit;
?>