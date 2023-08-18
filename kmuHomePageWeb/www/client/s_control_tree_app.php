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
		// $query = "
			// SELECT A.*, B.dbh, B.dbh_detail1, B.dbh_detail2, B.rcc, B.rcc_detail1, B.rcc_detail2 
			// FROM control_tree as A
				// LEFT JOIN damage_tree as B ON A.f_identify = B.f_identify 
			//WHERE A.f_identify = '{$identify}'
		// ";
		
		$query = "
			SELECT f_identify, tree, reg_x, reg_y, dbh, dbh_detail1, dbh_detail2, cvt_type, cvt_type2, cvt_x, cvt_y, ctrl_date, cfm_date
			FROM control_tree WHERE f_identify = '{$identify}'
		";
		
		
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result){
			// 일치하는 데이터가 '1개' 있을경우
			if($count==1){
				$row = mysqli_fetch_assoc($result);
				
			// 일치하는 데이터가 없거나, 결과가 여러개 인 경우
			}else if($count==0){
				// 훈증무더기에서 검색
				
				$query = "
					SELECT * 
					FROM fumi_dummy
					WHERE f_identify = '{$identify}'
				";
				
				// 쿼리실행
				$result = mysqli_query($conn,$query);
				// 쿼리결과 갯수
				$count = mysqli_num_rows($result);
						
			
				// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
				if($result){
					// 일치하는 데이터가 '1개' 있을경우
					if($count==1){
						$row = mysqli_fetch_assoc($result);
						
					// 일치하는 데이터가 없거나, 결과가 여러개 인 경우
					}else{
						$row = "fail";
						echo $row;
						exit;
					}
				// DB 연결에 실패했을 경우
				}else{
					$row = "DBCF";
				}
			
			}else{
				$row = "fail";
				echo $row;
				exit;
			}
			
			
			
			
		// DB 연결에 실패했을 경우
		}else{
			$row = "DBCF";
		}
		
		
		
		
		
		echo a2json($row);
	}
	exit;
?>