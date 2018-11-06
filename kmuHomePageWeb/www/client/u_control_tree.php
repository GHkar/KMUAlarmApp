<?php 
	// -----------------------------------------------
	// 피해목제거 업데이트
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

		// 기존값 조회
		$query = "
			SELECT * 
			FROM control_tree 
			WHERE f_identify = '{$identify}'
		";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		
		// 기존값 여부 검사
		if($result && $count==1){
			$overCheck = true;
		}else{
			$overCheck = false;
		}
		
		// 기존값 없으면 실패
		if($overCheck==false){
			echo "fail";
			exit;
		}else if($overCheck==true){
			// 데이터 생성
			$cfm_photo = isset($data["cfm_photo"])?$data["cfm_photo"]:"-";
			$cfm_report = isset($data["cfm_report"])?$data["cfm_report"]:"";
			$cfm_date = isset($data["cfm_date"])?$data["cfm_date"]:date("y-m-d",time());
		
			// 쿼리생성
			$query = "
				UPDATE control_tree 
				SET cfm_check = '예',
					cfm_photo = '{$cfm_photo}',
					cfm_report = '{$cfm_report}',
					cfm_date = '{$cfm_date}' 
				WHERE f_identify = '{$identify}'
			";
			
			// 쿼리실행
			$result = mysqli_query($conn,$query);
			
			// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
			if($result){
				echo "success";
			// DB 연결에 실패했을 경우
			}else{
				echo "DBCF";
			}
		}
	}
	exit;
?>