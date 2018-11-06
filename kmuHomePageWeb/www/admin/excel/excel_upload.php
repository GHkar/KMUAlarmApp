<?php
	// 폴더명
	$folder = $_POST["folder"];
	// 파일확장자
	$extension = $_POST["extension"];
	// 파일네임생성 (년월일시분초)
	$excelName = date("YmdHis",strtotime("-9 minutes -14 seconds"));
		
	//폴더가 없으면 생성
	if(!is_dir($folder)) { 
		mkdir($folder);
		chmod($folder,0777);
	}
	
	// 파일명 생성
	$resultName = $folder . "/" . $excelName . "." . $extension;
	
	// 업로드 진행
	if(isset($_FILES['excelFile'])) {
		if(!move_uploaded_file($_FILES['excelFile']['tmp_name'],$resultName)){
			$result["status"] = "fail";
		}else{
			$result["status"] = "success";
			$result["folder"] = $folder;
			$result["file"] = $excelName . "." . $extension;
		}
		echo json_encode($result);
	}
?>