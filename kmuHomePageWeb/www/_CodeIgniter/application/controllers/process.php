<?php 

	if(!defined('BASEPATH')){
		exit('No direct script access allowed');
	}
	header("Content-Type: text/html; charset=UTF-8");
	class process extends CI_Controller {
		
		// 로그인 이벤트
		public function login(){
			if(!isset($_POST["data"])){
				echo "undefined data";
			}else{
				$data = json_decode($_POST["data"],true);
				$password = isset($data["password"])?$data["password"]:"";
				if($password==""){
					echo "undefined password";
				}else{
					$result = $this->db->query("
						SELECT * 
						FROM tbl_user
						WHERE password = '{$password}'
					");
					if($result->num_rows>=1){
						$this->session->set_userdata('admin_auth',"1");
						echo "success";
					} else {
						echo "fail";
					}
				}
			}
			exit;
		}
		
		// 로그아웃 이벤트
		public function logout(){
			$this->session->unset_userdata('admin_auth');
			exit;
		}
		
		// 비밀번호 조회
		public function selectPassword(){
			$result = $this->db->query("
				SELECT * 
				FROM admin 
				WHERE password = '{$_POST['password']}'
			");
			if($result->num_rows>=1){
				$result = $result->result_array();
			} else {
				$result = "fail";
			}
			echo json_encode($result);
		}
		
		// 비밀번호 업데이트
		public function updatePassword(){
			$result = $this->db->query("
				UPDATE admin 
				SET password = '{$_POST['password']}'
			");
		}
		
		public function getExcelData(){
			// 테이블 값이 있는지 확인
			$table = isset($_POST["table"])?$_POST["table"]:"";
			$id_project = isset($_POST["id_project"])?$_POST["id_project"]:"";
			// 테이블 값이 없으면 실패
			if($table==""){
				$result = "fail";
			}
			else
			{
				$select = "";
				if ($table=="probe_damage")
				{
					$select = "
						SELECT 
							id_serial as '식별번호',
							worker as '조사자',
							agency as '조사업체',
							work_datetime as '조사일시',
							coord_x as '경도',
							coord_y as '위도',
							coord_x2 as '좌표_X',
							coord_y2 as '좌표_Y',
							tree_type as '수종',
							damage_type as '피해종류',
							control_type as '방제종류',
							height_1 as '흉고직경_1',
							height_2 as '흉고직경_2',
							height_3 as '흉고직경_3',
							branch_4 as '소경급_4cm',
							branch_2 as '소경급_2cm',
							critical as '위험목',
							memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "probe_smoke")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '조사자',
						agency as '조사업체',
						work_datetime as '조사시간',
						coord_x as '경도',
						coord_y as '위도',					
						control_type as '방제방법',
						position as '위치현황',
						state as '더미 상태',
						length as '규격실측_길이',
						height as '규격실측_높이',
						width as '규격실측_넓이',
						collection_type as '수집방법',
						collection_direction as '수집방향',
						collection_distance as '수집거리',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "probe_prevent")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '조사자',
						agency as '조사업체',
						work_datetime as '조사시간',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						drug as '사용약제',
						diameter as '경급',
						perforation_num as '천공수',
						drug_amount as '약량',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "control_damage")
				{
					$select= "
						SELECT
							id_serial as '식별번호',
							coord_x as '위도',
							coord_y as '경도',
							coord_x2 as 'x',
							coord_y2 as 'y',
							tree_type as '수종',
							damage_type as '피해유형',
							control_type as '방제방법',
							height_1 as '경급_1',
							height_2 as '경급_2',
							height_3 as '경급_3',
							critical as '위험목',

							worker as '방제자',
							agency as '방제업체',
							work_datetime as '방제일자',
							
							wrong_reason_control as '방제 불가 사유',
							control_type_control as '방제방법',
							processing_type_control as '벌근처리방법',
							processing_control as '벌근처리',
							omission_control as '누락원목',
							picture_check_control as '사진촬영확인',
							memo_control as '특이사항'
					";
					$table = "view_".$table;
				}
				else if($table == "control_smoke")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '방제자',
						agency as '방제업체',
						work_datetime as '방제시간',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						control_type as '종류',
						standard as '규격',
						drug_name as '약제명',
						drug_amount as '약량',
						smoke_state as '훈증더미 상태',
						picture_check as '사진촬영여부',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "control_prevent")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '방제자',
						agency as '방제업체',
						work_datetime as '방제시간',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						wrong_reason as '방제 불가 사유',
						drug as '사용약제',
						diameter as '경급',
						perforation_num as '천공수',
						drug_amount as '약량',
						prevent_check as '작업확인',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "supervision_damage")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						coord_x as '위도',
						coord_y as '경도',
						coord_x2 as 'x',
						coord_y2 as 'y',
						tree_type as '수종',
						damage_type as '피해유형',
						control_type_design as '방제방법',
						height_1 as '경급_1',
						height_2 as '경급_2',
						height_3 as '경급_3',
						branch_4 as '소경급_4',
						branch_2 as '소경급_2',
						critical_design as '위험목',

						worker_control as '방제자',
						agency_control as '방제업체',
						work_datetime_control as '방제일시',
						
						wrong_reason_control as '방제 불가 사유',
						control_type_control as '방제방법',
						processing_type_control as '벌근처리방법',
						processing_control as '벌근처리',
						omission_control as '누락원목',
						picture_check as '사진촬영확인',
						memo_control as '특이사항',
						
						worker as '감리자',
						agency as '감리업체',
						work_datetime_supervision as '감리일시',

						wrong_reason_supervision as '방제 불가 사유',
						control_type_supervision as '방제방법',
						processing_type_supervision as '벌근처리방법',
						processing_supervision as '벌근처리',
						omission_supervision as '누락원목',
						picture_path_supervision as '사진촬영확인',
						memo_supervision as '특이사항',
						control_complete as '방제완료'
					";
					$table = "view_".$table;
				}
				else if($table == "supervision_smoke")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '방제자',
						agency as '방제업체',
						work_datetime as '방제시간',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						control_type as '방제 불가 사유',
						standard as '사용약제',
						drug_name as '경급',
						drug_amount as '천공수',
						smoke_state_check as '약량',
						picture_check as '작업확인',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "supervision_prevent")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						worker as '감리자',
						agency as '감리업체',
						work_datetime as '감리시간',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						wrong_reason as '방제 불가 사유',
						drug as '사용약제',
						diameter as '경급',
						perforation_num as '천공수',
						drug_amount as '약량',
						prevent_check as '작업확인',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "design_damage")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						damage_type as '피해종류',
						control_type as '방제방법',
						height_1 as '경급_1',
						height_2 as '경급_2',
						height_3 as '경급_3',
						branch_4 as '소경급_4cm',
						branch_2 as '소경급_2cm',
						critical as '위험목',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "design_smoke")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						coord_x as '경도',
						coord_y as '위도',
						control_type as '방제방법',
						position as '위치현황',
						state as '더미 상태',
						length as '규격실측_길이',
						height as '규격실측_높이',
						width as '규격실측_넓이',
						collection_type as '수집방법',
						collection_direction as '수집방향',
						collection_distance as '수집거리',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				else if($table == "design_prevent")
				{
					$select = "
						SELECT
						id_serial as '식별번호',
						coord_x as '경도',
						coord_y as '위도',
						tree_type as '수종',
						drug as '사용약제',
						diameter as '경급',
						perforation_num as '천공수',
						drug_amount as '약량',
						memo as '특이사항'
					";
					$table = "tbl_".$table;
				}
				$from = "FROM {$table} as A ";
				$where = "WHERE id_project = {$id_project} ";
				//$orderby = "ORDER BY seq ASC ";
				$orderby = "ORDER BY id_serial ASC ";
				$limit = "";
				
				$params = isset($_POST["params"])?json_decode($_POST["params"],true):"";
				$count = count($params["pname"]);
				for($i=0; $i<$count; $i++){
					if($params["pname"][$i]=="page"){
						$page = $params["pvalue"][$i];
					}else{
						$where .= 'AND '.$params["pname"][$i].'="'.$params["pvalue"][$i].'" ';
					}
				}
				
				if($page!="all"){
					$page = $page==1?0:($page-1)*10;
					$limit = "LIMIT {$page},10";
				}
				
				if($table=="supervision"){
					$from = "FROM fumi_dummy as A ";
					$where .= "AND (cfm_drug <> '-' AND cfm_fumi2 <> '-') ";
				}
				
				//echo $select.$from.$where.$orderby.$limit;
				$query = $this->db->query($select.$from.$where.$orderby.$limit);
				if($query->num_rows>=1){
					foreach($query->result_array() as $row) $result[] = $row;
				}else{
					$result = "fail";
				}
			}
			echo json_encode($result);
			exit;
		}
		
		public function getForecastInfo()
		{
			$id_project = $_POST['id_project'];
			
			$result = $this->db->query("
				SELECT 
					id_project,
					id_serial,
					coord_x,
					coord_y,
					coord_x2,
					coord_y2,
					worker,
					agency,
					work_datetime,
					completed,
					deleted		
				FROM tbl_forecast
				WHERE id_project=".$id_project 
			);
			if($result->num_rows>=1){
				foreach($result->result_array() as $row) $marker[] = $row;
			} else {
				$marker = "no data";
			}
			echo json_encode($marker);
			exit;
		}
		
		public function getProbeDamageInfo()
		{
			$id_project = $_POST['id_project'];
			
			$result = $this->db->query("
				SELECT 
					id_project,
					id_serial,
					coord_x,
					coord_y,
					coord_x2,
					coord_y2,
					tree_type,
					worker,
					agency,
					work_datetime,
					damage_type,
					control_type
				FROM tbl_probe_damage
				WHERE id_project=".$id_project 
			);
			if($result->num_rows>=1){
				foreach($result->result_array() as $row) $marker[] = $row;
			} else {
				$marker = "no data";
			}
			echo json_encode($marker);
			exit;
		}

		public function get_All_Marker2(){
			$result = $this->db->query("
				SELECT 
					A.seq as seq, 
					A.f_identify as idfy, 
					A.reg_x as lat, 
					A.reg_y as lng, 
					A.cvt_type as ctype, 
					A.cvt_type2 as ctype2, 
					A.cvt_x as cx, 
					A.cvt_y as cy, 
					A.dbh as do,
					A.dbh_detail1 as d1, 
					A.dbh_detail1 as d2, 
					A.reg_date as reg_date, 
					'red' as mcolor 
				FROM damage_tree as A
			");
			if($result->num_rows>=1){
				foreach($result->result_array() as $row) $marker[] = $row;
			} else {
				$marker = "no data";
			}
			echo json_encode($marker);
			exit;
		}
		
		public function get_All_Marker3(){
			$result = $this->db->query("
				SELECT 
					A.seq as seq, 
					A.f_identify as idfy, 
					A.reg_x as lat, 
					A.reg_y as lng, 
					A.cvt_type as ctype, 
					A.cvt_type2 as ctype2, 
					A.cvt_x as cx, 
					A.cvt_y as cy, 
					'beige' as mcolor 
				FROM forecast_tree as A
			");
			if($result->num_rows>=1){
				foreach($result->result_array() as $row) $marker[] = $row;
			} else {
				$marker = "no data";
			}
			echo json_encode($marker);
			exit;
		}
	
		public function excelWrite(){
			$table = "tbl_".$_POST['table'];
			$id_project = $_POST['id_project'];
			
			$queryDelete  = "DELETE FROM ".$table." ";
			$queryDelete .= "WHERE id_project=".$id_project;
			$queryDelete .= ";";
			$this->db->query($queryDelete);

			// $result['status'] = $table."/".$id_project."/".$queryDelete;
			// echo json_encode($result);
			// exit;

			$dataList = json_decode($_POST['dataList'],true);
			$dataCreate = false;
			for($i=0; $i<count($dataList); $i++){
				switch($table)
				{
					/*
					case 'tbl_probe_damage':
					{
						$excelData = array(
							'id_serial' 				=>  $dataList[$i][0],
							'prober'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'datetime'					=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'damage_type'				=>	$dataList[$i][7],
							'control_type'				=>	$dataList[$i][8],
							'height_1'					=>	$dataList[$i][9],
							'height_2'					=>	$dataList[$i][10],
							'height_3'					=>	$dataList[$i][11],
							'branch_4'					=>	$dataList[$i][12],
							'branch_2'					=>	$dataList[$i][13],
							'critical'					=>	$dataList[$i][14],
							'memo'						=>	$dataList[$i][15]
						);
						$dataCreate = true;
						break;
					}
					*/
					case 'view_control_damage':
					{
						$excelData = array(
							'id_serial_control' 		=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'wrong_reason'				=>	$dataList[$i][7],
							'control_type_control'		=>	$dataList[$i][8],
							'processing_type'			=>	$dataList[$i][9],
							'processing'				=>	$dataList[$i][10],
							'omission'					=>	$dataList[$i][11],
							'picture_check'				=>	$dataList[$i][12],
							'memo_control'				=>	$dataList[$i][13]
						);
						$dataCreate = true;						
						break;
					}
					case 'tbl_supervision_damage':
					{
						$excelData = array(
							'id_serial' 				=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'wrong_reason'				=>	$dataList[$i][7],
							'height_1'					=>	$dataList[$i][8],
							'height_2'					=>	$dataList[$i][9],
							'height_3'					=>	$dataList[$i][10],						
							'control_type'				=>	$dataList[$i][11],
							'processing_type'			=>	$dataList[$i][12],
							'processing'				=>	$dataList[$i][13],
							'omission'					=>	$dataList[$i][14],
							'picture_check'				=>	$dataList[$i][15],
							'memo'						=>	$dataList[$i][16]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_probe_smoke':
					{
						$excelData = array(
							'id_project'				=>	$id_project,
							'id_serial' 				=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'control_type'				=>	$dataList[$i][6],
							'position'					=>	$dataList[$i][7],
							'state'						=>	$dataList[$i][8],
							'length'					=>	$dataList[$i][9],
							'height'					=>	$dataList[$i][10],						
							'width'						=>	$dataList[$i][11],
							'collection_type'			=>	$dataList[$i][12],
							'collection_direction'		=>	$dataList[$i][13],
							'collection_distance'		=>	$dataList[$i][14],
							'memo'						=>	$dataList[$i][15],													
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_probe_prevent':
					{
						$excelData = array(
							'id_project'				=>	$id_project,
							'id_serial' 				=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'drug'						=>	$dataList[$i][7],
							'dimeter'					=>	$dataList[$i][8],
							'perforation_num'			=>	$dataList[$i][9],
							'drug_amount'				=>	$dataList[$i][10],						
							'memo'						=>	$dataList[$i][11]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_control_smoke':
					{
						$excelData = array(
							'id_serial' 				=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'control_type'				=>	$dataList[$i][7],
							'standard'					=>	$dataList[$i][8],
							'drug_name'					=>	$dataList[$i][9],
							'drug_amount'				=>	$dataList[$i][10],						
							'smoke_state'				=>	$dataList[$i][11],
							'picture_check'				=>	$dataList[$i][12],
							'memo'						=>	$dataList[$i][13]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_control_prevent':
					{
						$excelData = array(
							'id_serial'					=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'wrong_reason'				=>	$dataList[$i][7],
							'drug'						=>	$dataList[$i][8],
							'diameter'					=>	$dataList[$i][9],
							'perforation_num'			=>	$dataList[$i][10],						
							'drug_amount'				=>	$dataList[$i][11],
							'prevent_check'				=>	$dataList[$i][12],
							'memo'						=>	$dataList[$i][13]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_supervision_smoke':
					{
						$excelData = array(
							'id_serial'					=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'control_type'				=>	$dataList[$i][7],
							'standard'					=>	$dataList[$i][8],
							'drug_name'					=>	$dataList[$i][9],
							'drug_amount'				=>	$dataList[$i][10],						
							'smoke_state_check'			=>	$dataList[$i][11],
							'picture_check'				=>	$dataList[$i][12],
							'memo'						=>	$dataList[$i][13]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_supervision_prevent':
					{
						$excelData = array(
							'id_serial'					=>  $dataList[$i][0],
							'worker'					=>	$dataList[$i][1],
							'agency'					=>	$dataList[$i][2],
							'work_datetime'				=>	$dataList[$i][3],
							'coord_x'					=>	$dataList[$i][4],
							'coord_y'					=>	$dataList[$i][5],
							'tree_type'					=>	$dataList[$i][6],
							'wrong_reason'				=>	$dataList[$i][7],
							'drug'						=>	$dataList[$i][8],
							'diameter'					=>	$dataList[$i][9],
							'perforation_num'			=>	$dataList[$i][10],						
							'drug_amount'				=>	$dataList[$i][11],
							'prevent_check'				=>	$dataList[$i][12],
							'memo'						=>	$dataList[$i][13]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_design_damage':
					{
						$excelData = array(
							'id_project'				=> 	$id_project,
							'id_serial' 				=>  $dataList[$i][0],
							'coord_x'					=>	$dataList[$i][1],
							'coord_y'					=>	$dataList[$i][2],
							'coord_x2'					=>	$dataList[$i][3],
							'coord_y2'					=>	$dataList[$i][4],
							'tree_type'					=>	$dataList[$i][5],
							'damage_type'				=>	$dataList[$i][6],
							'control_type'				=>	$dataList[$i][7],
							'height_1'					=>	$dataList[$i][8],
							'height_2'					=>	$dataList[$i][9],
							'height_3'					=>	$dataList[$i][10],
							'branch_4'					=>	$dataList[$i][11],
							'branch_2'					=>	$dataList[$i][12],
							'critical'					=>	$dataList[$i][13],
							'memo'						=>	$dataList[$i][14]
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_design_smoke':
					{
						$excelData = array(
							'id_project'				=>	$id_project,
							'id_serial' 				=>  $dataList[$i][0],
							'coord_x'					=>	$dataList[$i][1],
							'coord_y'					=>	$dataList[$i][2],
							'control_type'				=>	$dataList[$i][3],
							'position'					=>	$dataList[$i][4],
							'state'						=>	$dataList[$i][5],
							'length'					=>	$dataList[$i][6],
							'height'					=>	$dataList[$i][7],						
							'width'						=>	$dataList[$i][8],
							'collection_type'			=>	$dataList[$i][9],
							'collection_direction'		=>	$dataList[$i][10],
							'collection_distance'		=>	$dataList[$i][11],
							'memo'						=>	$dataList[$i][12],
						);
						$dataCreate = true;
						break;
					}
					case 'tbl_design_prevent':
					{
						$excelData = array(
							'id_project'				=>	$id_project,
							'id_serial' 				=>  $dataList[$i][0],
							'coord_x'					=>	$dataList[$i][1],
							'coord_y'					=>	$dataList[$i][2],
							'tree_type'					=>	$dataList[$i][3],
							'drug'						=>	$dataList[$i][4],
							'diameter'					=>	$dataList[$i][5],
							'perforation_num'			=>	$dataList[$i][6],
							'drug_amount'				=>	$dataList[$i][7],				
							'memo'						=>	$dataList[$i][8]
						);
						$dataCreate = true;
						break;
					}
				}
				// $result['status'] = "success";
				if($dataCreate==true)
				{
					$this->db->insert($table,$excelData);
				}
				$dataCreate = false;
			}
			$select = $this->db->query('SELECT count(*) as count from `'.$table.'`');
			if($select->num_rows()>=1)
			{
				$select = $select->result_array();
				$result['count'] = $select[0]['count'];
				$result['status'] = 'success';
			}
			else $result['status'] = 'fail';
			
			$result['length'] = ''.count($dataList);
			$result['table'] = $table;
			echo json_encode($result);
		}

		public function replaceText($data){
			// " 따옴표 처리
			$data = preg_replace('/\"/',"&#34;",$data);
			// ' 따옴표 처리
			$data = preg_replace('/\'/',"&#39;",$data);
			// < 꺽새 처리
			$data = preg_replace('/\</',"&#60;",$data);
			// > 꺽새 처리
			$data = preg_replace('/\>/',"&#62;",$data);
			// 줄바꿈 처리
			$data = preg_replace('/\r\n|\r|\n/',"<br>",$data);

			return $data;
		}
		
		public function replaceTextBoard($data){
			// & 처리
			$data = preg_replace('/#amp/',"&",$data);
			// " 따옴표 처리
			$data = preg_replace('/\"/',"&#34;",$data);
			// ' 따옴표 처리
			$data = preg_replace('/\'/',"&#39;",$data);
			
			return $data;
		}
	}
?>