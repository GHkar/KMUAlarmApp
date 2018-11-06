<?php /* Template_ 2.2.8 2018/11/02 15:26:30 /namgang5995/www/admin/supervision_damage.html 000005879 */ 
$TPL_supervision_damage_1=empty($TPL_VAR["supervision_damage"])||!is_array($TPL_VAR["supervision_damage"])?0:count($TPL_VAR["supervision_damage"]);?>
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
	var excelTable = "supervision_damage";
	var tableName = "피해목 감리";
</script>
<style>
	#header{min-width:1920px;}
	#title-area{min-width:1920px;max-width:1925px;}
	#table{min-width:1920px;max-width:1925px;}
</style>
</head>
<body>
	<div id="header"></div>
	<div id="contents">
		<div id="title-area" class="reset margin-all-auto">
			<div id="title"></div>
			<div id="excel" class="right">
				<form id="excel-form" class="reset po-a" method="POST" ENCTYPE="multipart/form-data">
					<a class="none" href="/admin/form/supervision_damage.xlsx" target="_blank">양식 다운로드</a>
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
					<td colspan="6">설계</td>
					<td colspan="10">방제</td>
					<td colspan="11">감리</td>
			</tr>			
			<tr id="table-header">
				<td width="">수종</td>
				<td width="">피해종류</td>
				<td width="">방제방법</td>
				<td width="100">경급</td>				
				<td width="100">소경급</td>				
				<td width="">위험목</td>

				<td>방제자</td>
				<td>방제업체</td>
				<td>방제일시</td>
				
				<td>방제 불가 사유</td>
				<td>방제방법</td>
				<td>벌근처리방법</td>
				<td>벌근처리</td>
				<td>누락원목</td>
				<td>사진촬영확인</td>
				<td>특이사항</td>

				<td>감리자</td>
				<td>감리업체</td>
				<td>감리일시</td>

				<td>방제 불가 사유</td>
				<td>방제방법</td>
				<td>벌근처리방법</td>
				<td>벌근처리</td>
				<td>누락원목</td>
				<td>사진촬영확인</td>
				<td>특이사항</td>
				<td>방제완료</td>
				
			</tr>
<?php if($TPL_supervision_damage_1){foreach($TPL_VAR["supervision_damage"] as $TPL_V1){?>
			<tr>
				<!--<td><input class="select-check" type="checkbox" data-seq="<?php echo $TPL_V1["seq"]?>"></td>-->
				<td><?php echo $TPL_V1["id_serial"]?></td>
				<td><?php echo $TPL_V1["coord_x"]?><br><?php echo $TPL_V1["coord_y"]?><br><b><?php echo $TPL_V1["coord_x2"]?> / <?php echo $TPL_V1["coord_y2"]?></b></td>

				<!-- 설계 -->
				<td><?php echo $TPL_V1["tree_type"]?></td>
				<td><?php echo $TPL_V1["damage_type"]?></td>
				<td><?php echo $TPL_V1["control_type_design"]?></td>
				<td><?php echo $TPL_V1["height_1"]?>/<?php echo $TPL_V1["height_2"]?>/<?php echo $TPL_V1["height_3"]?></td>
				<td><?php echo $TPL_V1["branch_4"]?>/<?php echo $TPL_V1["branch_2"]?></td>
				<td><?php echo $TPL_V1["critical_design"]?></td>

				<!-- 방제 -->
				<td><?php echo $TPL_V1["worker_control"]?></td>
				<td><?php echo $TPL_V1["agency_control"]?></td>
				<td><?php echo $TPL_V1["work_datetime_control"]?></td>
				
				<td><?php echo $TPL_V1["wrong_reason_control"]?></td>
				<td><?php echo $TPL_V1["control_type_control"]?></td>
				<td><?php echo $TPL_V1["processing_type_control"]?></td>
				<td><?php echo $TPL_V1["processing_control"]?></td>
				<td><?php echo $TPL_V1["omission_control"]?></td>
				<td><?php echo $TPL_V1["picture_check"]?></td>
				<td><?php echo $TPL_V1["memo_control"]?></td>

				<!-- 감리 -->
				<td><?php echo $TPL_V1["worker"]?></td>
				<td><?php echo $TPL_V1["agency"]?></td>
				<td><?php echo $TPL_V1["work_datetime_supervision"]?></td>
				
				<td><?php echo $TPL_V1["wrong_reason_supervision"]?></td>
				<td><?php echo $TPL_V1["control_type_supervision"]?></td>
				<td><?php echo $TPL_V1["processing_type_supervision"]?></td>
				<td><?php echo $TPL_V1["processing_supervision"]?></td>
				<td><?php echo $TPL_V1["omission_supervision"]?></td>
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