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
	
		// a 붙이기 제거 - 불가능한 것만 적용하는것임 
		$identify = $data["f_identify"];
		
		// 기존값 조회
		$query = "
			SELECT * 
			FROM control_tree 
			WHERE f_identify = '{$identify}'
		";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		
		if($result && $count==1){
			$overCheck = true;
		}else{
			$overCheck = false;
		}

		// 결과체크
		if($overCheck==false){
			echo "fail";
			exit;
		}else if($overCheck==true){
			// 데이터 생성		
			$reg_name = isset($data["reg_name"])?$data["reg_name"]:"-";
			$reg_company = isset($data["reg_company"])?$data["reg_company"]:"-";
			$ctrl = isset($data["ctrl"])?$data["ctrl"]:"-";
			$ctrl_type = isset($data['ctrl_type'])?$data['ctrl_type']:"-";
			$ctrl_height = isset($data['ctrl_height'])?$data['ctrl_height']:"-";
			$ctrl_peeling = isset($data['ctrl_peeling'])?$data['ctrl_peeling']:"-";
			$ctrl_fumi = isset($data['ctrl_fumi'])?$data['ctrl_fumi']:"-";
			$ctrl_photo = isset($data['ctrl_photo'])?$data['ctrl_photo']:"-";
			$ctrl_date = isset($data['ctrl_date'])?$data['ctrl_date']:date("y-m-d",time());
			$ctrl_report = isset($data['ctrl_report'])?$data['ctrl_report']:"-";
			$ctrl_report2 = isset($data['ctrl_report2'])?$data['ctrl_report2']:"-";
			
			$query = "
				UPDATE control_tree 
				SET 
					reg_name = '{$reg_name}',
					reg_company = '{$reg_company}',
					ctrl = '{$ctrl}',
					ctrl_type = '{$ctrl_type}',
					ctrl_height = '{$ctrl_height}',
					ctrl_peeling = '{$ctrl_peeling}',
					ctrl_fumi = '{$ctrl_fumi}',
					ctrl_photo = '{$ctrl_photo}',
					ctrl_date = '{$ctrl_date}',
					ctrl_report = '{$ctrl_report}',
					ctrl_report2 = '{$ctrl_report2}' 
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