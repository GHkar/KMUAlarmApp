<?php 
	// -----------------------------------------------
	// 피해목조사
	// -----------------------------------------------
	$CORERIVER = "CORERIVER";
	header("Content-Type: text/html; charset=UTF-8");
	include("db_connection.php");
	
	$postdata = file_get_contents('php://input');
		
	if(!isset($postdata)){
		echo "undefined data"; exit;
	}else{
		// json 형태로 데이터를 받음
		//$data = json_decode($_POST["data"],true);
		$data = json_decode($postdata,true);
		
		// 팀이름
		$team = isset($data["team"])?$data["team"]:"테스트";
		$team = strtoupper($team);
		
		// 식별번호 생성진행 - 팀별로 가장 마지막에 삽입된 값을 찾음
		$query = "
			SELECT f_identify 
			FROM damage_tree 
			WHERE f_identify 
				LIKE '{$team}-%' AND 
				seq = (
					SELECT MAX(seq) 
					FROM damage_tree 
					WHERE f_identify LIKE '{$team}-%'
				)
		";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		
		// 검색된 팀데이터가 없을때에는 기본 1을 세팅
		if($count==0){
			$team_seq = 1;
			
		// 기존값이 있는경우 기존값에서 1을 더해줌
		}else{
			$result = mysqli_fetch_array($result);
			$explode = explode("-",$result[0]);
			$team_seq = (int)$explode[1] + 1;
		}
		
		// 0붙여주기
		$zero = "";
		$end = 4 - strlen($team_seq);
		for($i=0; $i<$end; $i++) $zero .= "0";

		// 해당번호를 기준으로 식별번호 생성
		$identify = $team . "-" . $zero . $team_seq;
		
		// 중복검사
		$query = "
			SELECT f_identify 
			FROM damage_tree 
			WHERE f_identify = '{$identify}'
		";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		
		if($count!=0){
			echo "fail";
		}else{

			// 등록일자 생성(서버기준)
			$reg_date = date("Y-m-d",time());
			
			// 흉고직경, 근원경, 소경급, 특이사항 항목은 선택사항이기 때문에 반드시 예외처리가 필요함
			$dbh = isset($data['dbh'])?$data['dbh']:0;
			$dbh_detail1 = isset($data['dbh_detail1'])?$data['dbh_detail1']:0;
			$dbh_detail2 = isset($data['dbh_detail2'])?$data['dbh_detail2']:0;
			$rcc = isset($data['rcc'])?$data['rcc']:0;
			$rcc_detail1 = isset($data['rcc_detail1'])?$data['rcc_detail1']:0;
			$rcc_detail2 = isset($data['rcc_detail2'])?$data['rcc_detail2']:0;
			$stems_4cm = isset($data['stems_4cm'])?$data['stems_4cm']:0;
			$stems_2cm = isset($data['stems_2cm'])?$data['stems_2cm']:0;
			$report = isset($data['report'])?$data['report']:"-";
			
			// 좌표값 6자리 세팅
			$reg_x = explode(".",$data["reg_x"]);
			$reg_x = $reg_x[0] . "." . substr($reg_x[1],0,6);
			$reg_y = explode(".",$data["reg_y"]);
			$reg_y = $reg_y[0] . "." . substr($reg_y[1],0,6);
			$cvt_x = explode(".",$data["cvt_x"]);
			$cvt_x = $cvt_x[0] . "." . substr($cvt_x[1],0,6);
			$cvt_y = explode(".",$data["cvt_y"]);
			$cvt_y = $cvt_y[0] . "." . substr($cvt_y[1],0,6);
			
			// 쿼리생성
			$query = "
				INSERT INTO 
					damage_tree 
				VALUES(
					null,
					'{$identify}',
					'{$data['reg_name']}',
					'{$data['reg_company']}',
					'{$reg_date}',
					'{$reg_x}',
					'{$reg_y}',
					'{$data['cvt_type']}',
					'{$data['cvt_type2']}',
					'{$cvt_x}',
					'{$cvt_y}',
					'{$data['tree']}',
					'{$data['damage']}',
					'{$dbh}',
					'{$dbh_detail1}',
					'{$dbh_detail2}',
					'{$rcc}',
					'{$rcc_detail1}',
					'{$rcc_detail2}',
					'{$stems_4cm}',
					'{$stems_2cm}',
					'{$data['danger']}',
					'{$report}'
				)
			";
			// 쿼리실행
			$result = mysqli_query($conn,$query);
			// 업데이트 쿼리에 영향을 받은 갯수
			$count = mysqli_affected_rows($conn);
			
			// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
			if($result){
				// insert 성공
				if($count==1){
					echo "{$identify}";
				// insert 실패
				}else{
					echo "fail";
				}
			// DB 연결에 실패했을 경우
			}else{
				echo "DBCF";
			}
		}
	}
	exit;
?>