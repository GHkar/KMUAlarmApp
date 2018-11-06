<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/supervision_smoke.html 000005819 */ 
$TPL_supervision_smoke_1=empty($TPL_VAR["supervision_smoke"])||!is_array($TPL_VAR["supervision_smoke"])?0:count($TPL_VAR["supervision_smoke"]);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<title>Ryan</title>
<link rel="shortcut icon" href="#">
<link rel="stylesheet" href="./js/jquery/jquery-ui.css">
<script src="./js/jquery/jquery.min.js"></script>
<script src="./js/jquery/jquery-ui.min.js"></script>
<script src="./js/!ryan.js"></script>
<link rel="stylesheet" href="./css/!ryan.css">
<script src="./js/common.js"></script>
<link rel="stylesheet" href="./css/common.css">
<script src="./js/sheetjs.all.min.js"></script>
<script src="./js/excelplus-2.4.min.js"></script>
<script src="./js/simple-excel.js"></script>
<script>
	var excelTable = "supervision_smoke";
	var tableName = "훈증더미 감리";
</script>
<style>
	#header{min-width:1725px;}
	#title-area{min-width:1725px;max-width:1925px;}
	#table{min-width:1725px;max-width:1925px;}
</style>
</head>
<body>
	<div id="header"></div>
	<div id="contents">
		<div id="title-area" class="reset margin-all-auto">
			<div id="title"></div>
			<div id="excel" class="right">
				<form id="excel-form" class="reset po-a" method="POST" ENCTYPE="multipart/form-data">
					<a class="none" href="/admin/form/supervision_smoke.xlsx" target="_blank">양식 다운로드</a>
					<!--input type="button" class="excel-download excel-button reset button pointer" value="양식 다운로드"-->
					<!--input type="file" id="excel-select" name="excelFile" class="none" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
					<input type="button" id="excel-upload" class="excel-button reset button pointer" value="엑셀업로드(DB)"-->
					<input type="button" id="excel-download" class="excel-button reset button pointer" value="엑셀저장(현재)">
					<a id="excel-download-link" class="none" href="#" download="">&nbsp;</a>
					<input type="button" id="all-download" class="excel-button reset button pointer" value="엑셀저장(전체)">
					<a id="all-download-link" class="none" href="#" download="">&nbsp;</a>
				</form>
			</div>
		</div>

		<?php echo $TPL_VAR["sc"]["project_select"]?>	총 : <?php echo $TPL_VAR["sc"]["count"]?>개 검색 됨.

		<table id="table" class="table reset margin-all-auto">
			<tr id="table-header">
				<td rowspan="2">식별번호</td>
				<td rowspan="2">좌표</td>
				<td colspan="9">설계</td>
				<td colspan="10">방제</td>
				<td colspan="11">감리</td>
			</tr>
			<tr id="table-header">
				<td>방제방법</td>
				<td>위치현황</td>
				<td>더미 상태</td>
				<td>규격실측_길이</td>
				<td>규격실측_높이</td>
				<td>규격실측_넓이</td>
				<td>수집방법</td>
				<td>수집방향</td>
				<td>수집거리</td>

				<td>방제자</td>
				<td>방제업체</td>
				<td>방제일시</td>

				<td>종류</td>
				<td>규격</td>
				<td>약제명</td>
				<td>사용약량</td>
				<td>훈증상태확인</td>
				<td>사진촬영확인</td>
				<td>특이사항</td>
				
				<td>감리자</td>
				<td>감리업체</td>
				<td>감리일시</td>

				<td>종류</td>
				<td>규격</td>
				<td>약제명</td>
				<td>사용약량</td>
				<td>훈증상태확인</td>
				<td>사진촬영확인</td>
				<td>특이사항</td>
				<td>방제완료</td>
			</tr>

<?php if($TPL_supervision_smoke_1){foreach($TPL_VAR["supervision_smoke"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["id_serial"]?></td>
				<td><?php echo $TPL_V1["coord_x"]?><br><?php echo $TPL_V1["coord_y"]?><br><b><?php echo $TPL_V1["coord_x2"]?><br><?php echo $TPL_V1["coord_y2"]?></b></td>

				<!-- 설계 -->
				<td><?php echo $TPL_V1["control_type"]?></td>
				<td><?php echo $TPL_V1["position"]?></td>
				<td><?php echo $TPL_V1["state"]?></td>
				<td><?php echo $TPL_V1["length"]?></td>
				<td><?php echo $TPL_V1["height"]?></td>
				<td><?php echo $TPL_V1["width"]?></td>
				<td><?php echo $TPL_V1["collection_type"]?></td>
				<td><?php echo $TPL_V1["collection_direction"]?></td>
				<td><?php echo $TPL_V1["collection_distance"]?></td>

				<!-- 방제 -->
				<td><?php echo $TPL_V1["worker_control"]?></td>
				<td><?php echo $TPL_V1["agency_control"]?></td>
				<td><?php echo $TPL_V1["work_datetime_control"]?></td>

				<td><?php echo $TPL_V1["control_type_control"]?></td>
				<td><?php echo $TPL_V1["standard_control"]?></td>
				<td><?php echo $TPL_V1["drug_name_control"]?></td>
				<td><?php echo $TPL_V1["drug_amount_control"]?></td>
				<td><?php echo $TPL_V1["smoke_state_control"]?></td>
				<td><?php echo $TPL_V1["picture_check_control"]?></td>
				<td><?php echo $TPL_V1["memo_control"]?></td>

				<!-- 감리 -->
				<td><?php echo $TPL_V1["worker_supervision"]?></td>
				<td><?php echo $TPL_V1["agency_supervision"]?></td>
				<td><?php echo $TPL_V1["work_datetime_supervision"]?></td>

				<td><?php echo $TPL_V1["control_type_supervision"]?></td>
				<td><?php echo $TPL_V1["standard_supervision"]?></td>
				<td><?php echo $TPL_V1["drug_name_supervision"]?></td>
				<td><?php echo $TPL_V1["drug_amount_supervision"]?></td>
				<td><?php echo $TPL_V1["smoke_state_check_supervision"]?></td>
				<td><?php echo $TPL_V1["picture_check_supervision"]?></td>
				<td><?php echo $TPL_V1["memo_supervision"]?></td>
				<td><?php echo $TPL_V1["control_complete"]?></td>
			</tr>
<?php }}else{?>
			<tr><td colspan="15">조회된 데이터가 없습니다.</td></tr>
<?php }?>
		</table>
		<?php echo $TPL_VAR["sc"]["paging"]?>

	</div>
</body>
</html>