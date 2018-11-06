<?php 
	// -----------------------------------------------
	// 훈증무더기 입력
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
		// FCM 메세지
		$message = isset($data["message"])?$data["message"]:"";
		// 토큰값이 날라오는 경우, 단일발송
		$token = isset($data["token"])?$data["token"]:"";
		// FCM 기본주소
		$url = 'https://fcm.googleapis.com/fcm/send';
		// Header 정의
		$headers = array(
			"Content-Type:application/json",
			"Authorization:key=AAAA8771tww:APA91bH__EGLgX0rsYPGkEYtNFPCtl2LC0HBv5NFRM6m2F_dYRgu5fAtznnCA6oJxQa3BJffphHgCxukv7v1l6UANtjDDMCXJU4UpvvyieeLHrQuhTICoP7NLrjoi8OfDcnlergr6eht"
		);
		// 메세지 정의
		$fcm = array(
			"title"		=> "산림조사",
			"message"	=> $message
		);

		// 단체발송
		$query = "SELECT * FROM token" . ($token==""?"":" WHERE token = '{$token}'");
		// 쿼리실행
		$result = mysqli_query($conn,$query);
		// 쿼리결과 갯수
		$count = mysqli_num_rows($result);
		
		// DB연결 성공, 결과값이 1개이상 있을 경우에만 성공메세지 출력
		if($result){
			// 일치하는 데이터가 1개이상 있을경우
			if($count>=1){
				while($row = mysqli_fetch_assoc($result)) $token[] = $row;
				// 반복문을 통해 토큰값 목록마다 푸쉬메세지 발송.
				
				for($i=0; $i<$count; $i++){
					// 토큰값 세팅
					$fields = array(
						"registration_ids"	=> array($token[$i]["token"]),
						"data"				=> $fcm
					);
					// 발송시작
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					$result2 = curl_exec($ch);           
					if($result2 === FALSE) die("Curl failed: ".curl_error($ch));
					curl_close($ch);
				}
				echo "success";
			// 일치하는 데이터가 없거나, 결과가 여러개 인 경우
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