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
		$table = $data["table"];
	
			
		// 쿼리생성
		// 일반조회 기능		
		if($table!="status"){	
			
			
			if($table=="damage_tree"){
				$query = "
					SELECT damage_tree.* 
					FROM damage_tree 
						LEFT JOIN control_tree ON damage_tree.f_identify = control_tree.f_identify 
					WHERE control_tree.f_identify is NULL";					
			}else if($table=="control_tree"){
				$query = "
					SELECT A.*, B.dbh, B.dbh_detail1, B.dbh_detail2, B.rcc, B.rcc_detail1, B.rcc_detail2 
					FROM control_tree as A 
						LEFT JOIN damage_tree as B ON A.f_identify = B.f_identify
					";
			}else{
				$query = "SELECT * FROM {$table}";
			}
		}else{
			$query = "
				SELECT 
					A.seq as seq, 
					A.reg_x as lat, 
					A.reg_y as lng, 
					A.cvt_type as ctype, 
					A.cvt_type2 as ctype2, 
					A.cvt_x as cx, 
					A.cvt_y as cy, 
					IF(B.cfm_check='예','blue',IF(B.ctrl='가능','yellow','red')) as mcolor
				FROM damage_tree as A LEFT JOIN control_tree as B ON A.f_identify = B.f_identify 
				WHERE B.ctrl = '가능' OR B.ctrl IS NULL
			";
		}
		
		// tony 개수 관련 이슈 있어서 잠시 제한
		//$query = $query." order by seq desc limit 550";
		
	
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result){
			// 일치하는 데이터가 1개이상 있을경우
			if($count>=1){
				while($row = mysqli_fetch_assoc($result)){
					$return[] = $row;
				}
			// 일치하는 데이터가 없거나, 결과가 여러개 인 경우
			}else{
				$return = "fail";
			}
		// DB 연결에 실패했을 경우
		}else{
			$return = "DBCF";
		}
		echo a2json($return);
	}
	exit;
?>